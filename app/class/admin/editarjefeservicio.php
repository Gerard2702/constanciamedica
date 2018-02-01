<?php 
	include("../../../config/database.php");
	if (!empty($_POST['nombre'])) {
		$name = $_POST['nombre'];
	}
	$servicio = $_POST['servicio'];	
	$estado = $_POST['estado'];
	$id=$_POST['id'];


	$sql2="SELECT id_status FROM status WHERE nombre_status=?";
	if($stmt2 = $conn->prepare($sql2)){
		$stmt2->bind_param("s", $estado);
		$stmt2->execute();
		$stmt2->bind_result($id_status);
		$stmt2->fetch();
		$stmt2->close();
	};
	$sql3="SELECT id_servicio FROM servicios WHERE nombre_servicio=?";
	if($stmt3 = $conn->prepare($sql3)){
		$stmt3->bind_param("s", $servicio);
		$stmt3->execute();
		$stmt3->bind_result($id_servicio);
		$stmt3->fetch();
		$stmt3->close();
	};

		$sql = "UPDATE jefe_servicio SET nombre=?, id_status=?, id_servicio=? WHERE id_jefe=?";
		if($stmtu = $conn->prepare($sql)){
			$stmtu->bind_param("siii", $name,$id_status,$id_servicio,$id);
			$stmtu->execute();						
			$stmtu->close();
		}


	header("Location:../../admin/adminjefeservicio.php");
 ?>
