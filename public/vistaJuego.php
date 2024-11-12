<?php
session_start();

require_once '../models/JuegoClass.php';

// Verificar que los datos estén en la sesión
if (isset($_SESSION['dificultad'], $_SESSION['tiempo'])) {
    $dificultad = $_SESSION['dificultad'];
    $modoTiempo = $_SESSION['tiempo'];

    //Realizar consulta BD
    $juego = new JuegoClass();
    $objt = $juego->buscarPalabrasBD($dificultad);

    if (!empty($objt)) { // Verifica si hay resultados
        $palabras = [];
        foreach ($objt as $row) {
            $palabras[] = (array) $row; // Convierte cada stdClass a un arreglo
        }

        $indiceAleatorio = array_rand($palabras); // Selecciona un índice aleatorio
        $palabraAleatoria = $palabras[$indiceAleatorio]['palabra']; // Obtiene la palabra
        $_SESSION['palabraAleatoria'] = $palabraAleatoria; //guardamos la palabra
    } else {
        $palabraAleatoria = "No hay palabras disponibles para esta dificultad.";
    }
} else {
    // Si no hay datos en la sesión, redirigir al formulario de configuración
    header("Location: configJuego.php");
    exit();
}


// Verificar si se ha enviado una letra
$letra = '';
if (isset($_POST['letra'])) {
    $letra = strtolower($_POST['letra']); // Convertir la letra a minúsculas para que no haya distinción
}

// Mostrar la palabra con asteriscos o con las letras adivinadas
$palabraMostrada = '';
if (isset($palabraAleatoria)) {
    $palabraMostrada = '';
    // Convertimos la palabra en una cadena de asteriscos
    foreach (str_split($palabraAleatoria) as $letraPalabra) {
        // Reemplazamos los asteriscos con las letras adivinadas
        $palabraMostrada .= (strpos($_SESSION['letrasAdivinadas'], $letraPalabra) !== false) ? $letraPalabra : '*';
    }
}

// Guardar las letras adivinadas en la sesión
if (!isset($_SESSION['letrasAdivinadas'])) {
    $_SESSION['letrasAdivinadas'] = ''; // Inicializamos si no existe
}

// Agregar la letra adivinada
if ($letra && strpos($_SESSION['palabraAleatoria'], $letra) !== false) {
    $_SESSION['letrasAdivinadas'] .= $letra; // Guardar la letra adivinada
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Vista del Juego</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Manejo del formulario con AJAX
        $(document).ready(function() {
            $("#formAdivinar").submit(function(event) {
                event.preventDefault(); // Prevenir el envío normal del formulario

                var letra = $("#letra").val(); // Obtener la letra ingresada

                $.ajax({
                    url: "vistaJuego.php ", // El archivo PHP que procesará la letra
                    type: "POST",
                    data: { letra: letra },
                    success: function(response) {
                        // Actualizar la palabra mostrada
                        $("#palabra").html(response);
                    },
                    error: function() {
                        alert("Hubo un error en la solicitud.");
                    }
                });
            });
        });
    </script>

</head>

<body>
    <div class="content">
        <h1>Juego de Palabras</h1>
        <p>Dificultad seleccionada: <?= htmlspecialchars($dificultad) ?></p>
        <p>Modo de tiempo: <?= htmlspecialchars($modoTiempo) ?></p>
        <p>Palabra seleccionada: <?= htmlspecialchars($palabraAleatoria) ?></p>
        <p>Palabra oculta: <?= htmlspecialchars($palabraMostrada) ?></p>
    </div>

    <div class="content">
        <form method="POST" id="formAdivinar">
            <label for="letra">Introduce una letra:</label>
            <input type="text" name="letra" maxlength="1" required>
            <button type="submit">Adivinar</button>
        </form>
    </div>

    <div class="content">
        <p>Palabra a adivinar: <?= htmlspecialchars($palabraMostrada) ?></p>
    </div>

    <?php if ($palabraMostrada == $palabraAleatoria) : ?>
        <div class="content">
            <h2>¡Felicidades! Has adivinado la palabra.</h2>
        </div>
    <?php endif; ?>

</body>

</html>