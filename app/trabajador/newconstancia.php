<?php
    $title = "NUEVA CONSTANCIA";
   
    include("../core/header.php");

    include("../core/aside.php");
    include("../../config/database.php");

    if(!isset($_SESSION['constancia_trabajando'])){
    	echo "ERROR";
    }

    $constancianum=$_SESSION['constancia_trabajando'];

    $sqlconstancia = "SELECT dai.id_datos,dai.fecha,dai.numero_recibo,dai.afiliacion_dui,dai.nombre_paciente,dai.destinos,dai.cantidad,ser.nombre_servicio,dai.fecha_presentado,dai.fecha_cancelado FROM datos_iniciales dai INNER JOIN servicios ser ON dai.id_servicio=ser.id_servicio WHERE dai.id_datos=?";
	if($stmtcons = $conn->prepare($sqlconstancia)){
		$stmtcons -> bind_param('s',$constancianum);
		$stmtcons -> execute();
		$stmtcons -> bind_result($id_datos,$fechacreacion,$nrecibo,$afiliacion,$nombrepaciente,$destinos,$cantidad,$servicio,$fechapresento,$fechacancelo);
		$stmtcons -> fetch();
		$stmtcons -> close();
	}

    $sqlcontancia = "SELECT id_constancia,tipo_constancia FROM constancias";
    if($stmt1 = $conn->prepare($sqlcontancia)){
    	$stmt1 -> execute();
    	$stmt1 -> store_result();
    	$rows1 = $stmt1->num_rows;
    	$stmt1 -> bind_result($id_constancia,$nombre_constancia);
    }

    $sqlservicio = "SELECT id_servicio,nombre_servicio FROM servicios ORDER BY nombre_servicio ASC";
    if($stmt = $conn->prepare($sqlservicio)){
    	$stmt -> execute();
    	$stmt -> store_result();
    	$rows = $stmt->num_rows;
    	$stmt -> bind_result($id_servicio,$nombre_servicio);
    }

    $sqlmedico = "SELECT id_medico,nombre FROM medico_tratante WHERE id_status=1 ORDER BY nombre ASC";
    if($stmt2 = $conn->prepare($sqlmedico)){
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


    $conn->close();
?>
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="ui-content-body">
        <div class="ui-container">
        	<div class="row">
				<div class="col-md-2">
         			<a href="javascript:history.back(1)" class="btn btn-info" id="btn-regresar"><i class="fa fa-arrow-left"></i> Regresar</a>
         		</div>
			     <div class="col-md-8 col-md-offset-2">
			        <form class="form-horizontal" action="" method="POST">
			            <div class="form-group">
			                <label class="col-md-4 col-md-offset-4 control-label"><strong>Tipo de Constancia:</strong></label>
			                <div class="col-md-4">
			                    <select class="form-control input-sm cambiarconstancia" name="servicio">
                            		<?php 
                            			if($rows1 > 0){
                            				while ($stmt1->fetch()) {
                            		?>
                            		<option value="<?php echo $id_constancia; ?>"><?php echo $nombre_constancia; ?></option>
                            		<?php		
                            				}
                            			}
                            			$stmt1->close();
                            		 ?>
                            	</select>
			                </div>
			            </div>
			        </form>
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
                            	<form method="POST" action="../class/trabajador/agregar.php">
                            		<div class="row">
	                                    <div class="col-md-6">
	                                    	<div class="form-group">
	                                        	<label>Nombre del paciente</label>
	                                        	<input class="form-control input-sm" type="text" placeholder="Nombre del paciente" name="nombrepaciente" required="" value="<?php echo $nombrepaciente ?>" readonly="readonly">
	                                        	<input type="text" hidden="" name="constancianum" value="<?php echo $id_datos ?>" readonly="readonly">
	                                        	<input type="text" hidden="" name="tipoconstanciainput" id="tipoconstanciainput" value="" readonly="readonly">
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
	                                        	<label>Consulto el Año/Mes/Dia</label>
	                                        	<input class="form-control input-sm fecha" type="text" placeholder="Consulto el ..." name="consultafecha" required="" data-date-end-date="0d">
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
	                                        	<textarea class="form-control input-sm" name="diagnosticoini" id="" cols="30" rows="3"></textarea>
	                                    	</div>
	                                    </div>
                                    </div>
                                    <div id="divider"></div>
                                    <div id="formtipo">
                                    	<div class="row">
											<div class="col-md-6 ">
										    	<div class="form-group">
										        	<label>Permaneciendo ingresado hasta el Año/Mes/Dia</label>
										        	<input class="form-control input-sm fecha" type="text" placeholder="Permanecio ingresado hasta el ..." name="permaneciofecha" required="" data-date-end-date="0d">
										    	</div>
										    </div>
										</div>
										<div class="row">
											<div class="col-md-6 ">
										    	<div class="form-group">
										        	<label>Con diagnostico</label>
										        	<textarea class="form-control input-sm" name="diagnosticofinal" id="" cols="30" rows="3"></textarea>
										    	</div>
										    </div>
										</div>	
                                    </div>
                                    <div id="divider"></div>
                                    <div class="row">
                                    	<div class="col-md-6 ">
	                                    	<div class="form-group">
	                                        	<label>Nombre del solicitante</label>
	                                        	<input class="form-control input-sm" type="text" placeholder="" name="nombresolicitante" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,100}" title="Solo debe contener letras mayusculas o minusculas y al menos 3 caracteres" autocomplete="off">
	                                    	</div>
	                                    </div>
	                                    <div class="col-md-3 col-md-offset-1 ">
	                                    	<div class="form-group">
	                                        	<label>Parentesco</label>
	                                        	<input class="form-control input-sm" type="text" placeholder="" name="parentesco" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,100}" title="Solo debe contener letras mayusculas o minusculas y al menos 3 caracteres" autocomplete="off">
	                                    	</div>
	                                    </div>
                                    </div>
                                    <div class="row">
                                    	<div class="col-md-6 ">
	                                    	<div class="form-group">
	                                        	<label>Para ser presentada en</label>
	                                        	<input class="form-control input-sm" type="text" placeholder="" name="presentar" autocomplete="off">
	                                    	</div>
	                                    </div>
                                    </div>
                                    <div class="row">
                                    	<div class="col-md-6 ">
	                                    	<div class="form-group">
	                                        	<label>Fecha de extensión de constancia</label>
	                                        	<input class="form-control input-sm fecha" type="text" placeholder="Fecha de extension de constancia" name="fechaextension" data-date-end-date="0d">
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
                                                        <input class="checkmedico"	type="checkbox" checked name="checkmedico">
                                                    </span>
                                                    <select class="form-control input-sm medico" name="medico" required="">
                                                    	<option value="" disabled selected>Seleccione medico tratante</option>
	                                        			<?php 
					                            			if($rows2 > 0){
					                            				while ($stmt2->fetch()) {
					                            		?>
					                            		<option value="<?php echo $id_medico; ?>"><?php echo $nombre_medico; ?></option>
					                            		<?php		
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
                                                        <input class="checkjefe" type="checkbox" checked name="checkjefe">
                                                    </span>
                                                    <select class="form-control input-sm jefe" name="jefe" required="">
	                                        			<option value="" disabled selected>Seleccione un jefe de servicio</option>
	                                        			<?php 
					                            			if($rowsjefeservicio > 0){
					                            				while ($stmtjefeservicio->fetch()) {
					                            		?>
					                            		<option value="<?php echo $id_jefeservicio; ?>"><?php echo $nombre_jefeservicio; ?></option>
					                            		<?php		
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
                                                        <input class="checkjefesocial" type="checkbox" checked name="checkjefesocial">
                                                    </span>
                                                    <select class="form-control input-sm jefesocial" name="jefesocial" required="">
	                                        			<option value="" disabled selected>Seleccione un jefe de trabajo social</option>
	                                        			<?php 
					                            			if($rowsjefesocial > 0){
					                            				while ($stmtjefesocial->fetch()) {
					                            		?>
					                            		<option value="<?php echo $id_jefesocial; ?>"><?php echo $nombre_jefesocial; ?></option>
					                            		<?php		
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
                                                        <input class="checkdirector" type="checkbox" checked name="checkdirector">
                                                    </span>
                                                    <select class="form-control input-sm director" name="director" required="">
	                                        			<option value="" disabled selected>Seleccione un director</option>
	                                        			<?php 
					                            			if($rowsdirector > 0){
					                            				while ($stmtdirector->fetch()) {
					                            		?>
					                            		<option value="<?php echo $id_director; ?>"><?php echo $nombre_director; ?></option>
					                            		<?php		
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
	                                    	<button type="submit" class="btn btn-primary">Agregar</button>
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
    include("../core/footer.php");

 ?>
 <script>
    $(document).ready(function(){
        
        $(".cambiarconstancia").change(function(){
            var id_tipoconstancia = $( ".cambiarconstancia option:selected" ).val();
            var nombre = $( ".cambiarconstancia option:selected" ).text();
            $.ajax({
            url: "tipoconstancia.php",
            type: 'POST',
            data: { 
                id_tipoconstancia: id_tipoconstancia
            },
            success: function (data) {
                $("#formtipo").html(data);
                $("#constanciatitulo").html("Crear constancia de "+nombre);
                $("#tipoconstanciainput").val(id_tipoconstancia);
            },
            error: function () {
                alert("UN ERROR HA OCURRIDO");
            }
        });
        });

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
    
	var id_tipoconstancia = $( ".cambiarconstancia option:selected" ).val();
    var nombre = $( ".cambiarconstancia option:selected" ).text();
    $("#constanciatitulo").html("Crear constancia de "+nombre);
    $("#tipoconstanciainput").val(id_tipoconstancia);

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