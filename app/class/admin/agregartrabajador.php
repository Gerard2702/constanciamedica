<?php 
	include("../../../config/database.php");

	if (!empty($_POST['nombre']) && $_POST['nombre'] != "") {
		$name = $_POST['nombre'];
	}
	if (!empty($_POST['usuario']) && $_POST['usuario'] != "") {
		$usuario = $_POST['usuario'];
	}
	if (!empty($_POST['pass']) && $_POST['pass'] != "") {
		$pass = md5($_POST['pass']);
	}
	$servicio = $_POST['servicio'];	
	$tipousuario = $_POST['tipouser'];
	$estado="Activo";

	$sql1="SELECT id_tipousuario FROM tipo_usuario WHERE nombre_tipo=?";
	if($stmt = $conn->prepare($sql1)){
		$stmt->bind_param("s", $tipousuario);
		$stmt->execute();
		$stmt->bind_result($id_tipousuario);
		$stmt->fetch();
		$stmt->close();
	};
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

	$sql = "INSERT INTO usuario (name, user, id_status, password, id_tipousuario, id_servicio) VALUES (?, ?, ?, ?, ?, ?);";
		if($stmti = $conn->prepare($sql)){
			$stmti->bind_param("ssisii", $name,$usuario,$id_status,$pass,$id_tipousuario,$id_servicio);
			$stmti->execute();						
			$stmti->close();
		}

	$conn->close();
	header("Location:../../admin/admintrabajador.php");
 ?>