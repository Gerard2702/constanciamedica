<?php 
include("../../../config/database.php");
session_start();
$comentario = $_POST['comentario'];
$id_datos = $_SESSION['id_datosmodificarsolicitud'];
$estado = 5;
unset($_SESSION['id_datosmodificarsolicitud']);

$conn->autocommit(false);

try {
	$sql = 'INSERT INTO comentarios (id_datos,comentario) VALUES (?,?);';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('is',$id_datos,$comentario);
	$stmt->execute();
	$rows = $stmt->affected_rows;
	$stmt->close();


	$sql2 = 'UPDATE datos_iniciales SET id_estado=? WHERE id_datos=?';
	$stmt2 = $conn->prepare($sql2);
	$stmt2->bind_param('ii',$estado,$id_datos);
	$stmt2->execute();
	$rows2 = $stmt2->affected_rows;
	$stmt2->close();
	$conn->commit();
	$conn->close();

	if($rows==1&&$rows2==1){
		echo "true";
	}
	else{
		echo "false";
	}
} catch (Exception $e) {
	$conn->rollback();
}

 ?>