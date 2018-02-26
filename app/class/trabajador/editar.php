<?php 
	include("../../../config/database.php");
	$constancianum = $_POST['constancianum'];
	$id_datosc = $_POST['datosc'];
	$nombrepaciente = $_POST['nombrepaciente'];
	$afiliacion = $_POST['afiliacion'];
	$consultafecha = $_POST['consultafecha'];
	$servicio = $_POST['servicio'];
	$diagnosticoini = $_POST['diagnosticoini'];
	$nombresolicitante = $_POST['nombresolicitante'];
	$parentesco = $_POST['parentesco'];
	$presentar = $_POST['presentar'];
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
		$sql = "UPDATE datos_complementarios SET fecha_consulta=?, id_servicio=?, diagnostico=?, nombre_solicitante=?, parentesco=?, destino=?, fecha_extension=?, id_medico=?, id_jefe=?, id_jefesocial=?, id_director=? WHERE id_datosc=?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('sisssssiiiii',$consultafecha,$servicio, $diagnosticoini, $nombresolicitante, $parentesco, $presentar, $fechaextension,$medico,$jefe,$jefesocial,$director,$id_datosc);
		$stmt->execute();
		
		switch ($tipoconstanciainput) {
			case '1':
				# alta
				$permaneciofecha = $_POST['permaneciofecha'];
				$diagnosticofinal = $_POST['diagnosticofinal'];
				$alt = $_POST['alt'];
				$sqlalta = "UPDATE datos_const_alta SET fecha_de_alta=?,diagnostico=? WHERE id_datosca=?";
				$stmt2 = $conn->prepare($sqlalta);
				$stmt2->bind_param('ssi',$permaneciofecha,$diagnosticofinal,$alt);
				$stmt2->execute();
				$conn->commit();
				header( "Location:../../trabajador/infosolicitud.php?con=$constancianum");
				break;
			case '2':
				# ingresos
				$diagnosticoingreso = $_POST['diagnosticoingreso'];
				$alt = $_POST['alt'];
				$sqlingreso = "UPDATE datos_const_ingreso SET diagnostico=? WHERE id_datosci=?";
				$stmt2 = $conn->prepare($sqlingreso);
				$stmt2->bind_param('si',$diagnosticoingreso,$alt);
				$stmt2->execute();
				$conn->commit();
				header( "Location:../../trabajador/infosolicitud.php?con=$constancianum");
				break;
			case '3':
				# fallecimiento
				$permaneciofecha = $_POST['permaneciofecha'];
				$fallecimientopor = $_POST['fallecimientopor'];
				$alt = $_POST['alt'];
				$sqlfallecimiento = "UPDATE datos_const_fallecimiento SET fecha_defuncion=?, diagnostico=? WHERE id_datoscf=?";
				$stmt2=$conn->prepare($sqlfallecimiento);
				$stmt2->bind_param('ssi',$permaneciofecha,$fallecimientopor,$alt);
				$stmt2->execute();
				$conn->commit();
				header( "Location:../../trabajador/infosolicitud.php?con=$constancianum");
				break;
			case '4':
				# fallecimiento casa
				$permaneciofecha = $_POST['permaneciofecha'];
				$partidafecha = $_POST['partidafecha'];
				$lugarextension = $_POST['lugarextension'];
				$domiciliofecha = $_POST['domiciliofecha'];
				$alt = $_POST['alt'];
				$sqlfallecimientocase = "UPDATE datos_const_fallecimiento_casa SET fecha_de_alta=?, fecha_defun_ext=?,lugar_de_extension=?,fecha_fallecimiento=? WHERE id_datoscfc=?";
				$stmt2=$conn->prepare($sqlfallecimientocase);
				$stmt2->bind_param('ssssi',$permaneciofecha,$partidafecha,$lugarextension,$domiciliofecha,$alt);
				$stmt2->execute();
				$conn->commit();
				header( "Location:../../trabajador/infosolicitud.php?con=$constancianum"); 
				break;
			default:
				# code...
				break;
		}
	} catch (Exception $e) {
		$conn->rollback();
		echo "false";
	} finally {
		$stmt->close();
		$stmt2->close();
		$conn->close();
	}
	
 ?>