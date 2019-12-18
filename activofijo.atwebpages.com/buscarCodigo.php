<?php
session_start();
include_once './procesos/Conexion.php';
$cone = new Conexion();

$sw = 0;

$id = $_POST['Id'];
//$id = substr($id, 0, 9);
$idUbicaciones = $_SESSION['IdUbicaciones'];
$idExaminador = $_SESSION['IdExaminador'];
$idInventario = $_SESSION['IdInventario'];
//$sql3="select id_activo from activo_fijo where activo_fijo=$id";
$sql3 = "select id_activo from activo_fijo where numero_de_inventario=$id";
$r = $cone->SQLSeleccion($sql3);
$fila = mysqli_fetch_row($r);
if ($fila[0] == 0) {
    ?>

    <tr>
        <td>
            <form name="frmNuevo" id="frmNuevo">
                <table>
                    <tr>                                                                                        
                        <td>Activo Fijo</td>        
                        <td>Num Serie</td>                
                        <td>Denominacion</td> 
                        <td>Observacion</td>
                    </tr>
                    <tr>                        
                        <td> <input type="text" id="txtNumInv" name="txtNumInv" value="<?php echo $id; ?>"> </td>        
                        <td> <input type="text" id="txtNumSerie" name="txtNumSerie" value=""> </td>      
                        <td> <input type="text" id="txtDeno" name="txtDeno" value=""> </td>
                        <td> <input type="text" id="txtOBS" name="txtOBS" value=""> </td>
                        <td>
                            <input type="hidden" id="txtIdExaminador" name="txtIdExaminador" value="<?php echo $idExaminador; ?>">
                            <input type="hidden" id="txtIdUbicacion" name="txtIdUbicacion" value="<?php echo $idUbicaciones; ?>">
                            <input type="hidden" id="txtIdInventario" name="txtIdInventario" value="<?php echo $idInventario; ?>">
                            <input type="button" id="btnNuevo" name="btnNuevo" value="No Existe, Ingresalo">
                        </td>          
                    </tr>
                </table>
            </form>
        </td>

    </tr>
    <?php
    //echo 'No Existe el Objeto';
    $sw = 1;
}
$sql2 = "select count(*) from inventariados where id_activo=$fila[0] and iddetalle_inventario=$idInventario";
$cantidad = $cone->SQLSeleccion($sql2);
try {
    $regis = mysqli_fetch_row($cantidad);
    if ($regis[0] == 1) {
        echo 'Esta Registrado el Objeto en el Inventario';
        exit();
    }
} catch (Exception $exc) {
    
}

//$sql = "select * from activo_fijo where activo_fijo='$id' and criterio_clasif_5='$idUbicaciones'";
$sql = "select * from activo_fijo where numero_de_inventario='$id' and criterio_clasif_5='$idUbicaciones'";
$query = $cone->SQLSeleccion($sql);
?>

<?php
$cant = $cone->SQLOperacion($sql);
if ($cant == 0 && $sw == 0) {
    ?>
    <tr>                                                                                        
        <td>Criterio</td>        
        <td>Num. Inventario</td>
        <td>Num Serie</td>                
        <td>Denominacion</td> 
        <td>Observacion</td>
    </tr>
    <form name="frmNuevo2" id="frmNuevo2">
        <tr> 
            <td> <input type="text" id="txtCriterio" value=""> </td>
            <td> <input type="text" id="txtNumInv" value="<?php echo $id; ?>"> </td>        
            <td> <input type="text" id="txtNumSerie" value=""> </td>      
            <td> <input type="text" id="txtDeno" value=""> </td>
            <td> <input type="text" id="txtOBS" value=""> </td>
            <td>
                <input type="hidden" id="txtIdExaminador" value="<?php echo $idExaminador; ?>">
                <input type="hidden" id="txtIdUbicacion" value="<?php echo $idUbicaciones; ?>">
                <input type="hidden" id="txtIdInventario" value="<?php echo $idInventario; ?>">
                <input type="button" id="btnNuevo2" name="btnNuevo2" value="No Existe, Ingresado">
            </td>
        </tr>
    </form>
    <?php
} else {
    while ($row1 = mysqli_fetch_array($query)) {
        ?>
        <tr>                                                                                            
          
            <td>Num. Inventario</td>           
            <td>Num Serie</td>           
            <td>Denominacion</td> 
            <td>Operacion</td>
        </tr>
        <tr>                                                                                                
          
            <td><?php echo $row1[11]; ?></td>        
            <td><?php echo $row1[14]; ?></td>         
            <td><?php echo $row1[17]; ?></td>
            <td>
                <input type="hidden" id="txtIdEncontrado" value="<?php echo $row1[11]; ?>">
                <input type="text" id="txtObs" placeholder="Observaciones">
                <input type="button" id="btnCargar" name="btnCargar" value="Encontrado">
            </td>
        </tr>
        
        <script>
           setTimeout(clickbutton,1000);
           function clickbutton(){
            // simulamos el click del mouse en el boton del formulario
            $("#btnCargar").click();
            //alert("Aqui llega");  //Debugger
        }
        </script>
        <?php
    }
}
?>
<script>
    $(document).ready(function () {
        $("#btnCargar").click(function (ev) {
            $.ajax({
                type: 'POST',
                url: "grabarEncontrado.php",
                data: {id: $("#txtIdEncontrado").val(), obs: $("#txtObs").val()},
                success: function (data) {
                    if (data == 1) {
                        //alert('Registrado');
                        $(location).attr('href', "realizar_inventario.php");
                    } else {
                        //alert('No Se Pudo Grabar');
                    }

                }
            });
        });

        $("#btnNuevo").click(function (ev) {
            $.ajax({
                type: 'POST',
                url: "grabarNuevo.php",
                data: $("#frmNuevo").serialize(),
                success: function (data) {
                    if (data == 1) {
                        alert('Registrado en Faltantes');
                        $(location).attr('href', "realizar_inventario.php");
                    } else {
                        alert('No Se Pudo Grabar nuevo');
                    }

                }
            });
        });
    });
</script>