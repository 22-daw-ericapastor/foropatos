DROP DATABASE IF EXISTS web_recetas;

CREATE DATABASE web_recetas;

USE web_recetas;

CREATE TABLE IF NOT EXISTS usuarios (
  username VARCHAR(20),
  email VARCHAR(50),
  passwd VARCHAR(100),
  permissions TINYINT(1) DEFAULT 0,
  PRIMARY KEY(username)
);

CREATE TABLE IF NOT EXISTS recetas (
  id INT UNSIGNED AUTO_INCREMENT,
  elaboracion DATETIME,
  PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS ingredientes (
  id INT UNSIGNED AUTO_INCREMENT,
  id_receta INT UNSIGNED,
  PRIMARY KEY(id),
  FOREIGN KEY(id_receta) REFERENCES recetas(id)
);