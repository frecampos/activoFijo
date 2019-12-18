<?php
session_start();
include_once './procesos/Conexion.php';
$cone = new Conexion();

$ubicacion=$_POST["txtUbicacion"];
$inventario=$_POST["txtInventario"];
$examinador=$_POST["txtExaminador"];
$hallados=$_POST["txtHallados"];
$faltan=$_POST["txtFaltan"];
$nuevos=$_POST["txtNuevos"];
$OBS=$_POST["txtOBS"];
$observaciones="Ubicados:$hallados Faltan:$faltan Nuevos:$nuevos Observaciones: $OBS";
$sql="update detalle_inventario set realizado='S', observaciones='$observaciones' "
        . "where idcodigo_ubicacion='$ubicacion' and idinventario=$inventario";

$resp=$cone->SQLOperacion($sql);
echo $resp;

                                 
