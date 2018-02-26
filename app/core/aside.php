<!--sidebar start-->
<?php 

?>
<aside id="aside" class="ui-aside ui-aside--light">
    <ul class="nav" ui-nav id="mimenu">
        
        <?php switch ($_SESSION['tipousuario']) {
			case '1':
			# MENU SECRETARIA
             include("../../config/database.php");
             $sqlpendientes = "SELECT COUNT(*) as pendientesenvio FROM datos_iniciales WHERE id_estado=1 AND id_trabajador=?";
             if($stmspendientes = $conn->prepare($sqlpendientes)){
                $stmspendientes->bind_param('s',$_SESSION['id_usuario']);
                $stmspendientes->execute();
                $stmspendientes->bind_result($mispendientes);
                $stmspendientes->fetch();
                $stmspendientes->close();
             }

             $sqlrevision = "SELECT COUNT(*) as pendientesenvio FROM datos_iniciales WHERE id_estado=4";
             if($stmtrevision = $conn->prepare($sqlrevision)){
                $stmtrevision->execute();
                $stmtrevision->bind_result($mispendientesrev);
                $stmtrevision->fetch();
                $stmtrevision->close();
             }
             $conn->close();
		?>
        <li id="inicio"><a href="../secretaria/"><i class="fa fa-home"></i><span> INICIO </span></a></li>
		<li id="crearsolicitud"><a href="../secretaria/crearsolicitud.php"><i class="fa fa-file-text-o"></i><span>Crear Solicitud</span></a></li>
        <li id="pendienteenvio"><a href="../secretaria/pendienteenvio.php"><i class="fa fa-share-square-o"></i><span>Pendiente de Envio<small class="label label-info"><?php echo $mispendientes; ?></small></span></a></li>
        <li id="pendienterevision"><a href="../secretaria/pendienterevision.php"><i class="fa fa-inbox"></i><span>Pendiente de Revision<small class="label label-danger"><?php echo $mispendientesrev; ?></small></span></a></li>
		<?php
				break;
			case '2':
				# MENU TRABAJADOR
		?>
        <li id="inicio"><a href="../trabajador/"><i class="fa fa-home"></i><span> INICIO </span></a></li>
		<li id="recibidos"><a href="../trabajador/recibidos.php"><i class="fa fa-inbox"></i><span>Recibidos</span></a></li>
        <li id="pendientes"><a href="../trabajador/pendientes.php"><i class="fa fa-clock-o "></i><span>Pendiente</span></a></li>
        <li id="modificacion"><a href="#"><i class="fa fa-pencil-square-o "></i><span>Modificación</span></a></li>
		<?php		
				break;
			case '3':
		?>
        <li id="inicio"><a href="../admin/"><i class="fa fa-home"></i><span> INICIO </span></a></li>
		<li id="trabajadores">
            <a href=""><i class="fa fa-user"></i><span>Usuarios</span><i class="fa fa-angle-right pull-right"></i></a>
            <ul class="nav nav-sub">
                <li id="agregar"><a href="../admin/agregartrabajador.php"><span>Agregar</span></a></li>
                <li id="admin"><a href="../admin/admintrabajador.php"><span>Administrar</span></a></li>
            </ul>
        </li>
        <li id="medicos">
            <a href=""><i class="fa fa-user-md"></i><span>Medicos</span><i class="fa fa-angle-right pull-right"></i></a>
            <ul class="nav nav-sub">
                <li id="agregar"><a href="../admin/agregarmedico.php"><span>Agregar</span></a></li>
                <li id="admin"><a href="../admin/adminmedico.php"><span>Administrar</span></a></li>
            </ul>
        </li>
        <li id="jefes">
            <a href=""><i class="fa fa-user-md"></i><span>Jefes de Servicio</span><i class="fa fa-angle-right pull-right"></i></a>
            <ul class="nav nav-sub">
                <li id="agregar"><a href="../admin/agregarjefeservicio.php"><span>Agregar</span></a></li>
                <li id="admin"><a href="../admin/adminjefeservicio.php"><span>Administrar</span></a></li>
            </ul>
        </li>
        <li id="directores">
            <a href=""><i class="fa fa-user-md"></i><span>Directores</span><i class="fa fa-angle-right pull-right"></i></a>
            <ul class="nav nav-sub">
                <li id="agregar"><a href="../admin/agregardirector.php"><span>Agregar</span></a></li>
                <li id="admin"><a href="../admin/admindirector.php"><span>Administrar</span></a></li>
            </ul>
        </li>
        <li id="jefesocial">
            <a href=""><i class="fa fa-user-md"></i><span>Jefe Trabajo Social</span><i class="fa fa-angle-right pull-right"></i></a>
            <ul class="nav nav-sub">
                <li id="agregar"><a href="../admin/agregarjefesocial.php"><span>Agregar</span></a></li>
                <li id="admin"><a href="../admin/adminjefesocial.php"><span>Administrar</span></a></li>
            </ul>
        </li>
        <li id="precio">
            <a href="../admin/adminprecios.php"><i class="fa fa-usd"></i><span>Precio</span></a> 
        </li>
		<?php
				break;
			default:
				# code...
				break;
		} ?>
    </ul>
</aside>


<!--sidebar end-->