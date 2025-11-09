import urllib.request
from bs4 import BeautifulSoup
import re

#Name : Pedro
#StudentNum: 200481152
#Date:2025/11/07
#Time: 12:24

#This will check the url for if it is valid and then pass into the next stage where it will then search and parse information on the website for emails that
# match that regex

def validUrl(url):
    
    validEmail = re.compile(r"\w+@\w+\.\w+")
    url = urllib.request.urlopen(url)
    html = url.read()
    soup = BeautifulSoup(html, "html.parser")
    formattedText = soup.get_text()
    listOfText = formattedText.split()
    emailList = []

    # Loops through the text list to find for emails 
    for email in listOfText:
        matchObj = validEmail.search(email)
        if matchObj:
             emailList.append(email)
    return emailList

print (validUrl("https://barrie.ca"))
