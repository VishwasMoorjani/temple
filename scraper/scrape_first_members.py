import os
import json
import hashlib
import requests
from urllib.parse import urljoin
import time

BASE_URL = "https://rajasthanjainsabha.in/"
DOWNLOAD_DIR = "downloads"
TARGET_MEMBER_COUNT = 500  # Scrape images for the first 500 members (sorted by name)
HEADERS = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36"
}

def get_hashed_name(url):
    if not url or url == "#" or url.startswith("javascript:"):
        return None
    full_url = urljoin(BASE_URL, url)
    ext = os.path.splitext(full_url.split("?")[0])[-1] or ".jpg"
    return hashlib.md5(full_url.encode()).hexdigest()[:12] + ext

def download_image(url, subfolder):
    if not url or url == "#" or "user.png" in url: return
    full_url = urljoin(BASE_URL, url)
    filename = get_hashed_name(url)
    if not filename: return
    
    os.makedirs(os.path.join(DOWNLOAD_DIR, subfolder), exist_ok=True)
    filepath = os.path.join(DOWNLOAD_DIR, subfolder, filename)
    
    if os.path.exists(filepath) and os.path.getsize(filepath) > 1000:
        return filepath

    try:
        print(f"  Downloading: {full_url}")
        resp = requests.get(full_url, timeout=15, headers=HEADERS)
        if resp.status_code == 200 and len(resp.content) > 100:
            with open(filepath, "wb") as f:
                f.write(resp.content)
            return filepath
    except Exception as e:
        print(f"  Error: {e}")
    return None

def main():
    jf = os.path.join(DOWNLOAD_DIR, "members.json")
    if not os.path.exists(jf):
        print("members.json not found")
        return
        
    with open(jf, "r", encoding="utf-8") as f:
        members = json.load(f)
    
    # Sort members by name like the controller does
    members.sort(key=lambda x: x.get("name", "").lower())
    
    print(f"Targeting first {TARGET_MEMBER_COUNT} members...")
    downloaded = 0
    for i, m in enumerate(members[:TARGET_MEMBER_COUNT]):
        if m.get("photo_url"):
            res = download_image(m["photo_url"], "members")
            if res:
                downloaded += 1
                time.sleep(0.5) # Gentle delay
                
    print(f"Finished. Downloaded {downloaded} new images.")

if __name__ == "__main__":
    main()
