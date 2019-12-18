<?php

include_once './procesos/Conexion.php';
$cone = new Conexion();

$id = $_POST['Id'];

$sql="SELECT detalle_inventario.iddetalle_inventario, detalle_inventario.fecha, detalle_inventario.realizado,examinadores.nombre, ubicaciones.descripcion, detalle_inventario.observaciones,ubicaciones.codigo FROM detalle_inventario INNER JOIN examinadores
on detalle_inventario.idexaminadores=examinadores.idexaminadores
INNER JOIN ubicaciones on detalle_inventario.idcodigo_ubicacion=ubicaciones.codigo where detalle_inventario.idinventario=$id";


$query = $cone->SQLSeleccion($sql);
?>
<tr>
    <td>Identificador</td>
    <td>Fecha</td>
    <td>Realizado</td>
    <td>Examinador</td>
    <td>ubicacion</td>
    <td>Observaciones</td>
</tr>
<?php 


while ($row = mysqli_fetch_array($query)) {   
?>
<?php 
if ($row[2]=='S') {
    echo '<tr style="background-color: buttonface">';
}else{
    echo '<tr>';
}
?>
    <td><?php echo $row[0]; ?></td>
    <td style="width: auto;"><?php echo $row[1]; ?></td>
    <td><?php echo $row[2]; ?></td>
    <td><?php echo $row[3]; ?></td>
    <td><?php echo $row[4]; ?></td>
    <td><?php echo $row[5]; ?></td>
    <td>
        <?php echo $row[6]; ?>
    </td>
</tr>
<?php } ?>