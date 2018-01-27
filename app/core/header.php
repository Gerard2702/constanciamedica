<?php 
    session_start(); 
    include("../login/verificar.php");
 ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="shortcut icon" type="image/png" href="/imgs/favicon.png" /> -->

        <title>Constancia Medica | <?php echo $title; ?></title>

        <!-- PLUGINS -->
        <link rel="stylesheet" href="../../assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../assets/plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css"/>
 
        
        <!-- FIN PLUGINS -->

        <!-- ESTILOS  -->
        <link rel="stylesheet" href="../../assets/css/main.css">
        <link rel="stylesheet" href="../../assets/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="stylesheet">
        <!-- FIN ESTILOS -->
        <script src="../../assets/js/modernizr-custom.js"></script>
        <script src="../../assets/js/core.js"></script>


    </head>
    <body>
        <div id="ui" class="ui">
            <!--header start-->
            <header id="header" class="ui-header ui-header--blue text-white">
                <div class="navbar-header">
                    <!--logo start-->
                    <a href="index.html" class="navbar-brand">
                        <span class="logo"></span>
                        <span class="logo-compact"></span>
                    </a>
                    <!--logo end-->
                </div>
                <div class="search-dropdown dropdown pull-right visible-xs">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-search"></i></button>
                    <div class="dropdown-menu">
                        <form >
                            <input class="form-control" placeholder="Search here..." type="text">
                        </form>
                    </div>
                </div>
                <div class="navbar-collapse nav-responsive-disabled">
                    <ul class="nav navbar-nav">
                        <li>
                            <a class="toggle-btn" data-toggle="ui-nav" href="">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell-o"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu--responsive">
                                <div class="dropdown-header">Notificaciones</div>
                                <ul class="Notification-list Notification-list--small niceScroll list-group">
                                    
                                </ul>
                                <div class="dropdown-footer"><a href="">Ver más</a></div>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-usermenu">
                            <a href="#" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <div class="user-avatar"><img src="../../assets/img/edit-user.png" alt="usuario img"></div>
                                <span class="hidden-sm hidden-xs"><?php echo $_SESSION['usuario']; ?></span>
                                <!--<i class="fa fa-angle-down"></i>-->
                                <span class="caret hidden-sm hidden-xs"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                                <li><a href="../login/logout.php"><i class="fa fa-sign-out"></i> Salir</a></li>
                            </ul>
                        </li>
                        <li>
                        </li>
                    </ul>
                </div>
            </header>
            <!--header end-->