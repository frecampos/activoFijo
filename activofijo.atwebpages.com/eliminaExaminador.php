<?php

include_once './procesos/Conexion.php';
$cone = new Conexion();

$id = $_POST['Id'];

$sql="delete from examinadores where idexaminadores=$id";

$cant=$cone->SQLOperacion($sql);

header("Location: index.php");
