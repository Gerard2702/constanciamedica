<?php
  	
  	$contancianum = $_POST['id_solicitud'];

    include("../../config/database.php");
    $sqlservicio = "SELECT id_servicio,nombre_servicio FROM servicios ORDER BY nombre_servicio ASC";
    if($stmt = $conn->prepare($sqlservicio)){
    	$stmt -> execute();
    	$stmt -> store_result();
    	$rows = $stmt->num_rows;
    	$stmt -> bind_result($id_servicio,$nombre_servicio);
    }

     $sqlconstancia = "SELECT dai.id_datos,dai.fecha,dai.numero_recibo,dai.afiliacion_dui,dai.nombre_paciente,dai.destinos,dai.cantidad,ser.nombre_servicio,dai.fecha_presentado,dai.fecha_cancelado FROM datos_iniciales dai INNER JOIN servicios ser ON dai.id_servicio=ser.id_servicio WHERE dai.id_datos=?";
   		if($stmtcons = $conn->prepare($sqlconstancia)){
   			$stmtcons -> bind_param('s',$contancianum);
   			$stmtcons -> execute();
   			$stmtcons -> bind_result($id_datos,$fechacreacion,$nrecibo,$afiliacion,$nombrepaciente,$destinos,$cantidad,$servicio,$fechapresento,$fechacancelo);
   			$stmtcons -> fetch();
   			$stmtcons -> close();
   		}
    $conn->close();
?>

<div id="contenido">
	<form role="form" method="POST" action="">
		<div class="row">
			<div class="col-md-5">
    			<div class="form-group">
                	<label>Fecha</label>
                	<input class="form-control input-sm" type="date" placeholder="fecha" name="fecha" required="" value="<?php echo $fechacreacion; ?>" disabled>
            	</div>
			</div>
            <div class="col-md-5 col-md-offset-1">
            	<div class="form-group">
                	<label>N# Recibo</label>
                	<input class="form-control input-sm" type="number" placeholder="Numero de Recibo" name="recibo" required="" value="<?php echo $nrecibo; ?>" disabled>
                	<input type="text" name="id_solicitud" readonly="" hidden="" value="<?php echo $id_datos; ?>" disabled>
            	</div>
            </div>
		</div>
		<div class="row">
			<div class="col-md-5">
            	<div class="form-group">
                	<label>N# Afiliacion/DUI</label>
                	<input class="form-control input-sm" type="number" placeholder="Numero de Afiliacion/DUI" name="afiliacion" required="" value="<?php echo $afiliacion; ?>" disabled>
            	</div>
            </div>
            <div class="col-md-5 col-md-offset-1">
            	<div class="form-group">
                	<label>Nombre del paciente</label>
                	<input class="form-control input-sm" type="text" placeholder="Nombre del paciente" name="nombrepaciente" required="" value="<?php echo $nombrepaciente; ?>" disabled>
            	</div>
            </div>
		</div>
		<div class="row">
			<div class="col-md-5">
            	<div class="form-group">
                	<label>Constancia a presentar en</label>
                	<input class="form-control input-sm" type="text" placeholder="Constancia a presentar en" name="lugarpresentar" required="" value="<?php echo $destinos; ?>" disabled>
            	</div>
        	</div>
		</div>
		<div class="row">
			<div class="col-md-5">
            	<div class="form-group">
                	<label>Servicio</label>
                	<select class="form-control input-sm" name="servicio" disabled>
                		<?php 
                			if($rows > 0){
                				while ($stmt->fetch()) {
                					if($servicio==$nombre_servicio){
                		?>
                		<option value="<?php echo $id_servicio; ?>" selected><?php echo $nombre_servicio; ?></option>
                		<?php		}
                					else{
                		?>
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
            <div class="col-md-5 col-md-offset-1">
            	<div class="form-group">
                	<label>Cantidad</label>
                	<input class="form-control input-sm" type="number" placeholder="Cantidad de constancias" name="cantidad" required="" value="<?php echo $cantidad; ?>" disabled>
            	</div>
            </div>
		</div>
        <div class="row">
        	<div class="col-md-5 ">
            	<div class="form-group">
                	<label>Fecha que se presento</label>
                	<input class="form-control input-sm" type="date" placeholder="" name="fechapresento" required="" value="<?php echo $fechapresento; ?>" disabled>
            	</div>
            </div>
            <div class="col-md-5 col-md-offset-1">
            	<div class="form-group">
                	<label>Fecha cancelado solicitud</label>
                	<input class="form-control input-sm" type="date" placeholder="" name="fechacancelado" required="" value="<?php echo $fechacancelo ?>" disabled>
            	</div>
            </div>
        </div>
    </form>
</div>
