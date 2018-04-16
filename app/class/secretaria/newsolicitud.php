<?php 
include("../../../config/database.php");
session_start();
$conn->autocommit(false);

$fecha = $_POST['fecha'];
$recibo = $_POST['recibo'];
$afiliacion = $_POST['afiliacion'];
$nombrepaciente = strtoupper($_POST['nombrepaciente']);
$lugarpresentar = strtoupper($_POST['lugarpresentar']);
$servicio = $_POST['servicio'];
$cantidad = $_POST['cantidad'];
$fechapresento = $_POST['fechapresento'];
$fechacancelo = $_POST['fechacancelado'];
$id_user = $_SESSION['id_usuario'];

try {

	$sqlpre = "SELECT precio FROM precio_constancias LIMIT 1";
	if($stmtprecio = $conn->prepare($sqlpre)){
		$stmtprecio->execute();
		$stmtprecio->bind_result($preciocon);
		$stmtprecio->fetch();
		$stmtprecio->close();
	}

	if(isset($_POST['guardar'])){
		$id_estado = 1;
	}
	elseif(isset($_POST['guardarenviar'])){
		$id_estado = 2;
	}
	else{
		$id_estado = 1;
	}
	

	$sql = "INSERT INTO datos_iniciales (fecha,numero_recibo,afiliacion_dui,nombre_paciente,destinos,id_servicio,cantidad,fecha_presentado,fecha_cancelado,precio,id_estado,id_trabajador) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('sssssiissdii',$fecha,$recibo,$afiliacion,$nombrepaciente,$lugarpresentar,$servicio,$cantidad,$fechapresento,$fechacancelo,$preciocon,$id_estado,$id_user);
	$stmt->execute();
	$conn->commit();
	$stmt->close();
	$conn->close();
	header('Location:../../secretaria/crearsolicitud.php?estado='.$id_estado);
	
} catch (Exception $e) {
	$conn->rollback();
	echo $e;
} /*finally{
	$stmt->close();
	$conn->close();
}*/

 ?>