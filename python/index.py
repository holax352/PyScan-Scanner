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
gate_payload = "panel/api/payload.php"
gate_database = "panel/api/database.php"

payload_all = 0

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
    global gate_scraper
    if website == "":
        website = "database"
    total_url = panel_url+gate_scraper+"?url="+url
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

def InjectPayload(payload, pattern, result, lien, perform):
    global website
    if lien != "":
        try:
            newlien = lien.replace(payload, pattern, 1)
        except:
            print(bcolors.RED+"[NOP] "+bcolors.ENDC+" "+lien+" -> No payload on url .")
        sendurl(lien)
    elif lien == "":
        lien = website
        sendurl(website)
        try:
            newlien = website.replace(payload, pattern, 1)
        except:
            print(bcolors.RED+"[NOP] "+bcolors.ENDC+" "+lien+" -> No payload on url .")
    if newlien != lien:
        if perform == "result":
            try:
                html = urlopen(newlien).read()
                if result in html:
                    if lien != "":
                        insertvuln(website, lien, payload, "ok")
                    else:
                        insertvuln(website, website, payload, "ok")
                    print(bcolors.OKGREEN+"[OK] "+bcolors.ENDC+" "+pattern+" -> Possible payload injection ( Result based )")
                    print(newlien)
                else:
                    print(bcolors.WARNING+"[NOP] "+bcolors.ENDC+" "+pattern+" -> Payload no perform .( Result based )")
            except:
                print(bcolors.RED+"[NOP] "+bcolors.ENDC+" "+lien+" -> No can open url .")
        elif perform == "compare":
            try:
                base_link = urlopen(website).read()
                injected_link = urlopen(newlien).read()
                if base_link == injected_link:
                    print(bcolors.WARNING+"[NOP] "+bcolors.ENDC+" "+pattern+" -> Payload no perform ( Comparaison based ).")
                elif base_link != injected_link:
                    print(bcolors.OKGREEN+"[OK] "+bcolors.ENDC+" "+pattern+" -> Possible payload injection ( Comparaison based )")
                    print(newlien)
            except:
                print(bcolors.WARNING+"[NOP] "+bcolors.ENDC+" "+lien+" -> No can open url .")
        elif perform == "time":
            print('sleep based');
    else:
        print(bcolors.WARNING+"[NOP] "+bcolors.ENDC+" "+payload+" -> No payload on url .")

def GetPayload(id_payload):
    url_payload = panel_url+gate_payload+"?id="+id_payload
    html = urlopen(url_payload).read()
    if html !=  "0":
        split = html.split(':::')
        InjectPayload(split[0], split[1], split[2],"",split[3])
    else:
        print("Payload error")

        
def InjectAllPayload(lien):
    url_payload = panel_url+gate_payload
    html = urlopen(url_payload).read()
    if html !=  "0":
        split = html.split('::::')
        for check in split:
            split2 = check.split(':::')
            if split2[0] != "":
                InjectPayload(split2[0], split2[1], split2[2], lien, split2[3])
    else:
        print("Payload error")

def Injectdatabase():
    url_database = panel_url+gate_database
    html = urlopen(url_database).read()
    if html != "0":
        split = html.split('::::')
        for websites in split:
            if websites != "":
                InjectAllPayload(websites)

def scanner(lien):
    if "=" in lien:
        if payload_all != "0":
            InjectAllPayload(lien)
        else:
            SQLinjection(lien)


def main():
    global website
    global payload_all
    
    if len(sys.argv) > 2:
        website = sys.argv[2]
        if "-s" in sys.argv:
            scanner(website)
            sendurl(website)
        elif "-p" in sys.argv:
            id_payload = sys.argv[4]
            GetPayload(id_payload)
        elif "--all" in sys.argv:
            payload_all = 1
            InjectAllPayload(website)
    elif "--database" in sys.argv:
        Injectdatabase()

main()