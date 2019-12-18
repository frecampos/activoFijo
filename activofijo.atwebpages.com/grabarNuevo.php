<?php

include_once './procesos/Conexion.php';
$cone = new Conexion();

$num_inv=$_POST['txtNumInv'];
$num_serie=$_POST['txtNumSerie'];
$deno=$_POST['txtDeno'];
$obs=$_POST['txtOBS'];

$idExaminador=$_POST['txtIdExaminador'];
$idUbicacion=$_POST['txtIdUbicacion'];
$idInventario=$_POST['txtIdInventario'];

$idFaltantes=$cone->NextVal("faltantes");

$fecha=date('Y-m-d');
$sql = "insert into faltantes values($idFaltantes,'$idUbicacion',$idInventario,$idExaminador,'$num_inv','$num_serie','$deno','$fecha','$obs')";

$query = $cone->SQLOperacion($sql);

echo $query;

