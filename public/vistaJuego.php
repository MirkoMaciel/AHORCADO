<?php
session_start();

require_once '../models/JuegoClass.php';

// Verificar que los datos estén en la sesión
if (isset($_SESSION['dificultad'], $_SESSION['tiempo'])) {

    $dificultad = $_SESSION['dificultad'];
    //echo $dificultad;
    $modoTiempo = $_SESSION['tiempo'];

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
    <script src="../../AHORCADO/assets/js/script.js"></script>

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
        <p>Modo de tiempo: <?= htmlspecialchars($modoTiempo) ?></p>
        <p id="palabra">Palabra para descubrir: <?= htmlspecialchars($_SESSION['palabraOculta']) ?></p>
        
    </div>

    <div class="content">

            <label for="letra">Introduce una letra:</label>
            <input type="text" name="letra" id="letra" maxlength="1" required>
            <button id="adivinar">Adivinar</button>

            <div id="mensaje"></div>
            <div id="aciertos">Aciertos en la adivinanza:<?php echo $_SESSION['aciertos'];?></div>
            <div id="pistas">Pistas descubiertas:<?php echo $_SESSION['pistas']?></div>

    </div>

    <div class="content">
        <p>Palabra a adivinar: <?= htmlspecialchars($_SESSION['palabraAleatoria']) ?></p>
    </div>

    <div class="content">
        <button id="btnFin" name="btnFin">FINALIZAR PARTIDA</button>
    </div>

    <?php 
     
     
     
     //session_destroy();
     ?>

</body>

</html>