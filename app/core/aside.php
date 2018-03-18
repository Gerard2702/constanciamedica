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
        <li id="pendienteenvio"><a href="../secretaria/pendienteenvio.php"><i class="fa fa-share-square-o"></i><span>Pendiente de Envio <?php if($mispendientes>0){ ?><small class="label label-danger"><?php echo $mispendientes; ?></small><?php } ?></span></a></li>
        <li id="pendienterevision"><a href="../secretaria/pendienterevision.php"><i class="fa fa-inbox"></i><span>Pendiente de Revision <?php if($mispendientesrev>0){ ?><small class="label label-danger"><?php echo $mispendientesrev; ?></small><?php } ?></span></a></li>
        <li id="terminadas"><a href="../secretaria/terminadas.php"><i class="fa fa-check-circle "></i><span>Terminadas</span></a></li>
        <li id="buscarsolicitud"><a href="../secretaria/buscarsolicitud.php"><i class="fa fa-search"></i><span>Buscar Constancias</span></a></li>
        <li id="reporteria"><a href="../secretaria/Reporte.php"><i class="fa fa-file-excel-o"></i><span>Reporte</span></a></li>
		<?php
				break;
			case '2':
				# MENU TRABAJADOR
            include("../../config/database.php");
             $sqlpendientes = "SELECT COUNT(*) as pendientesenvio FROM datos_iniciales WHERE id_estado=2 AND id_servicio=?";
             if($stmspendientes = $conn->prepare($sqlpendientes)){
                $stmspendientes->bind_param('s',$_SESSION['id_servicio']);
                $stmspendientes->execute();
                $stmspendientes->bind_result($mispendientesrec);
                $stmspendientes->fetch();
                $stmspendientes->close();
             }
             $sqlpendientes2 = "SELECT COUNT(*) as pendientesenvio FROM datos_iniciales WHERE id_estado=3 AND id_trabajador=?";
             if($stmspendientes2 = $conn->prepare($sqlpendientes2)){
                $stmspendientes2->bind_param('s',$_SESSION['id_usuario']);
                $stmspendientes2->execute();
                $stmspendientes2->bind_result($mispendientes);
                $stmspendientes2->fetch();
                $stmspendientes2->close();
             }

             $sqledicion = "SELECT COUNT(*) as pendientesenvio FROM datos_iniciales WHERE id_estado=5 AND id_trabajador=?";
             if($stmtedicion = $conn->prepare($sqledicion)){
                $stmtedicion->bind_param('s',$_SESSION['id_usuario']);
                $stmtedicion->execute();
                $stmtedicion->bind_result($mispendientesedi);
                $stmtedicion->fetch();
                $stmtedicion->close();
             }
             $conn->close();
		?>
        <li id="inicio"><a href="../trabajador/"><i class="fa fa-home"></i><span> INICIO </span></a></li>
		<li id="recibidos"><a href="../trabajador/recibidos.php"><i class="fa fa-inbox"></i><span>Recibidos<?php if($mispendientesrec>0){ ?><small class="label label-danger"><?php echo $mispendientesrec; ?></small><?php } ?></span></a></li>
        <li id="pendientes"><a href="../trabajador/pendientes.php"><i class="fa fa-clock-o "></i><span>Pendientes<?php if($mispendientes>0){ ?><small class="label label-danger"><?php echo $mispendientes; ?></small><?php } ?></span></a></li>
        <li id="modificacion"><a href="../trabajador/modificacion.php"><i class="fa fa-pencil-square-o "></i><span>Modificación<?php if($mispendientesedi>0){ ?><small class="label label-danger"><?php echo $mispendientesedi; ?></small><?php } ?></span></a></li>
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
         <li id="reporteria">
            <a href="../admin/Reporte.php"><i class="fa fa-bar-chart"></i><span>Reportes</span></a> 
        </li>
		<?php
				break;
            case '4':
        ?>
        <li id="inicio"><a href="../jefe/"><i class="fa fa-home"></i><span> INICIO </span></a></li>
        <li id="revision"><a href="../jefe/revision.php"><i class="fa fa-inbox"></i><span>Revisión</span></a></li>
        <?php 
                break;
            case '5':
        ?>
        <li id="inicio"><a href="../jefesocial/"><i class="fa fa-home"></i><span> INICIO </span></a></li>
        <li id="revision"><a href="../jefesocial/revision.php"><i class="fa fa-inbox"></i><span>Revisión</span></a></li>
        <?php
                # code...
                break;
			default:
				# code...
				break;
		} ?>
    </ul>
</aside>


<!--sidebar end-->