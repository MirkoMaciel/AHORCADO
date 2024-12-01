<?php
/* Instanciación de clasese */
require_once 'BaseDeDatos.php';
class JuegoClass {

    public function __construct(){} //Constructor

    public function buscarPalabrasBD($dificultad){ //Selecciona las posibles palabras en base a la dificultad
        //Conectar BD
        $bd = new BaseDeDatos('localhost','root','','ahorcado');
        $bd->conectar();

        //Realizar consulta
        $query = "SELECT DISTINCT p.idPalabra, p.palabra FROM palabras p JOIN categoria c ON p.idCategoria = c.idCategoria 
        WHERE p.idCategoria = '$dificultad'";

        $resultado = $bd->obtenerResultados($bd->ejecutarConsulta($query)); //Obtiene resultados
        return $resultado;
    }

    public function seleccionarPalabra ($objt){ //Selecciona la palabra 
        foreach ($objt as $row) {
            $palabras[] = (array) $row; // Convierte cada stdClass a un arreglo
        }

        $indiceAleatorio = array_rand($palabras); // Selecciona un índice aleatorio
        $palabraAleatoria = $palabras[$indiceAleatorio]['palabra']; // Obtiene la palabra

        return $palabraAleatoria;
    }


}

?>