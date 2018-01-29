<?php 
  try{
	$usuario = $_POST['usuario'];
	$pass = md5($_POST['clave']);
	include("../../config/database.php");
	$sql = "SELECT name,user,password,id_tipousuario FROM usuario WHERE user=?";
	if($stmt = $conn->prepare($sql)){
		$stmt->bind_param("s", $usuario);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($name,$user,$password,$id_tipousuario);
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
        	$_SESSION['nombre'] = $name;
        	switch ($id_tipousuario) {
        		case '1':
        			header("Location:../secretaria/");
        			break;
        		case '2':
        			header("Location:../trabajador/");
        			break;
        		case '3':
        			header("Location:../admin/");
        			break;
        		default:
        			break;
        	}      	
        }
        else{
        	header("Location:../../?error=1");
        }
	} 
	else{
		header("Location:../../?error=2");
	}
  }
  catch(Exception $e){
  }
?>