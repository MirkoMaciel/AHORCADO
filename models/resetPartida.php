<?php
//Inicio de sessión
session_start();

/*  El archivo en cuestión busca eliminar las sessiones relacionadas al juego, se utiliza para reiniciar una partida */

// Eliminar una variable de sesión específica
unset($_SESSION['palabraOculta']); // Elimino el valor que se encuentre en 'palabraOculta'
unset($_SESSION['palabraAleatoria']); 
unset($_SESSION['acierto']); 
unset($_SESSION['pistas']); 
unset($_SESSION['letrasIntentadas']); 

header("Location: ../../../../AHORCADO/public/vistaConfigJuego.php");
exit();
?>