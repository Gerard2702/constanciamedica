<?php 
	include("../../../config/database.php");
	$id_datos=$_POST['solicitud'];
	$id_estado=4;

	$sqlcreadas = "SELECT id_datosc FROM datos_complementarios WHERE id_datos=?";
	if($stmtcre = $conn->prepare($sqlcreadas)){
		$stmtcre -> bind_param('i',$id_datos);
		$stmtcre -> execute();
		$stmtcre -> store_result();
		$rowscre = $stmtcre->num_rows;
		$stmtcre -> bind_result($id_datosc);
		$stmtcre -> close();
	}

	$sqlcantidad = "SELECT cantidad FROM datos_iniciales WHERE id_datos=?";
	if($stmtcantidad = $conn->prepare($sqlcantidad)){
		$stmtcantidad -> bind_param('i',$id_datos);
		$stmtcantidad -> execute();
		$stmtcantidad -> bind_result($cantidad);
		$stmtcantidad -> fetch();
		$stmtcantidad -> close();
	}
	if($rowscre!=$cantidad){
		$conn->close();
		echo "Cantidad de constancias creadas no es la correcta";
	}else{
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
				echo "error en la base de datos";
			}
		}
		$conn->close();
	}
 ?>