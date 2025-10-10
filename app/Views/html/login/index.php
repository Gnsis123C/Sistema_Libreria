
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Muhamad Nauval Azhar">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="Bienvenido, iniciar sesión">
	<title>Iniciar sesión</title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/img/icon') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/img/icon') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/img/icon') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('assets/img/icon') ?>/site.webmanifest">
	<link href="<?= base_url('assets/bootstrap-5.3.3-dist/css/bootstrap.min.css') ?>" rel="stylesheet" >
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <style type="text/css">
        html, body {
            height: 100%;
        }

        .form-login {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .btn-cr{
            background-color: #760300;
            color: #fff;
            padding-bottom: 12px;
            transition: all 0.2s ease;
        }

        .btn-cr:hover{
            border-color: #760300;
        }
    </style>
</head>

<body class="d-flex text-center">
	<form class="form-login" id="form_usuario" method="post" action="<?= base_url(route_to('iniciar')) ?>">
        <?= csrf_field() ?>
        <img src="<?= base_url('assets/img/logolibreria.png') ?>" class="mb-3" width="90" height="90">
        </svg>

        <h1 class="h3 mb-3 font-weight-normal">Hola, ingresa tus credenciales</h1>
        <!-- 'sr-only' will hide the text : 'Email Address'. So, 'Email Address' will be invisible -->
        <label for="usuario_text" class="sr-only d-none">Usuario</label>

        <div class="form-group mx-auto my-4" >
            <div id="alerta" class="alert alert-danger alert-dismissible" style="<?php if (session('mensaje')): ?>
                display: block;
            <?php else: ?>
                display: none;
            <?php endif ?>" role="alert">
                <!--<a href="#" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>-->
                <div id="alerta_texto"><?= session('mensaje') ?></div>
            </div>
        </div>

        <!-- 'autofocus' will highlight the input column initially -->
        <input 
            type="text" 
            id="usuario_text"
            name="usuario_text"
            class="form-control mb-2"
            placeholder="Ingrese su usuario"
            required
            autofocus
        >
        <!-- 'sr-only' will hide the text : 'Password'. So, 'Password' will be invisible -->
        <label for="usuario_pass" class="sr-only d-none">Password</label>
        <div class="input-group mb-2">
            <input 
                type="password" 
                id="usuario_pass"
                name="usuario_pass"
                class="form-control"
                placeholder="Ingrese su contraseña"
                required
            >
          <button class="btn btn-outline-secondary" id="btn-eye-pass" type="button"><i class="bi bi-eye"></i></button>
        </div>

        <div class="d-grid gap-2 mt-4">
            <!-- 'btn-block' will make the button wider -->
            <button class="btn btn-lg btn-cr btn-block" type="submit">
                Ingresar
            </button>
        </div>
        
    </form>

	<script src="<?= base_url('assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/jquery-3.7.1.min.js') ?>"></script>
    <script type="text/javascript">
        $(function(){
            var msj = {
                alert: function(mensaje) {
                    $('#alerta_texto').html('<span class="fa fa-warning"></span>  ' + mensaje);
                    if ($('#alerta').is(':hidden')) {
                        $('#alerta').toggle('slow');
                    }
                    setTimeout(function() {
                        $('#alerta').toggle('slow');
                    }, 2500);
                }
            }

            $('#form_usuario').submit(function(e) {
                let btn = $('#form_usuario button[type="submit"]');
                btn.prop("disabled", true)
                let user = $(this).find('#usuario_text').val();
                let pass = $(this).find('#usuario_ass').val();
                if(user == '' || pass==''){
                    msj.alert('Debe ingresar un usuario o contraseña');
                    e.preventDefault();
                }else{
                    btn.prop("disabled", true)
                }
            });

            $('#btn-eye-pass').click(function(e) {
                let btn = $(this);
                let input = $("#usuario_pass");
                if(input.attr("type") && input.attr("type") == "text"){
                    input.attr("type", "password");
                }else{
                    input.attr("type", "text");
                }
            });
        });
    </script>
</body>
</html>