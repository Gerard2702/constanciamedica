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

$contancianum = $_POST['id_solicitud'];

try {
	$sqlup = "UPDATE datos_iniciales SET fecha=?, numero_recibo=?, afiliacion_dui=?, nombre_paciente=?, destinos=?, id_servicio=?, cantidad=?, fecha_presentado=?, fecha_cancelado=? WHERE id_datos=?";
	$stmt = $conn->prepare($sqlup);
	$stmt->bind_param('sssssiisss',$fecha,$recibo,$afiliacion,$nombrepaciente,$lugarpresentar,$servicio,$cantidad,$fechapresento,$fechacancelo,$contancianum);
	$stmt->execute();
	$conn->commit();
	$stmt->close();
	$conn->close();
	header("Location:../../secretaria/pendienteenvio.php");
	
} catch (Exception $e) {
	$conn->rollback();
	echo $e;
} /*finally{
	$stmt->close();
	$conn->close();
}*/
 ?>