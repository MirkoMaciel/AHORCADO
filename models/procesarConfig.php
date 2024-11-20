<?php
session_start();

// Verificar que los datos del formulario estén presentes
if (isset($_POST['dificultad']) && isset($_POST['tiempo'])) {
    // Guardar los datos en las variables de sesión
    $_SESSION['dificultad'] = $_POST['dificultad'];
    $_SESSION['tiempo'] = $_POST['tiempo'];
    $_SESSION['aciertos'] = 0;
    $_SESSION['pistas'] = 0;

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
