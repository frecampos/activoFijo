<?php

include_once './procesos/Conexion.php';
$cone = new Conexion();

if (isset($_SESSION["arreglos"])) {
    $arreglo = $_SESSION["arreglos"];
    $idUbicaciones = $_SESSION['IdUbicaciones'];
    $fecha = date('Y-m-d');
    $idInventario = $_SESSION['IdInventario'];

    $texto='';
    for ($index = 1; $index < count($arreglo); $index++) {
        $idInv = $cone->NextVal("inventariados");
        $id=$arreglo[$index];
        //$reg=$cone->SQLSeleccion("select id_activo from activo_fijo where activo_fijo='$id'");
        $sql="select id_activo,denominacion_del_activo_fijo from activo_fijo where numero_de_inventario='$id'";
        $reg = $cone->SQLSeleccion($sql);        
        $texto=$texto.' '.$sql;
        while ($row = mysqli_fetch_array($reg)) {
            $idActivo = $row[0];
            $denominacion = $row[1];
        }
        $sql = "insert into inventariados values($idInv,'NO ESTA','$fecha','no se encuentra activo : $denominacion','$idInventario',$idActivo) ";
        
        $query = $cone->SQLOperacion($sql);
    }
    echo 2;
    
    
} else {
    echo 0;
}