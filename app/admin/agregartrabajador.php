<?php
    $title = "AGREGAR TRABAJADOR";
    
    include("../core/header.php");

    include("../core/aside.php");
?>
 <!--main content start-->
<div id="content" class="ui-content ui-content-aside-overlay">
    <div class="page-head-wrap">
        <h4 class="margin0">AGREGAR TRABAJADOR</h4>  
    </div>
    <div class="ui-content-body">
        <div class="ui-container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div id="titulo">
                            	<h4>Datos Trabajador</h4>
                            </div>
                            <div id="contenido">
                            	<form class="form-horizontal form-variance" method="get">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Default</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Help text</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="text">
                                            <span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
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
 <script>
 	$('#mimenu li').removeClass('active');
 	$('#mimenu li ul').removeClass('nav-sub--open');
 	$('#mimenu li ul li').removeClass('active');
 	$('#trabajadores').addClass('active');
 	$('#trabajadores ul').addClass('nav-sub--open');
 	$('#trabajadores ul #agregar').addClass('active');
 </script>