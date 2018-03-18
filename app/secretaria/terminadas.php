<?php
    $title = "HOME";
    include("../core/header.php");

    include("../core/aside.php");
    include("../../config/database.php");

    $sqlpendientes = "SELECT datos_iniciales.id_datos,datos_iniciales.fecha,datos_iniciales.numero_recibo,datos_iniciales.afiliacion_dui,datos_iniciales.nombre_paciente,datos_iniciales.destinos,datos_iniciales.cantidad,servicios.nombre_servicio FROM datos_iniciales INNER JOIN servicios ON datos_iniciales.id_servicio=servicios.id_servicio WHERE datos_iniciales.id_estado=6 ORDER BY datos_iniciales.id_datos";
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
                            	<h4>SOLICITUDES TERMINADAS</h4>
                            </div>
                            <div class="row">
                                    <div class="col-md-12">
                                        <h5>Busqueda por: </h5>
                                        <form class="miform" action="" method="GET" autocomplete="off">
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>ID Solicitud</label>
                                                        <input class="form-control" type="text" placeholder="ID Solicitud" name="idsolicitud">  
                                                    </div>
                                                </div>                                      
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label># Recibo</label>
                                                        <input class="form-control" type="text" placeholder="Numero de recibo" name="numrecibo">  
                                                    </div>
                                                </div>                                      
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label># Afiliacion o DUI</label>
                                                        <input class="form-control" type="text" placeholder="Afilicacion o DUI" name="numafiliacion">  
                                                    </div>
                                                </div>                                      
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Fecha Presento</label>
                                                        <input class="form-control fecha" type="text" placeholder="Fecha presento" name="fechapresento">  
                                                    </div>
                                                </div>                                      
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>&nbsp;</label>
                                                        <button type="submit" class="btn btn-primary form-control">Buscar</button> 
                                                    </div>
                                                </div>                                      
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <div id="contenido" class="table-responsive">
                            	<table class="table table-hover table-condensed" id="mitable">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th class="col-md-1 text-center">ID SOLICITUD</th>
                                            <th class="col-md-1 text-center">Fecha</th>
                                            <th class="col-md-1">N# Recibo</th>
                                            <th class="col-md-3">Nombre del paciente</th>
                                            <th class="col-md-1">Afiliacion/DUI</th>
                                            <th class="col-md-1">Cantidad</th>
                          					<th class="col-md-1">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                    <?php 
                                    	if($rows>0){
                                    		while ($stmt->fetch()) {
                                    ?>
                                    	<tr>
                                            <td><?php echo $id_datos; ?></td>
                                    		<td><?php echo $fechacreacion; ?></td>
                                    		<td><?php echo $nrecibo; ?></td>
                                    		<td><?php echo $nombrepaciente; ?></td>
                                    		<td><?php echo $afiliacion; ?></td>
                                    		<td><?php echo $cantidad; ?></td>
                                    		<td><a href="infoimpresion.php?con=<?php echo $id_datos ?>" class="btn btn-info btn-sm btn-block vertrabajador"  data-placement="left" data-solicitud="<?php echo $id_datos ?>" data-toggle="tooltip" data-placement="left" title="Ver para imprimir"><i class="fa fa-eye"></i></a></td>
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
 	$('#terminadas').addClass('active');
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
            "search": "Busqueda general: "
        },
        "searching": true,
        "searchCols": [
            <?php if(!isset($_GET['idsolicitud'])){ ?>null,<?php } else { if($_GET['idsolicitud']=='') { ?>null,<?php } else{ ?>{ "search": "<?php echo $_GET['idsolicitud']; ?>" },<?php } } ?>
            <?php if(!isset($_GET['fechapresento'])){ ?>null,<?php } else { if($_GET['fechapresento']=='') { ?>null,<?php } else{ ?>{ "search": "<?php echo $_GET['fechapresento']; ?>" },<?php } } ?>
            <?php if(!isset($_GET['numrecibo'])){ ?>null,<?php } else { if($_GET['numrecibo']=='') { ?>null,<?php } else{ ?>{ "search": "<?php echo $_GET['numrecibo']; ?>" },<?php } } ?>
            null,
            <?php if(!isset($_GET['numafiliacion'])){ ?>null,<?php } else { if($_GET['numafiliacion']=='') { ?>null,<?php } else{ ?>{ "search": "<?php echo $_GET['numafiliacion']; ?>" },<?php } } ?>
            null,
            null
          ]

    });

    $('.fecha').datepicker({
            todayBtn: "linked",
            format: 'yyyy-mm-dd',
            clearBtn: true,
            language: "es",
            autoclose: true,
            todayHighlight: true,
            disableTouchKeyboard: true,

    });
 </script>