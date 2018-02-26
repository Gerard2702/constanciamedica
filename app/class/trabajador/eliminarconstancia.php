<?php 

	include("../../../config/database.php");
	$id_constancia=$_POST['id_constancia'];
	$id_tipo = $_POST['id_tipo'];
	$alt = $_POST['alt'];
	$conn->autocommit(false);
	try {
		switch ($id_tipo) {
			case '1':
				$sqlalt = "DELETE FROM datos_const_alta WHERE id_datosca=?";
				$stmtalt=$conn->prepare($sqlalt);
				$stmtalt->bind_param('i',$alt);
				$stmtalt->execute();
				break;
			case '2':
				$sqlalt = "DELETE FROM datos_const_ingreso WHERE id_datosci=?";
				$stmtalt=$conn->prepare($sqlalt);
				$stmtalt->bind_param('i',$alt);
				$stmtalt->execute();
				break;
			case '3':
				$sqlalt = "DELETE FROM datos_const_fallecimiento WHERE id_datoscf=?";
				$stmtalt=$conn->prepare($sqlalt);
				$stmtalt->bind_param('i',$alt);
				$stmtalt->execute();
				break;
			case '4':
				$sqlalt = "DELETE FROM datos_const_fallecimiento_casa WHERE id_datoscfc=?";
				$stmtalt=$conn->prepare($sqlalt);
				$stmtalt->bind_param('i',$alt);
				$stmtalt->execute();
				break;
			default:
				# code...
				break;
		}

		$sqlup = "DELETE FROM datos_complementarios WHERE id_datosc=?";
		$stmt = $conn->prepare($sqlup);
		$stmt->bind_param('i',$id_constancia);
		$stmt->execute();
		$rows = $stmt->affected_rows;
		if($rows==1){
			echo "true";
		}
		else{
			echo "error";
		}
		$conn->commit();
	} catch (Exception $e) {
		$conn->rollback();
		echo $e;
	} finally{
		$stmt->close();
		$stmtalt->close();
		$conn->close();
	}

 ?>