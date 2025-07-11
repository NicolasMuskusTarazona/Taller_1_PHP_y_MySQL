CREATE DATABASE IF NOT EXISTS taller_api;
USE taller_api;

DROP TABLE IF EXISTS promociones;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL
);

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    categoria_id INT NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE promociones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion TEXT,
    descuento DECIMAL(5, 2),
    producto_id INT NOT NULL,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE
);
