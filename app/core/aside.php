<!--sidebar start-->
<aside id="aside" class="ui-aside ui-aside--light">
    <ul class="nav" ui-nav id="mimenu">
        
        <?php switch ($_SESSION['tipousuario']) {
			case '1':
			# MENU SECRETARIA 
		?>
        <li id="inicio"><a href=""><i class="fa fa-home"></i><span> INICIO </span></a></li>
		<li id="crearsolicitud"><a href=""><i class="fa fa-file-text-o"></i><span>Crear Solicitud</span></a></li>
        <li id="pendienteenvio"><a href=""><i class="fa fa-share-square-o"></i><span>Pendiente de Envio</span></a></li>
        <li id="pendienterevision"><a href=""><i class="fa fa-inbox"></i><span>Pendiente de Revision</span></a></li>
		<?php
				break;
			case '2':
				# MENU TRABAJADOR
		?>
        <li><a href=""><i class="fa fa-home"></i><span> INICIO </span></a></li>
		<li><a href=""><i class="fa fa-inbox"></i><span>Recibidos</span></a></li>
        <li><a href=""><i class="fa fa-clock-o "></i><span>Pendiente</span></a></li>
        <li><a href=""><i class="fa fa-check-square-o "></i><span>Finalizado</span></a>           </li>
        <li><a href=""><i class="fa fa-pencil-square-o "></i><span>Modificación</span></a></li>
		<?php		
				break;
			case '3':
		?>
        <li id="inicio"><a href="../admin/"><i class="fa fa-home"></i><span> INICIO </span></a></li>
		<li id="trabajadores" class="active">
            <a href=""><i class="fa fa-user"></i><span>Trabajadores</span><i class="fa fa-angle-right pull-right"></i></a>
            <ul class="nav nav-sub">
                <li id="agregar"><a href="../admin/agregartrabajador.php"><span>Agregar</span></a></li>
                <li id="admin"><a href="../admin/admintrabajador.php"><span>Administrar</span></a></li>
            </ul>
        </li>
        <li id="medicos">
            <a href=""><i class="fa fa-user-md"></i><span>Medicos</span><i class="fa fa-angle-right pull-right"></i></a>
            <ul class="nav nav-sub">
                <li id="agregar"><a href="#"><span>Agregar</span></a></li>
                <li id="admin"><a href="#"><span>Administrar</span></a></li>
            </ul>
        </li>
        <li id="jefes">
            <a href=""><i class="fa fa-user-md"></i><span>Jefes de Servicio</span><i class="fa fa-angle-right pull-right"></i></a>
            <ul class="nav nav-sub">
                <li id="agregar"><a href="#"><span>Agregar</span></a></li>
                <li id="admin"><a href="#"><span>Administrar</span></a></li>
            </ul>
        </li>
        <li id="directores">
            <a href=""><i class="fa fa-user-md"></i><span>Directores</span><i class="fa fa-angle-right pull-right"></i></a>
            <ul class="nav nav-sub">
                <li id="agregar"><a href="#"><span>Agregar</span></a></li>
                <li id="admin"><a href="#"><span>Administrar</span></a></li>
            </ul>
        </li>
        <li id="precio">
            <a href=""><i class="fa fa-usd"></i><span>Precio</span></a> 
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