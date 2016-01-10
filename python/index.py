#usr/bin/python

import sys
import re
import string
import requests
from urllib2 import urlopen
from bs4 import BeautifulSoup
import base64

website = ""
panel_url = "http://localhost:8888/pyscan/"
gate_scraper = "cmd/gate.php"
gate_scanner = "cmd/scan.php"
gate_vuln = "cmd/vuln.php"

class bcolors:
    RED = '\033[91m'
    HEADER = '\033[95m'
    OKBLUE = '\033[94m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'
    BOLD = '\033[1m'
    UNDERLINE = '\033[4m'

def sendurl(url):
    global website
    global panel_url
    global gate
    
    total_url = panel_url+gate_scraper+"?url="+url+"&d="+website
    html = urlopen(total_url)

def insertvuln(website, lien, typeinjection, source):
    url_prepare = panel_url+gate_vuln+"?url="+lien+"&d="+website+"&t="+typeinjection+"&s=ok"
    html = urlopen(url_prepare)

def checking(lien):
    html = urlopen(panel_url+"cmd/check.php?url="+lien).read()
    if "0" in html:
        return "ok"
    if "1" in html:
        return "nop"

def SQLinjection(lien):
    global website
    newlien = lien.replace("=", "='", 1)
    lien_openner = urlopen(newlien)
    source = lien_openner.read()
    match = "SQL syntax"
    blind = "%20AND%201=2"
    blindlink = lien.replace("=", "="+blind, 1)
    lien_opener_blind = urlopen(blindlink).read()
    if match in source:
        print(bcolors.OKGREEN+"[OK] "+bcolors.ENDC+"Error SQL found (string)")
        insertvuln(website, lien, "SQLinjection", source)
    elif lien_opener_blind != source:
        print(bcolors.OKGREEN+"[OK] "+bcolors.ENDC+"Possible injection (blind)")
    else:
        print(bcolors.WARNING+"[NOP] "+bcolors.ENDC+"No SQL possible error found .")


def scanner(lien):
    if "=" in lien:
        SQLinjection(lien)

def scraper(page):
    global website
    start_link = page.find("a href")
    if start_link == -1:
        return None, 0
    start_quote = page.find('"', start_link)
    end_quote = page.find('"', start_quote + 1)
    url = page[start_quote + 1: end_quote]
    if "http://" in url:
        scanner(url)
    elif "https://" in url:
        scanner(url)
    elif "/" in url[:1]:
        if ".com" in website[:4]:
            url = website+url
            scanner(url)
        split = website.split(".com", 1)
        url = split[0]+".com"+split[1]
        scanner(url)
    else:
        url = website+"/"+url
        scanner(url)
    result = checking(url)
    if result == "ok":
        sendurl(url)
        scraper(url)
    return url, end_quote


def main():
    global website
    if len(sys.argv) > 2:
        website = sys.argv[2]
        response = requests.get(website)
        page = str(BeautifulSoup(response.content, "html.parser"))
        while True:
            url, n = scraper(page)
            page = page[n:]
            if url:
                if url != website:
                    print url
            else:
                break
main()