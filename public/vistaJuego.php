<?php
session_start();

require_once '../models/JuegoClass.php';

// Verificar que los datos estén en la sesión
if (isset($_SESSION['dificultad'], $_SESSION['tiempo'])) {

    $dificultad = $_SESSION['dificultad'];
    $modoTiempo = $_SESSION['tiempo'];
    $letrasIntentadas = $_SESSION['letrasIntentadas'];
    $aciertos = $_SESSION['aciertos'];
    $pistas = $_SESSION['pistas'];


    //Si no existe la  sessión inicio el juego
    if (!isset($_SESSION['palabraAleatoria'])) {
        //Realizar consulta BD
        $juego = new JuegoClass();
        $objt = $juego->buscarPalabrasBD($dificultad);

        //var_dump ($objt);
        $_SESSION['palabraAleatoria'] = $juego->seleccionarPalabra($objt);
        $palabra = $_SESSION['palabraAleatoria'];
        $_SESSION['palabraOculta'] = str_repeat("*", strlen($palabra));

        echo "No existe la sesión";
    } else {
        echo "La sesión existe";
    }
} else {
    // Si no hay datos en la sesión, redirigir al formulario de configuración
    header("Location: configJuego.php");
    session_destroy();
    exit();
}

    
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Vista del Juego</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../AHORCADO/assets/js/script.js" defer></script>
    <style>
        /* Estilo general del contador */
        #contador {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            /* Espaciado entre elementos */
            font-family: Arial, sans-serif;
            font-size: 24px;
            text-align: center;
            margin-top: 20px;
            /* Espaciado superior */
        }

        /* Estilo para cada bloque de minutos y segundos */
        #divMinutos,
        #divSegundos {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Números de minutos y segundos */
        #contMinutos,
        #contSegundos {
            font-size: 48px;
            font-weight: bold;
            color: #333;
            margin: 0;
            /* Sin espacio adicional */
        }

        /* Etiquetas (MINUTOS, SEGUNDOS) */
        #minutos,
        #segundos {
            font-size: 16px;
            color: #777;
            margin: 0;
        }

        /* Estilo del separador */
        #divSeparador1 {
            font-size: 48px;
            font-weight: bold;
            color: #333;
            align-self: center;
            /* Centra verticalmente el separador */
        }
    </style>
</head>

<body>
    <div class="content">
        <h1>Juego de Palabras</h1>
        <p>Dificultad seleccionada: <?php
                                    // Usamos un switch para la dificultad
                                    switch (htmlspecialchars($_SESSION['dificultad'])) {
                                        case 1:
                                            echo "Baja";
                                            break;
                                        case 2:
                                            echo "Media";
                                            break;
                                        case 3:
                                            echo "Alta";
                                            break;
                                        default:
                                            echo "No definida";  // En caso de que no haya una dificultad válida
                                            break;
                                    } ?></p>
        <p>Modo de tiempo: <?php
                            // Usamos un switch para la dificultad
                            switch (htmlspecialchars($_SESSION['tiempo'])) {
                                case 1:
                                    echo "TIEMPO";
                                    break;
                                case 2:
                                    echo "SIN TIEMPO";
                                    break;
                            } ?></p>

        <span id="fecha"></span>

        <div id="contador">
            <div id="divMinutos">
                <p id="contMinutos">00</p>
                <p id="minutos">MINUTOS</p>
            </div>
            <div id="divSeparador1">:</div>
            <div id="divSegundos">
                <p id="contSegundos">00</p>
                <p id="segundos">SEGUNDOS</p>
            </div>
        </div>

        <p id="palabra">Palabra para descubrir: <?= htmlspecialchars($_SESSION['palabraOculta']) ?></p>

    </div>

    <div class="content">

        <label for="letra">Introduce una letra:</label>
        <input type="text" name="letra" id="letra" maxlength="1" required>
        <button id="adivinar">Adivinar</button>

        <div id="mensaje"></div>
        <div id="aciertos">Aciertos en la adivinanza:<?php echo $_SESSION['aciertos']; ?></div>
        <div id="pistas">Pistas descubiertas:<?php echo $_SESSION['pistas'] ?></div>
        <div id="letrasProbadas">Letras probadas :<?php $letrasIntentadas = $_SESSION['letrasIntentadas']; 
        //var_dump($letrasIntentadas);
        foreach ($letrasIntentadas as $letra) {
            if (empty($letra)){
                echo "No ingresaste ninguna letra";
            }else {
                echo $letra."-";
            }
        }?>
        
    </div>

    </div>

    <div class="content">
        <p>Palabra a adivinar: <?= htmlspecialchars($_SESSION['palabraAleatoria']) ?></p>
    </div>

    <div class="content">
        <button id="btnRendirse" name="btnR">ABANDONAR JUEGO</button>
    </div>
    <div class="content">
        <button id="btnNueva" name="btnFin">RENDIRSE</button>
    </div>

    <div>
        <button id="btnPartidaNueva" name="btnPartidaNueva" hidden>NUEVA PARTIDA</button>
    </div>

    <dialog id="mensajeFin">
        <h2>¿Estás seguro de que deseas ABANDONAR EL JUEGO?</h2>
        <p>Las consecuencias son: Perder la partida y se cerrará la sesión</p>
        <form method="POST" action="http://localhost/AHORCADO/models/logout.php" name="formSe">
            <button type="submit">Sí, ABANDONAR</button>
            <button type="button" id="btnCancelar">Cancelar</button>
        </form>
    </dialog>

    <dialog id="mensajeNueva">
        <h2>¿Estás seguro de que deseas RENDIRTE?</h2>
        <p>Las consecuencias son: - Perderas todo tu progreso actual pero podras iniciar otra partida</p>
        <form action="http://localhost/AHORCADO/models/resetPartida.php" method="POST" name="btnNuevaPartida">
            <button type="submit">Sí, quiero una nueva partida</button>
            <button type="button" id="btnCancelar2">Cancelar</button>
        </form>
    </dialog>





</body>

</html>