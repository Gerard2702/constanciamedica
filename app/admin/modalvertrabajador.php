<?php 
	include("../../config/database.php");
	$id = $_POST['idtrabajador'];
	$sql1="SELECT us.name, us.user,sta.id_status,sta.nombre_status,tip.id_tipousuario,tip.nombre_tipo,ser.id_servicio,ser.nombre_servicio FROM usuario us INNER JOIN status sta ON us.id_status=sta.id_status INNER JOIN tipo_usuario tip ON us.id_tipousuario=tip.id_tipousuario INNER JOIN servicios ser ON us.id_servicio=ser.id_servicio WHERE us.id_user=?";
	if($stmt = $conn->prepare($sql1)){
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->bind_result($nombre,$usuario,$idstatus,$status,$idtipouser,$tipouser,$idservicio,$servicio);
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

    $sql4 = "SELECT nombre_tipo FROM tipo_usuario";
    if($stmt4 = $conn->prepare($sql4)){
        $stmt4 ->execute();
        $stmt4->store_result();
        $rows4 = $stmt4->num_rows;
        $stmt4 ->bind_result($usuariotipo);
    }
	$conn->close();
 ?>
 <form class="form-horizontal form-variance" method="POST" action="../class/admin/editartrabajador.php">
    <div class="form-group">
        <label class="col-sm-3 control-label">Nombre</label>
        <div class="col-sm-7">
            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $nombre ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Usuario</label>
        <div class="col-sm-7">
            <input class="form-control" id="usuario" name="usuario" type="text" value="<?php echo $usuario ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Contraseña</label>
        <div class="col-sm-7">
            <input class="form-control" id="pass" name="pass" type="password">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Tipo Usuario</label>
        <div class="col-sm-7">
            <select class="form-control" name="tipouser" id="tipouser">
                <?php 
                    if($rows4>0) {
                        while ($stmt4->fetch()) {
                            if($tipouser == $usuariotipo){ ?>
                                <option value="<?php echo $usuariotipo ?>" selected><?php echo $usuariotipo; ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $usuariotipo ?>"><?php echo $usuariotipo; ?></option>
                           <?php }
                        }
                    }
                    $stmt4->close();
                ?>
            </select>
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