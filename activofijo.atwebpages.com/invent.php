<?php
include_once './procesos/Conexion.php';
$cone = new Conexion();

$id = $_POST['cboInventarios'];

$sql = "select inventario.idinventario,inventario.fecha,mandantes.nombre, tipo_inventario.descripcion,inventario.observaciones from inventario inner JOIN mandantes ON mandantes.idmandantes=inventario.idmandantes INNER JOIN tipo_inventario on tipo_inventario.idtipo_inventario=inventario.idtipo_inventario where inventario.idinventario=$id";

$query = $cone->SQLSeleccion($sql);
?>
<tr>
    <td>Identificador</td>
    <td>Fecha</td>
    <td>Mandante</td>
    <td>Tipo Auditoria</td>
    <td>Observaciones</td>    
</tr>
<?php 
while ($row = mysqli_fetch_array($query)) {   

?>
<tr>
    <td><?php echo $row[0]; ?></td>
    <td><?php echo $row[1]; ?></td>
    <td><?php echo $row[2]; ?></td>
    <td><?php echo $row[3]; ?></td>
    <td><?php echo $row[4]; ?></td>
</tr>
<?php } ?>