"""
Rajasthan Jain Sabha - Full Website Scraper
============================================
ASP.NET WebForms postback-aware scraper.
Handles VIEWSTATE, EVENTVALIDATION, and __doPostBack pagination.

Usage:
    pip install requests beautifulsoup4
    python scrape_rjs.py

Output:  ./downloads/  (JSON + images)
"""

import os
import re
import sys
import json
import time
import hashlib
import logging
import requests
from datetime import datetime
from bs4 import BeautifulSoup
from urllib.parse import urljoin

# ─── Configuration ──────────────────────────────────────────────────
BASE_URL = "https://rajasthanjainsabha.in/"
DOWNLOAD_DIR = os.path.join(os.path.dirname(os.path.abspath(__file__)), "downloads")
DELAY = 1.5  # seconds between requests
MAX_RETRIES = 3

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 "
                  "(KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
    "Accept-Language": "en-US,en;q=0.5",
    "Referer": BASE_URL,
}

# ─── Logging ────────────────────────────────────────────────────────
os.makedirs(DOWNLOAD_DIR, exist_ok=True)
logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s [%(levelname)s] %(message)s",
    handlers=[
        logging.StreamHandler(),
        logging.FileHandler(os.path.join(DOWNLOAD_DIR, "scraper.log"), encoding="utf-8"),
    ],
)
log = logging.getLogger("rjs_scraper")


# ─── Utility Functions ──────────────────────────────────────────────
class ASPSession:
    """Maintains ASP.NET session state across requests."""

    def __init__(self):
        self.session = requests.Session()
        self.session.headers.update(HEADERS)
        self.viewstate = ""
        self.viewstate_gen = ""
        self.event_validation = ""

    def get_page(self, url, retries=MAX_RETRIES):
        """GET a page and extract ASP.NET hidden fields."""
        for attempt in range(retries):
            try:
                resp = self.session.get(url, timeout=30)
                resp.raise_for_status()
                soup = BeautifulSoup(resp.text, "html.parser")
                self._extract_hidden_fields(soup)
                time.sleep(DELAY)
                return soup, resp.text
            except Exception as e:
                log.warning(f"GET {url} attempt {attempt+1} failed: {e}")
                time.sleep(DELAY * 2)
        log.error(f"Failed to GET {url} after {retries} retries")
        return None, ""

    def postback(self, url, event_target, event_argument="", extra_data=None, retries=MAX_RETRIES):
        """Simulate an ASP.NET __doPostBack call."""
        data = {
            "__VIEWSTATE": self.viewstate,
            "__VIEWSTATEGENERATOR": self.viewstate_gen,
            "__EVENTVALIDATION": self.event_validation,
            "__EVENTTARGET": event_target,
            "__EVENTARGUMENT": event_argument,
        }
        if extra_data:
            data.update(extra_data)

        for attempt in range(retries):
            try:
                resp = self.session.post(url, data=data, timeout=60)
                resp.raise_for_status()
                soup = BeautifulSoup(resp.text, "html.parser")
                self._extract_hidden_fields(soup)
                time.sleep(DELAY)
                return soup, resp.text
            except Exception as e:
                log.warning(f"POST {url} attempt {attempt+1} failed: {e}")
                time.sleep(DELAY * 2)
        log.error(f"Failed to POST {url} after {retries} retries")
        return None, ""

    def _extract_hidden_fields(self, soup):
        vs = soup.find("input", {"id": "__VIEWSTATE"})
        if vs:
            self.viewstate = vs.get("value", "")
        vsg = soup.find("input", {"id": "__VIEWSTATEGENERATOR"})
        if vsg:
            self.viewstate_gen = vsg.get("value", "")
        ev = soup.find("input", {"id": "__EVENTVALIDATION"})
        if ev:
            self.event_validation = ev.get("value", "")


def save_json(data, filename):
    """Save data as JSON to the downloads directory."""
    filepath = os.path.join(DOWNLOAD_DIR, filename)
    with open(filepath, "w", encoding="utf-8") as f:
        json.dump(data, f, ensure_ascii=False, indent=2)
    log.info(f"Saved {filepath} ({len(data) if isinstance(data, list) else 'object'} records)")


def download_image(url, subfolder, filename=None):
    """Download an image, return local path or None."""
    if not url or url.startswith("javascript:") or url == "#":
        return None

    full_url = urljoin(BASE_URL, url)
    folder = os.path.join(DOWNLOAD_DIR, subfolder)
    os.makedirs(folder, exist_ok=True)

    if not filename:
        # Use hash of URL for unique filename, preserve extension
        ext = os.path.splitext(full_url.split("?")[0])[-1] or ".jpg"
        filename = hashlib.md5(full_url.encode()).hexdigest()[:12] + ext

    filepath = os.path.join(folder, filename)
    if os.path.exists(filepath):
        return filepath  # Already downloaded

    # Retry logic for image downloads
    for attempt in range(MAX_RETRIES):
        try:
            resp = requests.get(full_url, timeout=30, headers=HEADERS)
            if resp.status_code == 200 and len(resp.content) > 100:
                with open(filepath, "wb") as f:
                    f.write(resp.content)
                return filepath
            elif resp.status_code == 404:
                return None # Don't retry 404s
        except Exception as e:
            if attempt < MAX_RETRIES - 1:
                log.warning(f"Retry {attempt+1} for image {full_url}: {e}")
                time.sleep(DELAY * 2)
            else:
                log.error(f"Failed to download image {full_url} after {MAX_RETRIES} attempts: {e}")

    return None


def get_text(el):
    """Safely get text from an element."""
    return el.get_text(strip=True) if el else ""


def detect_total_pages(soup):
    """Detect total pages from ASP.NET repeater pager."""
    pager_links = soup.select("a[id*='lnkPage']")
    if not pager_links:
        return 1

    # Look for the last numeric page link (often the "last page" link)
    max_page = 1
    for link in pager_links:
        text = link.get_text(strip=True)
        # Skip navigation symbols
        if text in ["»", "»ı", "«", "ı«", ".."]:
            continue
        try:
            page_num = int(text)
            max_page = max(max_page, page_num)
        except ValueError:
            pass
    return max_page


def get_pager_event_targets(soup):
    """Extract pager __doPostBack event targets."""
    pager_links = soup.select("a[id*='lnkPage']")
    targets = {}
    for link in pager_links:
        text = link.get_text(strip=True)
        href = link.get("href", "")
        match = re.search(r"__doPostBack\('([^']+)'", href)
        if match:
            targets[text] = match.group(1)
    return targets


# ─── Module Scrapers ────────────────────────────────────────────────

def scrape_members():
    """Scrape Lifetime Members (Members.aspx) - 856 pages."""
    log.info("=" * 60)
    log.info("SCRAPING: Lifetime Members")
    url = urljoin(BASE_URL, "Members.aspx")
    asp = ASPSession()

    all_members = []
    page_num = 1

    soup, html = asp.get_page(url)
    if not soup:
        return []

    total_pages = detect_total_pages(soup)
    log.info(f"Members: {total_pages} pages detected")

    while True:
        # Extract members from current page
        members_on_page = _extract_members_from_page(soup)
        all_members.extend(members_on_page)
        log.info(f"  Page {page_num}/{total_pages}: {len(members_on_page)} members (total: {len(all_members)})")

        if page_num >= total_pages:
            break

        # Navigate to next page
        page_num += 1
        pager_targets = get_pager_event_targets(soup)

        # Strategy: click "»" (next) button if available, else click page number
        target = None
        if "»" in pager_targets:
            target = pager_targets["»"]
        elif str(page_num) in pager_targets:
            target = pager_targets[str(page_num)]
        else:
            # Try to find next page in pager
            # If current window doesn't show target page, click ".." to advance window
            if ".." in pager_targets:
                target = pager_targets[".."]
            else:
                log.warning(f"Cannot navigate to page {page_num}, stopping")
                break

        soup, html = asp.postback(url, target)
        if not soup:
            log.error(f"Failed at page {page_num}")
            break

        # Re-detect total pages (pager window may have shifted)
        total_pages = max(total_pages, detect_total_pages(soup))

        # Periodic save
        if page_num % 50 == 0:
            save_json(all_members, "members_partial.json")

    save_json(all_members, "members.json")
    return all_members


def _extract_members_from_page(soup):
    """Extract member data from a Members.aspx page."""
    members = []
    # Members are in cards with repeater items
    cards = soup.select("[id*='rptList'] .card, [id*='rptList'] .team-player, .col-lg-3 .card")

    if not cards:
        # Fallback: find all h3/h5 with member names
        # The structure appears to be divs with name and ID
        content_area = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        if content_area:
            items = content_area.find_all("div", class_=re.compile(r"col-"))
            for item in items:
                name_el = item.find(["h3", "h4", "h5"])
                if not name_el:
                    continue
                name = get_text(name_el)
                if not name or name in ["Explore"]:
                    continue

                # Extract image
                img = item.find("img")
                img_url = img.get("src", "") if img else ""

                # Extract member ID
                texts = [t.strip() for t in item.stripped_strings]
                member_id = ""
                mobile = ""
                for t in texts:
                    if "Life Member ID:" in t:
                        member_id = t.replace("Life Member ID:", "").strip()
                    elif re.match(r"^\d{10}$", t):
                        mobile = t

                members.append({
                    "name": name,
                    "life_member_id": member_id,
                    "mobile": mobile,
                    "photo_url": urljoin(BASE_URL, img_url) if img_url else "",
                    "type": "lifetime",
                })
        return members

    for card in cards:
        name_el = card.find(["h3", "h4", "h5"])
        name = get_text(name_el)
        if not name or name in ["Explore"]:
            continue

        img = card.find("img")
        img_url = img.get("src", "") if img else ""

        texts = [t.strip() for t in card.stripped_strings]
        member_id = ""
        mobile = ""
        for t in texts:
            if "Life Member ID:" in t:
                member_id = t.replace("Life Member ID:", "").strip()
            elif re.match(r"^\d{10}$", t):
                mobile = t

        members.append({
            "name": name,
            "life_member_id": member_id,
            "mobile": mobile,
            "photo_url": urljoin(BASE_URL, img_url) if img_url else "",
            "type": "lifetime",
        })

    return members


def scrape_executive_members():
    """Scrape Executive Members (ExecutiveMember.aspx) - ~1 page."""
    log.info("=" * 60)
    log.info("SCRAPING: Executive Members")
    url = urljoin(BASE_URL, "ExecutiveMember.aspx")
    asp = ASPSession()

    all_members = []
    soup, html = asp.get_page(url)
    if not soup:
        return []

    total_pages = detect_total_pages(soup)
    page_num = 1

    while True:
        content = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        if content:
            items = content.find_all("div", class_=re.compile(r"col-"))
            for item in items:
                name_el = item.find(["h3", "h4", "h5"])
                name = get_text(name_el)
                if not name or name in ["Explore", "Executive Member"]:
                    continue

                img = item.find("img")
                img_url = img.get("src", "") if img else ""

                texts = [t.strip() for t in item.stripped_strings]
                designation = ""
                mobile = ""
                address = ""

                # Parse text elements: name, designation, phone, address
                clean_texts = [t for t in texts if t != name]
                for i, t in enumerate(clean_texts):
                    if re.match(r"^\d{10}$", t) or re.match(r"^\d{10}\s", t):
                        parts = t.split(" ", 1)
                        mobile = parts[0]
                        if len(parts) > 1:
                            address = parts[1]
                    elif t in ["President", "Vice President", "Senior Vice President",
                               "General Secretary", "Secretary", "Joint Secretary",
                               "Treasurer", "Working Member", "Associate Member"]:
                        designation = t
                    elif not designation:
                        designation = t

                all_members.append({
                    "name": name,
                    "designation": designation,
                    "mobile": mobile,
                    "address": address,
                    "photo_url": urljoin(BASE_URL, img_url) if img_url else "",
                    "type": "executive",
                })

        if page_num >= total_pages:
            break

        page_num += 1
        pager_targets = get_pager_event_targets(soup)
        target = pager_targets.get("»") or pager_targets.get(str(page_num))
        if not target:
            break
        soup, html = asp.postback(url, target)
        if not soup:
            break

    save_json(all_members, "executive_members.json")
    return all_members


def scrape_temples():
    """Scrape Temples directory (Temples.aspx)."""
    log.info("=" * 60)
    log.info("SCRAPING: Temples")
    url = urljoin(BASE_URL, "Temples.aspx")
    asp = ASPSession()

    all_temples = []
    soup, html = asp.get_page(url)
    if not soup:
        return []

    total_pages = detect_total_pages(soup)
    page_num = 1

    while True:
        content = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        if content:
            items = content.find_all("div", class_=re.compile(r"col-"))
            for item in items:
                name_el = item.find(["h3", "h4", "h5"])
                name = get_text(name_el)
                if not name or name in ["Explore", "Temples"]:
                    continue

                img = item.find("img")
                img_url = img.get("src", "") if img else ""

                texts = [t.strip() for t in item.stripped_strings if t.strip() != name]
                address = ""
                city = ""
                contact = ""

                for t in texts:
                    if re.match(r"^\d{10}", t):
                        contact = t
                    elif not address:
                        address = t
                    else:
                        city = t

                all_temples.append({
                    "name": name,
                    "address": address,
                    "city": city,
                    "contact": contact,
                    "image_url": urljoin(BASE_URL, img_url) if img_url else "",
                })

        if page_num >= total_pages:
            break

        page_num += 1
        pager_targets = get_pager_event_targets(soup)
        target = pager_targets.get("»") or pager_targets.get(str(page_num)) or pager_targets.get("..")
        if not target:
            break
        soup, html = asp.postback(url, target)
        if not soup:
            break
        total_pages = max(total_pages, detect_total_pages(soup))
        log.info(f"  Temples page {page_num}/{total_pages}")

    save_json(all_temples, "temples.json")
    return all_temples


def scrape_maharaj_mataji():
    """Scrape Maharaj & Mataji (MaharajaMaharani.aspx)."""
    log.info("=" * 60)
    log.info("SCRAPING: Maharaj & Mataji")
    url = urljoin(BASE_URL, "MaharajaMaharani.aspx")
    asp = ASPSession()

    all_entries = []
    soup, html = asp.get_page(url)
    if not soup:
        return []

    total_pages = detect_total_pages(soup)
    page_num = 1

    while True:
        content = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        if content:
            items = content.find_all("div", class_=re.compile(r"col-"))
            for item in items:
                name_el = item.find(["h3", "h4", "h5"])
                name = get_text(name_el)
                if not name or name in ["Explore", "Maharaj & Mataji"]:
                    continue

                img = item.find("img")
                img_url = img.get("src", "") if img else ""

                texts = [t.strip() for t in item.stripped_strings if t.strip() != name]

                all_entries.append({
                    "name": name,
                    "details": " | ".join(texts) if texts else "",
                    "image_url": urljoin(BASE_URL, img_url) if img_url else "",
                })

        if page_num >= total_pages:
            break

        page_num += 1
        pager_targets = get_pager_event_targets(soup)
        target = pager_targets.get("»") or pager_targets.get(str(page_num))
        if not target:
            break
        soup, html = asp.postback(url, target)
        if not soup:
            break
        log.info(f"  Maharaj page {page_num}/{total_pages}")

    save_json(all_entries, "maharaj_mataji.json")
    return all_entries


def scrape_yellow_pages():
    """Scrape Jain Yellow Pages (Advertisement.aspx)."""
    log.info("=" * 60)
    log.info("SCRAPING: Yellow Pages")
    url = urljoin(BASE_URL, "Advertisement.aspx")
    asp = ASPSession()

    all_businesses = []
    soup, html = asp.get_page(url)
    if not soup:
        return []

    total_pages = detect_total_pages(soup)
    page_num = 1

    while True:
        content = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        if content:
            items = content.find_all("div", class_=re.compile(r"col-"))
            for item in items:
                name_el = item.find(["h3", "h4", "h5"])
                name = get_text(name_el)
                if not name or name in ["Explore", "Jain Yellow Pages"]:
                    continue

                img = item.find("img")
                img_url = img.get("src", "") if img else ""

                texts = [t.strip() for t in item.stripped_strings if t.strip() != name]
                category = texts[0] if len(texts) > 0 else ""
                address = texts[1] if len(texts) > 1 else ""
                contact_person = texts[2] if len(texts) > 2 else ""
                phone = texts[3] if len(texts) > 3 else ""
                email = texts[4] if len(texts) > 4 else ""

                all_businesses.append({
                    "business_name": name,
                    "category": category,
                    "address": address,
                    "contact_person": contact_person,
                    "phone": phone,
                    "email": email,
                    "image_url": urljoin(BASE_URL, img_url) if img_url else "",
                })

        if page_num >= total_pages:
            break

        page_num += 1
        pager_targets = get_pager_event_targets(soup)
        target = pager_targets.get("»") or pager_targets.get(str(page_num))
        if not target:
            break
        soup, html = asp.postback(url, target)
        if not soup:
            break

    save_json(all_businesses, "yellow_pages.json")
    return all_businesses


def scrape_programs(program_type, filename):
    """Scrape Programs (Upcoming/Recent/Previous)."""
    page_map = {
        "upcoming": "UpcommingProgram.aspx",
        "recent": "RecentProgram.aspx",
        "previous": "PreviousProgram.aspx",
    }
    log.info("=" * 60)
    log.info(f"SCRAPING: Programs ({program_type})")
    url = urljoin(BASE_URL, page_map[program_type])
    asp = ASPSession()

    all_programs = []
    soup, html = asp.get_page(url)
    if not soup:
        return []

    total_pages = detect_total_pages(soup)
    page_num = 1

    while True:
        content = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        if content:
            items = content.find_all("div", class_=re.compile(r"col-"))
            for item in items:
                name_el = item.find(["h3", "h4", "h5"])
                name = get_text(name_el)
                if not name or name in ["Explore", "Upcomming Program", "Recent Program", "Previous Program"]:
                    continue

                img = item.find("img")
                img_url = img.get("src", "") if img else ""

                texts = [t.strip() for t in item.stripped_strings if t.strip() != name]

                # Try to extract date, venue, description
                date = ""
                venue = ""
                description = ""
                for t in texts:
                    if re.search(r"\d{2}[-/]\d{2}[-/]\d{4}", t):
                        date = t
                    elif not venue and len(t) < 100:
                        venue = t
                    else:
                        description += t + " "

                all_programs.append({
                    "title": name,
                    "date": date.strip(),
                    "venue": venue.strip(),
                    "description": description.strip(),
                    "image_url": urljoin(BASE_URL, img_url) if img_url else "",
                    "type": program_type,
                })

        if page_num >= total_pages:
            break

        page_num += 1
        pager_targets = get_pager_event_targets(soup)
        target = pager_targets.get("»") or pager_targets.get(str(page_num))
        if not target:
            break
        soup, html = asp.postback(url, target)
        if not soup:
            break
        log.info(f"  Programs ({program_type}) page {page_num}/{total_pages}")

    save_json(all_programs, filename)
    return all_programs


def scrape_news():
    """Scrape News (News.aspx)."""
    log.info("=" * 60)
    log.info("SCRAPING: News")
    url = urljoin(BASE_URL, "News.aspx")
    asp = ASPSession()

    all_news = []
    soup, html = asp.get_page(url)
    if not soup:
        return []

    total_pages = detect_total_pages(soup)
    page_num = 1

    while True:
        content = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        if content:
            items = content.find_all("div", class_=re.compile(r"col-"))
            for item in items:
                name_el = item.find(["h3", "h4", "h5"])
                name = get_text(name_el)
                if not name or name in ["Explore", "News"]:
                    continue

                img = item.find("img")
                img_url = img.get("src", "") if img else ""

                texts = [t.strip() for t in item.stripped_strings if t.strip() != name]
                date = ""
                desc = ""
                for t in texts:
                    if re.search(r"\d{2}[-/]\d{2}[-/]\d{4}", t):
                        date = t
                    else:
                        desc += t + " "

                all_news.append({
                    "title": name,
                    "date": date.strip(),
                    "description": desc.strip(),
                    "image_url": urljoin(BASE_URL, img_url) if img_url else "",
                })

        if page_num >= total_pages:
            break

        page_num += 1
        pager_targets = get_pager_event_targets(soup)
        target = pager_targets.get("»") or pager_targets.get(str(page_num))
        if not target:
            break
        soup, html = asp.postback(url, target)
        if not soup:
            break

    save_json(all_news, "news.json")
    return all_news


def scrape_jobs():
    """Scrape Jobs (Jobs.aspx)."""
    log.info("=" * 60)
    log.info("SCRAPING: Jobs")
    url = urljoin(BASE_URL, "Jobs.aspx")
    asp = ASPSession()

    all_jobs = []
    soup, html = asp.get_page(url)
    if not soup:
        return []

    total_pages = detect_total_pages(soup)
    page_num = 1

    while True:
        content = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        if content:
            items = content.find_all("div", class_=re.compile(r"col-"))
            for item in items:
                name_el = item.find(["h3", "h4", "h5"])
                name = get_text(name_el)
                if not name or name in ["Explore", "Jobs"]:
                    continue

                texts = [t.strip() for t in item.stripped_strings if t.strip() != name]

                all_jobs.append({
                    "title": name,
                    "details": " | ".join(texts),
                })

        if page_num >= total_pages:
            break

        page_num += 1
        pager_targets = get_pager_event_targets(soup)
        target = pager_targets.get("»") or pager_targets.get(str(page_num))
        if not target:
            break
        soup, html = asp.postback(url, target)
        if not soup:
            break

    save_json(all_jobs, "jobs.json")
    return all_jobs


def scrape_dharmshala():
    """Scrape Dharmshala (Dharmshala.aspx)."""
    log.info("=" * 60)
    log.info("SCRAPING: Dharmshala")
    url = urljoin(BASE_URL, "Dharmshala.aspx")
    asp = ASPSession()

    all_items = []
    soup, html = asp.get_page(url)
    if not soup:
        return []

    total_pages = detect_total_pages(soup)
    page_num = 1

    while True:
        content = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        if content:
            items = content.find_all("div", class_=re.compile(r"col-"))
            for item in items:
                name_el = item.find(["h3", "h4", "h5"])
                name = get_text(name_el)
                if not name or name in ["Explore", "Dharmshala"]:
                    continue

                texts = [t.strip() for t in item.stripped_strings if t.strip() != name]
                address = texts[0] if len(texts) > 0 else ""
                city = texts[1] if len(texts) > 1 else ""
                contact = texts[2] if len(texts) > 2 else ""

                all_items.append({
                    "name": name,
                    "address": address,
                    "city": city,
                    "contact": contact,
                })

        if page_num >= total_pages:
            break

        page_num += 1
        pager_targets = get_pager_event_targets(soup)
        target = pager_targets.get("»") or pager_targets.get(str(page_num))
        if not target:
            break
        soup, html = asp.postback(url, target)
        if not soup:
            break

    save_json(all_items, "dharmshala.json")
    return all_items


def scrape_tiye_ki_bethak():
    """Scrape Tiye Ki Bethak."""
    log.info("=" * 60)
    log.info("SCRAPING: Tiye Ki Bethak")
    url = urljoin(BASE_URL, "TiyeKiBethak.aspx")
    asp = ASPSession()

    all_items = []
    soup, html = asp.get_page(url)
    if not soup:
        return []

    total_pages = detect_total_pages(soup)
    page_num = 1

    while True:
        content = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        if content:
            items = content.find_all("div", class_=re.compile(r"col-"))
            for item in items:
                name_el = item.find(["h3", "h4", "h5"])
                name = get_text(name_el)
                if not name or name in ["Explore", "Tiye Ki Bethak"]:
                    continue

                img = item.find("img")
                img_url = img.get("src", "") if img else ""

                texts = [t.strip() for t in item.stripped_strings if t.strip() != name]

                all_items.append({
                    "title": name,
                    "content": " ".join(texts),
                    "image_url": urljoin(BASE_URL, img_url) if img_url else "",
                })

        if page_num >= total_pages:
            break

        page_num += 1
        pager_targets = get_pager_event_targets(soup)
        target = pager_targets.get("»") or pager_targets.get(str(page_num))
        if not target:
            break
        soup, html = asp.postback(url, target)
        if not soup:
            break

    save_json(all_items, "tiye_ki_bethak.json")
    return all_items


def scrape_gallery():
    """Scrape Gallery albums and images."""
    log.info("=" * 60)
    log.info("SCRAPING: Gallery")
    url = urljoin(BASE_URL, "Gallery.aspx")
    asp = ASPSession()

    all_albums = []
    soup, html = asp.get_page(url)
    if not soup:
        return []

    total_pages = detect_total_pages(soup)
    page_num = 1

    while True:
        content = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        if content:
            items = content.find_all("div", class_=re.compile(r"col-"))
            for item in items:
                name_el = item.find(["h3", "h4", "h5"])
                name = get_text(name_el)
                if not name or name in ["Explore", "Gallery"]:
                    continue

                img = item.find("img")
                img_url = img.get("src", "") if img else ""

                # Check for link to album detail
                link = item.find("a")
                album_url = link.get("href", "") if link else ""

                all_albums.append({
                    "title": name,
                    "thumbnail_url": urljoin(BASE_URL, img_url) if img_url else "",
                    "album_link": urljoin(BASE_URL, album_url) if album_url and not album_url.startswith("javascript:") else "",
                    "images": [],
                })

        if page_num >= total_pages:
            break

        page_num += 1
        pager_targets = get_pager_event_targets(soup)
        target = pager_targets.get("»") or pager_targets.get(str(page_num)) or pager_targets.get("..")
        if not target:
            break
        soup, html = asp.postback(url, target)
        if not soup:
            break
        total_pages = max(total_pages, detect_total_pages(soup))
        log.info(f"  Gallery page {page_num}/{total_pages}")

    # For each album with a detail link, scrape images
    for album in all_albums:
        if album["album_link"]:
            try:
                asp2 = ASPSession()
                detail_soup, _ = asp2.get_page(album["album_link"])
                if detail_soup:
                    imgs = detail_soup.find_all("img")
                    for img in imgs:
                        src = img.get("src", "")
                        if src and "upload" in src.lower() or "gallery" in src.lower():
                            album["images"].append(urljoin(BASE_URL, src))
            except Exception as e:
                log.warning(f"Failed to scrape album detail: {e}")

    save_json(all_albums, "gallery.json")
    return all_albums


def scrape_static_pages():
    """Scrape static content pages."""
    log.info("=" * 60)
    log.info("SCRAPING: Static Pages")

    pages = {
        "about": "About.aspx",
        "history": "History.aspx",
        "contact": "Contact.aspx",
        "privacy_policy": "PrivacyPolicy.aspx",
        "terms": "TermAndCondition.aspx",
        "health_medical": "HealthMedical.aspx",
        "education_scholarship": "EducationSchlorship.aspx",
        "donation_pension": "DonationPension.aspx",
    }

    all_pages = {}
    asp = ASPSession()

    for key, page_file in pages.items():
        url = urljoin(BASE_URL, page_file)
        soup, html = asp.get_page(url)
        if not soup:
            all_pages[key] = {"url": url, "content": "", "error": "Failed to fetch"}
            continue

        content_area = soup.find("div", {"id": lambda x: x and "ContentPlaceHolder" in x})
        content_html = str(content_area) if content_area else ""
        content_text = content_area.get_text(separator="\n", strip=True) if content_area else ""

        # Extract images from static pages
        images = []
        if content_area:
            for img in content_area.find_all("img"):
                src = img.get("src", "")
                if src:
                    images.append(urljoin(BASE_URL, src))

        all_pages[key] = {
            "url": url,
            "title": soup.title.string.strip() if soup.title else key,
            "content_html": content_html,
            "content_text": content_text,
            "images": images,
        }
        log.info(f"  Scraped: {key} ({len(content_text)} chars)")

    save_json(all_pages, "static_pages.json")
    return all_pages


def scrape_homepage():
    """Scrape homepage dynamic content (sliders, featured members, stats, philosophy)."""
    log.info("=" * 60)
    log.info("SCRAPING: Homepage")
    url = BASE_URL
    asp = ASPSession()

    soup, html = asp.get_page(url)
    if not soup:
        return {}

    homepage = {
        "stats": {},
        "philosophy": [],
        "featured_members": [],
        "slider_images": [],
        "contact_info": {},
    }

    # Stats (Members count, Maharaj, Mataji, Jobs)
    stat_items = soup.find_all(text=re.compile(r"Members|Maharaj|Mataji|Jobs"))
    for item in stat_items:
        parent = item.parent
        if parent:
            num_el = parent.find_previous(text=re.compile(r"^\d+$"))
            if num_el:
                homepage["stats"][item.strip()] = num_el.strip()

    # Slider images
    sliders = soup.find_all("div", class_=re.compile(r"slide|carousel|banner", re.I))
    for slider in sliders:
        imgs = slider.find_all("img")
        for img in imgs:
            src = img.get("src", "")
            if src:
                homepage["slider_images"].append(urljoin(BASE_URL, src))

    # Featured members
    member_section = soup.find(text=re.compile(r"Our.*Members", re.I))
    if member_section:
        parent = member_section.find_parent("div")
        if parent:
            cards = parent.find_all("div", class_=re.compile(r"col-"))
            for card in cards:
                name_el = card.find(["h3", "h4", "h5"])
                name = get_text(name_el)
                if name:
                    img = card.find("img")
                    phone_el = card.find("a", href=re.compile(r"tel:"))
                    homepage["featured_members"].append({
                        "name": name,
                        "phone": get_text(phone_el),
                        "photo": urljoin(BASE_URL, img.get("src", "")) if img else "",
                    })

    # Contact info
    homepage["contact_info"] = {
        "phone": "+91-97838 34102",
        "email": "rajasthanjainsabha@gmail.com",
        "address": "Basement In, Plot No 803, The Prime, Ashok Chowk, Adarsh Nagar, Jaipur",
    }

    save_json(homepage, "homepage.json")
    return homepage


def download_all_images(data_dir=DOWNLOAD_DIR):
    """Download all images referenced in extracted JSON files."""
    log.info("=" * 60)
    log.info("DOWNLOADING: All Images")

    json_files = [f for f in os.listdir(data_dir) if f.endswith(".json")]
    total_downloaded = 0

    for jf in json_files:
        filepath = os.path.join(data_dir, jf)
        try:
            with open(filepath, "r", encoding="utf-8") as f:
                data = json.load(f)
        except Exception:
            continue

        module = jf.replace(".json", "")

        if isinstance(data, list):
            for item in data:
                for key in ["photo_url", "image_url", "thumbnail_url"]:
                    if key in item and item[key]:
                        local = download_image(item[key], module)
                        if local:
                            total_downloaded += 1
                if "images" in item and isinstance(item["images"], list):
                    for img_url in item["images"]:
                        local = download_image(img_url, module)
                        if local:
                            total_downloaded += 1
        elif isinstance(data, dict):
            for key, val in data.items():
                if isinstance(val, dict):
                    for img_key in ["images", "slider_images"]:
                        if img_key in val and isinstance(val[img_key], list):
                            for img_url in val[img_key]:
                                local = download_image(img_url, module)
                                if local:
                                    total_downloaded += 1

    log.info(f"Total images downloaded: {total_downloaded}")


def generate_summary():
    """Generate a summary of all scraped data."""
    log.info("=" * 60)
    log.info("GENERATING: Summary Report")

    summary = {
        "generated_at": datetime.now().isoformat(),
        "modules": {},
    }

    json_files = [f for f in os.listdir(DOWNLOAD_DIR) if f.endswith(".json") and f != "summary.json"]

    for jf in sorted(json_files):
        filepath = os.path.join(DOWNLOAD_DIR, jf)
        try:
            with open(filepath, "r", encoding="utf-8") as f:
                data = json.load(f)

            module = jf.replace(".json", "")
            if isinstance(data, list):
                summary["modules"][module] = {
                    "record_count": len(data),
                    "sample": data[:2] if data else [],
                    "empty_fields": _check_empty_fields(data),
                }
            elif isinstance(data, dict):
                summary["modules"][module] = {
                    "type": "object",
                    "keys": list(data.keys()),
                }
        except Exception as e:
            log.warning(f"Error reading {jf}: {e}")

    save_json(summary, "summary.json")
    return summary


def _check_empty_fields(data):
    """Check for empty fields across all records."""
    if not data:
        return {}

    empty_counts = {}
    total = len(data)
    keys = data[0].keys() if data else []

    for key in keys:
        empty = sum(1 for item in data if not item.get(key))
        if empty > 0:
            empty_counts[key] = f"{empty}/{total} ({round(empty/total*100)}%)"

    return empty_counts


# ─── Main ───────────────────────────────────────────────────────────

def main():
    log.info("=" * 60)
    log.info("Rajasthan Jain Sabha - Full Website Scraper")
    log.info(f"Output directory: {DOWNLOAD_DIR}")
    log.info(f"Delay between requests: {DELAY}s")
    log.info("=" * 60)

    start_time = time.time()

    # 1. Homepage
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "homepage.json")):
        scrape_homepage()

    # 2. Static pages
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "static_pages.json")):
        scrape_static_pages()

    # 3. Executive Members
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "executive_members.json")):
        scrape_executive_members()

    # 4. Temples
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "temples.json")):
        scrape_temples()

    # 5. Maharaj / Mataji
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "maharaj_mataji.json")):
        scrape_maharaj_mataji()

    # 6. Yellow Pages
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "yellow_pages.json")):
        scrape_yellow_pages()

    # 7. Programs
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "programs_previous.json")):
        scrape_programs("upcoming", "programs_upcoming.json")
        scrape_programs("recent", "programs_recent.json")
        scrape_programs("previous", "programs_previous.json")

    # 8. News
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "news.json")):
        scrape_news()

    # 9. Jobs
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "jobs.json")):
        scrape_jobs()

    # 10. Dharmshala
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "dharmshala.json")):
        scrape_dharmshala()

    # 11. Tiye Ki Bethak
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "tiye_ki_bethak.json")):
        scrape_tiye_ki_bethak()

    # 12. Gallery
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "gallery.json")):
        scrape_gallery()

    # 13. Lifetime Members
    if not os.path.exists(os.path.join(DOWNLOAD_DIR, "members.json")):
        scrape_members()

    # 14. Download all images
    download_all_images()

    # 15. Generate summary
    summary = generate_summary()

    elapsed = time.time() - start_time
    log.info("=" * 60)
    log.info(f"SCRAPING COMPLETE in {elapsed/60:.1f} minutes")
    log.info(f"Summary: {json.dumps(summary.get('modules', {}), indent=2, default=str)[:2000]}")
    log.info("=" * 60)


if __name__ == "__main__":
    main()
