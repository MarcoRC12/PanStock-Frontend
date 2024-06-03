<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="icon" href="img/logo-app.jpg">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="lib/alertifyjs/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="lib/alertifyjs/css/themes/default.css">
    <link rel="stylesheet" type="text/css" href="lib/select2/css/select2.css">
</head>

<body style="background-image: url('img/pan-header-bg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;" class="bg-info">
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h2 class="text-center font-weight-light my-4">Iniciar Sesión</h2>
                    </div>
                    <form id="loginForm" class="col-xl-8 offset-2"> <br>
                        <div class="form-group">
                            <label for="username">Usuario</label>
                            <input type="text" class="form-control" id="username" name="us_usu" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="us_pas" required>
                        </div><br>
                        <div class="form-check mb-3">
                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                            <label class="form-check-label" for="inputRememberPassword">Recordar Contraseña</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                            <button type="submit" class="btn btn-success">Ingresar</button>
                        </div><br>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="lib/jquery-3.7.1.min.js"></script>
    <script src="lib/alertifyjs/alertify.js"></script>
    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script src="lib/select2/js/select2.js"></script>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(event) {
                event.preventDefault();
                var username = $('#username').val();
                var password = $('#password').val();

                $.ajax({
                    url: 'class/Usuarios.php',
                    type: 'POST',
                    data: {
                        us_usu: username,
                        us_pas: password
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alertify.success(response.message);
                            // Redireccionar a la página de inicio
                            window.location.href = 'view/home.php';
                        } else {
                            alertify.error(response.message);
                        }
                    },
                    error: function() {
                        alertify.error('Error al realizar la solicitud');
                    }
                });
            });
        });
    </script>
</body>

</html>
