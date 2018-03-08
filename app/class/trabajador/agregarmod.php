<?php 
	include("../../../config/database.php");
	$constancianum = $_POST['constancianum'];
	$nombrepaciente = $_POST['nombrepaciente'];
	$afiliacion = $_POST['afiliacion'];
	$consultafecha = $_POST['consultafecha'];
	$servicio = $_POST['servicio'];
	$diagnosticoini = $_POST['diagnosticoini'];
	$nombresolicitante = strtoupper($_POST['nombresolicitante']);
	$parentesco = $_POST['parentesco'];
	$presentar = strtoupper($_POST['presentar']);
	$fechaextension = $_POST['fechaextension'];
	$tipoconstanciainput = $_POST['tipoconstanciainput'];

	if(isset($_POST['checkmedico'])){
		$medico = $_POST['medico']; }
	else{ $medico = null; }
	if(isset($_POST['checkjefe'])){
		$jefe = $_POST['jefe']; }
	else{ $jefe = null; }
	if(isset($_POST['checkjefesocial'])){
		$jefesocial = $_POST['jefesocial']; }
	else{ $jefesocial = null; }
	if(isset($_POST['checkdirector'])){
		$director = $_POST['director']; }
	else{ $director = null; }

	$conn->autocommit(false);

	try {
		$sql = "INSERT INTO datos_complementarios (id_constancia, id_datos, fecha_consulta, id_servicio, diagnostico, nombre_solicitante, parentesco, destino, fecha_extension, id_medico, id_jefe, id_jefesocial, id_director) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('iisisssssssss',$tipoconstanciainput,$constancianum,$consultafecha,$servicio, $diagnosticoini, $nombresolicitante, $parentesco, $presentar, $fechaextension,$medico,$jefe,$jefesocial,$director);
		$stmt->execute();
		$lastid=$stmt->insert_id;
		
		switch ($tipoconstanciainput) {
			case '1':
				# alta
				$permaneciofecha = $_POST['permaneciofecha'];
				$diagnosticofinal = $_POST['diagnosticofinal'];
				$sqlalta = "INSERT INTO datos_const_alta (id_datosc,fecha_de_alta,diagnostico) VALUES (?,?,?)";
				$stmt2 = $conn->prepare($sqlalta);
				$stmt2->bind_param('iss',$lastid,$permaneciofecha,$diagnosticofinal);
				$stmt2->execute();
				$conn->commit();
				$stmt->close();
				$stmt2->close();
				$conn->close();
				header( "Location:../../trabajador/infosolicitudmod.php?con=$constancianum");
				break;
			case '2':
				# ingresos
				$diagnosticoingreso = $_POST['diagnosticoingreso'];
				$sqlingreso = "INSERT INTO datos_const_ingreso (id_datosc,diagnostico) VALUES (?,?)";
				$stmt2 = $conn->prepare($sqlingreso);
				$stmt2->bind_param('is',$lastid,$diagnosticoingreso);
				$stmt2->execute();
				$conn->commit();
				$stmt->close();
				$stmt2->close();
				$conn->close();
				header( "Location:../../trabajador/infosolicitudmod.php?con=$constancianum");
				break;
			case '3':
				# fallecimiento
				$permaneciofecha = $_POST['permaneciofecha'];
				$fallecimientopor = $_POST['fallecimientopor'];
				$sqlfallecimiento = "INSERT INTO datos_const_fallecimiento (id_datosc,fecha_defuncion, diagnostico) VALUES (?,?,?)";
				$stmt2=$conn->prepare($sqlfallecimiento);
				$stmt2->bind_param('iss',$lastid,$permaneciofecha,$fallecimientopor);
				$stmt2->execute();
				$conn->commit();
				$stmt->close();
				$stmt2->close();
				$conn->close();
				header( "Location:../../trabajador/infosolicitudmod.php?con=$constancianum");
				break;
			case '4':
				# fallecimiento casa
				$permaneciofecha = $_POST['permaneciofecha'];
				$partidafecha = $_POST['partidafecha'];
				$lugarextension = $_POST['lugarextension'];
				$domiciliofecha = $_POST['domiciliofecha'];
				$sqlfallecimientocase = "INSERT INTO datos_const_fallecimiento_casa (id_datosc,fecha_de_alta, fecha_defun_ext,lugar_de_extension,fecha_fallecimiento) VALUES (?,?,?,?,?)";
				$stmt2=$conn->prepare($sqlfallecimientocase);
				$stmt2->bind_param('issss',$lastid,$permaneciofecha,$partidafecha,$lugarextension,$domiciliofecha);
				$stmt2->execute();
				$conn->commit();
				$stmt->close();
				$stmt2->close();
				$conn->close();
				header( "Location:../../trabajador/infosolicitudmod.php?con=$constancianum"); 
				break;
			default:
				# code...
				break;
		}
	} catch (Exception $e) {
		$conn->rollback();
		echo "false";
	} /*finally {
		$stmt->close();
		$stmt2->close();
		$conn->close();
	}*/
	
 ?>