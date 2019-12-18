<?php

include_once './procesos/Conexion.php';
$cone = new Conexion();

$texto= strtoupper($_POST["datos"]);

$sql="select *from ubicaciones where descripcion like '%$texto%' order by descripcion";

$query=$cone->SQLSeleccion($sql);

$array= array();
$texto="";
while ($row = mysqli_fetch_array($query)) {
    array_push($array, $row["descripcion"]);
    $texto=$texto."<option>".utf8_encode($row["descripcion"])."</option>";
}
//echo implode(";", $array);
echo $texto;