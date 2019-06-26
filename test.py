import requests
import json
import random
import itertools
import wget

def get_book_data(id):
    data=requests.get('http://libgen.io/json.php?ids='+str(1)+'&fields=*').json()
    print(data)
    return data

id=random.randrange(999999)
get_book_data(id)