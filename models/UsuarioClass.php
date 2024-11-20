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
    public function getUsuarioBD($usuario) //Consulta un usuario por su nombre
    {

        //Conexion a la bd
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');

        //Consulta
        $query = "SELECT * FROM usuario u WHERE u.nombreUsuario = '$usuario'";

        //Resultado
        $result = $bd->obtenerResultado($bd->ejecutarConsulta($query));

        return $result;
    }

    public function getIdUsuarioBd($usuario) //Traigo el id del usuario
    {
        //Conexion a la bd
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');

        //Consulta
        $query = "SELECT u.idUsuario FROM `usuario` u WHERE u.nombreUsuario = '$usuario'";

        //Resultado
        $result = $bd->obtenerResultado($bd->ejecutarConsulta($query));

        return $result;
    }


    public function registrarJugador($nombreUsuario, $correo, $contraseña) //Registro al usuario en la bd
    {
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');

        // Consulta para insertar el registro
        $query = "INSERT INTO usuario (nombreUsuario, correo, contraseña) 
                  VALUES ('$nombreUsuario', '$correo', '$contraseña')";

        // Ejecutar la consulta
        $bd->ejecutarConsulta($query);
    }

    public function registrarPuntuacion($idUsuario)
    { //Registra la puntuación del usuario
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "INSERT INTO puntajes (`idUsuario`, `puntaje`, `cantidadPartidas`) VALUES ($idUsuario,0,0);";
        $bd->ejecutarConsulta($query);
    }

    public function buscarUsuarioRegistrado($nombreUsuario, $pass)
    {

        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "SELECT * FROM usuario u WHERE u.nombreUsuario = '$nombreUsuario' AND u.contraseña = '$pass'";
        //Resultado
        $result = $bd->obtenerResultado($bd->ejecutarConsulta($query));

        return $result;
    }

    public function getPuntuacionUsuario ($idUsuario){ //Bajar la información del puntaje  del usuario
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "SELECT p.puntaje, p.cantidadPartidas FROM puntajes p WHERE p.idUsuario = '$idUsuario'";
        $result = $bd->obtenerResultado($bd->ejecutarConsulta($query));
        return $result;
    }

    //Trae la información más relevante sobre el juego al usuario
    public function bajarInformacionUsuuario (){

    }
}
