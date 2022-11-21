CREATE DATABASE IF NOT EXISTS web_recetas;

USE web_recetas;

CREATE TABLE usuarios (
    ciff VARCHAR(9) PRIMARY KEY,
    nombre VARCHAR(15),
    apellido1 VARCHAR(15),
    apellido2 VARCHAR(15),
    bday DATE,
    username VARCHAR(20),
    pwd VARCHAR(100),
    email VARCHAR(50),
    permisos TINYINT(1)
);