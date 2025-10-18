<?= $this->extend('plantilla/layout') ?>

<?= $this->section('titulo') ?>
<?= $pagina ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/formvalidation/css/formValidation.css" />

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap-3/select2-bootstrap.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap4.min.css" />

<!-- File input -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/bootstrap-fileinput/css/fileinput.min.css" />

<style>
    #form_ {
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        display: block;
    }

    #cancelar{
      display: none;
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
        <div class="mb-5">
            <p class="text-muted h6 fw-light">
                <?= $subtitulo ?? $titulo ?>
            </p>
        </div>
        <!-- Tables Row -->
        <div class="row g-4">
            <div class="col-xl-12">
                <div class="card rounded-0 border-0 py-5">
                    <div class="card-body py-2">
                        <form class="p-4 border rounded-2" id="form_" autocomplete="off">
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


<script src="<?= base_url() ?>/assets/plugins/bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/bootstrap-fileinput/js/locales/es.js"></script>
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
            const formDataGlobal = new FormData();
            const API = {
                enviar: function(data, fileInputId = 'logo') {
                    var objData = new URLSearchParams(data);
                    objData.forEach(function (value, key) {
                        formDataGlobal.append(key, value);
                    });

                    // Agregar la imagen del fileinput si existe
                    if (fileInputId) {
                        const fileInput = document.getElementById(fileInputId);
                        if (fileInput && fileInput.files.length > 0) {
                            formDataGlobal.append('logo', fileInput.files[0]);
                        }
                    }

                    return $.ajax({
                        url: '<?= base_url(route_to('empresa.actions')) ?>',
                        type: 'POST',
                        data: formDataGlobal,
                        cache: false,
                        contentType: false,
                        processData: false,
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
                        if (!isNaN(value) && value.length === 10 && value !== '0000000000') {
                            return $.cedula(value);
                        }
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
                            
                            // cedula: {
                            //     validators: {
                            //         notEmpty: {
                            //             message: 'Por favor introduce un valor'
                            //         },
                            //         ValidarCedula: {
                            //             message: 'El documento de identificación ingresado no es correcto.'
                            //         },
                            //         stringLength: {
                            //             min: 10,
                            //             max: 10
                            //         },
                            //         remote: {
                            //             message: 'La cédula ya se encuentra registrada',
                            //             url: '',
                            //             type: 'GET',
                            //             data: function(validator) {
                            //                 return {
                            //                     "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                            //                     cedula: validator.getFieldElements('cedula').val(),
                            //                     id: validator.getFieldElements('id').val() || 0
                            //                 };
                            //             }
                            //         }
                            //     }
                            // }
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
                            setTimeout(() => window.location = '<?= base_url(route_to('empresa')) ?>', 2500);
                        } else {
                            UI.showError(data.error);
                        }
                    })
                    .fail(function() {
                        UI.showError('Tus datos no fueron guardados');
                    });
            });

            $('#cancelar').on('click', function() {
                window.location = '<?= base_url(route_to('empresa')) ?>';
            });

            // Configuración fileinput
            $("#logo").fileinput({
                language: 'es', // Idioma español
                theme: 'fas', // Usar Font Awesome 5
                
                // Validaciones de archivo
                allowedFileTypes: ['image'],
                allowedFileExtensions: ['jpg', 'jpeg', 'png'],
                maxFileSize: 1024, // 1MB
                minImageWidth: 50, // Ancho mínimo de imagen
                minImageHeight: 50, // Alto mínimo de imagen
                maxImageWidth: 5000, // Ancho máximo
                maxImageHeight: 5000, // Alto máximo
                
                // Comportamiento
                showUpload: false,
                showRemove: true,
                showCancel: false,
                browseOnZoneClick: true,
                dropZoneEnabled: true,
                overwriteInitial: true,
                initialPreviewAsData: true,
                maxFileCount: 1,
                
                // Mensajes personalizados
                msgValidationError: 'Error de validación',
                msgImageWidthSmall: 'El ancho de la imagen "{name}" debe ser de al menos {size} px.',
                msgImageHeightSmall: 'El alto de la imagen "{name}" debe ser de al menos {size} px.',
                msgImageWidthLarge: 'El ancho de la imagen "{name}" no puede exceder {size} px.',
                msgImageHeightLarge: 'El alto de la imagen "{name}" no puede exceder {size} px.',
                
                // Configuración de acciones de archivo
                fileActionSettings: {
                    showRemove: true,
                    showUpload: false,
                    showZoom: true,
                    showDrag: false,
                    zoomClass: 'btn btn-sm btn-primary',
                    removeClass: 'btn btn-sm btn-danger'
                },
                // Precargar imagen desde URL
                initialPreview: [
                    '<?= base_url($attrform[5]['value']) ?>' // URL de la imagen
                ],
                initialPreviewConfig: [
                    {
                        //caption: 'Mi Logo', // Texto que aparece debajo de la imagen
                        //width: '120px', // Ancho de la previsualización
                        //url: "/delete-url", // URL para eliminar (si es necesario)
                        //key: 1, // Identificador único
                        //extra: {id: 123} // Datos extra si los necesitas
                    }
                ]
            });

            $('#logo').on('change', function(event) {
                $('#change_logo').val('1');
            });
        });
</script>

<?= $this->endSection() ?>