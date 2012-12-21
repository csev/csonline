
# create database csonline default character set utf8;
# grant all on csonline.* to csonline@'localhost' identified by 'moocsRus';
# grant all on csonline.* to csonline@'127.0.0.1' identified by 'moocsRus';

CREATE TABLE Users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT KEY, 
  email VARCHAR(999) NOT NULL, 
  domain_id INT,
  first VARCHAR(1024) NOT NULL, 
  last VARCHAR(1024) NOT NULL, 
  twitter VARCHAR(32), 
  privacy INT,
  subscribe INT,
  role INT,
  oer INT,
  education INT,
  lat VARCHAR(128), 
  lng VARCHAR(128),
  homepage VARCHAR(1024), 
  blog VARCHAR(1024), 
  avatar VARCHAR(1024), 
  avatarlink VARCHAR(1024), 
  comment VARCHAR(2048), 
  created_at DATETIME NOT NULL,
  modified_at DATETIME NOT NULL,
  login_at DATETIME NOT NULL,
  login_ip VARCHAR(999) NOT NULL,
  identity VARCHAR(999) NOT NULL,
  identitysha VARCHAR(64) NOT NULL,
  emailsha VARCHAR(64) NOT NULL
);

alter table Users Add UNIQUE(identitysha);
alter table Users Add UNIQUE(emailsha);

CREATE INDEX UsersIdentity ON Users(identity);
CREATE INDEX UsersEmail ON Users(email);

CREATE TABLE Courses (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT KEY, 
  code VARCHAR(32) NOT NULL,
  title VARCHAR(1024) NOT NULL, 
  description VARCHAR(4096) NOT NULL, 
  image VARCHAR(1024) NOT NULL, 
  start_at DATETIME,
  close_at DATETIME,
  duration INT,
  bypass varchar(32),
  endpoint VARCHAR(1024),
  consumer_key VARCHAR(1024),
  consumer_secret VARCHAR(1024) 
);

CREATE TABLE Enrollments (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT KEY, 
  course_id INT,
  user_id INT,
  role INT,
  grade DOUBLE,
  fame INT,
  fame_at DATETIME NOT NULL,
  first SMALLINT,
  last SMALLINT,
  location SMALLINT,
  created_at DATETIME NOT NULL,
  modified_at DATETIME NOT NULL,
  launch_at DATETIME NOT NULL
);

// Not yet used - will be used to optimize mail sending order...
CREATE TABLE Domains (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT KEY, 
  domain VARCHAR(1024) NOT NULL
);

// Sample course - for now insert by hand
INSERT into Courses (
  code, title, 
  description, 
  start_at, close_at, duration, bypass, 
  endpoint, 
  consumer_key, consumer_secret)
VALUES
  ('IMS001', 'Introductory IMS LTI',
  'This is a course on IMS Learning Tools Interoperability and it is indeed awesome.',
  '2012-01-01 00:00:00', NULL, 10, NULL,
  'http://www.imsglobal.org/developers/LTI/test/v1p1/tool.php',
  '12345', 'secret');

