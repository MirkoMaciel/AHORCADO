<?php

require_once 'BaseDeDatos.php';
class JuegoClass {

    public function __construct(){

    }

    public function buscarPalabrasBD($dificultad){
        //Conectar BD
        $bd = new BaseDeDatos('localhost','root','','ahorcado');
        $bd->conectar();

        //Realizar consulta
        $query = "SELECT DISTINCT p.idPalabra, p.palabra FROM palabras p JOIN categoria c ON p.idCategoria = c.idCategoria 
        WHERE p.idCategoria = '$dificultad'";

        $resultado = $bd->obtenerResultados($bd->ejecutarConsulta($query));
        return $resultado;
    }


}

?>