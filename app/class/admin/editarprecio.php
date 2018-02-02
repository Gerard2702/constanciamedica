<?php 
	include("../../../config/database.php");
	if (!empty($_POST['precio']) || $_POST['precio'] != "") {
		$precio = $_POST['precio'];
	}
	$id=$_POST['id'];


		$sql = "UPDATE precio_constancias SET precio=?  WHERE id_precio=?";
		if($stmtu = $conn->prepare($sql)){
			$stmtu->bind_param("di",$precio,$id);
			$stmtu->execute();		 				
			$stmtu->close();
		}


	header("Location:../../admin/adminprecios.php");
 ?>
