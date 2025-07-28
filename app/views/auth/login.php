<?php
function base_url($ruta = '') {
    return '/System_RapiExpress/public/' . ltrim($ruta, '/');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>RapiExpress - Login</title>
    <link rel="icon" href="<?= base_url('assets/img/logo-rapi.ico') ?>" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/core.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/icon-font.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-page">

<div class="login-header box-shadow">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="brand-logo">
            <a href="#"><img src="<?= base_url('assets/img/logo.png') ?>" alt="RapiExpress Logo" /></a>
        </div>
    </div>
</div>

<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="<?= base_url('assets/img/login-page-img.png') ?>" alt="Imagen de login" />
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title">
                        <h2 class="text-center text-primary">Login RapiExpress</h2>
                    </div>

                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                        <?php if (isset($error)): ?>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: '<?= addslashes($error) ?>'
                                    });
                                });
                            </script>
                        <?php endif; ?>

                        <?php if (isset($success)): ?>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Éxito',
                                        text: '<?= addslashes($success) ?>'
                                    });
                                });
                            </script>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form id="loginForm" method="POST" action="#" onsubmit="return false;">
                        <div class="input-group custom">
                            <input name="Username" class="form-control form-control-lg" placeholder="Usuario" required>
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                            </div>
                        </div>

                        <div class="input-group custom mb-4">
                            <input name="Password" type="password" class="form-control form-control-lg password-input" placeholder="Contraseña" required>
                            <div class="input-group-append custom toggle-password" style="cursor: pointer;">
                                <span class="input-group-text"><i class="fa fa-eye"></i></span>
                            </div>
                        </div>

                        <div class="row pb-30">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <div class="forgot-password">
                                    <a href="index.php?c=auth&a=recoverPassword">¿Olvidaste tu contraseña?</a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="btnLogin">
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="spinnerLogin"></span>
                                        <span id="btnText">Entrar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="<?= base_url('assets/js/sweetalert2.js') ?>"></script>
<script src="<?= base_url('assets/js/password_view.js') ?>"></script>
<script src="<?= base_url('assets/js/core.js') ?>"></script>
<script src="<?= base_url('assets/js/script.min.js') ?>"></script>
<script src="<?= base_url('assets/js/layout-settings.js') ?>"></script>
<script src="<?= base_url('assets/js/script.js') ?>"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        $('#btnLogin').attr('disabled', true);
        $('#spinnerLogin').removeClass('d-none');
        $('#btnText').text('Entrando...');

        $.ajax({
            type: 'POST',
            url: 'index.php?c=auth&a=login',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                $('#btnLogin').attr('disabled', false);
                $('#spinnerLogin').addClass('d-none');
                $('#btnText').text('Entrar');

                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'index.php?c=dashboard&a=index';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                $('#btnLogin').attr('disabled', false);
                $('#spinnerLogin').addClass('d-none');
                $('#btnText').text('Entrar');

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud.'
                });
            }
        });
    });
});
</script>

</body>
</html>
