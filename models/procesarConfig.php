<?php

/* El objetivo del archivo es inicializar los datos del juego */
/* inicio de sessión */
session_start();

// Verificar que los datos del formulario estén presentes
if (isset($_POST['dificultad']) && isset($_POST['tiempo'])) { //Dificultad: Baja - Media - Alta | Tiempo = modo de juego
    // Guardar los datos en las variables de sesión
    $_SESSION['dificultad'] = $_POST['dificultad'];
    $_SESSION['tiempo'] = $_POST['tiempo'];
    $_SESSION['aciertos'] = 0; //Aciertos de la partida
    $_SESSION['pistas'] = 0; //Pistas de la partida
    $_SESSION['letrasIntentadas'] = []; //Letras intentadas en la partida

    // Redirigir a la vista del juego
    header("Location: ../../../../AHORCADO/public/vistaJuego.php");
    exit();
} else {
    // Si no se enviaron datos, redirigir al formulario con un mensaje de error
    $_SESSION['error'] = "Por favor, completa todos los campos.";
    header("Location:  ../../../AHORCADO/public/vistaConfigJuego.php");
    exit();
}


?>
