<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Menu Principal - Activo Fijo Puente Alto</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet">
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/resume.min.css" rel="stylesheet">


    </head>

    <body id="page-top">
        <script src="js/jquery.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".fancybox").fancybox({
                    openEffect: 'elastic',
                    closeEffect: 'elastic',
                    helpers: {
                        title: {
                            type: 'inside'
                        }
                    }
                });
                //$(".fancybox").fancybox();
            });
        </script>
        <?php
        //conexion con base de datos
        include_once './procesos/Conexion.php';
        $cone = new Conexion();
        ?>

        <?php
//        if (isset($_POST["idfoto"])) {
//            echo "<script>alert('foto para cargar')</script>";
//        }
        //Si se quiere subir una imagen
        if (isset($_POST['idfoto'])) {
            $id_foto = $_POST['idfoto'];
            $nombre_foto = "";
            $sql = "select * from fotos where numero_de_inventario=$id_foto";
            $query = $cone->SQLSeleccion($sql);
            $cantidad_filas = mysqli_num_rows($query);
            $OK = 0;
            if ($cantidad_filas == 0) {
                $sw = "I";
            } else {
                $fila = mysqli_fetch_row($query);
                $cantidad_filas = $fila[6];
                $sw = "A";
                //echo "<b>Cantidad de Fotos:$cantidad_filas</b>";
                if ($cantidad_filas == 5) {
                    $OK = 1;
                }
            }
            if ($OK == 0) {
                $archivo = $_FILES['txtFoto']['name'];
                if (isset($archivo) && $archivo != "") {
                    //Obtenemos algunos datos necesarios sobre el archivo
                    $tipo = $_FILES['txtFoto']['type'];
                    $tamano = $_FILES['txtFoto']['size'];
                    $temp = $_FILES['txtFoto']['tmp_name'];
                    //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                    if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 20000000))) {
                        echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>- Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.</b></div>';
                    } else {
                        //Si la imagen es correcta en tamaño y tipo
                        //Se intenta subir al servidor
                        $nombre_foto = $_POST["idfoto"] . '_' . $archivo;
                        if (move_uploaded_file($temp, 'images/' . $_POST["idfoto"] . '_' . $archivo)) {
                            //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                            chmod('images/' . $_POST["idfoto"] . '_' . $archivo, 0777);
                            //Mostramos el mensaje de que se ha subido co éxito
                            echo "<script>alert('foto cargada correctamente')</script>";
                            //echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
                            //Mostramos la imagen subida
                            //echo '<p><img src="images/' . $archivo . '"></p>';
                        } else {
                            //Si no se ha podido subir la imagen, mostramos un mensaje de error
                            //echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                            echo "<script>alert('Ocurrió algún error al subir el fichero. No pudo guardarse.')</script>";
                        }
                    }
                }
                $cantidad_filas++;
                if ($sw == "I") {
                    $sql = "insert into fotos values($id_foto,'$nombre_foto','','','','',$cantidad_filas)";
                    $result = $cone->SQLOperacion($sql);
                } else {
                    $sql = "update fotos set foto$cantidad_filas='$nombre_foto',cantidad=$cantidad_filas where numero_de_inventario='$id_foto' ";
                    $result = $cone->SQLOperacion($sql);
                }
            } else {
                echo "<script>alert('limite maximo de fotos de este articulo.')</script>";
            }
        }
        ?>
        <!-- FORMULARIOS MODALES --------------------------------------------------------------------------->
        <!-- Modal SUBIR -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">                        
                        <h4 class="modal-title">Subir Imagen </h4>
                    </div>
                    <div class="modal-body">

                        <p>Seleccione la fotografia a subir.</p>
                        <form method="POST" enctype="multipart/form-data">                            
                            <div id="dividfoto"></div>
                            <input type="hidden" id="idfoto" name="idfoto">                            
                            <input type="file" name="txtFoto"><br><br>
                            <input type="submit" value="Subir">
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- Modal VER -->        
        <div class="modal fade" id="myModalV" role="dialog">
            <div class="modal-dialog" style="width: 800px;">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">                        
                        <h4 class="modal-title">Ver Imagenes </h4>
                    </div>
                    <div class="modal-body" id="contenedor_foto">
                        <div id="contenido">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- FIN FORMULARIOS MODALES ---------------------------------------------------------------------->

        <?php
        if (isset($_SESSION['IdUbicaciones'])) {
            $idUbicaciones = $_SESSION['IdUbicaciones'];
            $idExaminador = $_SESSION['IdExaminador'];
            $idInventario = $_SESSION['IdInventario'];
        } else {
            $idUbicaciones = $_POST['cboUbicaciones'];
            $idExaminador = $_POST['cboExaminadores'];
            $idInventario = $_POST['txtIdInventario'];
            $_SESSION['IdUbicaciones'] = $idUbicaciones;
            $_SESSION['IdExaminador'] = $idExaminador;
            $_SESSION['IdInventario'] = $idInventario;
        }
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <span class="d-block d-lg-none">Activo Fijo</span>
                <span class="d-none d-lg-block">
                    <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="img/logo1.jpg" alt="">
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#1">Realizar Inventario</a>
                        <?php
                        $sql = "select * from examinadores where idexaminadores=$idExaminador";
                        $query = $cone->SQLSeleccion($sql);
                        $fila = mysqli_fetch_row($query);
                        echo $fila[1];
                        ?>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <hr class="m-0">
            <section id="1">

                <div>
                    <div class="resume-content">
                        <h3 class="mb-0">Realizar Inventario</h3>            
                        <?php
                        $sql = "select * from ubicaciones where codigo='$idUbicaciones'";
                        $query = $cone->SQLSeleccion($sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo 'Ubicacion:<b>' . $row[1] . '</b>';
                        }
                        ?>                            
                        <script>
                            $(document).ready(function () {
                                $("#btnCompletar").click(function () {
                                    $.ajax({
                                        type: 'POST',
                                        url: "fin_inventario_seccion.php",
                                        data: $("#frmTermino").serialize(),
                                        success: function (data) {
                                            alert(data);
                                            if (data == 1) {
                                                alert('Inventario en Ubiacion Terminado');
                                                $(location).attr('href', "index.php");
                                            } else {
                                                alert('Faltaron Datos');
                                            }
                                        }
                                    });
                                });
                                $("#txtBuscaCodigo").keypress(function (e) {
                                    var code = (e.keyCode ? e.keyCode : e.which);
                                    if (code == 13) {
                                        var x = $("#txtBuscaCodigo").val();
                                        $.ajax({
                                            type: 'POST',
                                            url: "buscarCodigo.php",
                                            data: {Id: $("#txtBuscaCodigo").val()},
                                            success: function (data) {
                                                $("#tablaBuscarCodigo").html(data);
                                            }
                                        });
                                    }
                                });
                                $("#btnOK").click(function (event) {
                                    $.ajax({
                                        type: 'POST',
                                        url: "grabar_inventario.php",
                                        data: $("#frmAuditoria").serialize(),
                                        success: function (data) {
                                            alert(data);
                                            if (data == 2) {
                                                alert('Registrado');
                                                $(location).attr('href', "index.php");
                                            } else {
                                                alert('Faltaron Datos');
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                        <?php echo '<br>Cod. Ubicacion:<b>' . $idUbicaciones . '</b>'; ?>
                        <?php echo ' Cod. Inventario:<b>' . $idInventario . '</b>'; ?>
                        <?php echo ' Cod. Examinador:<b>' . $idExaminador . '</b>'; ?>
                        <?php
                        $sql = "select * from activo_fijo where criterio_clasif_5='$idUbicaciones' and cantidad>0 and vida_rest_fact_ipc_aplic>0 order by numero_de_inventario ";

                        $query = $cone->SQLSeleccion($sql);
                        ?>
                        <br>
                        <input type="text" name="txtBuscaCodigo" id="txtBuscaCodigo">                                                       
                        <table class="table" id="tablaBuscarCodigo">                                
                            <tr>                                                                                        
                                <td>Clase Activo</td>
                                <td>Num. Inventario</td>
                                <td>Num Serie</td>
                                <td>Unidad</td>
                                <td>Cantidad</td>
                                <td>Denominacion</td> 
                                <td>Operacion</td>
                            </tr>
                            <tr>                                                                                        
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                        <form name="frmAuditoria" id="frmAuditoria">
                            <table class="table">
                                <tr>
                                    <td colspan="7"><b>Elementos a encontrar en la ubicacion</b></td>
                                </tr>
                                <tr>
                                    <td>Activo Fijo</td>                                                               
                                    <td>Num Serie</td>
                                    <td>Denominacion</td>                                       
                                    <td>Cantidad</td>
                                    <td>Valor Neto</td>
                                    <td>Vida Restante</td>                                        
                                    <td>
                                        Fotos
                                    </td>
                                </tr>
                                <?php
                                $faltan = 0;
                                $hallados = 0;
                                while ($row1 = mysqli_fetch_array($query)) {
                                    $idActivo = $row1[0];
                                    $sql2 = "select count(*) from inventariados where id_activo= $idActivo and iddetalle_inventario=$idInventario ";
                                    $reg = $cone->SQLSeleccion($sql2);
                                    $fila = mysqli_fetch_row($reg);
                                    if ($fila[0] == 0) {
                                        echo '<tr>';
                                        $faltan++;
                                    } else {
                                        echo '<tr style="background-color: #007bff">';
                                        $hallados++;
                                    }
                                    ?>
                                    <td><?php echo $row1[11]; ?></td>
                                    <td><?php echo $row1[14]; ?></td>
                                    <td><?php echo $row1[17]; ?></td>                                                                             
                                    <td><?php echo $row1[16]; ?></td>
                                    <td><?php echo $row1[31]; ?></td>
                                    <td><?php echo $row1[34]; ?></td>
                                    <td>
                                        <?php echo $row1[0]; ?>
                                        <script>
                                            function pasarIdFoto(datos) {
                                                document.getElementById("idfoto").value = datos.id;
                                                document.getElementById("dividfoto").innerHTML = datos.id;
                                            }
                                            //ejemplo
                                            function verIdFotoOK(datos) {
                                                var url = 'https://code.jquery.com/jquery-3.1.1.slim.min.js';
                                                fetch(url)
                                                        .then(response => response.text())
                                                        .then(data => console.info(data));
                                            }
                                            ////////////////////////////
                                            function verIdFoto(datos) {
                                                //alert(datos.id)
                                                const i = datos.id;
                                                var url = 'carga_fotos.php?id=' + i;
                                                fetch(url)
                                                        .then(response => response.text())
                                                        .then(data => accion(data));

                                            }
                                            function accion(dato) {                                                
                                                document.getElementById("contenido").innerHTML = dato;
                                                $('#myModalV').modal('show')
                                            }



                                        </script>
                                        <img src="img/camera.png" data-toggle="modal" data-target="#myM" id="<?php echo $row1[0]; ?>" width="30px" height="30px" alt="Ver" onclick="verIdFoto(this)">
                                        <img src="img/subir.png" data-toggle="modal" data-target="#myModal" id="<?php echo $row1[0]; ?>" onclick="pasarIdFoto(this)" width="30px" height="30px" alt="Subir">
                                    </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </form>                                            

                    </div>

                </div>
                <div>

                    <table class="table">
                        <tr>
                            <td colspan="5"><h2>Material Nuevo Inventariado en este lugar</h2> </td>
                        </tr>
                        <tr>
                            <td>Activo Fijo</td>
                            <td>Numero de Serie</td>
                            <td>Denominacion</td>
                            <td>Fecha</td>
                            <td>Observacion</td>
                        </tr>
                        <?php
                        $sql = "select * from faltantes where idUbicacion='$idUbicaciones' and idInventario='$idInventario'";
                        $nuevo = 0;
                        $registros_faltantes = $cone->SQLSeleccion($sql);
                        while ($row2 = mysqli_fetch_array($registros_faltantes)) {
                            ?>
                            <tr>
                                <td><?php echo $row2[4]; ?></td>
                                <td><?php echo $row2[5]; ?></td>
                                <td><?php echo $row2[6]; ?></td>
                                <td><?php echo $row2[7]; ?></td>
                                <td><?php echo $row2[8]; ?></td>
                            </tr>
                            <?php
                            $nuevo++;
                        }
                        ?>
                    </table>
                </div>
                <div>
                    <form id="frmTermino">
                        <table class="table table-dark">
                            <tr>
                                <td>
                                    <input type="hidden" name="txtUbicacion" value="<?php echo $idUbicaciones; ?>">
                                    <input type="hidden" name="txtInventario" value="<?php echo $idInventario; ?>">
                                    <input type="hidden" name="txtExaminador" value="<?php echo $idExaminador; ?>">
                                    <input type="hidden" name="txtFaltan" value="<?php echo $faltan; ?>">
                                    <input type="hidden" name="txtHallados" value="<?php echo $hallados; ?>">
                                    <input type="hidden" name="txtNuevos" value="<?php echo $nuevo; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Faltan: <b><?php echo $faltan; ?></b> </td>                                
                                <td>Hayados:<b><?php echo $hallados; ?></b></td>                                
                                <td>Nuevos:<b><?php echo $nuevo; ?></b></td>                                
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <input type="button" id="btnCompletar" value="TERMINAR AUDITORIA">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea name="txtOBS" rows="4" cols="40">
                                    </textarea>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

            </section>

        </div>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Plugin JavaScript -->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Custom scripts for this template -->
        <script src="js/resume.min.js"></script>
    </body>

</html>
