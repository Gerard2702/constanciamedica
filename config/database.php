<?php
	$servidordb = "localhost";
	$usuariodb = "root";
	$passworddb = "";
	$databasedb = "ts2";

	$conn = new mysqli($servidordb, $usuariodb, $passworddb, $databasedb);

	/* verificar conexión */
	if ($conn->connect_errno) {
    	echo "Falló la conexión a MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
	}
?>