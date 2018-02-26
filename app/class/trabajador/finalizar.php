<?php 
	include("../../../config/database.php");
	$id_datos=$_POST['solicitud'];
	$id_estado=4;

	$sql = "UPDATE datos_iniciales SET id_estado=? WHERE id_datos=?";
	if($stmt = $conn->prepare($sql)){
		$stmt->bind_param('ii',$id_estado,$id_datos);
		$stmt->execute();
		$rows = $stmt->affected_rows;
		$stmt->close();
		if($rows==1){
			echo "true";
		}
		else{
			echo "error";
		}
	}
	$conn->close();

 ?>