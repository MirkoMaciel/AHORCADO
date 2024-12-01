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

    // Método para ejecutar consultas preparadas
public function ejecutarConsultaPreparada($query, $paramTypes, $paramValues)
{

    $stmt = $this->conexion->prepare($query);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $this->conexion->error);
    }

    // Asociar los parámetros a la consulta
    $stmt->bind_param($paramTypes, ...$paramValues);

    // Ejecutar la consulta
    if (!$stmt->execute()) {
        die("Error en la ejecución de la consulta: " . $stmt->error);
    }

    // Retornar el resultado
    return $stmt->get_result();
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
            return $resultado->fetch_assoc(); // Arreglo único
        }
        return null; // Sin resultados
    }

    public function obtenerResultados($resultado) 
    {
        $objetos = []; //Define una variable como un arreglo de objetos

        while ($objeto = $resultado->fetch_object()) { //Multiples registros
            $objetos[] = $objeto;
        }

        return $objetos;
    }

    public function cerrarConexion()
    {
        $this->conexion->close();
    }
}