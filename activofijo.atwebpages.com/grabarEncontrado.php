<?php
session_start();
include_once './procesos/Conexion.php';
$cone = new Conexion();

$id = $_POST['id'];

//$id = substr($id, 0, 9);
$idUbicaciones = $_SESSION['IdUbicaciones'];
$idInv=$cone->NextVal("inventariados");
$estado='OK';
$fecha=date('Y-m-d');
$obs=$_POST['obs'];
$idInventario=$_SESSION['IdInventario'];

//$reg=$cone->SQLSeleccion("select id_activo from activo_fijo where activo_fijo='$id'");
$reg=$cone->SQLSeleccion("select id_activo from activo_fijo where numero_de_inventario='$id'");
while ($row = mysqli_fetch_array($reg)) {
    $idActivo=$row[0];
}
$sql = "insert into inventariados values($idInv,'$estado','$fecha','$obs',$idInventario,$idActivo) ";

$query = $cone->SQLOperacion($sql);

echo $query;
?>

