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
	    <div class="page-head-wrap">
	        <h4 class="margin0">SOLICITUD CON NUMERO RECIBO: # <?php echo $nrecibo; ?></h4>  
	    </div>
	    <div class="ui-content-body">
	        <div class="ui-container">
	            <div class="row">
	                <div class="col-md-12 col-lg-12">
	                    <div class="panel">
	                        <div class="panel-body">
	                            <div id="titulo">
	                            	<h4>Datos Principales</h4>
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
	                            	<a class="btn btn-info" href="<?php echo $contancianum ?>"><i class="fa fa-print"></i> Imprimir Constancias</a>
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
                                                while ($stmtcre->fetch()) {
	                                        ?>
	                                            <tr>
	                                                <td><?php echo $tipoconstancia; ?></td>
	                                                <td><?php echo $fecha_consulta; ?></td>
	                                                <td><?php echo $solicitante; ?></td>
	                                                <td><?php echo $parentesco; ?></td>
	                                                <td><?php echo $destinoc; ?></td>
	                                                <td><?php echo $fecha_extension; ?></td>
	                                                <td><a href="constancias.php?cal=<?php echo $id_datosc ?>&ti=<?php echo $tipoconstancia ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Ver Detalle"><i class="fa fa-eye"></i></a> <?php if($estadocon==1){ ?><a href="" class="btn btn-success btn-sm"><i class="fa fa-check"> Aprobado</i></a><?php } else{ ?><a href="" class="btn btn-default btn-sm"><i class="fa fa-error"> No Aprobado</i></a><?php } ?></td>
	                                            </tr>   
	                                        <?php 
	                                                }
	                                            }
	                                            $stmtcre->close();
	                                        ?>  
			                                </tbody>
			                            </table>
			                        </div>
			                        <a class="btn btn-success" href="#">Enviar para modificacion</a>
			                        <a class="btn btn-danger" href="#">Finalizar</a>  
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
