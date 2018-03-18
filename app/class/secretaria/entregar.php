<?php 

include("../../../config/database.php");
$id_constancia = $_POST['id_constancia'];
$entrega  = $_POST['entrega'];



$conn->autocommit(false);
if($entrega==null){
	$fecha = date("Y-m-d");
}
else{
	$fecha = null;
}


try {
	$sql="UPDATE datos_complementarios SET fecha_entregada=? WHERE id_datosc=?";
	$stmt=$conn->prepare($sql);
	$stmt->bind_param('si',$fecha,$id_constancia);
	$stmt->execute();
	$rows = $stmt->affected_rows;
	if($rows==1){
		echo $fecha;
	}
	else{
		echo "false";
	}
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