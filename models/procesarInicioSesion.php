<?php

/*DEBO TOMAR LOS DATOS INGRESADOS EN EL INDEX.HTML
CORROBORAR NOMBRE Y CONTRASEÑA 
*/ 

require_once "UsuarioClass.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if (isset($_POST['nombreUsuario']) && isset($_POST['passUsuario']) && $_POST['nombreUsuario'] != '' && $_POST['passUsuario'] != ''){
        
        //Instanciar objetos
        $user = new UsuarioClass();

        //Obtener los datos del formulario
        $nombre = $_POST['nombreUsuario'];
        $pass = $_POST['passUsuario'];

        //echo $nombre; echo $pass; 

        //Encripto la contraseña
        $passE = sha1($pass);

        $usuario = $user->buscarUsuarioRegistrado($nombre, $passE);
        
        if ($usuario){
            //Si el usuario es correcto bajo toda su información
            //Usuario - Puntaje
            //Guardalo en una session

            $_SESSION['nombre'] = $usuario['nombreUsuario'];

            $puntajeUsuario = $user->getPuntuacionUsuario($usuario['idUsuario']);
            
            $_SESSION['puntaje'] = $puntajeUsuario['puntaje'];
            $_SESSION['cantidadPartidas'] =  $puntajeUsuario['cantidadPartidas'];
            
            echo "<script>alert('El usuario existe');window.location='../public/vistaConfigJuego.php';</script>";
        }else {

            echo "<script>alert('El usuario NO existe'); window.location='../public/index.html';</script>";

        }

    }else{
        echo "Error al obtener los datos del formulario";
    }
}

?>