<?php 
	include("../../../config/database.php");
	$id_constancia = $_POST['id_constancia'];
	$id_tipo = $_POST['id_tipo'];
	$alt = $_POST['id_alt'];


	$conn->autocommit(false);
	try {

		$sqlup = "SELECT id_constancia,id_datos,fecha_consulta,id_servicio,diagnostico,nombre_solicitante,parentesco,destino,fecha_extension,id_medico,id_jefe,id_jefesocial,id_director,estado FROM datos_complementarios WHERE id_datosc=?";
		$stmt = $conn->prepare($sqlup);
		$stmt->bind_param('i',$id_constancia);
		$stmt->execute();
		$stmt->bind_result($id_constancia,$id_datos,$fecha_consulta,$id_servicio,$diagnostico,$nombre_solicitante,$parentesco,$destino,$fecha_extension,$id_medico,$id_jefe,$id_jefesocial,$id_director,$estado);
		$stmt->fetch();
		$stmt->close();

		$sqlinsert = "INSERT INTO datos_complementarios (id_constancia, id_datos, fecha_consulta, id_servicio, diagnostico, nombre_solicitante, parentesco, destino, fecha_extension, id_medico, id_jefe, id_jefesocial, id_director,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$stmtinsert = $conn->prepare($sqlinsert);
		$stmtinsert->bind_param('iisissssssssss',$id_constancia,$id_datos,$fecha_consulta,$id_servicio, $diagnostico, $nombre_solicitante, $parentesco, $destino, $fecha_extension,$id_medico,$id_jefe,$id_jefesocial,$id_director,$estado);
		$stmtinsert->execute();
		$rows = $stmtinsert->affected_rows;
		$lastid=$stmtinsert->insert_id;
		$stmtinsert->close();

		switch ($id_tipo) {
			case '1':
				$sqlalt = "SELECT id_datosc,fecha_de_alta,diagnostico FROM datos_const_alta WHERE id_datosca=?";
				$stmtalt=$conn->prepare($sqlalt);
				$stmtalt->bind_param('i',$alt);
				$stmtalt->execute();
				$stmtalt->bind_result($id_datosc,$fecha_de_alta,$diagnostico);
				$stmtalt->fetch();
				$stmtalt->close();
				$sqlalta = "INSERT INTO datos_const_alta (id_datosc,fecha_de_alta,diagnostico) VALUES (?,?,?)";
				$stmt2=$conn->prepare($sqlalta);
				$stmt2->bind_param('iss',$lastid,$fecha_de_alta,$diagnostico);
				$stmt2->execute();
				$rows = $stmt2->affected_rows;
				$stmt2->close();
				break;
			case '2':
				$sqlalt = "SELECT id_datosc, diagnostico FROM datos_const_ingreso WHERE id_datosci=?";
				$stmtalt=$conn->prepare($sqlalt);
				$stmtalt->bind_param('i',$alt);
				$stmtalt->execute();
				$stmtalt->bind_result($id_datosc,$diagnostico);
				$stmtalt->fetch();
				$stmtalt->close();
				$sqlingreso = "INSERT INTO datos_const_ingreso (id_datosc,diagnostico) VALUES (?,?)";
				$stmt2 = $conn->prepare($sqlingreso);
				$stmt2->bind_param('is',$lastid,$diagnostico);
				$stmt2->execute();
				$rows = $stmt2->affected_rows;
				$stmt2->close();
				break;
			case '3':
				$sqlalt = "SELECT id_datosc, fecha_defuncion, diagnostico FROM datos_const_fallecimiento WHERE id_datoscf=?";
				$stmtalt=$conn->prepare($sqlalt);
				$stmtalt->bind_param('i',$alt);
				$stmtalt->execute();
				$stmtalt->bind_result($id_datosc,$fecha_defuncion,$diagnostico);
				$stmtalt->fetch();
				$stmtalt->close();
				$sqlfallecimiento = "INSERT INTO datos_const_fallecimiento (id_datosc,fecha_defuncion, diagnostico) VALUES (?,?,?)";
				$stmt2=$conn->prepare($sqlfallecimiento);
				$stmt2->bind_param('iss',$lastid,$fecha_defuncion,$diagnostico);
				$stmt2->execute();
				$rows = $stmt2->affected_rows;
				$stmt2->close();
				break;
			case '4':
				$sqlalt = "SELECT id_datosc,fecha_de_alta, fecha_defun_ext, lugar_de_extension, fecha_fallecimiento FROM datos_const_fallecimiento_casa WHERE id_datoscfc=?";
				$stmtalt=$conn->prepare($sqlalt);
				$stmtalt->bind_param('i',$alt);
				$stmtalt->execute();
				$stmtalt->bind_result($id_datosc,$fecha_de_alta,$fecha_defun_ext,$lugar_de_extension,$fecha_fallecimiento);
				$stmtalt->fetch();
				$stmtalt->close();
				$sqlfallecimientocase = "INSERT INTO datos_const_fallecimiento_casa (id_datosc,fecha_de_alta, fecha_defun_ext,lugar_de_extension,fecha_fallecimiento) VALUES (?,?,?,?,?)";
				$stmt2=$conn->prepare($sqlfallecimientocase);
				$stmt2->bind_param('issss',$lastid,$fecha_de_alta,$fecha_defun_ext,$lugar_de_extension,$fecha_fallecimiento);
				$stmt2->execute();
				$rows = $stmt2->affected_rows;
				$stmt2->close();
				break;
			default:
				# code...
				break;
		}

		if($rows==1){
			echo "true";
		}
		else{
			echo "error";
		}
		$conn->commit();
		//$stmt->close();
		

		$conn->close();
	} catch (Exception $e) {
		
	}
 ?>