<?php

/*DEBO TOMAR LOS DATOS INGRESADOS EN EL INDEX.HTML
CORROBORAR NOMBRE Y CONTRASEÑA 
*/ 

/* El objetivo del archivo es validar que el usuario exista o no dentro de la BD, en base a eso inicia la aplicación */

/* Instanciación de clases */
require_once "UsuarioClass.php";
/* Inicio de sessión */
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){ //Si los datos fueron enviados a través de un formulario con el metodo POST

    if (isset($_POST['nombreUsuario']) && isset($_POST['passUsuario']) && $_POST['nombreUsuario'] != '' && $_POST['passUsuario'] != ''){ //Si el usuario/contraseña están definidos y no son vacios
        
        //Instanciar clases
        $user = new UsuarioClass();

        //Guardo el nick de usuario
        $_SESSION['nickUsuario'] = $_POST['nombreUsuario'];

        //Obtener los datos del formulario
        $nombre = $_POST['nombreUsuario'];
        $pass = $_POST['passUsuario'];

        //echo $nombre; echo $pass; 

        //Encripto la contraseña
        $passE = sha1($pass);

        $usuario = $user->buscarUsuarioRegistrado2($nombre, $passE); //Busco el usuario dentro de la BD
        
        if ($usuario){
            //Si el usuario es correcto bajo toda su información
            //Usuario - Puntaje
            //Guardalo en una session

            $_SESSION['nombre'] = $usuario['nombreUsuario'];

            $puntajeUsuario = $user->getPuntuacionUsuario($usuario['idUsuario']);
            
            $_SESSION['puntaje'] = $puntajeUsuario['puntaje'];
            $_SESSION['cantidadPartidas'] =  $puntajeUsuario['cantidadPartidas'];
            
            echo "<script>alert('Usuario logeado!');window.location='../public/vistaConfigJuego.php';</script>";
        }else {
            //No avanza
            echo "<script>alert('El usuario no es valido compruebe su usuario/contraseña'); window.location='../public/index.html';</script>";

        }

        $bd->cerrarConexion();

    }else{
        echo "Error al obtener los datos del formulario";
    }
}

?>