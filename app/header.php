<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="shortcut icon" type="image/png" href="/imgs/favicon.png" /> -->

        <title>Constancia Medica | Home</title>

        <!-- PLUGINS -->
        <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/plugins/font-awesome/css/font-awesome.min.css">
        <!-- FIN PLUGINS -->

        <!-- ESTILOS  -->
        <link rel="stylesheet" href="../assets/css/main.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
        <!-- FIN ESTILOS -->
        <script src="../assets/js/modernizr-custom.js"></script>
        <script src="../assets/js/core.js"></script>

    </head>
    <body>
        <div id="ui" class="ui">
            <!--header start-->
            <header id="header" class="ui-header">
                <div class="navbar-header">
                    <!--logo start-->
                    <a href="index.html" class="navbar-brand">
                        <span class="logo"><img src="imgs/logo-dark.png" alt=""/></span>
                        <span class="logo-compact"><img src="imgs/logo-icon-dark.png" alt=""/></span>
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
                    <!--toggle buttons start-->
                    <ul class="nav navbar-nav">
                        <li>
                            <a class="toggle-btn" data-toggle="ui-nav" href="">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- toggle buttons end -->

                    <!--search start-->
                    <!--<form class="search-content hidden-xs" >
                        <button type="submit" name="search" class="btn srch-btn">
                            <i class="fa fa-search"></i>
                        </button>
                        <input type="text" class="form-control" name="keyword" placeholder="Search here...">
                    </form>-->
                    <!--search end-->
                    <!--notification start-->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell-o"></i>
                                <!--<span class="badge"></span>-->
                            </a>
                            <!--dropdown -->
                            <ul class="dropdown-menu dropdown-menu--responsive">
                                <div class="dropdown-header">Notificaciones</div>
                                <ul class="Notification-list Notification-list--small niceScroll list-group">
                                    
                                </ul>
                                <div class="dropdown-footer"><a href="">View more</a></div>
                            </ul>
                            <!--/ dropdown -->
                        </li>
                        <li class="dropdown dropdown-usermenu">
                            <a href="#" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <div class="user-avatar"><img src="../assets/img/user1.jpg" alt="usuario img"></div>
                                <span class="hidden-sm hidden-xs"><?php echo $_SESSION['usuario']; ?></span>
                                <!--<i class="fa fa-angle-down"></i>-->
                                <span class="caret hidden-sm hidden-xs"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                                <li><a href="login/logout.php"><i class="fa fa-sign-out"></i> Salir</a></li>
                            </ul>
                        </li>
                        <li>
                            <!--<a data-toggle="ui-aside-right" href=""><i class="glyphicon glyphicon-option-vertical"></i></a>-->
                        </li>
                    </ul>
                    <!--notification end-->

                </div>
            </header>
            <!--header end-->