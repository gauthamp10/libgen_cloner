import requests
import json
import random
from bs4 import BeautifulSoup
from multiprocessing import Pool
import wget
import getpass
import requests
import pyrebase
import datetime
from fire_base import *
from config import config

firebase = pyrebase.initialize_app(config)
auth = firebase.auth()
user = auth.sign_in_with_email_and_password(config['uname'],config['passw'])
root ="Test_Write" 								#Name of firebase db root name
db = firebase.database()
print("-----Logged in------\n")

ids=list()

def get_book_data(ids):
    headers = {'User-Agent': 'My User Agent 1.0','From': 'youremail@domain.com'  }
    data=requests.get('http://libgen.io/json.php?ids='+str(ids)+'&fields=*',headers=headers).json()[0]
    print("Book"+str(ids)+": ",data['title'])
    write(db, user, data, ids,"Test_Write")
    
def generate_ids():
    for i  in range(1,999999):
        ids.append(i)
    
generate_ids()


p = Pool(20)
p.map(get_book_data, ids)
p.terminate()
p.join()