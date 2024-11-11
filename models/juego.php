<?php

require_once 'BaseDeDatos.php';
require_once 'UsuarioClass.php';
//header('Content-Type: application/json'); // Asegúrate de que la respuesta sea JSON



// Configuración de la conexión
$host = "localhost";
$usuario = "tu_usuario";
$contraseña = "tu_contraseña";
$nombreBD = "tu_base_de_datos";

//Usuario
$usuario = new UsuarioClass();

// Crear instancia de la base de datos
$db = new BaseDeDatos($host, $usuario, $contraseña, $nombreBD);

// Recibir los datos enviados por AJAX
$registroUsuario = $_POST['registroUsuario'];
$correo = $_POST['correo'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

// Verificar si el usuario ya existe
$consultaVerificar = $usuario->getUsuarioBD($registroUsuario);
$resultado = $db->ejecutarConsulta($consultaVerificar);

if ($db->obtenerResultado($resultado)) {
    echo json_encode(["success" => false, "message" => "El usuario ya existe."]);
} else {
    // Insertar nuevo usuario
    $consultaInsertar = $usuario->registrarJugador($registroUsuario, $correo , $pass);
    $db->ejecutarConsulta($consultaInsertar);

    echo json_encode(["success" => true, "message" => "Registro exitoso."]);
}

// Cerrar la conexión
$db->cerrarConexion();



/*
//Registro de un jugador
if (isset($_POST['registroUsuario']) && isset($_POST['correo']) && isset($_POST['pass'])) {
    var_dump($_POST); // Verifica qué datos están siendo enviados
    $nombreUsuario = $_POST['registroUsuario'];
    $correo = $_POST['correo'];
    $contrasenia = $_POST['pass'];

    // Llamar al método de inserción
    $user = new UsuarioClass();
    $result = $user->registrarJugador($nombreUsuario, $correo, $contrasenia);
    echo $result;
}*/

?>