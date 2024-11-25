<?php

session_start();
// Eliminar una variable de sesión específica
unset($_SESSION['palabraOculta']); // Ejemplo de eliminar 'nombre_usuario'
unset($_SESSION['palabraAleatoria']); 
unset($_SESSION['acierto']); 
unset($_SESSION['pistas']); 
unset($_SESSION['letrasIntentadas']); 

header("Location: ../../../../AHORCADO/public/vistaConfigJuego.php");
exit();
