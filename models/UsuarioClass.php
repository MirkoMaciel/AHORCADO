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

    //OTRA CONSULTA BUSQUEDA USUARIO

    public function buscarUsuarioRegistrado2($nombreUsuario, $pass)
    {
        // Conexión a la base de datos
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
    
        // Consulta SQL sensible a mayúsculas
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

    public function bajarTopJugadores (){
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "SELECT u.nombreUsuario , p.puntaje , p.cantidadPartidas FROM usuario u JOIN puntajes p ON u.idUsuario = p.idUsuario ORDER BY p.puntaje DESC LIMIT 10";
        $result = $bd->obtenerResultados($bd->ejecutarConsulta($query));
        return $result;
    }

    public function incrementarCantidadPartidas($idUsuario){
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "UPDATE puntajes SET cantidadPartidas = cantidadPartidas + 1 WHERE idUsuario = '$idUsuario'";
        $bd->ejecutarConsulta($query);
    }

    public function incrementarPuntosJugador($idUsuario, $puntaje){
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        $query = "UPDATE puntajes p SET puntaje = puntaje + '$puntaje' WHERE idUsuario = '$idUsuario'";
        $bd->ejecutarConsulta($query);
    }
}
