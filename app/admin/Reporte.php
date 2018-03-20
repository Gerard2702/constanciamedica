<?php
	$title = "Resportes de Constancias";
    if(!isset($_SERVER['HTTP_REFERER'])){
        header('Location:index.php');
    }

    
    include("../core/header.php");
    include("../core/aside.php"); 
    include("../../config/database.php");

    if(!empty($_POST['tipo'])){
    	$var = $_POST['tipo'];
    	if($var=="servicio"){
    		$sql = "SELECT DISTINCT(dc.id_servicio),sv.nombre_servicio FROM datos_complementarios dc JOIN servicios sv ON dc.id_servicio=sv.id_servicio WHERE dc.estado=1 ORDER BY dc.id_servicio ASC";
		    if($stm = $conn->prepare($sql)){                
		                $stm->execute();
		                $stm->store_result();
		                $rows = $stm->num_rows;
		                $stm->bind_result($idservicio,$nombre);                
		    }

		    $sql2 = "SELECT COUNT(id_datos) FROM datos_complementarios WHERE estado=1 AND id_servicio=?";
		    $i=0;
		    if($rows>0){
		    	while($stm->fetch()){
		    		${"name".$i}=$nombre;
			    	if(${"stm".$i} = $conn->prepare($sql2)){
			                ${"stm".$i}->bind_param('i',$idservicio);
			                ${"stm".$i}->execute();
			                ${"stm".$i}->store_result();	
			                ${"rows".$i} = ${"stm".$i}->num_rows;		                
			                ${"stm".$i}->bind_result(${"total".$i}); 
			                ${"stm".$i}->fetch();			                              
			        }
			        $i++;   
		    	}
		    }
    	}elseif ($var=="constancia") {
    		$sql="SELECT DISTINCT(dc.id_constancia),c.tipo_constancia FROM datos_complementarios dc JOIN constancias c ON dc.id_constancia=c.id_constancia WHERE dc.estado=1 ORDER BY dc.id_constancia ASC";
    		if($stm = $conn->prepare($sql)){                
		                $stm->execute();
		                $stm->store_result();
		                $rows = $stm->num_rows;
		                $stm->bind_result($idconstancia,$nombre);
		    }

		    $sql2 = "SELECT COUNT(id_datos) FROM datos_complementarios WHERE estado=1 AND id_constancia=?";
		    $i=0;
		    if($rows>0){
		    	while($stm->fetch()){
		    		${"name".$i}=$nombre;
			    	if(${"stm".$i} = $conn->prepare($sql2)){
			                ${"stm".$i}->bind_param('i',$idconstancia);
			                ${"stm".$i}->execute();
			                ${"stm".$i}->store_result();
			                ${"rows".$i} = ${"stm".$i}->num_rows;
			                ${"stm".$i}->bind_result(${"total".$i});
			                ${"stm".$i}->fetch();
			        }
			        $i++;
		    	}
		    }
    	}elseif ($var=="trabajador") {
    		$sql="SELECT DISTINCT(di.id_trabajador),u.name FROM datos_iniciales di JOIN usuario u ON di.id_trabajador=u.id_user ORDER BY di.id_trabajador ASC";
    		if($stm = $conn->prepare($sql)){                
		                $stm->execute();
		                $stm->store_result();
		                $rows = $stm->num_rows;
		                $stm->bind_result($idtrabajador,$nombre);
		    }

		    $sql2="SELECT COUNT(id_datos) FROM datos_complementarios WHERE estado=1 AND id_datos IN (SELECT id_datos FROM datos_iniciales WHERE id_trabajador=?)";
		    if($rows>0){
		    	$i=0;
		    	while($stm->fetch()){
		    		${"name".$i}=$nombre;
			    	if(${"stm".$i} = $conn->prepare($sql2)){
			                ${"stm".$i}->bind_param('i',$idtrabajador);
			                ${"stm".$i}->execute();
			                ${"stm".$i}->store_result();
			                ${"rows".$i} = ${"stm".$i}->num_rows;
			                ${"stm".$i}->bind_result(${"total".$i});
			                ${"stm".$i}->fetch();
			        }
			        $i++;
		    	}
		    }
    	}
    }
?>

<!--main content start-->
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="page-head-wrap">
        <h4 class="margin0">REPORTES</h4>  
    </div>
    <div class="ui-content-body">
        <div class="ui-container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div id="contenido">
                            	<form class="form-horizontal form-variance" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Reporte Por</label>
                                        <div class="col-sm-2">
                                            <select name="tipo" id="tipo" class="form-control">
                                            	<option  value="servicio">Servicio</option>
                                            	<option  value="constancia">Tipo de Constancia</option>
                                            	<option  value="trabajador">Trabajador</option>
                                            </select>
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
            <?php if(isset($_POST['search']) && (!empty($_POST['tipo'])) ){ ?>
            			<div class="panel">
								<div class="panel-body">
									<div id="titulo">
                                		<h4>REPORTE CONSTANCIAS CREADAS POR <?php echo strtoupper($_POST['tipo']) ?></h4>
                            		</div>
									<div id="contenido" class="table-responsive">
		                                <table class="table table-striped table-condensed" id="mitable">
		                                    <thead class="thead-inverse">
		                                        <tr>
		                                        	<th  class="col-md-1" style="display:none;"></th>
		                                        	<?php for ($ind=0; $ind < $i ; $ind++) { ?>
		                                        		<th class="col-md-1"><?php echo ${"name".$ind} ?></th>	
		                                        	<?php } ?>                                            
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                        	<tr>
		                                        	<th class="col-md-1" style="display:none;"></th>
		                                        	<?php
		                                        	for ($n=0; $n < $i ; $n++) { ?>
		                                        		<td class="text-left"><?php echo ${"total".$n} ?></td>
		                                        	<?php
		                                        	}?>
		                                        	</tr>
		                                        	<?php		                                             
		                                            for ($w=0; $w < $i ; $w++) { 
		                                            	${"stm".$w}->close();
		                                            }
		                                        ?> 
		                                    </tbody>
		                                </table>
		                            </div>
		                            <div style="clear:both; margin:60px"></div>
		                            <div id="container" class="ui-container">

		                            	
		                            </div>	
	                        	</div>
                    	</div>                    
                <?php } ?>
        </div>
    </div>
</div>
<!--main content end-->

<?php
    include("../core/footer.php");
 ?>

<script>
	window.onload = function(){document.getElementById("tipo").value = "<?=$_POST['tipo']?>" }
	
    Highcharts.chart('container', {
    data: {
        table: 'mitable'
    },
    chart: {
        type: 'column'
    },
    title: {
        text:''
    },
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Cantidad'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.series.name + '</b><br/>' +
                this.point.y + ' ' + this.point.name.toLowerCase();
        }
    }
});
</script>