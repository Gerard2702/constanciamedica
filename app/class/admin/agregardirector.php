<?php 
	include("../../../config/database.php");

	if (!empty($_POST['nombre']) && $_POST['nombre'] != "") {
		$titulo = $_POST['titulo'];
		$nameprov = trim($_POST['nombre']);
		$name = trim($titulo." ".$nameprov);
	}

	$servicio = $_POST['services'];	
	$estado="Activo";

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

	$sql = "INSERT INTO director (nombre, id_status, id_Servicio) VALUES (?, ?, ?);";
		if($stmti = $conn->prepare($sql)){
			$stmti->bind_param("sii", $name,$id_status,$id_servicio);
			$stmti->execute();						
			$stmti->close();
		}

	$conn->close();
	header("Location:../../admin/admindirector.php");
 ?>