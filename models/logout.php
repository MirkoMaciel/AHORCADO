<?php

/* El objetivo del archivo es eliminar toda información alojada dentro de las sessiones permite el deslogeo de la aplicación */

session_start();  // Inicia la sesión
session_unset();  // Elimina todas las variables de sesión
session_destroy();  // Destruye la sesión
header("Location: ../../../../AHORCADO/public/index.html");
exit();


?>; 