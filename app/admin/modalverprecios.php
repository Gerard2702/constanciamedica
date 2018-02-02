<?php 
	include("../../config/database.php");
	$id = $_POST['idprecio'];
	$sql1="SELECT precio FROM precio_constancias WHERE id_precio=?";
	if($stmt = $conn->prepare($sql1)){
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->bind_result($precio);
		$stmt->fetch();
		$stmt->close();
	}

	$conn->close();
 ?>
 <form class="form-horizontal form-variance" method="POST" action="../class/admin/editarprecio.php">
    <div class="form-group">
        <label class="col-sm-3 control-label">Precio</label>
        <div class="col-sm-7">
            <input class="form-control" id="precio" name="precio" type="text" value="<?php echo $precio ?>" required pattern="[0-9]{1,4}(\.[0-9]{0,2})*">
        </div>
    </div>

    <div class="form-group">
    	<div class="col-sm-6 col-sm-offset-3">
            <input id="id" name="id" type="hidden" value="<?php echo $id ?>">
    		<button type="submit" class="btn btn-primary">Guardar Cambios</button>
    	</div>
    </div>
</form>