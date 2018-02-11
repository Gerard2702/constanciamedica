<?php
    $title = "AGREGAR TRABAJADOR";
    
    include("../core/header.php");

    include("../core/aside.php");

    include("../../config/database.php");

    $sql2 = "SELECT nombre_servicio FROM servicios";
    if($stmt2 = $conn->prepare($sql2)){
        $stmt2 ->execute();
        $stmt2->store_result();
        $rows2 = $stmt2->num_rows;
        $stmt2 ->bind_result($servicesname);
    }

    $sql4 = "SELECT nombre_tipo FROM tipo_usuario";
    if($stmt4 = $conn->prepare($sql4)){
        $stmt4 ->execute();
        $stmt4->store_result();
        $rows4 = $stmt4->num_rows;
        $stmt4 ->bind_result($usuariotipo);
    }
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
                            	<form class="form-horizontal form-variance" method="POST" action="../class/admin/agregartrabajador.php">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Nombre</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="nombre" name="nombre" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Usuario</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="usuario" name="usuario" type="text" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Contraseña</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" id="pass" name="pass" type="password" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Tipo Usuario</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="tipouser" id="tipouser" required="">
                                                 <?php 
                                                    if($rows4>0) {
                                                        while ($stmt4->fetch()) {?>
                                                                <option value="<?php echo $usuariotipo ?>"><?php echo $usuariotipo; ?></option>
                                                           <?php                                                         
                                                        }
                                                    }
                                                    $stmt4->close();
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Servicio Asignado</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="servicio" id="servicio" required="">
                                                <?php 
                                                    if($rows2>0) {
                                                        while ($stmt2->fetch()) {?>
                                                            <option value="<?php echo $servicesname ?>"><?php echo $servicesname; ?></option>                                                           
                                                            <?php  
                                                        } 
                                                    }
                                                    $stmt2->close();
                                                    ?>
                                            </select>
                                            <span class="help-block">Servicio o Especialidad a la que pertenece</span>
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
 