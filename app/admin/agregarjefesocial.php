<?php
    $title = "AGREGAR JEFE TRABAJO SOCIAL";
    
    include("../core/header.php");

    include("../core/aside.php");
?>
 <!--main content start-->
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="page-head-wrap">
        <h4 class="margin0">AGREGAR JEFE TRABAJO SOCIAL</h4>  
    </div>
    <div class="ui-content-body">
        <div class="ui-container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div id="titulo">
                            	<h4>Datos Jefe Trabajo Social</h4>
                            </div>
                            <div id="contenido">
                            	<form class="form-horizontal form-variance" method="get">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Nombre Completo</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Servicio</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="services" id="services">
                                                <option value="Odontologia">Odontologia</option>
                                                <option value="Medicina3">Medicina3</option>
                                            </select>
                                            <span class="help-block">Servicio o Especialidad del jefe de servicio</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<div class="col-sm-6 col-sm-offset-3">
                                    		<button type="submit" class="btn btn-primary">Agregar</button>
                                    	</div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--main content end-->

<?php
    include("../core/footer.php");
 ?>