<?php
    $title = "CREAR SOLICITUD";
   	
    include("../core/header.php");
    include("../core/aside.php");
    
    include("../../config/database.php");
    $sqlservicio = "SELECT id_servicio,nombre_servicio FROM servicios ORDER BY nombre_servicio ASC";
    if($stmt = $conn->prepare($sqlservicio)){
    	$stmt -> execute();
    	$stmt -> store_result();
    	$rows = $stmt->num_rows;
    	$stmt -> bind_result($id_servicio,$nombre_servicio);
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
                            	<h4>Datos Soicitud</h4>
                            </div>
                            <div id="contenido">
                            	<form class="miform" method="POST" action="../class/secretaria/newsolicitud.php" autocomplete="off">
                            		<div class="row">
                            			<div class="col-md-4">
	                            			<div class="form-group">
	                                        	<label>Fecha</label>
	                                        	<input class="form-control fecha" type="text" placeholder="fecha" name="fecha" id="fecha" required="" data-date-end-date="0d" autocomplete="off">  
	                                    	</div>
                            			</div>
	                                    <div class="col-md-4 col-md-offset-1">
	                                    	<div class="form-group">
	                                        	<label>N# Recibo</label>
	                                        	<input class="form-control" type="text" placeholder="Numero de Recibo" name="recibo" id="recibo" required="" pattern="[0-9]{1,5}" title="Solo digitos, maximo 5">
	                                    	</div>
	                                    </div>
                            		</div>
                            		<div class="row">
                            			<div class="col-md-4">
	                                    	<div class="form-group">
	                                        	<label>N# Afiliacion/DUI</label>
	                                        	<input class="form-control" type="text" placeholder="Numero de Afiliacion/DUI" name="afiliacion" id="afiliacion" required="" pattern="[0-9]{9}" title="Debe contener 9 digitos sin guiones o espacios">
	                                    	</div>
	                                    </div>
	                                    <div class="col-md-4 col-md-offset-1">
	                                    	<div class="form-group">
	                                        	<label>Nombre del paciente</label>
	                                        	<input class="form-control" type="text" placeholder="Nombre del paciente" name="nombrepaciente" id="nombrepaciente" required="" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,100}" title="Solo debe contener letras mayusculas o minusculas y al menos 3 caracteres">
	                                    	</div>
	                                    </div>
                            		</div>
                            		<div class="row">
                            			<div class="col-md-4">
	                                    	<div class="form-group">
	                                        	<label>Constancia a presentar en</label>
	                                        	<input class="form-control" type="text" placeholder="Constancia a presentar en" name="lugarpresentar" id="lugarpresentar" required="" >
	                                    	</div>
                                    	</div>
                            		</div>
                            		<div class="row">
                            			<div class="col-md-4">
	                                    	<div class="form-group">
	                                        	<label>Servicio</label>
	                                        	<select class="form-control miselect" name="servicio" id="servicio" required="">
	                                        		<option value="" ></option>
	                                        		<?php 
	                                        			if($rows > 0){
	                                        				while ($stmt->fetch()) {
	                                        		?>
	                                        		<option value="<?php echo $id_servicio; ?>"><?php echo $nombre_servicio; ?></option>
	                                        		<?php		
	                                        				}
	                                        			}
	                                        			$stmt->close();
	                                        		 ?>
	                                        	</select>
	                                    	</div>
	                                    </div>
	                                    <div class="col-md-4 col-md-offset-1">
	                                    	<div class="form-group">
	                                        	<label>Cantidad</label>
	                                        	<input class="form-control" type="number" placeholder="Cantidad de constancias" name="cantidad" id="cantidad" required="" >
	                                    	</div>
	                                    </div>
                            		</div>
                                    <div class="row">
                                    	<div class="col-md-4 ">
	                                    	<div class="form-group">
	                                        	<label>Fecha que se presento</label>
	                                        	<input class="form-control fecha" type="text" placeholder="Fecha que se presento" name="fechapresento" id="fechapresento" required="" data-date-end-date="0d">
	                                    	</div>
	                                    </div>
	                                    <div class="col-md-4 col-md-offset-1">
	                                    	<div class="form-group">
	                                        	<label>Fecha cancelado solicitud</label>
	                                        	<input class="form-control fecha" type="text" placeholder="Fecha cancelado solicitud" name="fechacancelado" id="fechacancelado" required="" data-date-end-date="0d">
	                                    	</div>
	                                    </div>
                                    </div>
                                    <div class="row">
                                    	<div class="col-md-12">
	                                    	<button type="submit" name="guardar" id="guardar" class="btn btn-primary">Guardar</button>
	                                    	<button type="submit" name="guardarenviar" id="guardarenviar" class="btn btn-primary">Guardar y enviar</button>
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
 <?php 
 	if ($_GET['estado']) {
 		if($_GET['estado']==1){
 ?>
	 <script>
	 	swal({
		    title: "Solicitud guardada con exito!",
		    icon: "success",
		})
		.then((value) => {
		    location.href ="crearsolicitud.php";
		}); 
	 </script>
 <?php
 		}
 		if($_GET['estado']==2){
 ?>
	<script>
	 	swal({
		    title: "Solicitud enviada exito!",
		    icon: "success",
		})
		.then((value) => {
		    location.href ="crearsolicitud.php";
		}); 
	 </script>
 <?php
 		}
 	}
  ?>
 <script>
 	$('#crearsolicitud').addClass('active');
	$('.fecha').datepicker({
		    todayBtn: "linked",
		    format: 'yyyy-mm-dd',
		    clearBtn: true,
		    language: "es",
		    autoclose: true,
		    todayHighlight: true,
		    disableTouchKeyboard: true,
	});

	$('.miselect').select2({
	  placeholder: 'Seleccione un servicio'
	});

	$(document).ready(function(){
		
		/*$('.miform').submit(function(e){
			e.preventDefault();
			var fecha = $('#fecha').val();
			var recibo = $('#recibo').val();
			var afiliacion = $('#afiliacion').val();
			var nombrepaciente = $('#nombrepaciente').val();
			var lugarpresentar = $('#lugarpresentar').val();
			var servicio = $('#servicio').val();
			var cantidad = $('#cantidad').val();
			var fechapresento = $('#fechapresento').val();
			var fechacancelado = $('#fechacancelado').val();
			var guardar = $('#guardar').val()
			alert('done');
			$.ajax({
	            url: "../class/secretaria/newsolicitud.php",
	            type: 'POST',
	            data: { 
	                fecha = fecha,
	                recibo = recibo,
	                afiliacion = afiliacion,
	                nombrepaciente = nombrepaciente,
	                lugarpresentar = lugarpresentar,
	                servicio = servicio,
	                cantidad = cantidad,
	                fechapresento = fechapresento,
	                fechacancelado = fechacancelado
	            },
	            success: function (data) {
	            	if(data=='true'){
	            		swal({
                            title: "Solicitud enviada a trabajador social",
                            icon: "success",
                        }).then((value) => {
                              location.href ="crearsolicitud.php";
                        });	
	            	}
	            	if(data=='true2'){
	            		swal({
                            title: "Solicitud guardada con exito",
                            icon: "success",
                        }).then((value) => {
                              location.href ="crearsolicitud.php";
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
		})*/

	});

 </script>