
import requests
from bs4 import BeautifulSoup

url = "https://rajasthanjainsabha.in/MaharajaMaharani.aspx"
headers = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
}

r = requests.get(url, headers=headers)
soup = BeautifulSoup(r.text, 'html.parser')

# Find all images in the content area
content = soup.find("div", {"id": "ContentPlaceHolder1_UpMain"}) or soup
imgs = content.find_all("img")

for i, img in enumerate(imgs[:10]):
    print(f"Image {i}: {img.get('src')}")

# Print one item structure
item = soup.find("div", class_="col-md-3") or soup.find("div", class_="col-sm-4")
if item:
    print("\nItem HTML:")
    print(item.prettify())
