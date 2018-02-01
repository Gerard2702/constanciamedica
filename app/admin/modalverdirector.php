<?php 
	include("../../config/database.php");
	$id = $_POST['iddirector'];
	$sql1="SELECT us.nombre,sta.id_status,sta.nombre_status,ser.id_servicio,ser.nombre_servicio FROM director us INNER JOIN status sta ON us.id_status=sta.id_status INNER JOIN servicios ser ON us.id_servicio=ser.id_servicio WHERE us.id_director=?";
	if($stmt = $conn->prepare($sql1)){
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->bind_result($nombre,$idstatus,$status,$idservicio,$servicio);
		$stmt->fetch();
		$stmt->close();
	}

    $sql2 = "SELECT nombre_servicio FROM servicios";
    if($stmt2 = $conn->prepare($sql2)){
        $stmt2 ->execute();
        $stmt2->store_result();
        $rows2 = $stmt2->num_rows;
        $stmt2 ->bind_result($servicesname);
    }

    $sql3 = "SELECT nombre_status FROM status";
    if($stmt3 = $conn->prepare($sql3)){
        $stmt3 ->execute();
        $stmt3->store_result();
        $rows3 = $stmt3->num_rows;
        $stmt3 ->bind_result($statusname);
    }
	$conn->close();
 ?>
 <form class="form-horizontal form-variance" method="POST" action="../class/admin/editardirector.php">
    <div class="form-group">
        <label class="col-sm-3 control-label">Nombre</label>
        <div class="col-sm-7">
            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $nombre ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Servicio Asignado</label>
        <div class="col-sm-7">
            <select class="form-control" name="servicio" id="servicio">
            	<?php 
                    if($rows2>0) {
                        while ($stmt2->fetch()) {
                            if($servicio == $servicesname){ ?>
                                <option value="<?php echo $servicesname ?>" selected><?php echo $servicesname; ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $servicesname ?>"><?php echo $servicesname; ?></option>
                           <?php }
                        }
                    }
                    $stmt2->close();
                ?>
            </select>
            <span class="help-block">Servicio o Especialidad a la que pertenece</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Estado</label>
        <div class="col-sm-7">
            <select class="form-control" name="estado" id="estado">
            	<?php 
                    if($rows3>0) {
                        while ($stmt3->fetch()) {
                            if($status == $statusname){ ?>
                                <option value="<?php echo $statusname ?>" selected><?php echo $statusname; ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $statusname ?>"><?php echo $statusname; ?></option>
                           <?php }
                        }
                    }
                    $stmt3->close();
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
    	<div class="col-sm-6 col-sm-offset-3">
            <input id="id" name="id" type="hidden" value="<?php echo $id ?>">
    		<button type="submit" class="btn btn-primary">Guardar Cambios</button>
    	</div>
    </div>
</form>