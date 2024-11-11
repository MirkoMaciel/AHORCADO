<?php
class BaseDeDatos
{
    private $host;
    private $usuario;
    private $contraseña;
    private $nombreBD;
    private $conexion;

    public function __construct($host, $usuario, $contraseña, $nombreBD)
    {
        $this->host = $host;
        $this->usuario = $usuario;
        $this->contraseña = $contraseña;
        $this->nombreBD = $nombreBD;
        $this->conectar();
    }

    public function conectar()
    {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->contraseña, $this->nombreBD);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function ejecutarConsulta($consulta)
    {
        $resultado = $this->conexion->query($consulta);

        if ($this->conexion->error) {
            die("Error en la consulta: " . $this->conexion->error);
        }

        return $resultado;
    }

    public function obtenerResultado($resultado)
    {
        if ($resultado->num_rows > 0) { //Define un único objeto si la consulta es exitosa
            return $resultado->fetch_object(); // Objeto único
        }
        return null; // Sin resultados
    }

    public function cerrarConexion()
    {
        $this->conexion->close();
    }
}