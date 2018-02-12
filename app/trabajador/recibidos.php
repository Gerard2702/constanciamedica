<?php
    $title = "RECIBIDOS";
    include("../core/header.php");

    include("../core/aside.php");
    include("../../config/database.php");

    $sqlrecibidas = "SELECT datos_iniciales.id_datos,datos_iniciales.fecha,datos_iniciales.numero_recibo,datos_iniciales.afiliacion_dui,datos_iniciales.nombre_paciente,datos_iniciales.destinos,datos_iniciales.cantidad,servicios.nombre_servicio FROM datos_iniciales INNER JOIN servicios ON datos_iniciales.id_servicio=servicios.id_servicio WHERE datos_iniciales.id_estado=2 AND datos_iniciales.id_servicio=?";
    if($stmt = $conn->prepare($sqlrecibidas)){
        $stmt -> bind_param('s',$_SESSION['id_servicio']);
    	$stmt -> execute();
    	$stmt -> store_result();
    	$rows = $stmt->num_rows;
    	$stmt -> bind_result($id_datos,$fechacreacion,$nrecibo,$afiliacion,$nombrepaciente,$destinos,$cantidad,$servicio);
    }

    $sqlservicio = "SELECT id_servicio,nombre_servicio FROM servicios ORDER BY nombre_servicio ASC";
    if($stmt1 = $conn->prepare($sqlservicio)){
        $stmt1 -> execute();
        $stmt1 -> store_result();
        $rows1 = $stmt1->num_rows;
        $stmt1 -> bind_result($id_servicio,$nombre_servicio);
    }
    $conn->close();
?>
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="page-head-wrap">
        <h4 class="margin0">BANDEJA DE SOLICITUDES RECIBIDAS </h4>  
    </div>
    <div class="ui-content-body">
        <div class="ui-container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div id="titulo">
                            	<h4 id="serviciotitulo">Servicio de <?php echo $_SESSION['nombre_servicio'] ?></h4>
                            </div>
                                <div class="col-md-8 col-md-offset-4">
                                    <form class="form-horizontal" action="" method="POST">
                                        <div class="form-group">
                                            <label for="inputEmail1" class="col-md-4 col-md-offset-4 control-label">Ver otro tipo de Servicio</label>
                                            <div class="col-md-4">
                                                <select class="form-control cambiarservicio" name="servicio" id="cambiarservicio">
                                                    <?php 
                                                        if($rows1 > 0){
                                                            while ($stmt1->fetch()) {
                                                                if($_SESSION['nombre_servicio']==$nombre_servicio){
                                                    ?>
                                                    <option value="<?php echo $id_servicio; ?>" selected><?php echo $nombre_servicio; ?></option>
                                                    <?php       }     
                                                                else{
                                                                ?>
                                                    <option value="<?php echo $id_servicio; ?>" ><?php echo $nombre_servicio; ?></option>
                                                    <?php        }
                                                            }
                                                        }
                                                        $stmt1->close();
                                                     ?>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <div class="col-md-12" id="misrecibidos">
                                <div id="contenido" class="table-responsive">
                                    <table class="table table-striped table-condensed" id="mitable">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th class="col-md-1 text-center">Fecha</th>
                                                <th class="col-md-1">N# Recibo</th>
                                                <th class="col-md-3">Nombre del paciente</th>
                                                <th class="col-md-1">Afiliacion/DUI</th>
                                                <th class="col-md-3">A presentar en</th>
                                                <th class="col-md-1">Cantidad</th>
                                                <th class="col-md-1">Servicio</th>
                                                <th class="col-md-1">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                        <?php 
                                            if($rows>0){
                                                while ($stmt->fetch()) {
                                        ?>
                                            <tr>
                                                <td><?php echo $fechacreacion; ?></td>
                                                <td><?php echo $nrecibo; ?></td>
                                                <td><?php echo $nombrepaciente; ?></td>
                                                <td><?php echo $afiliacion; ?></td>
                                                <td><?php echo $destinos; ?></td>
                                                <td><?php echo $cantidad; ?></td>
                                                <td><?php echo $servicio; ?></td>
                                                <td><a href="javascript:;" class="btn btn-info btn-sm verconstancia"  data-placement="left" data-solicitud="<?php echo $id_datos ?>" data-toggle="tooltip" data-placement="left" title="Ver detalle"><i class="fa fa-eye"></i></a> <a href="javascript:;" class="btn btn-success btn-sm" id="aceptarsolicitud" data-solicitud="<?php echo $id_datos ?>" data-toggle="tooltip" data-placement="left" title="Aceptar Solicitud"><i class="fa fa-check"></i></a></td>
                                            </tr>   
                                        <?php 
                                                }
                                            }
                                            $stmt->close();
                                        ?>    
                                        </tbody>
                                    </table>
                                </div>
                            </div>                     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
<?php
    include("../core/footer.php");
 ?>
 <script>
 	$('#recibidos').addClass('active');
    
    $(document).ready(function(){

        $(".cambiarservicio").change(function(){
            var id_servicio = $( "#cambiarservicio option:selected" ).val();
            var nombre = $( "#cambiarservicio option:selected" ).text();
            $.ajax({
            url: "otrosserviciosrecibidos.php",
            type: 'POST',
            data: { 
                id_servicio: id_servicio
            },
            success: function (data) {
                $("#misrecibidos").html(data);
                $("#serviciotitulo").html("Servicio de "+nombre);
            },
            error: function () {
                alert("UN ERROR HA OCURRIDO");
            }
        });
        });

        $("#aceptarsolicitud").click(function(e) {
            e.preventDefault();
            var solicitud = $(this).data('solicitud');
            $.ajax({
                url: "../class/trabajador/aceptarsolicitud.php",
                type: 'POST',
                data: { 
                    solicitud: solicitud
                },
                success: function (data) {
                    if(data=="true"){
                        location.href ="infosolicitud.php?con="+solicitud;
                    }
                },
                error: function () {
                    alert("UN ERROR HA OCURRIDO");
                }
            });
        });

    });
 </script>