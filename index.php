<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="shortcut icon" type="image/png" href="/imgs/favicon.png" /> -->
        <title>Constancia Medica | Inicio Sesion</title>

        <!-- PLUGINS -->
        <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
        <!-- FIN PLUGINS -->

        <!-- ESTILOS  -->
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet"> 
        <!-- FIN ESTILOS -->

        <script src="assets/js/core.js"></script>
    </head>
    <body>
        <div class="sign-in-wrapper">
            <div class="sign-container">
                <div class="text-center">
                    <!--<h2 class="logo"><img src="imgs/logo-dark.png" width="130px" alt=""/></h2>-->
                    <h2><strong>Constancia Medica</strong></h2>
                    <h4>Iniciar sesión</h4>
                </div>

                <form class="sign-in-form" action="app/login/login.php" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" name="usuario" placeholder="Usuario" required="">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="clave" placeholder="Contraseña" required="">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                    <!--<div class="text-center help-block">
                        <a href="forgot-password.html"><small>Forgot password?</small></a>
                        <p class="text-muted help-block"><small>Do not have an account?</small></p>
                    </div>
                    <a class="btn btn-md btn-default btn-block" href="registration.html">Create an account</a>
                </form>
                <div class="text-center copyright-txt">
                    <small>Bootkit - Copyright © 2017</small>
                </div>-->
            </div>
        </div>

        <!-- inject:js -->
        <script src="assets/js/jquery-3.3.1.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/nicescroll.min.js"></script>
        <script src=""></script>
        <!-- endinject -->

    </body>
</html>