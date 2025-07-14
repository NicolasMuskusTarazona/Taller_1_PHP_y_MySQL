<?php

// POO
// Usuario
class Salario{
    private $saldo = 1200000;

    public function depositar($cantidad){
        $this->saldo += $cantidad;
    }
    public function obtenerSaldo(){
        return $this->saldo;
    }
}


class Usuario extends Salario{
    public $nombre;
    public $email;
    private $saldo = 1200000;

    public function Saludar(){
        return "Hola $this->nombre tu email es: $this->email";
    }

    public function obtenerSaldo(){
        return "Tienes un Saldo de: $this->saldo";
    }
}





