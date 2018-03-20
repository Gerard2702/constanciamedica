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
        <link href="https://fonts.googleapis.com/css?family=Roboto:500" rel="stylesheet">
        <!-- FIN ESTILOS -->

        <script src="assets/js/core.js"></script>
    </head>
    <body id="milogin">
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
                    <p id="mensaje" class="text-error"></p>
                    <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                </form>
                
            </div>
        </div>
        <!-- inject:js -->
        <script src="assets/js/jquery-3.3.1.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/nicescroll.min.js"></script>
        <script >
            $('#mensaje').hide();
            function getParameterByName(name) {
                name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
                return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
            }
            var error = getParameterByName('error');
            if(error == 1){
                $('#mensaje').html('Error! Contraseña incorrecta.').show();
            }
            if(error == 2){
                $('#mensaje').html('Error! No existe el usuario.').show();
            }
        </script>
        <!-- endinject -->

    </body>
</html>