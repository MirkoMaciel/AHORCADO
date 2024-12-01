<?php

/* El objetivo del archivo es procesar la información digitada por el usuario, se utiliza en el proceso de REGISTRO */

/* Instanciación de clases */
require_once "../models/UsuarioClass.php";
require_once "../models/BaseDeDatos.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') { //Si el envio del formulario es a través del metodo post

    //Declaración de variables
    $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
    $user = new UsuarioClass();

    //Obtengo lo digitado por el usuario
    $nombre = $_POST['registroUsuario'];
    $correo = $_POST['correo'];
    $contra = $_POST['pass'];
    $contraEncriptada = sha1($contra);

    //echo $nombre;echo$correo;echo$contra;

    //Busco al usuario dentro de la BD
    $usuarioExistente = $user->getUsuarioBD($nombre);
    
    //Verifico que no existe un usuario dentro de la BD
    if ($usuarioExistente) {
        //Informo al usuario
        echo "<script>alert('El usuario ya existe');
                window.location = '/AHORCADO/public/index.html';</script>";
    } else {
        //Registro al usuario dentro de la base de datos
        $user->registrarJugador($nombre, $correo, $contraEncriptada); //Registro
        $idUserNuevo = $user->getIdUsuarioBd($nombre); //Obtengo su ID
        $user->registrarPuntuacion($idUserNuevo['idUsuario']); //Inicializo su puntuación
        echo "<script>alert('Usuario registrado con exito');
        window.location = '/AHORCADO/public/index.html';</script>";
        $bd->cerrarConexion();
    }

}


?>