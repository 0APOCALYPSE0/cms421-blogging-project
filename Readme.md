***************** Database Information *******************
database name: cms4.2.1
tables: admins, category, comments and posts

admins:
  id: int, primary key, auto increament
  datetime: varchar(50)
  username: varchar(50)
  password: varchar(50)
  aname: varchar(50)
  headline: varchar(30)
  bio: text
  image: text
  addedby: varchar(50)

category:
  id: int, primary key, auto increament
  title: varchar(20)
  author: varchar(50)
  datetime: varchar(20)

comments:
  id: int, primary key, auto increament
  datetime: varchar(20)
  name: varchar(50)
  email: varchar(50)
  comment: text
  approvedby: varchar(50)
  status: varchar(3)
  post_id: foreign key reference to post table id

post:
  id: int, primary key, auto increament
  datetime: varchar(50)
  title: varchar(300)
  category: varchar(50)
  author: varchar(50)
  image: text
  post: text
