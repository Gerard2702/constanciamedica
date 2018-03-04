<?php
    $title = "PENDIENTES";
    include("../core/header.php");

    include("../core/aside.php");
    include("../../config/database.php");

    $sqlrecibidas = "SELECT datos_iniciales.id_datos,datos_iniciales.fecha,datos_iniciales.numero_recibo,datos_iniciales.afiliacion_dui,datos_iniciales.nombre_paciente,datos_iniciales.destinos,datos_iniciales.cantidad,servicios.nombre_servicio FROM datos_iniciales INNER JOIN servicios ON datos_iniciales.id_servicio=servicios.id_servicio WHERE datos_iniciales.id_estado=3 AND id_trabajador=?";
    if($stmt = $conn->prepare($sqlrecibidas)){
        $stmt -> bind_param('s',$_SESSION['id_usuario']);
    	$stmt -> execute();
    	$stmt -> store_result();
    	$rows = $stmt->num_rows;
    	$stmt -> bind_result($id_datos,$fechacreacion,$nrecibo,$afiliacion,$nombrepaciente,$destinos,$cantidad,$servicio);
    }

    $conn->close();
?>
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="ui-content-body">
        <div class="ui-container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div id="titulo">
                            	<h4 id="serviciotitulo">MIS SOLICITUDES PENDIENTES DE CREACION DE CONSTANCIAS</h4>
                            </div>
                            <div class="col-md-12" id="misrecibidos">
                                <div id="contenido" class="table-responsive">
                                    <table class="table table-hover table-condensed" id="mitable">
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
                                                <td><a href="infosolicitud.php?con=<?php echo $id_datos ?>" class="btn btn-success btn-block btn-sm crearconstancias" data-toggle="tooltip" data-placement="left" title="Crear Constancias"><i class="fa fa-edit"></i></a></td>
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
 	$('#pendientes').addClass('active');
    
 </script>