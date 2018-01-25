<?php 
  try{
	$usuario = $_POST['usuario'];
	$pass = md5($_POST['clave']);
	include("../../config/database.php");
	$sql = "SELECT user,password,id_tipousuario FROM usuario WHERE user=?";
	if($stmt = $conn->prepare($sql)){
		$stmt->bind_param("s", $usuario);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($user,$password,$id_tipousuario);
	    $stmt->fetch();
	    $rows = $stmt->num_rows;
	    $stmt->close();
	}
    $conn->close();
	session_start();
    if($rows>0){
        if($pass==$password){
        	$_SESSION['usuario'] = $user;
        	$_SESSION['tipousuario'] = $id_tipousuario;
        	header("Location:../");
        }
        else{
        	echo "contraseña incorrecta";
        }
	} 
	else{
		header("Location:../../index.php?error=1");
	}
  }
  catch(Exception $e){
  }
?>