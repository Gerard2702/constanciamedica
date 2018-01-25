<!--sidebar start-->
<aside id="aside" class="ui-aside">
    <ul class="nav" ui-nav>
        <li class="active">
            <a href=""><i class="fa fa-home"></i><span> INICIO </span></a>
        </li>
        <?php switch ($_SESSION['tipousuario']) {
			case '1':
			# MENU SECRETARIA 
		?>
		<li>
            <a href=""><i class="fa fa-envelope-o"></i><span> Crear Solicitud</span></a>
            <a href=""><i class="fa fa-envelope-o"></i><span> Pendiente de Envio</span></a>
            <a href=""><i class="fa fa-envelope-o"></i><span> Pendiente de Revision</span></a>
        </li>
		<?php
				break;
			case '2':
				# MENU TRABAJADOR
		?>
		<li>
            <a href=""><i class="fa fa-inbox"></i><span> Recibidos</span></a>
            <a href=""><i class="fa fa-clock-o "></i><span> Pendiente</span></a>
            <a href=""><i class="fa fa-check-square-o "></i><span> Finalizado</span></a>
            <a href=""><i class="fa fa-envelope-o"></i><span> Modificación</span></a>
        </li>
		<?php		
				break;
			case '3':
				# code...
				break;
			default:
				# code...
				break;
		} ?>
    </ul>
</aside>


<!--sidebar end-->