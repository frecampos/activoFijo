<?php

class Conexion {

    private $host = "localhost";
    private $bdd = "3094613_activo";
    private $user = "root";
    private $pass = "";
    private $con;

    function __construct() {
        $this->con = mysqli_connect($this->host, $this->user, $this->pass, $this->bdd);
    }

    public function SQLSeleccion($sql) {
        try {
            $reg = mysqli_query($this->con, $sql);
            return $reg;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function SQLOperacion($sql) {
        try {
            $reg = mysqli_query($this->con, $sql);
            return mysqli_affected_rows($this->con);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function Ultimo($tabla) {
        try {
            $sql = "select count(*) as total from " . $tabla;
            $reg = mysqli_query($this->con, $sql);
            $fila = mysqli_fetch_row($reg);
            return $fila[0];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function NextVal($tabla) {
        try {
            $sql = "select count(*)+1 as total from " . $tabla;
            $reg = mysqli_query($this->con, $sql);
            $fila = mysqli_fetch_row($reg);
            return $fila[0];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
