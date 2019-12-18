<?php

include_once './procesos/Conexion.php';
$cone = new Conexion();

$nombre = $_POST['nombre'];
$id=$cone->NextVal("examinadores");
$sql="insert into examinadores values($id,'$nombre')";

$cant=$cone->SQLOperacion($sql);

echo $cant;
