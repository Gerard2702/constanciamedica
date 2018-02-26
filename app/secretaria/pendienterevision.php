<?php
    $title = "HOME";
    include("../core/header.php");

    include("../core/aside.php");
    include("../../config/database.php");

    $sqlpendientes = "SELECT datos_iniciales.id_datos,datos_iniciales.fecha,datos_iniciales.numero_recibo,datos_iniciales.afiliacion_dui,datos_iniciales.nombre_paciente,datos_iniciales.destinos,datos_iniciales.cantidad,servicios.nombre_servicio FROM datos_iniciales INNER JOIN servicios ON datos_iniciales.id_servicio=servicios.id_servicio WHERE datos_iniciales.id_estado=4";
    if($stmt = $conn->prepare($sqlpendientes)){
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
                            	<h4>SOLICITUDES PENDIENTES DE REVISION</h4>
                            </div>
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
                                    		<td><a href="infosolicitud.php?con=<?php echo $id_datos ?>" class="btn btn-info btn-sm btn-block vertrabajador"  data-placement="left" data-solicitud="<?php echo $id_datos ?>" data-toggle="tooltip" data-placement="left" title="Revisar"><i class="fa fa-eye"></i></a></td>
                                    	</tr>	
                                    <?php 
                                    		}
                                    	}
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
<?php
    include("../core/footer.php");
 ?>
 <script>
 	$('#pendienterevision').addClass('active');
    $('#mitable').DataTable({
        //"pagingType": "full_numbers",
        "paging": true,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraton registros",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros ",
            "infoEmpty": "No se encontraton registros",
            "infoFiltered": "(Filtrado de _MAX_ registros)",
            "paginate": {
                "first": "Primera",
                "last": "Ultima",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "search": "Buscar: "
        }
    });
 </script>