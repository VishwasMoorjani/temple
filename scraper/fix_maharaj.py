"""
Re-scrape Maharaj & Mataji images from RJS website.
Downloads images into downloads/maharaj_mataji/ folder
and updates the JSON with correct image URLs.
"""
import os
import re
import json
import hashlib
import requests
from bs4 import BeautifulSoup
from urllib.parse import urljoin

BASE_URL = "https://rajasthanjainsabha.in/"
DOWNLOAD_DIR = "downloads/maharaj_mataji"
os.makedirs(DOWNLOAD_DIR, exist_ok=True)

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36"
}

def get_hashed_name(url):
    if not url or url.endswith("/") or "SiteImage/$" in url:
        return None
    ext = url.rsplit('.', 1)[-1].split('?')[0] if '.' in url else 'jpg'
    if ext not in ('jpg', 'jpeg', 'png', 'gif', 'webp'):
        ext = 'jpg'
    return hashlib.md5(url.encode()).hexdigest()[:12] + '.' + ext

def download_image(url):
    if not url or url.endswith("/"):
        return None
    fname = get_hashed_name(url)
    if not fname:
        return None
    path = os.path.join(DOWNLOAD_DIR, fname)
    if os.path.exists(path):
        return fname
    try:
        r = requests.get(url, headers=HEADERS, timeout=15)
        if r.status_code == 200 and len(r.content) > 500:
            with open(path, 'wb') as f:
                f.write(r.content)
            print(f"  Downloaded: {fname} ({len(r.content)} bytes)")
            return fname
        else:
            print(f"  Skipped (status={r.status_code}, size={len(r.content)}): {url}")
    except Exception as e:
        print(f"  Error: {e}")
    return None

class ASPSession:
    def __init__(self):
        self.session = requests.Session()
        self.session.headers.update(HEADERS)
        self.viewstate = ""
        self.viewstate_gen = ""
        self.event_validation = ""
    
    def get_page(self, url):
        try:
            r = self.session.get(url, timeout=30)
            soup = BeautifulSoup(r.text, 'html.parser')
            self._extract(soup)
            return soup, r.text
        except Exception as e:
            print(f"Error getting page: {e}")
            return None, None

    def postback(self, url, target):
        data = {
            "__EVENTTARGET": target,
            "__EVENTARGUMENT": "",
            "__VIEWSTATE": self.viewstate,
            "__VIEWSTATEGENERATOR": self.viewstate_gen,
            "__EVENTVALIDATION": self.event_validation,
        }
        try:
            r = self.session.post(url, data=data, timeout=30)
            soup = BeautifulSoup(r.text, 'html.parser')
            self._extract(soup)
            return soup, r.text
        except Exception as e:
            print(f"Postback error: {e}")
            return None, None

    def _extract(self, soup):
        vs = soup.find("input", {"id": "__VIEWSTATE"})
        if vs: self.viewstate = vs.get("value", "")
        vsg = soup.find("input", {"id": "__VIEWSTATEGENERATOR"})
        if vsg: self.viewstate_gen = vsg.get("value", "")
        ev = soup.find("input", {"id": "__EVENTVALIDATION"})
        if ev: self.event_validation = ev.get("value", "")

def get_text(el):
    return el.get_text(strip=True) if el else ""

def detect_total_pages(soup):
    pager = soup.find("div", class_="dataPager") or soup.find("div", class_=re.compile(r"pager"))
    if not pager:
        # Try to find pager links
        links = soup.find_all("a", href=re.compile(r"__doPostBack.*rptPager"))
        if links:
            nums = []
            for link in links:
                txt = link.get_text(strip=True)
                if txt.isdigit():
                    nums.append(int(txt))
            return max(nums) if nums else 1
        return 1
    links = pager.find_all("a")
    nums = []
    for link in links:
        txt = link.get_text(strip=True)
        if txt.isdigit():
            nums.append(int(txt))
    return max(nums) if nums else 1

def get_pager_targets(soup):
    targets = {}
    for a in soup.find_all("a", href=re.compile(r"__doPostBack")):
        txt = a.get_text(strip=True)
        match = re.search(r"__doPostBack\('([^']+)'", a.get("href", ""))
        if match:
            targets[txt] = match.group(1)
    return targets

def main():
    print("=" * 60)
    print("Re-scraping Maharaj & Mataji with images")
    url = urljoin(BASE_URL, "MaharajaMaharani.aspx")
    asp = ASPSession()
    
    all_entries = []
    soup, html = asp.get_page(url)
    if not soup:
        print("Failed to load page!")
        return
    
    total_pages = detect_total_pages(soup)
    page_num = 1
    print(f"Total pages detected: {total_pages}")
    
    while True:
        print(f"\nPage {page_num}/{total_pages}:")
        content = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        if not content:
            content = soup
        
        items = content.find_all("div", class_=re.compile(r"col-"))
        for item in items:
            name_el = item.find(["h3", "h4", "h5"])
            name = get_text(name_el)
            if not name or name in ["Explore", "Maharaj & Mataji", ""]:
                continue
            
            img = item.find("img")
            img_url = ""
            if img:
                src = img.get("src", "")
                if src and not src.endswith("/"):
                    img_url = urljoin(BASE_URL, src)
            
            texts = [t.strip() for t in item.stripped_strings if t.strip() != name]
            
            # Download image
            local_img = download_image(img_url) if img_url else None
            
            all_entries.append({
                "name": name,
                "details": " | ".join(texts) if texts else "",
                "image_url": img_url,
                "local_image": local_img or "",
            })
            print(f"  {name} -> img: {local_img or 'none'}")
        
        if page_num >= total_pages:
            break
        
        page_num += 1
        targets = get_pager_targets(soup)
        target = targets.get("»") or targets.get(str(page_num)) or targets.get("..")
        if not target:
            print("No more pages found")
            break
        
        soup, html = asp.postback(url, target)
        if not soup:
            print(f"Postback failed on page {page_num}")
            break
        total_pages = max(total_pages, detect_total_pages(soup))
    
    # Save updated JSON
    with open("downloads/maharaj_mataji.json", "w", encoding="utf-8") as f:
        json.dump(all_entries, f, indent=2, ensure_ascii=False)
    
    print(f"\n{'=' * 60}")
    print(f"Total Maharaj entries: {len(all_entries)}")
    print(f"With images: {sum(1 for e in all_entries if e.get('local_image'))}")
    print("Done! JSON saved to downloads/maharaj_mataji.json")

if __name__ == "__main__":
    main()
