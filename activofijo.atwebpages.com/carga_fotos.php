<?php
//$datos = json_decode($_GET["data2"], true);
$datos = $_GET["id"];
//conexion con base de datos
include_once './procesos/Conexion.php';
$cone = new Conexion();
$sql = "select * from fotos where numero_de_inventario=$datos";
$query = $cone->SQLSeleccion($sql);
$cantidad_filas = mysqli_num_rows($query);
if ($cantidad_filas == 0) {
    
    ?>
    <div style="float: left">
        <img src="img/sin_foto.jpg" width="150px" height="150px">
    </div>
    <div style="float: left">
        <img src="img/sin_foto.jpg" width="150px" height="150px">
    </div>
    <div style="float: left">
        <img src="img/sin_foto.jpg" width="150px" height="150px">
    </div>
    <div style="float: left">
        <img src="img/sin_foto.jpg" width="150px" height="150px">
    </div>
    <div style="float: left">
        <img src="img/sin_foto.jpg" width="150px" height="150px">
    </div>
    <?php
} else {
    $filas = mysqli_fetch_row($query);
    $f1 = 'img/sin_foto.jpg';
    $f2 = 'img/sin_foto.jpg';
    $f3 = 'img/sin_foto.jpg';
    $f4 = 'img/sin_foto.jpg';
    $f5 = 'img/sin_foto.jpg';
    if (strlen($filas[1]) > 1) {
       $f1= 'images/'.$filas[1];
    }
    if (strlen($filas[2]) > 1) {
        $f2= 'images/'.$filas[2];
    }
    if (strlen($filas[3]) > 1) {
        $f3= 'images/'.$filas[3];
    }
    if (strlen($filas[4]) > 1) {
        $f4= 'images/'.$filas[4];
    }
    if (strlen($filas[5]) > 1) {
        $f5= 'images/'.$filas[5];
    }
    ?>
    <div style="float: left;padding: 2px;">
        <img src="<?php echo $f1; ?>" width="150px" height="190px">
    </div>
    <div style="float: left;padding: 2px;">
        <img src="<?php echo $f2; ?>" width="150px" height="190px">
    </div>
    <div style="float: left;padding: 2px;">
        <img src="<?php echo $f3; ?>" width="150px" height="190px">
    </div>
    <div style="float: left;padding: 2px;">
        <img src="<?php echo $f4; ?>" width="150px" height="190px">
    </div>
    <div style="float: left;padding: 2px;">
        <img src="<?php echo $f5; ?>" width="150px" height="190px">
    </div>
    <?php
}
?>