<?php 
  try{
	$usuario = $_POST['usuario'];
	$pass = md5($_POST['clave']);
	include("../../config/database.php");
	$sql = "SELECT usuario.id_user,usuario.name,usuario.user,usuario.password,usuario.id_tipousuario,usuario.id_servicio,servicios.nombre_servicio FROM usuario INNER JOIN servicios ON usuario.id_servicio=servicios.id_servicio WHERE user=?";
	if($stmt = $conn->prepare($sql)){
		$stmt->bind_param("s", $usuario);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id_user,$name,$user,$password,$id_tipousuario,$id_servicio,$nombre_servicio);
	    $stmt->fetch();
	    $rows = $stmt->num_rows;
	    $stmt->close();
	}
    $conn->close();
	session_start();
    if($rows>0){
        if($pass==$password){
            $_SESSION['id_usuario'] = $id_user;
        	$_SESSION['usuario'] = $user;
        	$_SESSION['tipousuario'] = $id_tipousuario;
        	$_SESSION['nombre'] = $name;
            $_SESSION['id_servicio'] = $id_servicio;
            $_SESSION['nombre_servicio'] = $nombre_servicio;
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