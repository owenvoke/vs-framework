CREATE DATABASE IF NOT EXISTS vs;

USE vs;

CREATE TABLE IF NOT EXISTS acls (
  id   BIGINT PRIMARY KEY AUTO_INCREMENT UNIQUE,
  name VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS categories (
  id   BIGINT PRIMARY KEY AUTO_INCREMENT UNIQUE,
  name VARCHAR(200) UNIQUE
);

CREATE TABLE IF NOT EXISTS tags (
  id   BIGINT PRIMARY KEY AUTO_INCREMENT UNIQUE,
  name VARCHAR(150) UNIQUE
);

CREATE TABLE IF NOT EXISTS users (
  id       BIGINT PRIMARY KEY AUTO_INCREMENT UNIQUE,
  username VARCHAR(200) UNIQUE,
  email    VARCHAR(300) UNIQUE,
  password VARCHAR(500),
  acl      BIGINT             DEFAULT 1,
  joined   BIGINT,
  CONSTRAINT users_acls_id_fk FOREIGN KEY (acl) REFERENCES acls (id)
);

CREATE TABLE IF NOT EXISTS users_info (
  id      BIGINT PRIMARY KEY UNIQUE,
  avatar  VARCHAR(500),
  api_key VARCHAR(150) UNIQUE,
  CONSTRAINT users_info_users_id_fk FOREIGN KEY (id) REFERENCES users (id)
);

CREATE TABLE IF NOT EXISTS videos (
  id          BIGINT PRIMARY KEY AUTO_INCREMENT UNIQUE,
  hash        VARCHAR(40) UNIQUE,
  title       VARCHAR(400),
  description VARCHAR(1000)      DEFAULT '',
  uploader    BIGINT,
  category    BIGINT,
  date        BIGINT,
  file_type   VARCHAR(10),
  views       BIGINT             DEFAULT 0,
  CONSTRAINT videos_categories_id_fk FOREIGN KEY (category) REFERENCES categories (id)
);

CREATE TABLE IF NOT EXISTS videos_tags (
  id  BIGINT PRIMARY KEY,
  tag BIGINT,
  CONSTRAINT videos_tags_videos_id_fk FOREIGN KEY (id) REFERENCES videos (id),
  CONSTRAINT videos_tags_tags_id_fk FOREIGN KEY (tag) REFERENCES tags (id)
);

CREATE TABLE IF NOT EXISTS videos_stats
(
  id    BIGINT PRIMARY KEY UNIQUE NOT NULL,
  views BIGINT DEFAULT 0          NOT NULL,
  CONSTRAINT videos_stats_videos_id_fk FOREIGN KEY (id) REFERENCES videos (id)
);

CREATE TABLE IF NOT EXISTS videos_ratings
(
  id     BIGINT PRIMARY KEY UNIQUE NOT NULL,
  user   BIGINT DEFAULT 0          NOT NULL,
  rating TINYINT DEFAULT 0         NOT NULL,
  CONSTRAINT videos_ratings_users_id_fk FOREIGN KEY (user) REFERENCES users (id),
  CONSTRAINT videos_ratings_videos_id_fk FOREIGN KEY (id) REFERENCES videos (id)
);

# Populate basics
INSERT IGNORE INTO categories (name) VALUES ('Other');
INSERT IGNORE INTO acls (name) VALUES ('User');