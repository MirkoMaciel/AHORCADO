<?php

class UsuarioClass {

    protected $idUsuario;
    protected $nombreUsuario;
    protected $correo;
    protected $contrasenia;

    public function __construct($idUsuario, $nombreUsuario, $correo, $contrasenia){
        $this->idUsuario = $idUsuario;
        $this->nombreUsuario = $nombreUsuario;
        $this->contrasenia = $correo;
        $this->contrasenia = $contrasenia;
    }

    public function getUsuarioBD(){


    }

}


?>