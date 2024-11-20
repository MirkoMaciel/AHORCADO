<?php
session_start();
header('Content-Type: application/json');
$letra = strtolower($_POST['letra']); // Letra enviada desde AJAX
$palabra = strtolower($_SESSION['palabraAleatoria']);
$oculto = $_SESSION['palabraOculta'];
$pistas = $_SESSION['pistas'];
$aciertos = $_SESSION['aciertos'];

if (strpos($palabra, $letra) !== false) {
    // Si la letra está en la palabra, reemplazar los asteriscos
    for ($i = 0; $i < strlen($palabra); $i++) {
        if ($palabra[$i] === $letra) {
            $oculto[$i] = $letra;
        }
    }
    $aciertos++;
    $_SESSION['aciertos'] = $aciertos;
    $_SESSION['palabraOculta'] = $oculto;
    $mensaje = "¡Bien hecho! La letra '$letra' está en la palabra.";
} else {
    $pistas++;
    $_SESSION['pistas'] = $pistas;

    $mensaje = "La letra '$letra' no está en la palabra.";
}

$terminado = false;
if ($_SESSION['palabraOculta'] === $palabra) {
    $mensaje = "¡Felicidades! Has adivinado la palabra: $palabra";
    $terminado = true;
} else if ($_SESSION['palabraOculta'] === $palabra && $_SESSION['aciertos'] < $_SESSION['pistas'] ) { //Recordartorio cambiar la condición
    $mensaje = "Has perdido. La palabra era: $palabra";
    $terminado = true;
}

// Respuesta JSON
echo json_encode([
    "success" => true,
    "palabra" => $_SESSION['palabraOculta'],
    "aciertos" => $_SESSION['aciertos'],
    "pistas" => $_SESSION['pistas'],
    "mensaje" => $mensaje,
    "terminado" => $terminado,
]);



?>