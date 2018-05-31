<?php
    $title = "SOLICITUD";
    if(!isset($_SERVER['HTTP_REFERER'])){
      header('Location:index.php');
    }
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

   		$sqlcomprobar = "SELECT id_datos FROM datos_iniciales WHERE id_datos=? AND id_estado=3 AND id_trabajador=?";
	   		if($stmtcomp = $conn->prepare($sqlcomprobar)){
	   		$stmtcomp->bind_param('ii',$_GET['con'],$_SESSION['id_usuario']);
	   		$stmtcomp->execute();
	   		$stmtcomp->store_result();
	   		$rowscomp = $stmtcomp->num_rows;
	   		$stmtcomp->close();
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
		                                    <strong>Error!</strong> ESTA SOLICITUD YA FUE ACEPTADA POR OTRO TRABAJADOR O NO A SIDO ACEPTADA;
		                                    <p>Para poder ver la informacion de solicitudes, busque en la sección de recibidos o en la sección de pendientes.</p>
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

   		$sqlcreadas = "SELECT dat.id_datosc,dat.id_constancia,dat.fecha_consulta,dat.nombre_solicitante,dat.parentesco,dat.destino,dat.fecha_extension,con.tipo_constancia FROM datos_complementarios dat INNER JOIN constancias con ON dat.id_constancia=con.id_constancia WHERE dat.id_datos=? ORDER BY dat.id_datosc";
   		if($stmtcre = $conn->prepare($sqlcreadas)){
   			$stmtcre -> bind_param('i',$contancianum);
   			$stmtcre -> execute();
   			$stmtcre -> store_result();
	    	$rowscre = $stmtcre->num_rows;
   			$stmtcre -> bind_result($id_datosc,$id_constancia,$fecha_consulta,$solicitante,$parentesco,$destinoc,$fecha_extension,$tipoconstancia);
   		}
	    
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
                                <?php 
                                    if($rowscre>=$cantidad){ ?>
                                     <a class="btn btn-info" href="" disabled><i class="fa fa-plus"></i> Agregar Constancia</a>
                                    <?php }
                                    else{  ?>
                                  <a class="btn btn-info" href="newconstancia.php"><i class="fa fa-plus"></i> Agregar Constancia</a>
                                 <?php   }
                                 ?>
	                            	
	                            	<div id="contenido" class="table-responsive">
			                        	<table class="table table-striped table-condensed" id="mitable">
			                                <thead class="thead-inverse">
			                                    <tr>
			                                        <th class="col-md-2">Tipo Constancia</th>
			                                        <th class="col-md-1">Fecha Consulta</th>
			                                        <th class="col-md-2">Solicitante</th>
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
                                                	$id_tipo=0;
                                                	switch ($id_constancia) {
                                                		case '1':
                                                			$sqltipo = "SELECT id_datosca FROM datos_const_alta WHERE id_datosc=?";
                                                			if($stmttipo = $conn->prepare($sqltipo)){
                                                				$stmttipo->bind_param('i',$id_datosc);
                                                				$stmttipo->execute();
                                                				$stmttipo->bind_result($id_tipo);
                                                				$stmttipo->fetch();
                                                				$stmttipo->close();
                                                			}
                                                			break;
                                                		case '2':
                                                			$sqltipo = "SELECT id_datosci FROM datos_const_ingreso WHERE id_datosc=?";
                                                			if($stmttipo = $conn->prepare($sqltipo)){
                                                				$stmttipo->bind_param('i',$id_datosc);
                                                				$stmttipo->execute();
                                                				$stmttipo->bind_result($id_tipo);
                                                				$stmttipo->fetch();
                                                				$stmttipo->close();
                                                			}
                                                			break;
                                                		case '3':
                                                			$sqltipo = "SELECT id_datoscf FROM datos_const_fallecimiento WHERE id_datosc=?";
                                                			if($stmttipo = $conn->prepare($sqltipo)){
                                                				$stmttipo->bind_param('i',$id_datosc);
                                                				$stmttipo->execute();
                                                				$stmttipo->bind_result($id_tipo);
                                                				$stmttipo->fetch();
                                                				$stmttipo->close();
                                                			}
                                                			break;
                                            			case '4':
                                            				$sqltipo = "SELECT id_datoscfc FROM datos_const_fallecimiento_casa WHERE id_datosc=?";
                                                			if($stmttipo = $conn->prepare($sqltipo)){
                                                				$stmttipo->bind_param('i',$id_datosc);
                                                				$stmttipo->execute();
                                                				$stmttipo->bind_result($id_tipo);
                                                				$stmttipo->fetch();
                                                				$stmttipo->close();
                                                			}
                                            				break;
                                                		default:
                                                			# code...
                                                			break;
                                                	}
	                                        ?>
	                                            <tr>
	                                                <td><?php echo $tipoconstancia; ?></td>
	                                                <td><?php echo $fecha_consulta; ?></td>
	                                                <td><?php echo $solicitante; ?></td>
	                                                <td><?php echo $parentesco; ?></td>
	                                                <td><?php echo $destinoc; ?></td>
	                                                <td><?php echo $fecha_extension; ?></td>
	                                                <td><a href="editconstancia.php?con=<?php echo $id_datosc; ?>&alt=<?php echo $id_tipo ?>" class="btn btn-success btn-sm " data-toggle="tooltip" data-placement="left" title="Ver o editar"><i class="fa fa-edit"></i></a> <a href="javascript:;" class="btn btn-warning btn-sm duplicar" data-constancia="<?php echo $id_datosc ?>" data-tipo="<?php echo $id_constancia; ?>" data-alt="<?php echo $id_tipo; ?>" data-toggle="tooltip" data-placement="left" title="Duplicar"><i class="fa fa-copy"></i></a> <a href="javascript:;" class="btn btn-danger btn-sm eliminar"  data-placement="left" data-constancia="<?php echo $id_datosc ?>" data-tipo="<?php echo $id_constancia; ?>" data-alt="<?php echo $id_tipo; ?>"data-toggle="tooltip" data-placement="left" title="Eliminar"><i class="fa fa-times"></i></a></td>
	                                            </tr>   
	                                        <?php 
	                                                }
	                                            }
	                                            $stmtcre->close();
	                                        ?>  
			                                </tbody>
			                            </table>
			                        </div>
			                        	<a  href="javascript:;" type="submit" class="btn btn-success" name="finalizar" id="finalizar" data-solicitud="<?php echo $id_datos ?>">Finalizar</a>
			                        </form>
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
	$conn->close();
	}
   }
    
?>

<script>
$(document).ready(function(){
	$("#finalizar").click(function(e) {
        e.preventDefault();
        var solicitud = $(this).data('solicitud');
        var numrecibo = <?php echo $nrecibo; ?>;
        swal({
          title: "Desea finalizar y enviar la solicitud #"+numrecibo+"?",
          text: "Verifique que todas las constancias hayan sido creadas!",
          icon: "warning",
          buttons: ["Cancelar", "Finalizar"],
        })
        .then((finalizar) => {
          if (finalizar) {    
            $.ajax({
                url: "../class/trabajador/finalizar.php",
                type: 'POST',
                data: { 
                    solicitud: solicitud
                },
                success: function (data) {
                    if(data=="true"){
                        swal({
                        title: "Solicitud enviada exito!",
                        icon: "success",
	                    }).then((value) => {
	                          location.href ="pendientes.php";
	                    }); 
                    }
                    else{
                    	swal({
                        title: "Un Error ha ocurrido!",
                        text: data,
                        icon: "error",
	                    }).then((value) => {
	                          location.href ="infosolicitud.php?con=<?php echo $id_datos ?>";
	                    });
                    }
                },
                error: function () {
                    alert("UN ERROR HA OCURRIDO");
                }
            });
       } else {
            
          }
        });

    });

    $(".eliminar").click(function(e){
    	
        e.preventDefault();
        var id_constancia= $(this).data('constancia');
        var id_tipo = $(this).data('tipo');
        var alt = $(this).data('alt');
        swal({
          title: "Desea eliminar la constancia?",
          text: "",
          icon: "warning",
          buttons: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "../class/trabajador/eliminarconstancia.php",
                type: 'POST',
                data: { 
                    id_constancia: id_constancia,id_tipo: id_tipo,alt: alt
                },success: function (data) {
                	if(data=="true"){
                		swal({
                        title: "Constancia eliminada con exito!",
                        icon: "success",
	                    }).then((value) => {
	                          location.href ="infosolicitud.php?con=<?php echo $id_datos ?>";
	                    }); 
                	}
                	else{
                		swal({
                        title: "Un Error ha ocurrido!",
                        icon: "error",
	                    }).then((value) => {
	                          location.href ="infosolicitud.php?con=<?php echo $id_datos ?>";
	                    });
                	}
                    
                },error: function () {
                    alert("UN ERROR HA OCURRIDO");
                }
            });
          } else {}
        });     
    });

    $('.duplicar').click(function(e){
      e.preventDefault();
      var id_datosc = $(this).data('constancia');
      var tipo = $(this).data('tipo');
      var alt = $(this).data('alt');
      swal({
          title: "Desea Duplicar la constancia?",
          text: "",
          icon: "warning",
          buttons: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                url: "../class/trabajador/duplicarconstancia.php",
                type: 'POST',
                data: { 
                    id_constancia: id_datosc,
                    id_tipo: tipo,
                    id_alt: alt
                },success: function (data) {
                  if(data=="true"){
                    swal({
                        title: "Constancia duplicada con exito!",
                        icon: "success",
                      }).then((value) => {
                            location.href ="infosolicitud.php?con=<?php echo $id_datos ?>";
                      }); 
                  }
                  else{
                    alert(data)
                    swal({
                        title: "Un Error ha ocurrido!",
                        icon: "error",
                      }).then((value) => {
                            location.href ="infosolicitud.php?con=<?php echo $id_datos ?>";
                      });
                  }
                    
                },error: function () {
                    alert("UN ERROR HA OCURRIDO");
                }
            });
          } else {}
        });
    })
})
</script>
