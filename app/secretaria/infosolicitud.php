<?php
    $title = "SOLICITUD";

    include("../core/header.php");

    include("../core/aside.php");
    include("../../config/database.php");
    if(!isset($_GET['con']) || $_GET['con']=='' || $_GET['con']==0)
   	{
?>
	<div id="content" class="ui-content ui-content-aside-overlay">
	    <div class="ui-content-body">
	        <div class="ui-container">
	            <div class="row">
	                <div class="col-md-12 col-lg-12">
	                    <div class="panel">
	                        <div class="panel-body">
	                            <div id="contenido">
	                            	<div class="alert alert-danger">
	                                    <strong>Error!</strong> No se encontro la solicitud.
	                                    <p>Pruebe seleccionado una solicitud en la seccion de pendientes de revision</p>
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
   	}
   	else {
   		
   		$contancianum = $_GET['con'];

   		$sqlcomprobar = "SELECT id_datos FROM datos_iniciales WHERE id_datos=? AND id_estado=4";
	   		if($stmtcomp = $conn->prepare($sqlcomprobar)){
	   		$stmtcomp->bind_param('i',$_GET['con']);
	   		$stmtcomp->execute();
	   		$stmtcomp->store_result();
	   		$rowscomp = $stmtcomp->num_rows;
   		}

   		if($rowscomp!=1){
   			?>
		<div id="content" class="ui-content ui-content-aside-overlay">
		    <div class="ui-content-body">
		        <div class="ui-container">
		            <div class="row">
		                <div class="col-md-12 col-lg-12">
		                    <div class="panel">
		                        <div class="panel-body">
		                            <div id="contenido">
		                            	<div class="alert alert-danger">
		                                    <strong>Error!</strong>
		                                    <strong>NO TIENE PERMISOS PARA VER ESTA SOLICITUD</strong>
		                                    <p>Para poder ver la informacion de solicitudes, busque en la seccion de pendientes de revision y seleccione la solicitud que desea ver.</p>
		                                    <p>Gracias!.</p>
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

   		}
	else{

		$_SESSION['constancia_trabajando'] = $contancianum;
   		$sqlconstancia = "SELECT dai.id_datos,dai.fecha,dai.numero_recibo,dai.afiliacion_dui,dai.nombre_paciente,dai.destinos,dai.cantidad,ser.nombre_servicio,dai.fecha_presentado,dai.fecha_cancelado FROM datos_iniciales dai INNER JOIN servicios ser ON dai.id_servicio=ser.id_servicio WHERE dai.id_datos=?";
   		if($stmtcons = $conn->prepare($sqlconstancia)){
   			$stmtcons -> bind_param('s',$contancianum);
   			$stmtcons -> execute();
   			$stmtcons -> bind_result($id_datos,$fechacreacion,$nrecibo,$afiliacion,$nombrepaciente,$destinos,$cantidad,$servicio,$fechapresento,$fechacancelo);
   			$stmtcons -> fetch();
   			$stmtcons -> close();
   		}

   		$sqlcreadas = "SELECT dat.id_datosc,dat.fecha_consulta,dat.nombre_solicitante,dat.parentesco,dat.destino,dat.fecha_extension,con.tipo_constancia,dat.estado FROM datos_complementarios dat INNER JOIN constancias con ON dat.id_constancia=con.id_constancia WHERE dat.id_datos=?";
   		if($stmtcre = $conn->prepare($sqlcreadas)){
   			$stmtcre -> bind_param('i',$contancianum);
   			$stmtcre -> execute();
   			$stmtcre -> store_result();
	    	$rowscre = $stmtcre->num_rows;
   			$stmtcre -> bind_result($id_datosc,$fecha_consulta,$solicitante,$parentesco,$destinoc,$fecha_extension,$tipoconstancia,$estadocon);
   		}
	    $conn->close();
?>
	<!--main content start-->
	<div id="content" class="ui-content ui-content-aside-overlay">
	    <div class="ui-content-body">
	        <div class="ui-container">
	            <div class="row">
	                <div class="col-md-12 col-lg-12">
	                    <div class="panel">
	                        <div class="panel-body">
	                            <div id="titulo">
	                            	<h4>SOLICITUD CON NUMERO RECIBO: # <?php echo $nrecibo; ?></h4>
	                            </div>
	                            <div id="contenido">
	                        		<div class="col-md-12">
	                        			<p><strong>Nombre del paciente: </strong><?php echo $nombrepaciente; ?></p>
	                        			<p><strong>N# Afiliacion o DUI: </strong><?php echo $afiliacion; ?></p>
	                        			<p><strong>Servicio: </strong><?php echo $servicio; ?></p>
	                        		</div>
	                        		<div class="col-md-6">	
	                        			<p><strong>Fecha que se presento: </strong><?php echo $fechapresento; ?></p>
	                        			<p><strong>Constancia a presentar en: </strong><?php echo $destinos; ?></p>	
	                        		</div>
	                        		<div class="col-md-6">
	                        			<p><strong>Fecha que se cancelo: </strong><?php echo $fechacancelo; ?></p>
	                        			<p><strong>Cantidad de constancias: </strong><?php echo $cantidad; ?></p>	
	                        		</div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="panel">
	                        <div class="panel-body">
	                            <div id="titulo">
	                            	<h4>Constancias creadas</h4> 
	                            </div>
	                            <div id="contenido">
	                            	<!-- $constancianum  contiene el id de la solicitud a imprimir-->
	                            	<a class="btn btn-info" target="_blank" href="constancias.php?contancianum=<?php echo $contancianum ?>"><i class="fa fa-print"></i> Imprimir Constancias</a>
	                            	<div id="contenido" class="table-responsive">
			                        	<table class="table table-striped table-condensed" id="mitable">
			                                <thead class="thead-inverse">
			                                    <tr>
			                                        <th class="col-md-1">Tipo Constancia</th>
			                                        <th class="col-md-1">Fecha Consulta</th>
			                                        <th class="col-md-3">Solicitante</th>
			                                        <th class="col-md-1">Parentesco</th>
			                                        <th class="col-md-3">A presentar en</th>
			                                        <th class="col-md-1">Fecha Extensión</th>
			                                        <th class="col-md-2">Opciones</th>
			                                    </tr>
			                                </thead>
			                                <tbody> 
			                                <?php 
                                            if($rowscre>0){
                                            	$cont=1;
                                                while ($stmtcre->fetch()) {
                                                	
	                                        ?>
	                                            <tr>
	                                                <td><?php echo $cont." - ".$tipoconstancia; ?></td>
	                                                <td><?php echo $fecha_consulta; ?></td>
	                                                <td><?php echo $solicitante; ?></td>
	                                                <td><?php echo $parentesco; ?></td>
	                                                <td><?php echo $destinoc; ?></td>
	                                                <td><?php echo $fecha_extension; ?></td>
	                                                <td><a href="" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Ver Detalle"><i class="fa fa-eye"></i></a> <?php if($estadocon==1){ ?><a href="javascript:;" class="btn btn-success btn-sm estado" id="estado<?php echo $id_datosc ?>" data-estado="<?php echo $estadocon; ?>" data-constancia="<?php echo $id_datosc; ?>"><i class="fa fa-check"> Aprobado</i></a><?php } else{ ?><a href="javascript:;" class="btn btn-default btn-sm estado" id="estado<?php echo $id_datosc ?>" data-estado="<?php echo $estadocon; ?>" data-constancia="<?php echo $id_datosc; ?>"><i class="fa "> No Aprobado</i></a><?php } ?></td>
	                                            </tr>   
	                                        <?php 	$cont=$cont+1;
	                                                }
	                                            }
	                                            $stmtcre->close();
	                                        ?>  
			                                </tbody>
			                            </table>
			                        </div>
			                        <a class="btn btn-success modificar" href="javascript:;" data-constancia="<?php echo $id_datos; ?>">Enviar para modificacion</a>
			                        <a class="btn btn-warning" href="#">Finalizar</a>  
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
	}
   }
    
?>
<script>
	$(document).ready(function(){
		$('.estado').click(function(e){
			var estado = $(this).data('estado');
			var id_constancia =  $(this).data('constancia')
			var idestado = document.getElementById("estado");
				$.ajax({
	            url: "../class/secretaria/aprobar.php",
	            type: 'POST',
	            data: { 
	                id_constancia: id_constancia,
	                estado: estado
	            },
	            success: function (data) {
	            	if(data=='true'){
	            		if(estado==0){
	            			$('#estado'+id_constancia).removeClass('btn-default');
	            			$('#estado'+id_constancia).addClass('btn-success estado');
	            			$('#estado'+id_constancia).data( 'estado', '1' );
	            			$('#estado'+id_constancia+' i').addClass('fa-check');
	            			$('#estado'+id_constancia+' i').html('Aprobado');
	            		}
	            		else if(estado==1){
	            			$('#estado'+id_constancia).removeClass('btn-success');
	            			$('#estado'+id_constancia).addClass('btn-default estado');
	            			$('#estado'+id_constancia).data( 'estado', '0' );
	            			$('#estado'+id_constancia+' i').removeClass('fa-check');
	            			$('#estado'+id_constancia+' i').html('No Aprobado');
	            		}
	            	}
	            },
	            error: function () {
	                alert("UN ERROR HA OCURRIDO");
	            }
			});	
		})

		$('.modificar').click(function(){
			var id_constancia =  $(this).data('constancia');
			swal({
              title: "Desea enviar la solicitud para modificación?",
              text: "",
              icon: "warning",
              buttons: true,
            })
            .then((enviar) => {
              if (enviar) {
                $('#myModal').modal();
              } else {
                
              }
            });
		});

		$('.frmcomentario').submit(function(e){
			e.preventDefault();
			var comentario = $('#comentarioinput').val();
			$.ajax({
	            url: "../class/trabajador/editarsolicitud.php",
	            type: 'POST',
	            data: { 
	                comentario: comentario
	            },
	            success: function (data) {
	            	if(data=='true'){
	            		swal({
                            title: "Solicitud enviada para modificación!",
                            icon: "success",
                        }).then((value) => {
                              location.href ="pendienterevision.php";
                        });	
	            	}
	            	else{
	            		swal({
                            title: "Un error ha ocurrido!",
                            icon: "error",
                        }).then((value) => {
                              location.reload(true);
                        });
	            	}
	            },
	            error: function () {
	                alert("UN ERROR HA OCURRIDO");
	            }
			});	
		});

	})
</script>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Especificaciones</h4>
            </div>
            <div class="modal-body">
                <div id="conten-modal">
                    <form class="frmcomentario" action="" method="post">
                    	<div class="row">
                			<div class="col-md-12">
                    			<div class="form-group">
                                	<label>Comentario</label>
                                	<textarea class="form-control input-sm" name="comentario" id="comentarioinput" cols="30" rows="3" required=""></textarea>
                                	<?php $_SESSION['id_datosmodificarsolicitud'] = $id_datos; ?>
                            	</div>
                			</div>
                		</div>
                		<div class="row">
                			<div class="col-md-12">
                    			<div class="form-group">
                                	<button type="submit" class="btn btn-primary">Enviar para modificar</button>
                            	</div>
                			</div>
                		</div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script>
	
</script>