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
('Deportes'),
('Moda'),
('Juguetes');

INSERT INTO productos (nombre, precio, categoria_id) VALUES
('Laptop Lenovo', 2499.99, 1),
('Celular Samsung', 1799.50, 1),
('Aspiradora Robot', 899.00, 2),
('Silla Gamer', 620.00, 2),
('Bicicleta MTB', 1200.00, 3),
('Balon de futbol', 85.00, 3),
('Camisa casual', 110.99, 4),
('Zapatillas deportivas', 210.00, 4),
('Muñeca interactiva', 150.00, 5),
('Carro a control remoto', 99.99, 5);

INSERT INTO promociones (descripcion, descuento, producto_id) VALUES
('Descuento de temporada en laptop', 10.00, 1),
('Oferta limitada en celular', 15.00, 2),
('Promocion de limpieza hogar', 20.00, 3),
('Descuento en ropa seleccionada', 5.00, 7),
('Promo juguetes por aniversario', 12.50, 9);
