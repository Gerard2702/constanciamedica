<?php
	
	include("../../config/database.php");

	if(!empty($_POST["id"])){
		$iddatos = $_POST["id"];		
    
	    $sql = "SELECT medico_tratante.nombre,status.nombre_status,servicios.nombre_servicio
	            FROM ((medico_tratante
	            INNER JOIN status ON medico_tratante.id_status = status.id_status)
	            INNER JOIN servicios ON medico_tratante.id_servicio = servicios.id_servicio)
	            WHERE medico_tratante.id_medico = $id;";

	    if ($stmt  = $conn->prepare($sql)) {
	        $stmt ->execute();
	        $stmt->store_result();
	        $rows = $stmt->num_rows;
	        $stmt ->bind_result($nombre, $status, $servicio);    
	    }
	    $conn->close();	
	}

					String html = " ";

			    	if($rows>0) {
			            while ($stmt->fetch()) {
			    
			    	html = "<div id="contenido">"
                            	+"<form class="form-horizontal form-variance" method="get">"
                                    +"<div class="form-group">"
                                        +"<label class="col-sm-3 control-label">Nombre Completo</label>"
                                        +"<div class="col-sm-6">"
                                            +"<input class="form-control" type="text" value="$nombre">"
                                        +"</div>"
                                    +"</div>"
                                    +"<div class="form-group">"
                                        +"<label class="col-sm-3 control-label">Servicio</label>"
                                        +"<div class="col-sm-6">"
                                            +"<select class="form-control" name="services" id="services">
                                                <option value="$servicio">"+$servicio+"</option>"
                                            +"</select>"
                                            +"<span class="help-block">Servicio o Especialidad a la que pertenece el medico</span>"
                                        +"</div>"
                                    +"</div>"
                                    +"<div class="form-group">"
                                        +"<label class="col-sm-3 control-label">Status</label>"
                                        +"<div class="col-sm-6">"
                                            +"<input class="form-control" type="text" value="$status">"
                                        +"</div>"
                                    +"</div>"
                                +"</form>"
                            +"</div>"
                        }
                    }else{
                    	html = "<center><h4>No se encontraron los datos del registro.</h4></center>";
                    }
                    $stmt->close();

                    out.println(html);