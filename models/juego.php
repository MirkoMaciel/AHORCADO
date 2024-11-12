<?php

require_once 'BaseDeDatos.php';
require_once 'UsuarioClass.php';
header('Content-Type: application/json'); // Asegúrate de que la respuesta sea JSON

//Class Usuario 
$user = new UsuarioClass();

//Parametros
$nombre = $_POST['name'];
$correo = $_POST['correouser'];
$contra = $_POST['contra'];

var_dump($nombre, $correo, $contra);

// Aquí iría la lógica de tu registro de usuario
// Simula la respuesta (solo un ejemplo)
$result = $user->getUsuarioBD($nombre);

// Muestra la respuesta en formato JSON
echo json_decode($result);
exit();

?>