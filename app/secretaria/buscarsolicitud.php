<?php
    $title = "Buscar Soliditud";
    
    include("../core/header.php");
    include("../core/aside.php");
    
    include("../../config/database.php");

    if(!empty($_POST['nombre'])){

    	//$nombre = strtoupper($_POST['nombre']);
    	$nombre = $_POST['nombre'];

    	$sql = "SELECT di.afiliacion_dui,di.nombre_paciente,di.destinos,sv.nombre_servicio,et.nombre_status FROM datos_iniciales di JOIN servicios sv ON di.id_servicio=sv.id_servicio JOIN status et ON di.id_estado=et.id_status WHERE di.nombre_paciente LIKE CONCAT('%',?,'%')";
    	if($stm = $conn->prepare($sql)){
                $stm -> bind_param('s',$nombre);
                $stm -> execute();
                $stm -> store_result();
                $rows = $stm->num_rows;
                $stm -> bind_result($afiliacion,$nombre_paciente,$destinos,$servicio,$estado);                
            }

    }
    elseif(!empty($_POST['recibo'])){

    	$numero_recibo = $_POST['recibo'];

    	$sql = "SELECT di.afiliacion_dui,di.nombre_paciente,di.destinos,sv.nombre_servicio,et.nombre_status FROM datos_iniciales di JOIN servicios sv ON di.id_servicio=sv.id_servicio JOIN status et ON di.id_estado=et.id_status WHERE di.numero_recibo=?";
    	if($stm = $conn->prepare($sql)){
                $stm -> bind_param('i',$numero_recibo);
                $stm -> execute();
                $stm -> store_result();
                $rows = $stm->num_rows;
                $stm -> bind_result($afiliacion,$nombre_paciente,$destinos,$servicio,$estado);                
            }

    }
    elseif(!empty($_POST['fecha'])){

    	$fechas = $_POST['fecha'];

    	$sql = "SELECT di.afiliacion_dui,di.nombre_paciente,di.destinos,sv.nombre_servicio,et.nombre_status FROM datos_iniciales di JOIN servicios sv ON di.id_servicio=sv.id_servicio JOIN status et ON di.id_estado=et.id_status WHERE di.fecha=?";
    	if($stm = $conn->prepare($sql)){
                $stm -> bind_param('s',$fechas);
                $stm -> execute();
                $stm -> store_result();
                $rows = $stm->num_rows;
                $stm -> bind_result($afiliacion,$nombre_paciente,$destinos,$servicio,$estado);                
            }
    	
    }

 ?>

<!--main content start-->
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="page-head-wrap">
        <h4 class="margin0">BUSCAR SOLICTUDES</h4>  
    </div>
    <div class="ui-content-body">
        <div class="ui-container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div id="titulo">
                            	<h4>Busqueda por Nombre Paciente / Número Recibo / Fecha</h4>
                            </div>
                            <div id="contenido">
                            	<form class="form-horizontal form-variance" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Nombre Paciente</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" id="nombre" placeholder="Nombre Paciente" name="nombre" type="text" autofocus>
                                        </div>
                                        <label class="col-sm-1 control-label">Número Recibo</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" type="number" placeholder="Numero de Recibo" name="recibo" >
                                        </div>
                                        <label class="col-sm-1 control-label">Fecha</label>
                                        <div class="col-sm-2">
                                            <input class="form-control fecha" type="text" placeholder="Fecha" id="fecha" name="fecha" data-date-end-date="0d">
                                        </div>
                                    	<div class="col-sm-1 col-sm-offset-2">
                                    		<button type="submit" id="search" name="search" class="btn btn-primary">Buscar</button>
                                    	</div>
                                    </div> 
                                </form>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
            <?php if(isset($_POST['search']) && (!empty($_POST['nombre']) || !empty($_POST['recibo']) || !empty($_POST['fecha']) )){ ?>
            				<div class="panel">
								<div class="panel-body">
									<div id="contenido" class="table-responsive">
		                                <table class="table table-striped table-condensed" id="mitable">
		                                    <thead class="thead-inverse">
		                                        <tr>
		                                            <th class="col-md-2">Afiliacion/DUI</th>
		                                            <th class="col-md-4">Nombre Paciente</th>
		                                            <th class="col-md-2">Destinos</th>
		                                            <th class="col-md-2">Servicio</th>
		                                            <th class="col-md-2 text-right">Estado</th>                                            
		                                        </tr>
		                                    </thead>
		                                    <tbody>  		                                                                      	
		                                        <?php		                                        	                                         
		                                            if($rows>0) {
		                                                while ($stm->fetch()) {
		                                        ?>
		                                                <tr>
		                                                <td class="text-left"><?php echo $afiliacion ?></td>
		                                                <td class="text-left"><?php echo $nombre_paciente ?></td>
		                                                <td class="text-left"><?php echo $destinos ?></td>
		                                                <td class="text-left"><?php echo $servicio ?></td>
		                                                <td class="text-right"><span class="label label-info"><?php echo $estado ?></span></td>                                             
		                                                </tr>    
		                                        <?php        
		                                                }
		                                            }else{?>	
		                                            	<div class="alert alert-warning">
														  <center><strong>Warning!</strong> NO SE ENCONTRARON REGISTROS</center>
														</div>																												
													<?php
		                                            }
		                                            $stm->close();
		                                        ?> 
		                                    </tbody>
		                                </table>
		                            </div>
	                        </div>
                    </div>

                           <?php
                           } ?>
        </div>
    </div>
</div>
<!--main content end-->

 <?php
    include("../core/footer.php");

 ?>
 <script>
	$('.fecha').datepicker({
		    todayBtn: "linked",
		    clearBtn: true,
		    language: "es",
		    format: 'yyyy-mm-dd',
		    autoclose: true,
		    todayHighlight: true,
		    disableTouchKeyboard: true,
		});
 </script>
 <script >
function  mostrarTabla(){
	event.preventDefault();
	elem=document.getElementById('contenido2');
	elem.style.display='block';
}
</script>