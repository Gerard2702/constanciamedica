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
	$conn->close();
 ?>
 <form class="form-horizontal form-variance" method="POST" action="../class/admin/editartrabajador.php">
    <div class="form-group">
        <label class="col-sm-3 control-label">Nombre</label>
        <div class="col-sm-6">
            <input class="form-control" type="text" value="<?php echo $nombre ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Usuario</label>
        <div class="col-sm-6">
            <input class="form-control" type="text" value="<?php echo $usuario ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Contraseña</label>
        <div class="col-sm-6">
            <input class="form-control" type="password">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Tipo Usuario</label>
        <div class="col-sm-6">
            <select class="form-control" name="tipouser" id="tipouser">
            	<option value="<?php echo $idtipouser ?>"><?php echo $tipouser; ?></option>
                <option value="secretaria">Secretaria</option>
                <option value="trabajador">Trabajador Social</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Servicio Asignado</label>
        <div class="col-sm-6">
            <select class="form-control" name="servicio" id="servicio">
            	<option value="<?php echo $idservicio ?>"><?php echo $servicio; ?></option>
                <option value="na">Na</option>
            </select>
            <span class="help-block">Servicio o Especialidad a la que pertenece</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Estado</label>
        <div class="col-sm-6">
            <select class="form-control" name="servicio" id="servicio">
            	<option value="<?php echo $idestatus ?>"><?php echo $status; ?></option>
                <option value="Activo">Activo</option>
                <option value="Activo">Inactivo</option>
            </select>
        </div>
    </div>
    <div class="form-group">
    	<div class="col-sm-6 col-sm-offset-3">
    		<button type="submit" class="btn btn-primary">Editar</button>
    	</div>
    </div>
</form>