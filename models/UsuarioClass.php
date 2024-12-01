<?php

/* instanciación de clases */
require_once "BaseDeDatos.php";
class UsuarioClass
{

    protected $idUsuario;
    protected $nombreUsuario;
    protected $correo;
    protected $contrasenia;

    public function __construct() {}

    ////////////////////////////////////////////// GETERS Y SETERS ///////////////////////////////////////
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
    }

    /////////////////////////////////   CONSULTAS A BASE DE DATOS ////////////////////////////////

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

    public function registrarJugador($nombreUsuario, $correo, $contraseña) //Registro al usuario con su contraseña en la base de datos
    {
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');

        // Consulta para insertar el registro
        $query = "INSERT INTO usuario (nombreUsuario, correo, contraseña) 
                  VALUES ('$nombreUsuario', '$correo', '$contraseña')";

        // Ejecutar la consulta
        $bd->ejecutarConsulta($query);
    }

    public function registrarPuntuacion($idUsuario)//Registro la puntuación de un jugador en la base de datos
    { //Registra la puntuación del usuario
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "INSERT INTO puntajes (`idUsuario`, `puntaje`, `cantidadPartidas`) VALUES ($idUsuario,0,0);";
        $bd->ejecutarConsulta($query);
    }

    public function buscarUsuarioRegistrado($nombreUsuario, $pass) //Busqueda de un usuario bajo los parametros de usuario y contraseña
    {

        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "SELECT * FROM usuario u WHERE u.nombreUsuario = '$nombreUsuario' AND u.contraseña = '$pass'";
        //Resultado
        $result = $bd->obtenerResultado($bd->ejecutarConsulta($query));
        return $result;
    }

    public function buscarUsuarioRegistrado2($nombreUsuario, $pass)//Busqueda de un usuario bajo los parametros de usuario y contraseña
    {
        // Conexión a la base de datos
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
    
        // Consulta SQL 
        $query = "SELECT * FROM usuario WHERE BINARY nombreUsuario = ? AND contraseña = ?";
    
        // Tipos de los parámetros ("ss" para dos cadenas)
        $parametros = "ss"; 
    
        // Valores de los parámetros
        $paramValor = [$nombreUsuario, $pass];
    
        // Ejecutar la consulta preparada
        $result = $bd->ejecutarConsultaPreparada($query, $parametros, $paramValor);
    
        // Devolver el usuario encontrado o NULL si no existe
        return $bd->obtenerResultado($result);
    }

    public function getPuntuacionUsuario ($idUsuario){ //Bajar la información del puntaje  del usuario
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "SELECT p.puntaje, p.cantidadPartidas FROM puntajes p WHERE p.idUsuario = '$idUsuario'";
        $result = $bd->obtenerResultado($bd->ejecutarConsulta($query));
        return $result;
    }

    //Trae la información más relevante sobre el juego al usuario
    public function bajarInformacionUsuario ($nombreUsuario){
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "SELECT DISTINCT u.idUsuario, u.nombreUsuario, p.puntaje, p.cantidadPartidas FROM usuario u JOIN puntajes p ON u.idUsuario = p.idUsuario WHERE u.nombreUsuario = '$nombreUsuario'";
        $result = $bd->obtenerResultado($bd->ejecutarConsulta($query));
        return $result;
    }

    //Función que devuelve los TOP 10 jugadores en orden descendente de la tabla puntajes
    public function bajarTopJugadores (){
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "SELECT u.nombreUsuario , p.puntaje , p.cantidadPartidas FROM usuario u JOIN puntajes p ON u.idUsuario = p.idUsuario ORDER BY p.puntaje DESC LIMIT 10";
        $result = $bd->obtenerResultados($bd->ejecutarConsulta($query));
        return $result;
    }

    //Función para actualizar el valor de la cantidad de partidas del usuario
    public function incrementarCantidadPartidas($idUsuario){
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "UPDATE puntajes SET cantidadPartidas = cantidadPartidas + 1 WHERE idUsuario = '$idUsuario'";
        $bd->ejecutarConsulta($query);
    }

    //Funcion para incrementar los puntos del usuario
    public function incrementarPuntosJugador($idUsuario, $puntaje){
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "UPDATE puntajes p SET puntaje = puntaje + '$puntaje' WHERE idUsuario = '$idUsuario'";
        $bd->ejecutarConsulta($query);
    }
}
