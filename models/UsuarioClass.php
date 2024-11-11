<?php

require_once "BaseDeDatos.php";
class UsuarioClass {

    protected $idUsuario;
    protected $nombreUsuario;
    protected $correo;
    protected $contrasenia;

    public function __construct(){

    }


    public function getNombreUsuario (){
        return $this->nombreUsuario;
    }
    public function setNombreUsuario($nombreUsuario){
        $this->nombreUsuario = $nombreUsuario;
    }
    public function getUsuarioBD($usuario){
        
        //Conexion a la bd
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');

        //Consulta
        $query = "SELECT nombreUsuario FROM usuario u WHERE u.nombreUsuario = '$usuario'";

        //Resultado
        $result = $bd->obtenerResultado($bd->ejecutarConsulta($query));
        
        //Return
        return $result;

    }
    /*
    public function registrarJugador($nombreUsuario, $correo, $contraseña)
    {
        $bd = new BaseDeDatos('localhost', 'root', '', 'ahorcado');
        
        // Primero, verificar si el nombre de usuario ya existe
        $query = "SELECT * FROM usuario WHERE nombreUsuario = '$nombreUsuario'";
        $resultado = $bd->obtenerResultado($bd->ejecutarConsulta($query));
    
        if (count($resultado) > 0) {
            // Si el nombre de usuario ya existe, mostrar un mensaje
            echo "El nombre de usuario ya está en uso. Elige otro.";
        } else {
            // Si no existe, cifrar la contraseña
            $contraseñaCifrada = password_hash($contraseña, PASSWORD_DEFAULT);
            
            // Inserta el nuevo jugador
            $queryInsert = "INSERT INTO usuario (nombreUsuario, correo, contraseña) 
                            VALUES ('$nombreUsuario', '$correo', '$contraseñaCifrada')";
            
            $resultadoInsert = $bd->ejecutarConsulta($queryInsert);
    
            // Comprobar si la inserción fue exitosa
            if ($resultadoInsert) {
                echo "Jugador registrado exitosamente";
            } else {
                echo "Error al registrar al jugador";
            }
        }
    }*/

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
    
        // Comprobar si la inserción fue exitosa
        if ($resultado) {
            echo "Jugador registrado exitosamente";
        } else {
            echo "Error al registrar al jugador";
        }
    }

}


?>