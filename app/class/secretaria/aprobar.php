<?php 

include("../../../config/database.php");
$id_constancia = $_POST['id_constancia'];
$estado  = $_POST['estado'];

if($estado==0){
	$estado=1;
}
else{
	$estado=0;
}

$conn->autocommit(false);

try {
	$sql="UPDATE datos_complementarios SET estado=? WHERE id_datosc=?";
	$stmt=$conn->prepare($sql);
	$stmt->bind_param('ii',$estado,$id_constancia);
	$stmt->execute();
	$rows = $stmt->affected_rows;
	if($rows==1){
		echo "true";
	}
	else{
		echo "false";
	}
	$conn->commit();
	
} catch (Exception $e) {
	$conn->rollback();
	echo $e;
} finally{
	$stmt->close();
	$conn->close();
}

 ?>