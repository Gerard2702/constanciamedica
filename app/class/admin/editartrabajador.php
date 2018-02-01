<?php 
	include("../../../config/database.php");
	if (!empty($_POST['nombre'])) {
		$name = $_POST['nombre'];
	}
	if (!empty($_POST['usuario'])) {
		$usuario = $_POST['usuario'];
	}
	if (!empty($_POST['pass'])) {
		$pass = $_POST['pass'];
	}
	$tipouser = $_POST['tipouser'];
	$servicio = $_POST['servicio'];	
	$estado = $_POST['estado'];
	$id=$_POST['id'];

	$sql1="SELECT id_tipousuario FROM tipo_usuario WHERE nombre_tipo=?";
	if($stmt = $conn->prepare($sql1)){
		$stmt->bind_param("s", $tipouser);
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
	if(empty($pass) || $pass==""){
		$sql = "UPDATE usuario SET name=?, user=?, id_status=?, id_tipousuario=?, id_servicio=? WHERE id_user=?";
		if($stmtu = $conn->prepare($sql)){
			$stmtu->bind_param("ssiiii", $name,$usuario,$id_status,$id_tipousuario,$id_servicio,$id);
			$stmtu->execute();						
			$stmtu->close();
		}
	}/*else{
		$mpass = md5($pass);
		$sql = "UPDATE usuario SET name=?, user=?, id_status=?, password=?, id_tipousuario=?, id_servicio=? WHERE id_user=?";
		if($stmtu = $conn->prepare($sql)){
			$stmtu->bind_param("ssisiii", $name,$usuario,$id_status,$mpass,$id_tipousuario,$id_servicio,$id);
			$stmtu->execute();						
			$stmtu->close();
	}*/

	header("Location:../../admin/admintrabajador.php");
 ?>
