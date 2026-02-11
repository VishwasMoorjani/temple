import os
import json
import hashlib
import requests
from urllib.parse import urljoin
import time

BASE_URL = "https://rajasthanjainsabha.in/"
DOWNLOAD_DIR = "downloads"
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
    if not url or url == "#": return
    full_url = urljoin(BASE_URL, url)
    filename = get_hashed_name(url)
    if not filename: return
    
    os.makedirs(os.path.join(DOWNLOAD_DIR, subfolder), exist_ok=True)
    filepath = os.path.join(DOWNLOAD_DIR, subfolder, filename)
    
    if os.path.exists(filepath):
        print(f"  Skipping (exists): {filename}")
        return filepath

    try:
        print(f"  Downloading: {full_url} -> {filename}")
        resp = requests.get(full_url, timeout=15, headers=HEADERS)
        if resp.status_code == 200:
            with open(filepath, "wb") as f:
                f.write(resp.content)
            return filepath
    except Exception as e:
        print(f"  Error: {e}")
    return None

def main():
    # Only small modules
    modules = [
        "executive_members",
        "temples",
        "maharaj_mataji",
        "yellow_pages",
        "programs_upcoming",
        "programs_recent",
        "programs_previous",
        "news",
        "jobs",
        "dharmshala",
        "static_pages"
    ]
    
    for mod in modules:
        jf = os.path.join(DOWNLOAD_DIR, f"{mod}.json")
        if not os.path.exists(jf): continue
        
        print(f"Processing module: {mod}")
        with open(jf, "r", encoding="utf-8") as f:
            data = json.load(f)
        
        if isinstance(data, list):
            for item in data:
                for key in ["photo_url", "image_url", "thumbnail_url", "photo"]:
                    if key in item and item[key]:
                        download_image(item[key], mod)
                if "images" in item and isinstance(item["images"], list):
                    for img in item["images"]:
                        download_image(img, mod)
        elif isinstance(data, dict):
             # Static pages etc
             for slug, p in data.items():
                 if isinstance(p, dict):
                      if "image_url" in p and p["image_url"]:
                          download_image(p["image_url"], mod)

if __name__ == "__main__":
    main()
