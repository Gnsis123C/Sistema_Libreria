<?= $this->extend('plantilla/layout') ?>

<?= $this->section('titulo') ?>
<?= $pagina ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/formvalidation/css/formValidation.css" />

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2.min.css" />
<link rel="stylesheet" type="text/css"
    href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap-3/select2-bootstrap.css" />
<link rel="stylesheet" type="text/css"
    href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap4.min.css" />
<style>
    #form_ {
        max-width: 500px;
        /* margin-left: auto;
        margin-right: auto; */
        display: block;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-4">
  <h1 class="display-6 fw-bold mb-2 text-dark">
    M. Usuarios
  </h1>
</div>
<!--begin::Row-->
<div class="row">
    <div class="col-12 px-0 px-sm-3">
        <!-- <div class="mb-5">
            <p class="text-muted h6 fw-light">
                <?= $subtitulo ?? $titulo ?>
            </p>
        </div> -->
        <!-- Tables Row -->
        <div class="row g-4">
            <div class="col-xl-12">
                <div class=" rounded-0 border-0 py-2">
                    <div class=" py-2">
                        <form class="p-4 border rounded-2 bg-white" id="form_" autocomplete="off">
                            <?= $this->include('plantilla/form/html') ?>
                            
                            <div id="alert-msg-general" class="alert alert-danger alert-dismissible fade show mt-4 d-none" role="alert">
                                <div id="messages" class="d-flex flex-column"></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Row-->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!--formvalidation-->
<script src="<?= base_url() ?>/assets/plugins/formvalidation/js/formValidation.js" type="text/javascript"></script>
<script src="<?= base_url() ?>/assets/plugins/formvalidation/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?= base_url() ?>/assets/plugins/cedulayruc.js" type="text/javascript"></script>
<script src="<?= base_url() ?>/assets/plugins/formvalidation/js/framework/bootstrap.js" type="text/javascript"></script>
<script src="<?= base_url() ?>/assets/plugins/formvalidation/js/language/es_ES.js" type="text/javascript"></script>

<script src="<?= base_url() ?>/assets/plugins/select2/dist/js/select2.full.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/select2/dist/js/i18n/es.js"></script>
<?= $this->include('plantilla/form/javascript') ?>
<script type="text/javascript">
    $(function() {
            // ==========================
            // Módulo de utilidades
            // ==========================
            const UI = {
                toggleForm: function(disabled) {
                    $('#form_').find('input, textarea, button, select').prop('disabled', disabled);
                },
                toggleBotones: function(estado) {
                    // estado: 0 => ambos deshabilitados | 1 => habilitados | >1 => solo eliminar habilitado
                    $('#editar').prop('disabled', !(estado === 1));
                    $('#eliminar').prop('disabled', !(estado === 1 || estado > 1));
                },
                loading: function(isLoading) {
                    $('#caption').html(isLoading ? 'Guardando...' : 'Guardar');
                    $('#loading').toggleClass('fa-save', !isLoading)
                        .toggleClass('fa-refresh fa-spin', isLoading);
                },
                showError: function(msg) {
                    toastr.error("Existe un error", msg);
                    UI.toggleForm(false);
                    $('#form_').data('formValidation').resetForm();
                    UI.loading(false);
                    UI.toggleBotones(0);
                },
                showSuccess: function(msg) {
                    toastr.success("Proceso terminado", msg);
                },
                showToast: function(mensaje, accion) {
                    $('#mensaje').html(mensaje);
                    $('#accion-text').html(accion);
                    $('.toast').toast('show');
                }
            };

            // ==========================
            // AJAX
            // ==========================
            const API = {
                enviar: function(data) {
                    return $.ajax({
                        url: '<?= base_url(route_to('persona.actions', $pagina)) ?>',
                        type: 'POST',
                        data: data,
                        dataType: 'JSON',
                        beforeSend: function() {
                            UI.toggleForm(true);
                            UI.loading(true);
                        }
                    });
                }
            };

            // ==========================
            // Inicializar FormValidation
            // ==========================
            function initForm() {
                FormValidation.Validator.ValidarCedula = {
                    validate: function(validator, $field) {
                        const value = $field.val();
                        <?php if($pagina == 'cliente'){ ?>
                            if (!isNaN(value) && value.length === 10 && value !== '0000000000') {
                                return $.cedula(value);
                            }
                        <?php }else if($pagina == 'proveedor'){ ?>
                            if (!isNaN(value) && value.length === 13 && value !== '0000000000000') {
                                return $.ruc(value);
                            }
                        <?php } ?>
                        
                        return true;
                    }
                };

                return $('#form_')
                    .on('init.field.fv', function(e, data) {
                        // lugar para mensajes custom por campo si deseas
                    })
                    .on('err.field.fv', function(e, data) {
                        $('#alert-msg-general').removeClass('d-none');
                    })
                    .on('success.field.fv', function(e, data) {
                        $('#alert-msg-general').addClass('d-none');
                    })
                    .formValidation({
                        framework: 'bootstrap',err: {
                            container: '#messages'
                        },
                        icon: {
                            valid: 'bi bi-check',
                            invalid: 'bi bi-x',
                            validating: 'bi bi-arrow-repeat bi-spin'
                        },
                        fields: {
                            cedula_ruc: {
                                validators: {
                                    notEmpty: {
                                        message: 'Por favor introduce un valor'
                                    },
                                    ValidarCedula: {
                                        message: 'El documento de identificación ingresado no es correcto.'
                                    },
                                    stringLength: {
                                        min: 10,
                                        max: 13
                                    },
                                    remote: {
                                        message: 'La cédula ya se encuentra registrada',
                                        url: '<?= base_url(route_to('persona.validar.cedula_ruc')) ?>',
                                        type: 'GET',
                                        data: function(validator) {
                                            return {
                                                "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                                                cedula_ruc: validator.getFieldElements('cedula_ruc').val(),
                                                id: validator.getFieldElements('id').val() || 0
                                            };
                                        }
                                    }
                                }
                            },
                            email: {
                                validators: {
                                    notEmpty: {
                                        message: 'Por favor introduce un valor'
                                    },
                                    stringLength: {
                                        min: 5,
                                        max: 50
                                    },
                                    
                                }
                            },
                            nombre_completo: {
                                validators: {
                                    notEmpty: {
                                        message: 'Por favor introduce un valor'
                                    },
                                    stringLength: {
                                        min: 2,
                                        max: 50
                                    },
                                    remote: {
                                        message: 'El nombre ya se encuentra registrado',
                                        url: '<?= base_url(route_to('persona.validar.nombre')) ?>',
                                        type: 'GET',
                                        data: function(validator) {
                                            return {
                                                "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                                                nombre_completo: validator.getFieldElements('nombre_completo').val(),
                                                id: validator.getFieldElements('id').val() || 0
                                            };
                                        }
                                    }
                                }
                            },
                        }
                    });
            }

            // ==========================
            // Eventos principales
            // ==========================
            const form = initForm();

            form.on('success.form.fv', function(e) {
                e.preventDefault();
                const $form = $(e.target);

                API.enviar($form.serialize())
                    .done(function(data) {
                        if (data.resp) {
                            UI.showSuccess("Tus datos fueron guardados");
                            setTimeout(() => window.location = '<?= base_url(route_to('persona', $pagina)) ?>', 2500);
                        } else {
                            UI.showError(data.error);
                        }
                    })
                    .fail(function() {
                        UI.showError('Tus datos no fueron guardados');
                    });
            });

            $('#cancelar').on('click', function() {
                window.location = '<?= base_url(route_to('persona', $pagina)) ?>';
            });
        });
</script>

<?= $this->endSection() ?>