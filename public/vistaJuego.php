<?php
/* inicio de sessión */
session_start();

/* Instancia de clases */
require_once '../models/JuegoClass.php';
require_once "../models/UsuarioClass.php";

// Verificar que los datos estén en la sesión
if (isset($_SESSION['dificultad'], $_SESSION['tiempo'])) { /*Dificultad = Baja - Media - Alta  | Tiempo : modo de juego*/

    $dificultad = $_SESSION['dificultad'];
    $modoTiempo = $_SESSION['tiempo'];
    $letrasIntentadas = $_SESSION['letrasIntentadas'];
    $aciertos = $_SESSION['aciertos'];
    $pistas = $_SESSION['pistas'];


    //Si no existe la  sessión inicio el juego
    if (!isset($_SESSION['palabraAleatoria'])) {

        /* Declaración de variables */
        $user = new UsuarioClass();
        $juego = new JuegoClass();
        $nickUsuario = $_SESSION['nickUsuario'];
        $infoJugador = $user->bajarInformacionUsuario($nickUsuario); //Bajar la información del usuario
        $user->incrementarCantidadPartidas($infoJugador['idUsuario']);  //Incrementar en uno la cantidad de partidas
        $objt = $juego->buscarPalabrasBD($dificultad);

        //var_dump ($objt);
        $_SESSION['palabraAleatoria'] = $juego->seleccionarPalabra($objt); //Guardo la palabra seleccionada aleatoriamente dentro de la sessión
        $palabra = $_SESSION['palabraAleatoria'];
        $_SESSION['palabraOculta'] = str_repeat("*", strlen($palabra)); //A la variable palabra se le calcula la longitud , luego se genera una cadena de "*" de la misma longitud

        //echo "No existe la sesión";
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
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="../../AHORCADO/assets/js/script.js" defer></script>
    <script src="../../AHORCADO/assets/js/contador.js" defer></script>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <div id="contenedorGrande">

        <div class="container" id="contenedorInformacion">
            <!--    INFORMACIÓN DE LA CONFIGURACIÓN DEL JUEGO   -->
            <h1>ADIVINA LA PALABRA</h1>
            <p>Dificultad seleccionada: <?php
                                        // Usamos un switch para la dificultad
                                        switch (htmlspecialchars($_SESSION['dificultad'])) {
                                            case 1:
                                                echo "BAJA";
                                                break;
                                            case 2:
                                                echo "MEDIA";
                                                break;
                                            case 3:
                                                echo "ALTA";
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
                                    case 0:
                                        echo "SIN TIEMPO";
                                        break;
                                } ?></p>

            <span id="fecha"></span>

            <div id="contenedorContador" style="display: <?php echo $_SESSION['tiempo'] == '1' ? 'block' : 'none'; ?>;">
                <p id="parrafoTiempo">Tiempo restante: 02:00</p>
            </div>

            <div class="" id="contenedorPalabra">
                <p id="palabra">Palabra para descubrir:
                    <span class="span" id="txtPalabra"> <?= htmlspecialchars($_SESSION['palabraOculta']) ?></span>
                </p>
            </div>
        </div>

        <div class="container" id="contenedorInteracción">

            <!-- FORMULARIO DE INTERACCIÓN DEL USUARIO  -->
            <label for="letra">Introduce una letra:</label>
            <input type="text" name="letra" id="letra" maxlength="1" pattern="[A-Za-z]+" required>
            <div id="contenedorBtn">
                <button id="adivinar">Adivinar</button>
            </div>
            <div class="contenedorMsj" id="mensaje"></div>
            <div class="contenedorMsj" id="aciertos">Aciertos en la adivinanza:<span class="span"><?php echo $_SESSION['aciertos']; ?></span></div>
            <div class="contenedorMsj" id="pistas">Pistas descubiertas:<span class="span"><?php echo $_SESSION['pistas'] ?></span></div>
            <div class="contenedorMsj" id="letrasProbadas">Letras probadas :<span class="span"><?php $letrasIntentadas = $_SESSION['letrasIntentadas'];
                                                                                                //var_dump($letrasIntentadas);
                                                                                                foreach ($letrasIntentadas as $letra) {
                                                                                                    if (empty($letra)) {
                                                                                                        echo "No ingresaste ninguna letra";
                                                                                                    } else {
                                                                                                        echo $letra . "-";
                                                                                                    }
                                                                                                } ?></span>

            </div>

        </div>
    </div>

    <!--PALABRA A DESCUBRIR-->
    <div class="container" style="display : none">
        <p>Palabra a adivinar: <?= htmlspecialchars($_SESSION['palabraAleatoria']) ?></p>
    </div>

    <div id="contenedorBtns">
        <!-- CONTENEDOR DE BOTONES -->
        <div class="contenedorBtn">
            <button id="btnRendirse" name="btnR">ABANDONAR JUEGO</button>
        </div>
        <div class="contenedorBtn">
            <button id="btnNueva" name="btnFin">RENDIRSE</button>
        </div>

        <div class="contenedorBtn">
            <form action="http://localhost/AHORCADO/models/resetPartida.php" method="POST" name="btnNuevaPartida">
                <button id="btnPartidaNueva" name="btnPartidaNueva" type="submit" style="display: none;">NUEVA PARTIDA</button>
            </form>
        </div>

    </div>


    <!--MENSAJES VENTANA POP UP-->
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
    <!--     ////////////////////////////       -->




</body>

</html>