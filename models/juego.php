<?php

/* El archivo se encarga de toda la logica del juego */

/* inicio de sessión */
session_start();
header('Content-Type: application/json');
/* Instanciación de clases */
require_once "UsuarioClass.php";
/* Declaración de variables*/
$usuario = new UsuarioClass();
$nickUsuario = $_SESSION['nickUsuario'];
$infoJugador = $usuario->bajarInformacionUsuario($nickUsuario); //Obtener información del usuario logeado

/* Bajo toda la información relevante almacenada dentro de la sessiones */
$letra = strtolower($_POST['letra']); // Letra enviada desde AJAX
$palabra = strtolower($_SESSION['palabraAleatoria']); //La palabra seleccionada, se convierte toda en minusculas
$oculto = $_SESSION['palabraOculta']; 
$pistas = $_SESSION['pistas'];
$aciertos = $_SESSION['aciertos'];
$letrasIntentadas = $_SESSION['letrasIntentadas'];
$dificultad = $_SESSION['dificultad'];

$flag = false; //Variable utilizada como bandera
$cantLetras = count($letrasIntentadas); //Contador de la cantidad de letras intentadas guardadas en el arreglo




// Verificar si la letra ya fue probada/ingresada
if (in_array($letra, $letrasIntentadas)) { //Si la letra enviada por el usuario, se encuentra dentro de las letras ya probadas
    $mensaje = "La letra ingresada ya existe dentro de las letras probadas";
    $terminado = false; // En este caso, no se termina el juego
    $flag = true; // Marca que la letra ya fue intentada
} else { //Si no
    // Si la letra no fue probada, la agregamos al arreglo de letrasIntentadas
    array_push($letrasIntentadas, $letra);
    $_SESSION['letrasIntentadas'] = $letrasIntentadas;

    // Continuamos con la lógica si la letra no fue probada
    if (strpos($palabra, $letra) !== false) { //Si es distinto de falso, es decir la letra (subcadena) está en la palabra (cadena)
        // Si la letra está en la palabra, reemplazar los asteriscos
        for ($i = 0; $i < strlen($palabra); $i++) { //Itero en la palabra
            if ($palabra[$i] === $letra && $oculto[$i] == '*') { //Si la subcadena se encuentra en la cadena(pos) y en la misma posición pero de la cadena oculta está un '*'
                $oculto[$i] = $letra; //Cambio el asterisco en dicha posición por la subcadena
            }
        }
        $aciertos++; //Incremento los aciertos
        $_SESSION['aciertos'] = $aciertos;
        $_SESSION['palabraOculta'] = $oculto;
        $mensaje = "¡Bien hecho! La letra '$letra' está en la palabra.";
    } else {
        //Si la letra no está dentro de la cadena
        $pistas++; //Incremento las pistas
        $_SESSION['pistas'] = $pistas;
    
        // Buscar el primer asterisco en la palabra oculta y reemplazarlo con la letra de la palabra correcta en esa posición
        for ($i = 0; $i < strlen($oculto); $i++) { //Recorro la variable oculto
            if ($oculto[$i] === '*') { //Si encuentra un asterisco en la cadena en 'i' posición
                $_SESSION['letraPista'] = $palabra[$i]; //Guardo la 'i' posición de la cadena en la session
                $oculto[$i] = $_SESSION['letraPista'];  //Reemplazo en la 'i' posición el asterisco por la letra de la palabra
                $_SESSION['palabraOculta'] = $oculto;
                // Solo reemplazamos el primer asterisco encontrado
                break;  //Termina la función
            }
        }
        //Almaceno la pista nueva
        $letraPista = $_SESSION['letraPista'];
        $mensaje = "La letra '$letra' no está en la palabra. La pista descubierta es la letra: '$letraPista'";
    }
}

//Variable utilizada como bandera para definir la finalización del juego
$terminado = false;


    if ($_SESSION['palabraOculta'] === $palabra && $_SESSION['pistas'] < $_SESSION['aciertos']) { //Si la palabra oculta es igual a la palabra
        //Siendo la cantidad de aciertos mayor a la cantidad de pistas
        // GANADOR
        $mensaje = "¡Felicidades! Has adivinado la palabra: $palabra";
        $terminado = true;
        if ($terminado) {
            //Dependiendo la dificultad en la que este el juego, se incrementan los aciertos de diferente manera
            switch ($dificultad) {
                case 1: //BAJA
                    //La sesión no se modifica
                    $usuario->incrementarPuntosJugador($infoJugador['idUsuario'], $aciertos);
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
    } else if ($_SESSION['palabraOculta'] === $palabra && $_SESSION['aciertos'] < $_SESSION['pistas']) { //Si la palabra oculta es igual a la palabra
        //Siendo la cantidad de aciertos menor a la cantidad de pistas
        // PERDEDOR
        $mensaje = "Has perdido. La palabra era: $palabra";
        $terminado = true;
    } else if ($_SESSION['palabraOculta'] === $palabra && $_SESSION['aciertos'] == $_SESSION['pistas']) { //Si la palabra oculta es igual a la palabra
        //Siendo la cantidad de aciertos igual a las pistas
        // EMPATE
        $mensaje = "ES UN EMPATE. La palabra era: $palabra";
        $terminado = true;
    }



    /* EN LOS CASOS DE DERROTA Y EMPATE, NO SE SUMAN LOS PUNTOS Y SOLO SE ACTUALIZA LA CANTIDAD DE PARTIDAS */
    /* la actualización del valor cantidadPartidas se realizar en el archivo vistaJuego.php */


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