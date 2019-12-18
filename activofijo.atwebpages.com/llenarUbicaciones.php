<?php

include_once './procesos/Conexion.php';
$cone = new Conexion();

$id=$_POST['Id'];

$sql="SELECT ubicaciones.descripcion, ubicaciones.codigo FROM detalle_inventario INNER JOIN examinadores on detalle_inventario.idexaminadores=examinadores.idexaminadores INNER JOIN ubicaciones on detalle_inventario.idcodigo_ubicacion=ubicaciones.codigo where detalle_inventario.idinventario=$id";

$query = $cone->SQLSeleccion($sql);
?>
<?php 
while ($row = mysqli_fetch_array($query)) {
?>
<option value="<?php echo $row[1]; ?>"><?php echo $row[0]; ?></option>
<?php } ?>