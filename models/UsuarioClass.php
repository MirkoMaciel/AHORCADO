<?php

require_once "BaseDeDatos.php";
class UsuarioClass
{

    protected $idUsuario;
    protected $nombreUsuario;
    protected $correo;
    protected $contrasenia;

    public function __construct() {}


    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
    }
    public function getUsuarioBD($usuario) //Verifica si existe el usuario dentro de la BD
    {

        //Conexion a la bd
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');

        //Consulta
        $query = "SELECT * FROM usuario u WHERE u.nombreUsuario = '$usuario'";

        //Resultado
        $result = $bd->obtenerResultado($bd->ejecutarConsulta($query));

        //Return
        return $result;
    }


    public function registrarJugador($nombreUsuario, $correo, $contraseña)
    {
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');

        // Cifrar la contraseña antes de guardarla
        $contraseñaCifrada = password_hash($contraseña, PASSWORD_DEFAULT);

        // Consulta para insertar el registro
        $query = "INSERT INTO usuario (nombreUsuario, correo, contraseña) 
                  VALUES ('$nombreUsuario', '$correo', '$contraseñaCifrada')";

        // Ejecutar la consulta
        $resultado = $bd->ejecutarConsulta($query);

        return $resultado;
    }
}
