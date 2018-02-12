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
    <div class="page-head-wrap">
        <h4 class="margin0">CREAR SOLICITUD</h4>  
    </div>
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
                            	<form role="form" method="POST" action="../class/secretaria/newsolicitud.php">
                            		<div class="row">
                            			<div class="col-md-4">
	                            			<div class="form-group">
	                                        	<label>Fecha</label>
	                                        	<input class="form-control" type="date" placeholder="fecha" name="fecha" required="">
	                                    	</div>
                            			</div>
	                                    <div class="col-md-4 col-md-offset-1">
	                                    	<div class="form-group">
	                                        	<label>N# Recibo</label>
	                                        	<input class="form-control" type="number" placeholder="Numero de Recibo" name="recibo" required="">
	                                    	</div>
	                                    </div>
                            		</div>
                            		<div class="row">
                            			<div class="col-md-4">
	                                    	<div class="form-group">
	                                        	<label>N# Afiliacion/DUI</label>
	                                        	<input class="form-control" type="number" placeholder="Numero de Afiliacion/DUI" name="afiliacion" required="">
	                                    	</div>
	                                    </div>
	                                    <div class="col-md-4 col-md-offset-1">
	                                    	<div class="form-group">
	                                        	<label>Nombre del paciente</label>
	                                        	<input class="form-control" type="text" placeholder="Nombre del paciente" name="nombrepaciente" required="">
	                                    	</div>
	                                    </div>
                            		</div>
                            		<div class="row">
                            			<div class="col-md-4">
	                                    	<div class="form-group">
	                                        	<label>Constancia a presentar en</label>
	                                        	<input class="form-control" type="text" placeholder="Constancia a presentar en" name="lugarpresentar" required="">
	                                    	</div>
                                    	</div>
                            		</div>
                            		<div class="row">
                            			<div class="col-md-4">
	                                    	<div class="form-group">
	                                        	<label>Servicio</label>
	                                        	<select class="form-control" name="servicio">
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
	                                        	<input class="form-control" type="number" placeholder="Cantidad de constancias" name="cantidad" required="">
	                                    	</div>
	                                    </div>
                            		</div>
                                    <div class="row">
                                    	<div class="col-md-4 ">
	                                    	<div class="form-group">
	                                        	<label>Fecha que se presento</label>
	                                        	<input class="form-control" type="date" placeholder="" name="fechapresento" required="">
	                                    	</div>
	                                    </div>
	                                    <div class="col-md-4 col-md-offset-1">
	                                    	<div class="form-group">
	                                        	<label>Fecha cancelado solicitud</label>
	                                        	<input class="form-control" type="date" placeholder="" name="fechacancelado" required="">
	                                    	</div>
	                                    </div>
                                    </div>
                                    <div class="row">
                                    	<div class="col-md-12">
	                                    	<button type="submit" name="guardar" class="btn btn-primary">Guardar</button>
	                                    	<button type="submit" name="guardarenviar" class="btn btn-primary">Guardar y enviar</button>
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
 	$('#crearsolicitud').addClass('active');
 </script>