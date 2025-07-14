<?php

require_once 'producto.php';
require_once 'usuario.php';


// --- usuario.php ----
$MiNombre = new Usuario();



$MiNombre->nombre = "Nicolas" . "\n";
$MiNombre->email = "nicolasmuskus1@gmail.com"  . "\n";
echo $MiNombre->Saludar();
echo $MiNombre->obtenerSaldo()  . "\n";


// --- producto.php ---

$MiProducto = new Producto("Raqueta",10.00);

echo $MiProducto->mostrarInfo() . "\n";