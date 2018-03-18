<?php
    $title = "Buscar Constancias";
    if(!isset($_SERVER['HTTP_REFERER'])){
        header('Location:index.php');
    }

    
    include("../core/header.php");
    include("../core/aside.php");
    
    include("../../config/database.php");

    if(!empty($_POST['idsoli'])){

    	$idsolicitud = $_POST['idsoli'];

    	$sql = "SELECT di.afiliacion_dui,c.tipo_constancia,di.nombre_paciente,dc.destino,dc.nombre_solicitante,sv.nombre_servicio,dc.estado,dc.fecha_entregada FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN constancias c ON dc.id_constancia=c.id_constancia WHERE dc.id_datos=?";
    	if($stm = $conn->prepare($sql)){
                $stm -> bind_param('i',$idsolicitud);
                $stm -> execute();
                $stm -> store_result();
                $rows = $stm->num_rows;
                $stm -> bind_result($afiliacion,$tipoconstancia,$nombrepaciente,$destino,$solicitante,$servicio,$estado,$fechaentrega);                
            }

    }
    elseif(!empty($_POST['afiliacion'])){

        $numafiliacion = $_POST['afiliacion'];

        $sql = "SELECT di.afiliacion_dui,c.tipo_constancia,di.nombre_paciente,dc.destino,dc.nombre_solicitante,sv.nombre_servicio,dc.estado,dc.fecha_entregada FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN constancias c ON dc.id_constancia=c.id_constancia WHERE di.afiliacion_dui=?";
        if($stm = $conn->prepare($sql)){
                $stm -> bind_param('i',$numafiliacion);
                $stm -> execute();
                $stm -> store_result();
                $rows = $stm->num_rows;
                $stm -> bind_result($afiliacion,$tipoconstancia,$nombrepaciente,$destino,$solicitante,$servicio,$estado,$fechaentrega);                
            }

    }
    elseif(!empty($_POST['recibo'])){

    	$numero_recibo = $_POST['recibo'];

    	$sql = "SELECT di.afiliacion_dui,c.tipo_constancia,di.nombre_paciente,dc.destino,dc.nombre_solicitante,sv.nombre_servicio,dc.estado,dc.fecha_entregada FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN constancias c ON dc.id_constancia=c.id_constancia WHERE di.numero_recibo=?";
    	if($stm = $conn->prepare($sql)){
                $stm -> bind_param('i',$numero_recibo);
                $stm -> execute();
                $stm -> store_result();
                $rows = $stm->num_rows;
                $stm -> bind_result($afiliacion,$tipoconstancia,$nombrepaciente,$destino,$solicitante,$servicio,$estado,$fechaentrega);                
            }

    }
    elseif(!empty($_POST['fecha'])){

    	$fechas = $_POST['fecha'];

    	$sql = "SELECT di.afiliacion_dui,c.tipo_constancia,di.nombre_paciente,dc.destino,dc.nombre_solicitante,sv.nombre_servicio,dc.estado,dc.fecha_entregada FROM datos_complementarios dc JOIN datos_iniciales di ON dc.id_datos=di.id_datos JOIN servicios sv ON dc.id_servicio=sv.id_servicio JOIN constancias c ON dc.id_constancia=c.id_constancia WHERE di.fecha=?";
    	if($stm = $conn->prepare($sql)){
                $stm -> bind_param('s',$fechas);
                $stm -> execute();
                $stm -> store_result();
                $rows = $stm->num_rows;
                $stm -> bind_result($afiliacion,$tipoconstancia,$nombrepaciente,$destino,$solicitante,$servicio,$estado,$fechaentrega);                
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
                                        <label class="col-sm-2 control-label">ID Solicitud</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="idsoli" placeholder="Id Solicitud" name="idsoli" type="number" autofocus>
                                        </div>
                                        <label class="col-sm-2 control-label"># Afiliacion/Dui</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="afiliacion" placeholder="# Afiliciacion/DUI" name="afiliacion" type="number">
                                        </div>                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Número Recibo</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" type="number" placeholder="Numero de Recibo" name="recibo" >
                                        </div>
                                        <label class="col-sm-2 control-label">Fecha</label>
                                        <div class="col-sm-3">
                                            <input class="form-control fecha" type="text" placeholder="Fecha" id="fecha" name="fecha" data-date-end-date="0d">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2 col-md-offset-2">
                                            <button type="submit" id="search" name="search" class="btn btn-primary btn-block">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
            <?php if(isset($_POST['search']) && (!empty($_POST['recibo']) || !empty($_POST['fecha']) || !empty($_POST['idsoli']) || !empty($_POST['afiliacion']) )){ ?>
            				<div class="panel">
								<div class="panel-body">
									<div id="contenido" class="table-responsive">
		                                <table class="table table-striped table-condensed" id="mitable">
		                                    <thead class="thead-inverse">
		                                        <tr>
		                                            <th class="col-md-1">Afiliacion/DUI</th>
                                                    <th class="col-md-1">Tipo Constancia</th>
		                                            <th class="col-md-3">Nombre Paciente</th>
		                                            <th class="col-md-2">Destino</th>
                                                    <th class="col-md-2">Nombre Solicitante</th>
		                                            <th class="col-md-1">Servicio</th>
                                                    <th class="col-md-1">Estado</th>
		                                            <th class="col-md-2">Fecha Entrega</th>                                            
		                                        </tr>
		                                    </thead>
		                                    <tbody>  		                                                                      	
		                                        <?php	                                                	                                        	                                         
		                                            if($rows>0) {
		                                                while ($stm->fetch()) {
		                                        ?>
		                                                <tr>
		                                                <td class="text-left"><?php echo $afiliacion ?></td>
		                                                <td class="text-left"><?php echo $tipoconstancia ?></td>
		                                                <td class="text-left"><?php echo $nombrepaciente ?></td>
		                                                <td class="text-left"><?php echo $destino ?></td>
                                                        <td class="text-left"><?php echo $solicitante ?></td>
                                                        <td class="text-left"><?php echo $servicio ?></td>
                                                        <td class="text-left"><?php if($estado==1){echo "Finalizada";}else{echo "En Progreso";} ?></td>
		                                                <td class="text-left"><?php echo $fechaentrega ?></td>                                             
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