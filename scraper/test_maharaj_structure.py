
import requests
from bs4 import BeautifulSoup

url = "https://rajasthanjainsabha.in/MaharajaMaharani.aspx"
headers = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36"
}

r = requests.get(url, headers=headers)
soup = BeautifulSoup(r.text, 'html.parser')

target = soup.find(string=lambda t: "Achariya" in str(t))
if target:
    print("Found 'Achariya':")
    # print parent of parent or so
    parent = target.find_parent("div", class_="col-md-3") or target.find_parent("div")
    if parent:
        print(parent.prettify())
    else:
        print("No parent div found")
else:
    print("Text 'Achariya' not found in page source")
