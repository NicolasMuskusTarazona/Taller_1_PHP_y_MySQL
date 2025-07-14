<?php

class Producto {
    public $nombre;
    public $precio;

    public function __construct($nombre, $precio) {
        $this->nombre = $nombre;
        $this->precio = $precio;
    }

    public function mostrarInfo() {
        return "Producto: $this->nombre - Precio: $this->precio COP";
    }
}
