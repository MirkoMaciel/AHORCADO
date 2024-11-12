<?php session_start()?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/configJuego.js" defer></script>
    <title>Inicio de Partida - Juego de Palabras</title>
</head>

<body>

    <div class="container">
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
            <input type="radio" id="conTiempo" name="tiempo" value="CON TIEMPO">
            <label for="sinTiempo">Sin tiempo</label>
            <input type="radio" id="sinTiempo" name="tiempo" value="SIN TIEMPO">

            <button type="submit" class="btn">Iniciar partida</button>
        </form>

        <div class="result" id="result"></div>

        <!-- Botón para salir y volver al índice -->
        <button class="exit-btn" onclick="window.location.href='index.html';">Volver al índice</button>
    </div>
    </div>

</body>

</html>