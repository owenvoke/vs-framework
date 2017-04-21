CREATE DATABASE IF NOT EXISTS vs;

USE vs;

# Create USERS table
CREATE TABLE IF NOT EXISTS users (
  id       BIGINT PRIMARY KEY AUTO_INCREMENT UNIQUE,
  username VARCHAR(200) UNIQUE,
  email    VARCHAR(300) UNIQUE,
  password VARCHAR(500),
  acl      INT                DEFAULT 1,
  joined   BIGINT
);

# Create USERS_INFO table
CREATE TABLE IF NOT EXISTS users_info (
  id     BIGINT PRIMARY KEY UNIQUE,
  avatar VARCHAR(500)
);

# Create CATEGORIES table
CREATE TABLE IF NOT EXISTS categories (
  id   BIGINT PRIMARY KEY AUTO_INCREMENT UNIQUE,
  name VARCHAR(200) UNIQUE
);

# Create TAGS table
CREATE TABLE IF NOT EXISTS tags (
  id   BIGINT PRIMARY KEY AUTO_INCREMENT UNIQUE,
  name VARCHAR(150) UNIQUE
);

# Create VIDEOS table
CREATE TABLE IF NOT EXISTS videos (
  id          BIGINT PRIMARY KEY AUTO_INCREMENT UNIQUE,
  hash        VARCHAR(40) UNIQUE,
  title       VARCHAR(400),
  description VARCHAR(1000),
  uploader    BIGINT,
  category    BIGINT,
  date        BIGINT,
  file_type   VARCHAR(10),
  views       BIGINT
);

# Create VIDEO_TAGS table
CREATE TABLE IF NOT EXISTS video_tags (
  id  BIGINT PRIMARY KEY,
  tag BIGINT
);

# Create ACLS table
CREATE TABLE IF NOT EXISTS acls (
  id   BIGINT PRIMARY KEY AUTO_INCREMENT UNIQUE,
  name VARCHAR(100)
);

# Populate basics
INSERT IGNORE INTO categories (name) VALUES ('Other');
INSERT IGNORE INTO acls (name) VALUES ('User');