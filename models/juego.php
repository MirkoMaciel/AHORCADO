<?php
session_start();
header('Content-Type: application/json');
require_once "UsuarioClass.php";
$usuario = new UsuarioClass();
$nickUsuario = $_SESSION['nickUsuario'];
$infoJugador = $usuario->bajarInformacionUsuario($nickUsuario);

$letra = strtolower($_POST['letra']); // Letra enviada desde AJAX
$palabra = strtolower($_SESSION['palabraAleatoria']);
$oculto = $_SESSION['palabraOculta'];
$pistas = $_SESSION['pistas'];
$aciertos = $_SESSION['aciertos'];
$letrasIntentadas = $_SESSION['letrasIntentadas'];
$dificultad = $_SESSION['dificultad'];


//Guardo la letra que se ingreso
if (!empty($letra)){
    array_push($letrasIntentadas, $letra);
    $_SESSION['letrasIntentadas'] = $letrasIntentadas;
}

if (strpos($palabra, $letra) !== false) {
    // Si la letra está en la palabra, reemplazar los asteriscos
    for ($i = 0; $i < strlen($palabra); $i++) {
        if ($palabra[$i] === $letra && $oculto[$i] == '*') {
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

    // Buscar el primer asterisco en la palabra oculta y reemplazarlo con la letra de la palabra correcta en esa posición
    for ($i = 0; $i < strlen($oculto); $i++) {
        if ($oculto[$i] === '*') {
            // Reemplazar el primer asterisco con la letra correspondiente de la palabra correcta
            $_SESSION['letraPista'] = $palabra[$i];
            $oculto[$i] = $_SESSION['letraPista'];  // Tomamos la letra correcta de la palabra original
            $_SESSION['palabraOculta'] = $oculto;
            break;  // Solo reemplazamos el primer asterisco encontrado
        }
    }
    
        $letraPista = $_SESSION['letraPista'];
    

    $mensaje = "La letra '$letra' no está en la palabra. La pista descubierta es la letra: '$letraPista'";
}

$terminado = false;


if ($_SESSION['palabraOculta'] === $palabra && $_SESSION['pistas'] < $_SESSION['aciertos'] ) {
    $mensaje = "¡Felicidades! Has adivinado la palabra: $palabra";
    $terminado = true;
    if ($terminado){
        switch ($dificultad) {
            case 1:
                //La sesión no se modifica
                break;
            case 2:
                // DIFICULTAD MEDIA
                $aciertos = $_SESSION['aciertos'];
                $aciertos = $aciertos * 2;
                $_SESSION['aciertos'] = $aciertos;
                $usuario->incrementarPuntosJugador($infoJugador['idUsuario'], $aciertos);
                break;
                case 3:
                    // DIFICULTAD ALTA
                    $aciertos = $_SESSION['aciertos'];
                    $aciertos = $aciertos * 3;
                    $_SESSION['aciertos'] = $aciertos;
                    $usuario->incrementarPuntosJugador($infoJugador['idUsuario'], $aciertos);
                break;
            default:
                // Código a ejecutar si ninguno de los casos anteriores coincide
                echo "error de seleccion de dificultad";
                break;
        }
    }
    
} else if ($_SESSION['palabraOculta'] === $palabra && $_SESSION['aciertos'] < $_SESSION['pistas'] ) { //Recordartorio cambiar la condición
    $mensaje = "Has perdido. La palabra era: $palabra";
    $terminado = true;
} else if ($_SESSION['palabraOculta'] === $palabra && $_SESSION['aciertos'] == $_SESSION['pistas']){
    $mensaje = "ES UN EMPATE. La palabra era: $palabra";
    $terminado = true;
}


// Respuesta JSON
echo json_encode([
    "success" => true,
    "palabra" => $_SESSION['palabraOculta'],
    "aciertos" => $_SESSION['aciertos'],
    "pistas" => $_SESSION['pistas'],
    "letrasIntentadas" => $_SESSION['letrasIntentadas'],
    "mensaje" => $mensaje,
    "terminado" => $terminado,
]);



?>