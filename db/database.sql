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

INSERT INTO categorias (nombre) VALUES
('Tecnologia'),
('Hogar'),
('Deportes')


INSERT INTO productos (nombre, precio, categoria_id) VALUES
('Laptop Lenovo', 2499.99, 1),
('Celular Samsung', 1799.50, 1),
('Aspiradora Robot', 899.00, 2),
('Silla Gamer', 620.00, 2),
('Bicicleta MTB', 1200.00, 3)


INSERT INTO promociones (descripcion, descuento, producto_id) VALUES
('Descuento de temporada en laptop', 10.00, 1),
('Oferta limitada en celular', 15.00, 2),
('Descuento 25% en aspiradora', 25.00, 3),
('Promo 30% silla gamer', 30.00, 4);