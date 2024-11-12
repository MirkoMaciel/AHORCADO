<?php

require_once 'UsuarioClass.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['nombreUsuario']) && isset($_POST['passUsuario'])) {

        //Isntanciar el objeto Usuario
        $usuario = new UsuarioClass();

        //Obtener los valores digitados
        $nombreUser = $_POST['nombreUsuario'];
        $pass = $_POST['passUsuario'];

        // Validar que los campos no estén vacíos
        if (empty($nombreUser) || empty($pass)) {
            echo "Por favor, completa todos los campos.";
            exit();
        }

        $result = $usuario->getUsuarioBD($nombreUser, $pass);

        if ($result) {
                // La contraseña es correcta
                echo "¡Bienvenido, " . htmlspecialchars($result['nombreUsuario']) . "!";
                // Aquí puedes redirigir al usuario a otra página (por ejemplo, al inicio de sesión)
                header("Location: ../../../public/vistaJuego.php");
                exit();
            } else {
                // La contraseña es incorrecta
                echo "<div class='error'>Contraseña incorrecta.</div>";
            }
        } else {
            // El usuario no existe
            echo "<div class='error'>Usuario no encontrado.</div>";
        }
    }
?>
