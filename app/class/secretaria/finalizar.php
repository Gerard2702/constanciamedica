<?php 

$contancianum = $_POST['id_solicitud'];
include("../../../config/database.php");
$conn->autocommit(false);

try {

	$sqlup = "UPDATE datos_iniciales SET id_estado=6 WHERE id_datos=?";
	$stmt = $conn->prepare($sqlup);
	$stmt->bind_param('i',$contancianum);
	$stmt->execute();
	$conn->commit();
	$stmt->close();
	$conn->close();
	
} catch (Exception $e) {
	$conn->rollback();
	echo $e;
} /*finally{
	$stmt->close();
	$conn->close();
}*/

 ?>