<?php
    $title = "EDITAR CONSTANCIA";
   	if(!isset($_SERVER['HTTP_REFERER'])){
   		header('Location:index.php');
   	}
    include("../core/header.php");

    include("../core/aside.php");
    include("../../config/database.php");

    if(!isset($_SESSION['constancia_trabajando']) || !isset($_GET['con']) || $_GET['con']=='' || $_GET['con']==0){
    	header('Location:index.php');
    }

    $constancianum=$_SESSION['constancia_trabajando'];
    $numcon=$_GET['con'];
    $alt = $_GET['alt'];
    $sqlconstancia = "SELECT dai.id_datos,dai.fecha,dai.numero_recibo,dai.afiliacion_dui,dai.nombre_paciente,dai.destinos,dai.id_servicio,dai.cantidad,ser.nombre_servicio,dai.fecha_presentado,dai.fecha_cancelado FROM datos_iniciales dai INNER JOIN servicios ser ON dai.id_servicio=ser.id_servicio WHERE dai.id_datos=?";
	if($stmtcons = $conn->prepare($sqlconstancia)){
		$stmtcons -> bind_param('s',$constancianum);
		$stmtcons -> execute();
		$stmtcons -> bind_result($id_datos,$fechacreacion,$nrecibo,$afiliacion,$nombrepaciente,$destinos,$id_servicioini,$cantidad,$servicio,$fechapresento,$fechacancelo);
		$stmtcons -> fetch();
		$stmtcons -> close();
	}

	$sqldatosc = "SELECT dat.id_datosc,dat.id_constancia,dat.id_datos,dat.fecha_consulta,dat.id_servicio,dat.diagnostico,dat.nombre_solicitante,dat.parentesco,dat.destino,dat.fecha_extension,dat.id_medico,med.nombre,dat.id_jefe,jef.nombre,dat.id_jefesocial,jefs.nombre,dat.id_director,dir.nombre FROM datos_complementarios dat LEFT JOIN medico_tratante med ON med.id_medico=dat.id_medico LEFT JOIN jefe_trabajo_social jefs ON jefs.id_jefesocial=dat.id_jefesocial LEFT JOIN jefe_servicio jef ON jef.id_jefe=dat.id_jefe LEFT JOIN director dir ON dir.id_director=dat.id_director WHERE dat.id_datosc=? AND dat.id_datos=?";
    if($stmt1 = $conn->prepare($sqldatosc)){
    	$stmt1 -> bind_param('ii',$numcon,$constancianum);
    	$stmt1 -> execute();
    	$stmt1 -> store_result();
    	$rows1 = $stmt1->num_rows;
    	$stmt1 -> bind_result($id_datosc,$id_tipoconstancia,$id_datos,$fecha_consulta,$id_servicio,$diagnosticoini,$nombresolicitante,$parentesco,$destino,$fecha_extension,$id_medicoc,$medico,$id_jefec,$jefe,$id_jefesocialc,$jefesocial,$id_directorc,$director);
    	$stmt1 -> fetch();
    	$stmt1 -> close();
    }

    $sqlservicio = "SELECT id_servicio,nombre_servicio FROM servicios ORDER BY nombre_servicio ASC";
    if($stmt = $conn->prepare($sqlservicio)){
    	$stmt -> execute();
    	$stmt -> store_result();
    	$rows = $stmt->num_rows;
    	$stmt -> bind_result($id_servicio,$nombre_servicio);
    }

    $sqlmedico = "SELECT id_medico,nombre FROM medico_tratante WHERE id_status=1 AND id_servicio=? ORDER BY nombre ASC";
    if($stmt2 = $conn->prepare($sqlmedico)){
    	$stmt2 -> bind_param('i',$id_servicioini);
    	$stmt2 -> execute();
    	$stmt2 -> store_result();
    	$rows2 = $stmt2->num_rows;
    	$stmt2 -> bind_result($id_medico,$nombre_medico);
    }

    $sqljefeservicio = "SELECT id_jefe,nombre FROM jefe_servicio WHERE id_status=1 ORDER BY nombre ASC";
    if($stmtjefeservicio = $conn->prepare($sqljefeservicio)){
    	$stmtjefeservicio -> execute();
    	$stmtjefeservicio -> store_result();
    	$rowsjefeservicio = $stmtjefeservicio->num_rows;
    	$stmtjefeservicio -> bind_result($id_jefeservicio,$nombre_jefeservicio);
    }


    $sqljefesocial = "SELECT id_jefesocial,nombre FROM jefe_trabajo_social WHERE id_status=1 ORDER BY nombre ASC";
    if($stmtjefesocial = $conn->prepare($sqljefesocial)){
    	$stmtjefesocial -> execute();
    	$stmtjefesocial -> store_result();
    	$rowsjefesocial = $stmtjefesocial->num_rows;
    	$stmtjefesocial -> bind_result($id_jefesocial,$nombre_jefesocial);
    }
    

    $sqldirector = "SELECT id_director,nombre FROM director WHERE id_status=1 ORDER BY nombre ASC";
    if($stmtdirector = $conn->prepare($sqldirector)){
    	$stmtdirector -> execute();
    	$stmtdirector -> store_result();
    	$rowsdirector = $stmtdirector->num_rows;
    	$stmtdirector -> bind_result($id_director,$nombre_director);
    }
?>
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="ui-content-body">
        <div class="ui-container">
        	<div class="row">
				<div class="col-md-2">
         			<a href="javascript:history.back(1)" class="btn btn-info" id="btn-regresar"><i class="fa fa-arrow-left"></i> Regresar</a>
         		</div>
			</div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div id="titulo">
                            	<h4 id="constanciatitulo"></h4>
                            </div>
                            <div id="contenido">
                            	<form method="POST" action="../class/trabajador/editar.php">
                            		<div class="row">
	                                    <div class="col-md-6">
	                                    	<div class="form-group">
	                                        	<label>Nombre del paciente</label>
	                                        	<input class="form-control input-sm" type="text" placeholder="Nombre del paciente" name="nombrepaciente" required="" value="<?php echo $nombrepaciente ?>" readonly="readonly">
	                                        	<input type="text" hidden="" name="constancianum" value="<?php echo $id_datos ?>" readonly="readonly">
	                                        	<input type="text" hidden="" name="tipoconstanciainput" id="tipoconstanciainput" value="<?php echo $id_tipoconstancia; ?>" readonly="readonly">
	                                        	<input type="text" hidden="" name="datosc" id="datosc" value="<?php echo $id_datosc; ?>" readonly="readonly">
	                                    	</div>
	                                    </div>
	                                    <div class="col-md-3 col-md-offset-1">
	                                    	<div class="form-group">
	                                        	<label>N# Afiliacion/DUI</label>
	                                        	<input class="form-control input-sm" type="number" placeholder="Numero de Afiliacion/DUI" name="afiliacion" required="" value="<?php echo $afiliacion ?>" readonly="readonly">
	                                    	</div>
	                                    </div>
                            		</div>
                            		<div class="row">
                            			<div class="col-md-6">
	                                    	<div class="form-group">
	                                        	<label>Consulto el dia/mes/Año</label>
	                                        	<input class="form-control input-sm fecha" type="text" placeholder="" name="consultafecha" required="" value='<?php echo $fecha_consulta; ?>' data-date-end-date="0d">
	                                    	</div>
                                    	</div>
                                    	<div class="col-md-3 col-md-offset-1">
	                                    	<div class="form-group">
	                                        	<label>En el Servicio de</label>
	                                        	<select class="form-control input-sm" name="servicio" readonly>
	                                        		<?php 
	                                        			if($rows > 0){
	                                        				while ($stmt->fetch()) {
		                                        				if($servicio==$nombre_servicio){
		                                        				
	                                        		?>
	                                        		<option value="<?php echo $id_servicio; ?>" selected><?php echo $nombre_servicio; ?></option>
	                                        		<?php
	                                        					} else{ ?>
													<option value="<?php echo $id_servicio; ?>"><?php echo $nombre_servicio; ?></option>
	                                        		<?php	
	                                        					}	
	                                        				}
	                                        			}
	                                        			$stmt->close();
	                                        		 ?>
	                                        	</select>
	                                    	</div>
	                                    </div>
                            		</div>
                                    <div class="row">
                                    	<div class="col-md-6 ">
	                                    	<div class="form-group">
	                                        	<label>Con diagnostico</label>
	                                        	<textarea class="form-control input-sm" name="diagnosticoini" id="" cols="30" rows="3"><?php echo $diagnosticoini; ?></textarea>
	                                    	</div>
	                                    </div>
                                    </div>
                                    <div id="divider"></div>
                                    <?php 

                                    	switch ($id_tipoconstancia) {
                                    		case '1':
                                    			# alta
                                    		$sqlalt = 'SELECT id_datosca,id_datosc,fecha_de_alta,diagnostico FROM datos_const_alta WHERE id_datosca=? AND id_datosc=?';
                                    		if($stmtalt = $conn->prepare($sqlalt)){
                                    			$stmtalt -> bind_param('ii',$alt,$numcon);
										    	$stmtalt -> execute();
										    	$stmtalt -> store_result();
										    	$rowsalt = $stmtalt->num_rows;
										    	$stmtalt -> bind_result($id_alt,$id_datosc,$fecha_de_alta,$diagnosticofinal);
										    	$stmtalt -> fetch();
										    	$stmtalt -> close();
										    }

                                    ?>
                                	<div class="row">
										<div class="col-md-6 ">
									    	<div class="form-group">
									        	<label>Permaneciendo ingresado hasta</label>
									        	<input class="form-control input-sm fecha" type="text" placeholder="" name="permaneciofecha" required="" value='<?php echo $fecha_de_alta ?>' data-date-end-date="0d">
									        	<input type="hidden" readonly="" value="<?php echo $id_alt; ?>" name='alt'>
									    	</div>
									    </div>
									</div>
									<div class="row">
										<div class="col-md-6 ">
									    	<div class="form-group">
									        	<label>Con diagnostico</label>
									        	<textarea class="form-control input-sm" name="diagnosticofinal" id="" cols="30" rows="3"><?php echo $diagnosticofinal; ?></textarea>
									    	</div>
									    </div>
									</div>	
                                    <?php
                                    			break;
                                    		case '2':
                                    			# ingreso
                                    		$sqlalt = 'SELECT id_datosci,id_datosc,diagnostico FROM datos_const_ingreso WHERE id_datosci=? AND id_datosc=?';
                                    		if($stmtalt = $conn->prepare($sqlalt)){
                                    			$stmtalt -> bind_param('ii',$alt,$numcon);
										    	$stmtalt -> execute();
										    	$stmtalt -> store_result();
										    	$rowsalt = $stmtalt->num_rows;
										    	$stmtalt -> bind_result($id_alt,$id_datosc,$diagnosticofinal);
										    	$stmtalt -> fetch();
										    	$stmtalt -> close();
										    }
                                    ?>
                                    <div class="row">
										<div class="col-md-6 ">
									    	<div class="form-group">
									        	<label>Permanecio ingresado a la fecha con diagnostico</label>
									        	<textarea class="form-control input-sm" name="diagnosticoingreso" id="" cols="30" rows="3"><?php echo $diagnosticofinal; ?></textarea>
									        	<input type="text" readonly="" hidden="" value="<?php echo $id_alt; ?>" name='alt'>
									    	</div>
									    </div>
									</div>
                                    <?php
                                    			break;
                                    		case '3':
                                    			# fallecido
                                    		$sqlalt = 'SELECT id_datoscf,id_datosc,fecha_defuncion,diagnostico FROM datos_const_fallecimiento WHERE id_datoscf=? AND id_datosc=?';
                                    		if($stmtalt = $conn->prepare($sqlalt)){
                                    			$stmtalt -> bind_param('ii',$alt,$numcon);
										    	$stmtalt -> execute();
										    	$stmtalt -> store_result();
										    	$rowsalt = $stmtalt->num_rows;
										    	$stmtalt -> bind_result($id_alt,$id_datosc,$fecha_defuncion,$diagnosticofinal);
										    	$stmtalt -> fetch();
										    	$stmtalt -> close();
										    }
                                    ?>
                                    <div class="row">
										<div class="col-md-6 ">
									    	<div class="form-group">
									        	<label>Permaneciendo ingresado hasta dia/mes/año</label>
									        	<input class="form-control input-sm fecha" type="text" placeholder="" name="permaneciofecha" required="" value="<?php echo $fecha_defuncion; ?>" data-date-end-date="0d">
									        	<input type="text" readonly="" hidden="" value="<?php echo $id_alt; ?>" name='alt'>
									    	</div>
									    </div>
									</div>
									<div class="row">
										<div class="col-md-6 ">
									    	<div class="form-group">
									        	<label>Fallecimiento por</label>
									        	<textarea class="form-control input-sm" name="fallecimientopor" id="" cols="30" rows="3"><?php echo $diagnosticofinal; ?></textarea>
									    	</div>
									    </div>
									</div>
                                    <?php
                                    			break;
                                    		case '4':
                                    			# fallecido casa
                                    		$sqlalt = 'SELECT id_datoscfc,id_datosc,fecha_de_alta,fecha_defun_ext,lugar_de_extension,fecha_fallecimiento FROM datos_const_fallecimiento_casa WHERE id_datoscfc=? AND id_datosc=?';
                                    		if($stmtalt = $conn->prepare($sqlalt)){
                                    			$stmtalt -> bind_param('ii',$alt,$numcon);
										    	$stmtalt -> execute();
										    	$stmtalt -> store_result();
										    	$rowsalt = $stmtalt->num_rows;
										    	$stmtalt -> bind_result($id_alt,$id_datosc,$fecha_de_alta,$fecha_defun_ext,$lugar_de_extension,$fecha_fallecimiento);
										    	$stmtalt -> fetch();
										    	$stmtalt -> close();
										    }
                                    ?>
                                    <div class="row">
										<div class="col-md-6 ">
									    	<div class="form-group">
									        	<label>Permaneciendo hasta fecha de alta dia/mes/año</label>
									        	<input class="form-control input-sm fecha" type="text" placeholder="" name="permaneciofecha" required="" value="<?php echo $fecha_de_alta; ?>" data-date-end-date="0d">
									        	<input type="text" readonly="" hidden="" value="<?php echo $id_alt; ?>" name='alt'>
									    	</div>
									    </div>
									    <div class="col-md-5 col-md-offset-1 ">
									    	<div class="form-group">
									        	<label>Partida de defuncion extendida dia/mes/año</label>
									        	<input class="form-control input-sm fecha" type="text" placeholder="" name="partidafecha" required="" value="<?php echo $fecha_defun_ext; ?>" data-date-end-date="0d">
									    	</div>
									    </div>
									</div>
									<div class="row">
										<div class="col-md-6 ">
									    	<div class="form-group">
									        	<label>Lugar de extension de partida</label>
									        	<input class="form-control input-sm" type="text" placeholder="" name="lugarextension" required="" value="<?php echo $lugar_de_extension; ?>">
									    	</div>
									    </div>
									    <div class="col-md-5 col-md-offset-1 ">
									    	<div class="form-group">
									        	<label>Fallecimiento en domicilio dia/mes/año</label>
									        	<input class="form-control input-sm fecha" type="text" placeholder="" name="domiciliofecha" required="" value="<?php echo $fecha_fallecimiento ?>" data-date-end-date="0d">
									    	</div>
									    </div>
									</div>
                                    <?php
                                    			break;
                                    		default:
                                    			# code...
                                    			break;
                                    	}
                                     ?>
                                    <div id="divider"></div>
                                    <div class="row">
                                    	<div class="col-md-6 ">
	                                    	<div class="form-group">
	                                        	<label>Nombre del solicitante</label>
	                                        	<input class="form-control input-sm" type="text" placeholder="" name="nombresolicitante" value='<?php echo $nombresolicitante; ?>'>
	                                    	</div>
	                                    </div>
	                                    <div class="col-md-3 col-md-offset-1 ">
	                                    	<div class="form-group">
	                                        	<label>Parentesco</label>
	                                        	<input class="form-control input-sm" type="text" placeholder="" name="parentesco" value='<?php echo $parentesco; ?>'>
	                                    	</div>
	                                    </div>
                                    </div>
                                    <div class="row">
                                    	<div class="col-md-6 ">
	                                    	<div class="form-group">
	                                        	<label>Para ser presentada en</label>
	                                        	<input class="form-control input-sm" type="text" placeholder="" name="presentar" value='<?php echo $destino; ?>'>
	                                    	</div>
	                                    </div>
                                    </div>
                                    <div class="row">
                                    	<div class="col-md-6 ">
	                                    	<div class="form-group">
	                                        	<label>Fecha de extensión de constancia</label>
	                                        	<input class="form-control input-sm fecha" type="text" placeholder="" name="fechaextension" value='<?php echo $fecha_extension; ?>' data-date-end-date="0d">
	                                    	</div>
	                                    </div>
                                    </div>
                                    <div id="divider"></div>
                                    <p><strong>Seleccione solo las entidades que necesite</strong></p>
                                    <div class="row">
                                    	<div class="col-md-6 ">
	                                    	<div class="form-group">
	                                    		<label>Medico Tratante</label>
	                                        	<div class="input-group mb-10">
                                                    <span class="input-group-addon">
                                                    	<?php if($medico!=null){?>
                                                        <input class="checkmedico"	type="checkbox" checked name="checkmedico">
                                                        <?php } else { ?>
                                                        <input class="checkmedico"	type="checkbox" name="checkmedico">
                                                        <?php } ?>
                                                    </span>
                                                    <select class="form-control input-sm medico miselect" name="medico">
                                                    	<option value="" disabled selected>Seleccione medico tratante</option>
	                                        			<?php 
					                            			if($rows2 > 0){
					                            				while ($stmt2->fetch()) {
					                            					if($id_medico==$id_medicoc){
					                            		?>
					                            		<option value="<?php echo $id_medico; ?>" selected><?php echo $nombre_medico; ?></option>
					                            		<?php
					                            					}
					                            					else{ ?>
														<option value="<?php echo $id_medico; ?>"><?php echo $nombre_medico; ?></option>
					                            		<?php
					                            					}		
					                            				}
					                            			}
					                            			$stmt2->close();
					                            		 ?>
	                                        		</select>
                                                </div>
	                                    	</div>
	                                    </div>
	                                    <div class="col-md-5 col-md-offset-1">
	                                    	<div class="form-group">
	                                    		<label>Jefe de Servicio</label>
	                                        	<div class="input-group mb-10">
                                                    <span class="input-group-addon">
                                                    	<?php if($jefe!=null){?>
                                                        <input class="checkjefe" type="checkbox" checked name="checkjefe">
                                                        <?php } else { ?>
                                                        <input class="checkjefe" type="checkbox" name="checkjefe">
                                                        <?php } ?>
                                                    </span>
                                                    <select class="form-control input-sm jefe miselect" name="jefe">
	                                        			<option value="" disabled selected>Seleccione un jefe de servicio</option>
	                                        			<?php 
					                            			if($rowsjefeservicio > 0){
					                            				while ($stmtjefeservicio->fetch()) {
					                            					if($id_jefeservicio==$id_jefec){
					                            		?>
					                            		<option value="<?php echo $id_jefeservicio; ?>" selected><?php echo $nombre_jefeservicio; ?></option>
					                            		<?php
					                            					}
					                            					else{ ?>
														<option value="<?php echo $id_jefeservicio; ?>"><?php echo $nombre_jefeservicio; ?></option>
					                            		<?php
					                            					}		
					                            				}
					                            			}
					                            			$stmtjefeservicio->close();
					                            		 ?>
	                                        		</select>
                                                </div>
	                                    	</div>
	                                    </div>
                                    </div>
                                    <div class="row">
                                    	<div class="col-md-6 ">
	                                    	<div class="form-group">
	                                    		<label>Jefe de Trabajo Social</label>
	                                        	<div class="input-group mb-10">
                                                    <span class="input-group-addon">
                                                        <?php if($jefesocial!=null){?>
                                                        <input class="checkjefesocial" type="checkbox" checked name="checkjefesocial">
														<?php } else { ?>
														<input class="checkjefesocial" type="checkbox" name="checkjefesocial">
														<?php } ?>
                                                    </span>
                                                    <select class="form-control input-sm jefesocial miselect" name="jefesocial">
	                                        			<option value="" disabled selected>Seleccione un jefe de trabajo social</option>
	                                        			<?php 
					                            			if($rowsjefesocial > 0){
					                            				while ($stmtjefesocial->fetch()) {
					                            					if($id_jefesocial==$id_jefesocialc){
					                            		?>
					                            		<option value="<?php echo $id_jefesocial; ?>" selected><?php echo $nombre_jefesocial; ?></option>
					                            		<?php
					                            					}
					                            					else{ ?>
														<option value="<?php echo $id_jefesocial; ?>"><?php echo $nombre_jefesocial; ?></option>
														<?php
					                            					}		
					                            				}
					                            			}
					                            			$stmtjefesocial->close();
					                            		 ?>
	                                        		</select>
                                                </div>
	                                    	</div>
	                                    </div>
	                                    <div class="col-md-5 col-md-offset-1">
	                                    	<div class="form-group">
	                                    		<label>Director Hospital General</label>
	                                        	<div class="input-group mb-10">
                                                    <span class="input-group-addon">
                                                    	<?php if($director!=null){?>
                                                    	<input class="checkdirector" type="checkbox" checked name="checkdirector">
														<?php } else { ?>
														<input class="checkdirector" type="checkbox" name="checkdirector">
														<?php } ?>
                                                    </span>
                                                    <select class="form-control input-sm director miselect" name="director">
	                                        			<option value="" disabled selected>Seleccione un director</option>
	                                        			<?php 
					                            			if($rowsdirector > 0){
					                            				while ($stmtdirector->fetch()) {
					                            					if($id_director==$id_directorc){
					                            		?>
					                            		<option value="<?php echo $id_director; ?>" selected><?php echo $nombre_director; ?></option>
					                            		<?php
					                            					}
					                            					else{ ?>
														<option value="<?php echo $id_director; ?>"><?php echo $nombre_director; ?></option>
					                            		<?php	}	
					                            				}
					                            			}
					                            			$stmtdirector->close();
					                            		 ?>
	                                        		</select>
                                                </div>
	                                    	</div>
	                                    </div>
                                    </div>
                                    <div class="row">
                                    	<div class="col-md-12">
	                                    	<button type="submit" class="btn btn-primary">Editar</button>
                                    	</div>
                                    </div>	
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
	$conn->close();
    include("../core/footer.php");

 ?>
 <script>
    $(document).ready(function(){
        
        $(".checkmedico").change(function(){  
        	if( $('.checkmedico').prop('checked') ) {
				$(".medico").prop('required',true);
			}
			else{
				$(".medico").prop('required',false);
			}
        });
        $(".checkjefe").change(function(){  
        	if( $('.checkjefe').prop('checked') ) {
				$(".jefe").prop('required',true);
			}
			else{
				$(".jefe").prop('required',false);
			}
        });
        $(".checkjefesocial").change(function(){  
        	if( $('.checkjefesocial').prop('checked') ) {
				$(".jefesocial").prop('required',true);
			}
			else{
				$(".jefesocial").prop('required',false);
			}
        });
        $(".checkdirector").change(function(){  
        	if( $('.checkdirector').prop('checked') ) {
				$(".director").prop('required',true);
			}
			else{
				$(".director").prop('required',false);
			}
        });
    });
    $('.miselect').select2({
	  		
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