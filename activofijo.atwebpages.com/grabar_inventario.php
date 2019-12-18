<?php

include_once './procesos/Conexion.php';
$cone = new Conexion();

$idINV = $_POST['txtID'];
$cantidad = $_POST['txtCantidad'];
$fecha = $_POST['txtFecha'];
$fechaFin = $_POST['txtFechaFin'];
$obs = $_POST['txtOBS'];
$mandante = $_POST['cboMandante'];
$tipo = $_POST['cboTipo'];
$titulo=$_POST['txtTitulo'];

$sql = "insert into inventario values($idINV,'$fecha','$fechaFin','$obs','$titulo',$tipo,$mandante)";

$cone->SQLOperacion($sql);
$sw = 1;

$texto = "";
//for ($index = 1; $index < $cantidad; $index++) {
//
//    if (isset($_POST['id' . $index])) {
//        $ubicacion = $_POST['txtId' . $index];
//        $id = $_POST['id' . $index];
//        $num = $cone->NextVal("detalle_inventario");
//        $fecha = date('Y-m-d');
//        $sql = "insert into detalle_inventario values($num,'$fecha','N',1,$idINV,'$ubicacion','--')";
//        $cone->SQLOperacion($sql);
//        $texto = $texto . " " . $sql;
//    }
//}
//$sw = $sw + 1;
//echo $texto;

$valores = $_POST["txtCodigos"];
$arreglo = explode(";", $valores);
foreach ($arreglo as $key => $value) {
    $sql = "select * from ubicaciones where descripcion='$value'";
    $query = $cone->SQLSeleccion($sql);
    $fila = "";
    while ($row = mysqli_fetch_array($query)) {
        $fila = $row["codigo"];
    }
    //echo "COD:" . $fila;        
    $num = $cone->NextVal("detalle_inventario");
    $fecha = date('Y-m-d');
    $sql = "insert into detalle_inventario values($num,'$fecha','N',1,$idINV,'$fila','--')";
    $cone->SQLOperacion($sql);    
}
$sw=$sw+1;
echo $sw;