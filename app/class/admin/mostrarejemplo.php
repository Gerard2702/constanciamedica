<?php 

include("../../../config/database.php");
$sql = "SELECT name,user FROM usuario";

if ($stmt  = $conn->prepare($sql)) {
    $stmt ->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    $stmt ->bind_result($nombre, $user);

    if($rows>0){
    	while ($stmt->fetch()) {
        	echo $nombre."   ".$user;
        	echo "<br>";
    	}
    }
    else{
    	echo "No hay registros";
    }
    $stmt->close();
}
$conn->close();

 ?>