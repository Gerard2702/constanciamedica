<?php 

session_start();
$id_solicitud = $_POST['solicitud'];
$id_user = $_SESSION['id_usuario'];

include("../../../config/database.php");

if($id_user!="" && $id_solicitud!=""){
	$sql = "UPDATE datos_iniciales SET id_estado=3, id_trabajador=? WHERE id_datos=?";
	if($stmt=$conn->prepare($sql)){
		$stmt->bind_param('ii',$id_user,$id_solicitud);
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

}
else{

}

?>