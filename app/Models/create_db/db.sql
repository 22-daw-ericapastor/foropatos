DROP DATABASE IF EXISTS web_recetas;

CREATE DATABASE web_recetas;

USE web_recetas;

CREATE TABLE IF NOT EXISTS users(
  username VARCHAR(20),
  email VARCHAR(50),
  passwd VARCHAR(100),
  activo TINYINT(1) DEFAULT 1,
  permissions TINYINT(1) DEFAULT 0,
  PRIMARY KEY(username)
);

CREATE TABLE IF NOT EXISTS recipes(
  id INT UNSIGNED AUTO_INCREMENT,
  elaboracion DATETIME,
  PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS comments(
  id INT UNSIGNED AUTO_INCREMENT,
  username VARCHAR(50),
  comentario VARCHAR(200),
  date_time DATETIME,
  PRIMARY KEY(id),
  FOREIGN KEY(username) REFERENCES users(username)
);

CREATE TABLE IF NOT EXISTS mensajes(
  id INT UNSIGNED AUTO_INCREMENT,
  username VARCHAR(50),
  mensaje VARCHAR(500),
  date_time DATETIME,
  PRIMARY KEY(id),
  FOREIGN KEY(username) REFERENCES users(username)
);