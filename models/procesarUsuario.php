<?php

require_once "../models/UsuarioClass.php";
require_once "../models/BaseDeDatos.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Instancia de objetos
    $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
    $user = new UsuarioClass();

    //Obtengo lo digitado por el usuario
    $nombre = $_POST['registroUsuario'];
    $correo = $_POST['correo'];
    $contra = $_POST['pass'];
    $contraEncriptada = sha1($contra);

    //echo $nombre;echo$correo;echo$contra;

    //Verifico que no existe un usuario dentro de la BD
    $usuarioExistente = $user->getUsuarioBD($nombre);

    if ($usuarioExistente) {
        //Informo al usuario
        echo "<script>alert('El usuario ya existe');
                window.location = '/AHORCADO/public/index.html';</script>";
    } else {
        //Agrego el usuario a la base de datos
        $user->registrarJugador($nombre, $correo, $contraEncriptada);
        $idUserNuevo = $user->getIdUsuarioBd($nombre);
        $user->registrarPuntuacion($idUserNuevo['idUsuario']);
        echo "<script>alert('Usuario registrado con exito');
        window.location = '/AHORCADO/public/index.html';</script>";
    }

}


?>