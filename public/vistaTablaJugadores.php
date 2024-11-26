<?php 
session_start();
require_once "../models/UsuarioClass.php";
$user = new UsuarioClass();
$datos = $user->bajarTopJugadores(); //var_dump($datos)
$datoUsuario = $user->bajarInformacionUsuario($_SESSION['nickUsuario']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/tablas.css">
    <title>TABLA DE JUGADORES</title>
</head>

<body>

    <h1>Tabla de Jugadores</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre de Usuario</th>
                <th>Puntaje</th>
                <th>Cantidad de Partidas</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($datos) && is_array($datos)): ?>
                <?php foreach ($datos as $jugador): ?>
                    <tr>
                        <td><?= htmlspecialchars($jugador->nombreUsuario) ?></td>
                        <td><?= htmlspecialchars($jugador->puntaje) ?></td>
                        <td><?= htmlspecialchars($jugador->cantidadPartidas) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay datos disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="contentInfo" class="container">
        <?php
            if (!empty($datoUsuario)){  
                echo "<h2>TUS ESTADISTICAS</h2>";

                echo "<p>Hola, " . strtoupper($datoUsuario['nombreUsuario']) . " ahora en base a tu resultado estas son tus estadisticas ahora: </p>";
                echo "<p>Puntaje partida: ".$_SESSION['aciertos']."</p>";
                echo "<p>Puntaje: " . $datoUsuario['puntaje'] . "</p>";
                echo "<p>Cantidad de Partidas: " . $datoUsuario['cantidadPartidas'] . "</p>";
            }
        ?>
    </div>


    <div class="" id="contenedorBtnCerrar">
        <button onclick="window.close()" id="btnCerrar">CERRAR</button>
    </div>

</body>

</html>