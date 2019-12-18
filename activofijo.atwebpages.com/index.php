<?php session_start(); ?>
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
        <?php
        include_once './procesos/Conexion.php';
        $cone = new Conexion();
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <span class="d-block d-lg-none">Activo Fijo</span>
                <span class="d-none d-lg-block">
                    <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="img/logo.jpg" alt="">
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#1">Realizar Inventario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#2">Resultados Inventarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#3">Carga Sabana</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#4">Cruzar Inventarios</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid p-0">

            <section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="about">
                <div class="w-100">
                    <h1 class="mb-0">Sistema Activo Fijo

                    </h1>        
                </div>
            </section>
            <hr class="m-0">
            <section class="resume-section p-3 p-lg-5 d-flex justify-content-center" id="1">
                <div class="w-100">
                    <h2 class="mb-5">Realizar Inventario</h2>                 

                    <div class="resume-item d-flex flex-column flex-md-row justify-content-between mb-5">
                        <div class="resume-content">
                            <h3 class="mb-0">Pedir Inventario</h3>            
                            <p>Ingrese el nombre del departamento que pide realizar un inventario:<p>
                                <script>
                                    $(document).ready(function () {
                                        $("#cboInventarios").change(function () {
                                            var x = $("#cboInventarios").val();
                                            $("#txtIdInventario").val(x);
                                            $.ajax({
                                                type: 'POST',
                                                url: "invent.php",
                                                data: {cboInventarios: $("#cboInventarios").val()},
                                                success: function (data) {
                                                    $("#tabla_contenido").html(data);
                                                }
                                            });
                                            $.ajax({
                                                type: 'POST',
                                                url: "det_invent.php",
                                                data: {Id: $("#cboInventarios").val()},
                                                success: function (data) {
                                                    $("#tabla_detalle_contenido").html(data);
                                                }
                                            });
                                            $.ajax({
                                                type: 'POST',
                                                url: "llenarUbicaciones.php",
                                                data: {Id: $("#cboInventarios").val()},
                                                success: function (data) {
                                                    $("#cboUbicaciones").html(data);
                                                }
                                            });
                                        });
                                        $("#txtTexto").keydown(function (event) {
                                            var datos = $("#txtTexto").val();
                                            //cboLista
                                            $.ajax({
                                                type: 'POST',
                                                url: "filtro_ubicaciones.php",
                                                data: {datos: datos},
                                                success: function (data) {
                                                    //alert(data);
                                                    $("#cboLista").html(data);
                                                }
                                            });
                                        });
                                        $("#btnOK").click(function (event) {
                                            var datos = "";
                                            $("#cboLista2 option").each(function () {
                                                datos += $(this).text() + ";";
                                            });
                                            //alert(datos);
                                            $("#txtCodigos").val(datos);
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
                            <form name="frmAuditoria" id="frmAuditoria">
                                <table border="1">
                                    <tr>
                                        <td colspan="2"><b>Formulario Pedir Auditoria</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Id:                                            
                                        </td>
                                        <td>
                                            <input type="text" disabled="true" value="<?php echo $cone->NextVal("inventario"); ?>" />
                                            <input type="hidden" name="txtID" value="<?php echo $cone->NextVal("inventario"); ?>" />                                            
                                        </td>                                        
                                    </tr>
                                    <tr>
                                        <td>
                                            Titulo:
                                        </td>
                                        <td>
                                            <input type="text" name="txtTitulo" placeholder="ingrese titulo de inventario">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Mandante:</td>
                                        <td>
                                            <?php
                                            $sql = "select * from mandantes";
                                            $query = $cone->SQLSeleccion($sql);
                                            ?>
                                            <select name="cboMandante">
                                                <option>Selecciones</option>
                                                <?php while ($row = mysqli_fetch_array($query)) { ?>
                                                    <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tipo de Inventario:</td>
                                        <td>
                                            <?php
                                            $sql = "select * from tipo_inventario";
                                            $query = $cone->SQLSeleccion($sql);
                                            ?>
                                            <select name="cboTipo">
                                                <option>Selecciones</option>
                                                <?php while ($row = mysqli_fetch_array($query)) { ?>
                                                    <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fecha Realizacion:</td>
                                        <td>
                                            <input type="date" name="txtFecha" value="<?php echo date('Y-m-d') ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fecha Final:</td>
                                        <td>
                                            <input type="date" name="txtFechaFin" value="<?php echo date('Y-m-d') ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Observaciones</td>
                                        <td>
                                            <textarea name="txtOBS" rows="4" cols="40">                                                
                                            </textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><b>Departamentos Auditados</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">
                                            <script>
                                                function marcarTodo() {
                                                    var max = parseInt(document.getElementById("txtCantidad").value);
                                                    for (var i = 1; i < max; i++) {
                                                        document.getElementById("id" + i).checked = "true";
                                                    }

                                                }
                                                function desmarcarTodo() {
                                                    var max = parseInt(document.getElementById("txtCantidad").value);
                                                    for (var i = 1; i < max; i++) {
                                                        document.getElementById("id" + i).checked = 0;
                                                    }
                                                }
                                            </script>
                                            <input type="text" id="txtTexto" name="txtTexto">
                                            <input type="button" id="btnFiltrar" value="Buscar"><br>                                                 
                                            <input type="button" onclick="pasarTodo()" value="Pasar todo">
                                            <input type="button" onclick="pasar()"  value="Pasar >>">
                                            <input type="button" onclick="quitar()"  value="<< Quitar">
                                            <input type="button" onclick="quitarTodo()" value="Quitar todo">                                                                                                                                    
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <script>
                                                function  quitar() {
                                                    var xx = document.getElementById("cboLista2").value;
                                                    //alert('pasar ' + xx);
                                                    if (xx.trim().length == 0) {
                                                        alert('no selecciono nada');
                                                        return;
                                                    }
                                                    var x = document.getElementById("cboLista");
                                                    var option = document.createElement("option");
                                                    option.text = xx;
                                                    x.add(option);
                                                    var sel = document.getElementById("cboLista2");
                                                    sel.remove(sel.selectedIndex);
                                                }

                                                function  pasar() {
                                                    var xx = document.getElementById("cboLista").value;
                                                    //alert('pasar ' + xx);
                                                    if (xx.trim().length == 0) {
                                                        alert('no selecciono nada');
                                                        return;
                                                    }

                                                    var x = document.getElementById("cboLista2");
                                                    var option = document.createElement("option");
                                                    option.text = xx;
                                                    sw = 0;
                                                    for (var i = 0; i < (x.length); i++) {
                                                        //  Aca haces referencia al "option" actual
                                                        var opt = x[i];
                                                        //var option = document.createElement("option");
                                                        // Haces lo que te de la gana aca
                                                        //console.log(opt.value);
                                                        if (opt.value == xx) {
                                                            sw = 1;
                                                        }
                                                    }
                                                    if (sw == 0) {
                                                        x.add(option);
                                                        var sel = document.getElementById("cboLista");
                                                        sel.remove(sel.selectedIndex);
                                                    } else {
                                                        alert('existe en el listado');
                                                    }
                                                }
                                                function quitarTodo() {
                                                    var sel = document.getElementById("cboLista2");
                                                    var x = document.getElementById("cboLista");
                                                    for (var i = 0; i < (sel.length); i++) {
                                                        //  Aca haces referencia al "option" actual
                                                        var opt = sel[i];
                                                        var option = document.createElement("option");
                                                        // Haces lo que te de la gana aca
                                                        //console.log(opt.value);
                                                        option.text = opt.value;
                                                        x.add(option);
                                                    }
                                                    for (var s = 0; s < 500; s++) {
                                                        sel.remove(0);
                                                    }

                                                }
                                                function pasarTodo() {
                                                    var sel = document.getElementById("cboLista");
                                                    var x = document.getElementById("cboLista2");
                                                    //var y= document.getElementById("txtCodigos");
                                                    for (var i = 0; i < (sel.length); i++) {
                                                        //  Aca haces referencia al "option" actual
                                                        var opt = sel[i];
                                                        var option = document.createElement("option");
                                                        // Haces lo que te de la gana aca
                                                        //console.log(opt.value);
                                                        option.text = opt.value;
                                                        x.add(option);
                                                        //y.add(option);
                                                        //document.getElementById("txtCodigos").value+=opt.value+";";
                                                    }
                                                    for (var s = 0; s < 500; s++) {
                                                        sel.remove(0);
                                                    }
                                                }
                                            </script>                                            
                                            <select id="cboLista" size="20" style="width: 400px;">
                                                <?php
                                                $sql = "select * from ubicaciones order by descripcion";
                                                $query = $cone->SQLSeleccion($sql);
                                                $x = 0;
                                                while ($row88 = mysqli_fetch_array($query)) {
                                                    $x++;
                                                    ?>
                                                    <option><?php echo utf8_encode($row88[1]); ?></option>
                                                <?php } ?>
                                            </select> 
                                        </td>
                                        <td>
                                            <select size="20" style="width: 400px;" id="cboLista2">                                                
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;" colspan="2">
                                            <input type="button" id="btnOK"  value="Grabar">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <textarea style="visibility: hidden" id="txtCodigos" name="txtCodigos" cols="2" rows="2"></textarea>
                                        </td>
                                    </tr>
                                    <input type="hidden" id="txtCantidad" name="txtCantidad" value="<?php echo $x; ?>">    
                                </table>
                            </form>    
                        </div>

                    </div>

                    <div class="resume-item d-flex flex-column flex-md-row justify-content-between mb-12">
                        <div class="resume-content">
                            <h3 class="mb-6">Realizar inventario</h3>                            
                            <p>Listado de los inventarios pendientes</p>
                            <table>
                                <tr>
                                    <td>Inventario:</td>
                                    <td>
                                        <?php
                                        $sql = "select * from inventario";
                                        $query = $cone->SQLSeleccion($sql);
                                        ?>
                                        <select id="cboInventarios" name="cboInventarios">
                                            <option>Selecciones</option>
                                            <?php while ($row = mysqli_fetch_array($query)) { ?>
                                                <option value="<?php echo $row[0]; ?>"><?php echo $row[1].' - '.$row[3]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                <table class="table table-condensed table-bordered table-hover" style="margin-top: 10px;font-size: 10px ;width:auto;" border="1" id="tabla_contenido">
                                    <tr>
                                        <td>Identificador</td>
                                        <td>Fecha</td>
                                        <td>Mandante</td>
                                        <td>Tipo Auditoria</td>
                                        <td>Observaciones</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>

                                <table class="table table-condensed table-bordered table-hover" style="margin-top: 10px; font-size: 10px; width:auto" border="1" id="tabla_detalle_contenido">
                                    <tr>
                                        <td>Identificador</td>
                                        <td>Fecha</td>
                                        <td>Realizado</td>
                                        <td>Examinador</td>
                                        <td>ubicacion</td>
                                        <td>Observaciones</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>                                                       
                        </div>

                    </div>

                    <div class="resume-item d-flex flex-column flex-md-row justify-content-between">
                        <div class="resume-content">
                            <h3 class="mb-0">Estado Inventario</h3>                            
                            <p>Seleccione el Inventario y Ubicacion a Inventariar </p>
                            <form method="post" action="realizar_inventario.php">
                                <table>
                                    <tr>
                                        <td>Id Inventario</td>
                                        <td>
                                            <input type="text" value="" id="txtIdInventario" name="txtIdInventario">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Seleccione Ubicacion:</td>
                                        <td>
                                            <select id="cboUbicaciones" name="cboUbicaciones">
                                                <option>Selecciones</option>
                                            </select>
                                        </td>                                     
                                    </tr>
                                    <tr>
                                        <td>Seleccione Auditor:</td>
                                        <td>
                                            <?php
                                            $sql = "select * from examinadores";
                                            $query = $cone->SQLSeleccion($sql);
                                            ?>
                                            <select id="cboExaminadores" name="cboExaminadores">
                                                <option>Selecciones</option>
                                                <?php while ($row = mysqli_fetch_array($query)) { ?>
                                                    <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="submit" value="Auditar">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>

                    </div>

                    


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
