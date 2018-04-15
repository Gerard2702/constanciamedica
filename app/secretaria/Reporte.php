<?php
	$title = "Reporte";
    if(!isset($_SERVER['HTTP_REFERER'])){
        header('Location:index.php');
    }


    include("../core/header.php");
    include("../core/aside.php");
    
    include("../../config/database.php");    


    if(!empty($_POST['fecha'])){
    	$fechau=$_POST['fecha'];
    	$sql="SELECT fecha,numero_recibo,nombre_paciente,afiliacion_dui,destinos,cantidad,precio,(precio*cantidad) as total FROM `datos_iniciales` WHERE fecha=?";
    	if($stm = $conn->prepare($sql)){
                $stm -> bind_param('s',$fechau);
                $stm -> execute();
                $stm -> store_result();
                $rows = $stm->num_rows;
                $stm -> bind_result($fecha,$recibo,$paciente,$afiliacion,$destino,$cantidad,$precio,$total);                
            }
    }elseif(!empty($_POST['fechainicial']) && !empty($_POST['fechafinal'])){
    	$fechaini=$_POST['fechainicial'];
    	$fechafin=$_POST['fechafinal'];
    	$sql="SELECT fecha,numero_recibo,nombre_paciente,afiliacion_dui,destinos,cantidad,precio,(precio*cantidad) as total FROM datos_iniciales WHERE fecha BETWEEN ? AND ?";
    	if($stm = $conn->prepare($sql)){
                $stm -> bind_param('ss',$fechaini,$fechafin);
                $stm -> execute();
                $stm -> store_result();
                $rows = $stm->num_rows;
                $stm -> bind_result($fecha,$recibo,$paciente,$afiliacion,$destino,$cantidad,$precio,$total);                
            }
    }

?>

<!--main content start-->
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="page-head-wrap">
        <h4 class="margin0">REPORTE DE CONSTANCIAS CANCELADAS</h4>  
    </div>
    <div class="ui-content-body">
        <div class="ui-container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div id="titulo">
                            	<h4>Busqueda por Fecha /Rango de Fechas</h4>
                            </div>
                            <div id="contenido">
                            	<form class="form-horizontal form-variance" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Fecha</label>
                                        <div class="col-sm-2">
                                            <input class="form-control fecha" type="text" placeholder="Fecha" id="fecha" name="fecha" data-date-end-date="0d">
                                        </div>                                      
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Fecha Inicio</label>
                                        <div class="col-sm-2">
                                            <input class="form-control fecha" type="text" placeholder="Fecha" id="fechainicial" name="fechainicial" data-date-end-date="0d">
                                        </div>
                                        <label class="col-sm-1 control-label">Fecha Fin</label>
                                        <div class="col-sm-2">
                                            <input class="form-control fecha" type="text" placeholder="Fecha" id="fechafinal" name="fechafinal" data-date-end-date="0d">
                                        </div>
                                    	<div class="col-sm-1">
                                    		<button type="submit" id="search" name="search" class="btn btn-primary">Buscar</button>
                                    	</div>
                                    </div> 
                                </form>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
            <?php if(isset($_POST['search']) &&  !empty($_POST['fecha']) ){ 
            	$monto=0;
            	?>			            				
            				<div class="panel">
            					<div class="col-md-2 col-md-offset-10">            						
                               		<?php
                               		echo "<a href='Reporte2.php?fec=$fechau'><button type='button'  class='btn btn-success'> Descargar Formato Excel </button></a>"
                               		?>
                            	</div>
								<div class="panel-body">									
									<div id="contenido" class="table-responsive">
		                                <table class="table table-striped table-condensed" id="mitable">
		                                    <thead class="thead-inverse">
		                                        <tr>
		                                            <th class="col-md-1">Fecha</th>
                                                    <th class="col-md-1">N° Recibo</th>
		                                            <th class="col-md-3">Nombre Paciente</th>
		                                            <th class="col-md-2">N° Afiliacion / DUI</th>
                                                    <th class="col-md-2">Constancia a Presentar en</th>
		                                            <th class="col-md-1">Cantidad</th>
                                                    <th class="col-md-1">Total</th>
		                                            <th class="col-md-2">Monto Total Del Mes</th>                                            
		                                        </tr>
		                                    </thead>
		                                    <tbody>  		                                                                      	
		                                        <?php	                                                	                                        	                                         
		                                            if($rows>0) {
		                                                while ($stm->fetch()) {
		                                        ?>
		                                                <tr>
		                                                <td class="text-left"><?php echo $fecha ?></td>
		                                                <td class="text-left"><?php echo $recibo ?></td>
		                                                <td class="text-left"><?php echo $paciente ?></td>
		                                                <td class="text-left"><?php echo $afiliacion ?></td>
                                                        <td class="text-left"><?php echo $destino ?></td>
                                                        <td class="text-left"><?php echo $cantidad ?></td>
                                                        <td class="text-left"><?php echo "$".$total ?></td>		                                                
													<?php	$monto= $monto + $total; ?>
		                                                </tr>    		                                        
		                                            <?php
		                                                }?>
		                                                <tr>		                                                
		                                                <td class="text-left"></td>
		                                                <td class="text-left"></td>
		                                                <td class="text-left"></td>
		                                                <td class="text-left"></td>
		                                                <td class="text-left"></td>
		                                                <td class="text-left"></td>
		                                                <td class="text-left"></td>
		                                                <td class="text-center"><strong><?php echo "$".$monto ?></strong></td>
		                                            	</tr>
		                                            <?php
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
                           } elseif(isset($_POST['search']) && !empty($_POST['fechainicial']) && !empty($_POST['fechafinal']) ){ 
				            	$monto=0;
				            	?>
            				<div class="panel">
            					<div class="col-md-2 col-md-offset-10">
            						<?php
                               		echo "<a href='Reporte2.php?fecini=$fechaini&fecf=$fechafin'><button type='button'  class='btn btn-success'> Descargar Formato Excel </button></a>"
                               		?>                               		
                            	</div>
								<div class="panel-body">
									<div id="contenido" class="table-responsive">
		                                <table class="table table-striped table-condensed" id="mitable">
		                                    <thead class="thead-inverse">
		                                        <tr>
		                                            <th class="col-md-1">Fecha</th>
                                                    <th class="col-md-1">N° Recibo</th>
		                                            <th class="col-md-3">Nombre Paciente</th>
		                                            <th class="col-md-2">N° Afiliacion / DUI</th>
                                                    <th class="col-md-2">Constancia a Presentar en</th>
		                                            <th class="col-md-1">Cantidad</th>
                                                    <th class="col-md-1">Total</th>
		                                            <th class="col-md-2">Monto Total Del Mes</th>                                            
		                                        </tr>
		                                    </thead>
		                                    <tbody>  		                                                                      	
		                                        <?php	                                                	                                        	                                         
		                                            if($rows>0) {
		                                                while ($stm->fetch()) {
		                                        ?>
		                                                <tr>
		                                                <td class="text-left"><?php echo $fecha ?></td>
		                                                <td class="text-left"><?php echo $recibo ?></td>
		                                                <td class="text-left"><?php echo $paciente ?></td>
		                                                <td class="text-left"><?php echo $afiliacion ?></td>
                                                        <td class="text-left"><?php echo $destino ?></td>
                                                        <td class="text-left"><?php echo $cantidad ?></td>
                                                        <td class="text-left"><?php echo "$".$total ?></td>		                                                
													<?php	$monto= $monto + $total; ?>
		                                                </tr>    		                                        
		                                            <?php
		                                                }?>
		                                                <tr>		                                                
		                                                <td class="text-left"></td>
		                                                <td class="text-left"></td>
		                                                <td class="text-left"></td>
		                                                <td class="text-left"></td>
		                                                <td class="text-left"></td>
		                                                <td class="text-left"></td>
		                                                <td class="text-left"></td>
		                                                <td class="text-center"><strong><?php echo "$".$monto ?></strong></td>
		                                            	</tr>
		                                            <?php
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