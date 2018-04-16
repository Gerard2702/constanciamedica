<?php 

$contancianum = $_POST['id_solicitud'];
include("../../../config/database.php");
$conn->autocommit(false);
$ctrl='true';
try {

	$sqlverificar = "SELECT id_datosc,estado FROM datos_complementarios WHERE id_datos=?";
	$stmtverificar = $conn->prepare($sqlverificar);
	$stmtverificar -> bind_param('i',$contancianum);
	$stmtverificar -> execute();
	$stmtverificar -> bind_result($id_datos,$estado);
	while ($stmtverificar->fetch()) {
		if($estado==0){
			$ctrl='aprobar';
		}
	}
	$stmtverificar -> close();

	if($estado=='true'){
		$sqlup = "UPDATE datos_iniciales SET id_estado=6 WHERE id_datos=?";
		$stmt = $conn->prepare($sqlup);
		$stmt->bind_param('i',$contancianum);
		$stmt->execute();
		$conn->commit();
		$stmt->close();
	}
	$conn->close();
	echo $ctrl;
	
} catch (Exception $e) {
	$conn->rollback();
	echo $e;
} /*finally{
	$stmt->close();
	$conn->close();
}*/

 ?>