<?php session_start();

require_once "../models/UsuarioClass.php";
$user = new UsuarioClass();
$nickUsuario = $_SESSION['nickUsuario'];
$infoJugador = $user->bajarInformacionUsuario($nickUsuario);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../../AHORCADO/assets/js/contador.js" defer></script>
    <title>Inicio de Partida - Juego de Palabras</title>
</head>

<body>

    <div>
        <h1>Bienvenido <?php echo $_SESSION['nickUsuario'] ?></h1>
    </div>

    <div id="contenedorGrande">

        <div id="contentInfo" class="container">
            <?php
            if (!empty($infoJugador)) {
                echo "<h2>INFORMACIÓN DEL USUARIO</h2>";
                echo "<p>Eres nuestro usuario número: " . $infoJugador['idUsuario'] . "</p>";
                echo "<p>Nombre: " . $infoJugador['nombreUsuario'] . "</p>";
                echo "<p>Puntaje: " . $infoJugador['puntaje'] . "</p>";
                echo "<p>Cantidad de Partidas: " . $infoJugador['cantidadPartidas'] . "</p>";
            }
            ?>

            <p id="parrafoInfoJuego"> Depende el modo seleccionado tus puntos al ganar una partida se multiplicaran de la siguiente manera:<br>
                <br>Si la dificultad es baja: x1<br>
                Si la dificultad es media: x2<br>
                Si la dificultad es alta: x3<br>
            </p>
        </div>


        <div class="container" id="contentConfig">
            <h1>Configuración de partida</h1>

            <form id="gameForm" method="POST" action="../models/procesarConfig.php">
                <label for="dificultad">Selecciona la dificultad:</label>
                <select id="dificultad" name="dificultad">
                    <option value="1">Baja (3 a 5 letras)</option>
                    <option value="2">Media (6 a 8 letras)</option>
                    <option value="3">Alta (más de 8 letras)</option>
                </select>

                <label>Selecciona el tipo de partida:</label>
                <label for="conTiempo">Con tiempo</label>
                <input type="radio" id="conTiempo" name="tiempo" value="1">
                <label for="sinTiempo">Sin tiempo</label>
                <input type="radio" id="sinTiempo" name="tiempo" value="0">

                <button type="submit" class="btn" id="btnIniciar">Iniciar partida</button>
            </form>
            <!-- Botón para salir y volver al índice -->
            <button class="exit-btn" id="btnCerrar" onclick="window.location.href='http://localhost/AHORCADO/models/logout.php';">Cerrar sesión</button>
        </div>
    </div>

</body>

</html>