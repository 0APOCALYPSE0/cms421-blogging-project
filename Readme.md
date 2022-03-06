# CMS Blogging Site

## [Live Demo](https://blogging.lovestoblog.com/)

## Steps to install in local machine

1. Clone the project inside htdocs folder of the XAMPP server.
2. Import the CMS4_2_1.sql (provided in the project folder) file inside your my sql database.
3. Run your apache and mysql using XAMPP tool.
4. For sending otp to your email you have to configure your PHP.ini and sendmail.ini file using steps below.


if you are using XAMPP then you can easily send mail from localhost.

for example you can configure C:\xampp\php\php.ini and c:\xampp\sendmail\sendmail.ini for gmail to send mail.

in C:\xampp\php\php.ini find extension=php_openssl.dll and remove the semicolon from the beginning of that line to make SSL working for gmail for localhost.

in php.ini file find [mail function] and change

```
SMTP=smtp.gmail.com
smtp_port=587
sendmail_from = my-gmail-id@gmail.com
sendmail_path = "C:\xampp\sendmail\sendmail.exe -t"
```

(use the above send mail path only and it will work)

Now Open C:\xampp\sendmail\sendmail.ini. Replace all the existing code in sendmail.ini with following code

```
[sendmail]

smtp_server=smtp.gmail.com
smtp_port=587
error_logfile=error.log
debug_logfile=debug.log
auth_username=my-gmail-id@gmail.com
auth_password=my-gmail-password
force_sender=my-gmail-id@gmail.com

```


Now you have done!! create php file with mail function and send mail from localhost.



##  ***************** Database Information *******************

<b>Database Name:</b> cms4.2.1 <br>
<b>Tables Names:</b> admins, category, comments and posts

<b>admins:</b> \
  id: int, primary key, auto increament \
  datetime: varchar(50) \
  username: varchar(50) \
  email: varchar(255) \
  password: varchar(50) \
  aname: varchar(50) \
  headline: varchar(30) \
  bio: text \
  image: text \
  addedby: varchar(50) \
  permission: varchar(50)

<b>category:</b> \
  id: int, primary key, auto increament \
  title: varchar(20) \
  author: varchar(50) \
  datetime: varchar(20)

<b>comments:</b> \
  id: int, primary key, auto increament \
  datetime: varchar(20) \
  name: varchar(50) \
  email: varchar(50) \
  comment: text \
  approvedby: varchar(50) \
  status: varchar(3) \
  post_id: foreign key reference to post table id

<b>post:</b> \
  id: int, primary key, auto increament \
  datetime: varchar(50) \
  title: varchar(300) \
  slug: varchar(300) \
  tags: varchar(500) \
  category: varchar(50) \
  author: varchar(50) \
  image: text \
  post: text \
  status: varchar(50) \
  user_id: int

<b>authentication:</b> \
  id: int, primary key, auto increament \
  otp: int(11) \
  expired: int(11) contains 0 or 1 value \
  created: datetime
