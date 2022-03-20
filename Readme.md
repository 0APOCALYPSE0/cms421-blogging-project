# CMS Blogging Site

## [Live Demo](https://blogging.lovestoblog.com/)

## Steps to install in local machine

1. Clone the project inside htdocs folder of the XAMPP server.
2. Import the CMS4_2_1.sql (provided in the project folder) file inside your my sql database.
3. Install the composer and then install PHPMailer library.
4. Run your apache and mysql using XAMPP tool.
5. For sending otp to your email you have to configure config.php file. You can just replace CONTACTFORM_FROM_ADDRESS, CONTACTFORM_FROM_NAME
   CONTACTFORM_SMTP_USERNAME and CONTACTFORM_SMTP_PASSWORD with your's in config.php.
6. Now set up SMTP server using gmail. For that you can follow below steps.

## How to get your SMTP credentials

To be able to send messages with this contact form, you'll need a working SMTP service. InfinityFree does not provide this with free hosting, but you can use third party SMTP services.

A simple, free option to use is Gmail. You can use Gmail to send your messages like so:

1. Sign up for a free Gmail account.
2. Enable Two Factor Authentication on the Google account: https://myaccount.google.com/signinoptions/two-step-verification
3. Generate an App Specific Password for the account: https://myaccount.google.com/apppasswords
4. In the configuration file, set the SMTP Hostname `smtp.gmail.com`, enter your full Gmail address in the SMTP Username field and enter the App Specific Password in the SMTP Password field.


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
