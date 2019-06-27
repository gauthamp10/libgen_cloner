def read_inp():
    with open('link8.txt','r') as f:
        urls = f.readlines()
        urls = [x.strip() for x in urls]
    return urls


def between(value, a, b):
    # Find and validate before-part.
    pos_a = value.find(a)
    if pos_a == -1:
        return ""
    # Find and validate after part.
    pos_b = value.rfind(b)
    if pos_b == -1:
        return ""
    # Return middle part.
    adjusted_pos_a = pos_a + len(a)
    if adjusted_pos_a >= pos_b:
        return ""
    return value[adjusted_pos_a:pos_b]


def get_user(user):
    return user['email']


def write(db, user, data, sub,mail_id):
    db.child(mail_id).child(sub).set(data)

    

def read(db, user, mail_id):
    urls = db.child(mail_id).get(user['idToken'])
    print(urls.val())

def scrape_count_write(db,user,mail_id,c):
    db.child("Scrape Count").child(mail_id).set(c)

def scrape_count_read(db,user,mail_id):
    c=db.child("Scrape Count").child(mail_id).get()
    return c.val()

def delete(db, mail_id):
    db.child(mail_id).remove()
    db.child("Scrape Count").child(mail_id).remove()

'''def resolve_mail(mail_id):
    domain = between(mail_id, "@", ".")
    mail_id = mail_id.split('@')[0]
    mail_id = mail_id + "@" + domain
    return mail_id'''
