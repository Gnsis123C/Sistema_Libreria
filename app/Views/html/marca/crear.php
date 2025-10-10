<?= $this->extend('plantilla/layout') ?>

<?= $this->section('titulo') ?> 
    <?= $pagina ?> | <?= $titulo ?> <?= json_encode(session('usuario')['usuario']) ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
    
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/formvalidation/css/formValidation.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2.min.css" /> 
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap-3/select2-bootstrap.css" /> 
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap4.min.css" /> 
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/cropperjs-main/dist/cropper.min.css" /> 

    <style>
        .preview-imagen{
            max-width: 150px;
        }

        .preview-imagen img {
            width: 96%;
            height: auto;
            margin-top: 13px;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!--begin::Row-->
<div class="row">
  <div class="col-12 col-md-6 px-0 px-sm-3">
    <div class="card shadow-none">
      <div class="card-header">
        <h3 class="card-title">
          <?= $titulo ?>
        <!-- <div class="card-tools">
            <button
            type="button"
            class="btn btn-tool"
            data-lte-toggle="card-collapse"
            title="Collapse"
            >
            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
            </button>
            <button
            type="button"
            class="btn btn-tool"
            data-lte-toggle="card-remove"
            title="Remove"
            >
            <i class="bi bi-x-lg"></i>
            </button>
        </div> -->
        </div>
        <div class="card-body">
            <form id="form_global" data-fv-icon-validating="bi bi-arrow-repeat bi-spin">
                <?= $this->include('plantilla/form/html') ?>
            </form>
        </div>
      
        <style type="text/css">
            .cortar-img {
                display: flex;
                flex-direction: row;
                align-items: center;
                gap: 20px;
            }
        </style>
        <!-- Modal para recortar la imagen -->
        <div class="modal" id="modal-recortar-imagen" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="cortar-img">
                            <div id="cropper-container" style="width:100%">
                                <img id="imagen-cropper" src="" style="width:100%">
                            </div>
                            <div class="btn-group">
                            <button class="btn btn-primary" id="btn_plus"><i class="bi bi-plus-circle"></i></button>
                            <button class="btn btn-primary" id="btn_minus"><i class="bi bi-dash-circle"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-guardar-imagen" type="button" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary btn-cerrar" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
      <!-- /.card-body -->
      <!-- <div class="card-footer">Footer</div> -->
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->
  </div>
</div>
<!--end::Row-->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= $this->include('plantilla/form/javascript') ?>
<!--formvalidation-->
<script src="<?= base_url() ?>/assets/plugins/formvalidation/js/formValidation.js"  type="text/javascript"></script>
<script src="<?= base_url() ?>/assets/plugins/formvalidation/js/jquery.validate.js"  type="text/javascript"></script>
<script src="<?= base_url() ?>/assets/plugins/cedulayruc.js" type="text/javascript"></script>
<script src="<?= base_url() ?>/assets/plugins/formvalidation/js/framework/bootstrap.js"  type="text/javascript"></script>
<script src="<?= base_url() ?>/assets/plugins/formvalidation/js/language/es_ES.js"  type="text/javascript"></script>

<script src="<?= base_url() ?>/assets/plugins/select2/dist/js/select2.full.min.js"></script> 
<script src="<?= base_url() ?>/assets/plugins/select2/dist/js/i18n/es.js"></script> 

<script src="<?= base_url() ?>/assets/plugins/cropperjs-main/dist/cropper.min.js"></script> 

<script type="text/javascript">
  $(function(){
    var opciones = {
        showError: function (str) {
            toastr.error("Existe un error", str);
            $('#form_global').data('formValidation').resetForm();
            $('#form_global').find('input, textarea, button, select').prop('disabled', false);
            //opciones.ocultarForm();
            $('#caption').html('Guardar');
            opciones.disabled(0);
        },
        disabled: function (valor) {
            if (valor === 0) {
                $('#editar').prop('disabled', true);
                $('#eliminar').prop('disabled', true);
            }
            if (valor === 1) {
                $('#editar').prop('disabled', false);
                $('#eliminar').prop('disabled', false);
            }
            if (valor > 1) {
                $('#editar').prop('disabled', true);
                $('#eliminar').prop('disabled', false);
            }
        },
        ajaxEnviar: function (data) {
            var objData = new URLSearchParams(data);
            objData.forEach(function(value, key) {
                formDataGlobal.append(key, value);
            });
            
            return $.ajax({
                url: '<?= base_url(route_to('marca.actions')) ?>',
                type: 'POST',
                data: formDataGlobal,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                beforeSend: function () {
                    $('#form_global').find('input, textarea, button, select').prop('disabled', true);
                    $('#caption').html('Guardando...');
                    $('#loading').removeClass('fa-save');
                    $('#loading').addClass('fa-refresh fa-spin');
                }
            });
        }
    };
    
    var init_form = function(){
        FormValidation.Validator.ValidarCedula = {
            validate: function (validator, $field, option) {
                var value = $field.val();
                if (!isNaN(value)) {
                    if (value.length === 10) {
                        return $.cedula(value);
                    }
                }
                return true;
            }
        };
        return $('#form_global').on('init.field.fv', function(e, data) {
        // data.field   --> The field name
        // data.element --> The field element
        var base_name = '#messages_error_';
        if (data.field === 'nombres') {
            //var $icon = data.element.data('fv.icon');
            //$icon.appendTo(base_name+'nombres');
        }
        }).formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'bi bi-check',
                invalid: 'bi bi-x',
                validating: 'bi bi-arrow-repeat bi-spin'
            },
            // live: 'enabled',
            fields: {
                nombre: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor introduce un valor'
                        },
                        stringLength: {
                            min: 2,
                            max: 100,
                            //message: 'The username must be more than 6 and less than 30 characters long'
                        },
                        remote: {
                            message: 'El nombre ya se encuentra registrado',
                            url: '<?= base_url(route_to('categoria.validar.nombre')) ?>',
                            data: function (validator, $field, value) {
                                return {
                                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                                    nombre: validator.getFieldElements('nombre').val(),
                                    id: validator.getFieldElements('id').val() == '' ? 0 : validator.getFieldElements('id').val()
                                };
                            },
                            type: 'GET'
                        }
                    }
                },
            }
        });
    }
    /**FIN OPCIONES DEL SISTEMA */
    form = init_form();
    function ShowMensaje(mensaje, accion){
        $('#mensaje').html(mensaje);
        $('#accion-text').html(accion);
        $('.toast').toast('show');
    }
    form.on('success.form.fv', function (e) {
        e.preventDefault();
        var $form = $(e.target), fv = $form.data('formValidation');
        opciones.ajaxEnviar($form.serialize())
                .done(function (data) {
                    if (data.resp) {
                        toastr.success("Proceso terminado", "<Tus datos fueron guardados");
                        setTimeout(function() {
                            window.location = '<?= base_url(route_to('marca')) ?>';
                        }, 2500);
                    } else {
                        $('#form_global').data('formValidation').resetForm();
                        $('#form_global').find('input, textarea, button, select').prop('disabled', false);
                        opciones.showError(data.error);
                    }
                    return;
                }).fail(function () {
                    $('#form_global').data('formValidation').resetForm();
                    $('#form_global').find('input, textarea, button, select').prop('disabled', false);
                    opciones.showError('Tus datos no fueron guardados');
        });
    });
    
    $('#cancelar').click(function () {
        window.location = '<?= base_url(route_to('marca')) ?>';
    });

    //Imágenes.
    // Elementos
    const formDataGlobal = new FormData();
    const $modalCargarImagen = $("#modal-cargar-imagen");
    const $modalRecortarImagen = $("#modal-recortar-imagen");
    const $imagenCropper = $("#imagen-cropper");
    const $btnGuardarImagen = $("#btn-guardar-imagen");
    const $inputImagen = $("#imagen");
    const $previewImagen = $("#preview-imagen-imagen");

    let cropper = null;

    // Convertir base64 a Blob
    function dataURLtoBlob(dataURL) {
        const [header, base64] = dataURL.split(',');
        const mime = header.match(/:(.*?);/)[1];
        const binary = atob(base64);
        const array = new Uint8Array(binary.length);
        for (let i = 0; i < binary.length; i++) {
            array[i] = binary.charCodeAt(i);
        }
        return new Blob([array], { type: mime });
    }

    // Al seleccionar imagen
    $inputImagen.on("change", function () {
        const imagenSeleccionada = this.files[0];
        if (!imagenSeleccionada) {
            toastr.error("Error", "No se seleccionó ninguna imagen");
            return;
        }

        const imagenURL = URL.createObjectURL(imagenSeleccionada);
        $imagenCropper.attr("src", imagenURL);

        // Cerrar modal de carga y abrir de recorte
        $modalCargarImagen.modal("hide");
        $modalRecortarImagen.modal("show");

        // Inicializar cropper
        cropper = new Cropper($imagenCropper[0], {
            aspectRatio: (1/1),
            zoomOnWheel: false
        });
    });

    // Guardar imagen recortada
    $btnGuardarImagen.off("click").on("click", function () {
        if (!cropper) return;

        const croppedDataURL = cropper.getCroppedCanvas({
            fillColor: 'transparent' // importante para fondo transparente
        }).toDataURL("image/png");
        const blob = dataURLtoBlob(croppedDataURL);

        formDataGlobal.append("image_real", blob, "imagen_recortada.jpg");

        const croppedImageUrl = URL.createObjectURL(blob);

        // Mostrar imagen recortada
        $previewImagen.find("img").attr("src", croppedImageUrl);

        // Cerrar y limpiar
        cropper.destroy();
        cropper = null;
        $imagenCropper.attr("src", "");
        $modalRecortarImagen.modal("hide");
        $inputImagen.val(""); // Reset input file

        $("#form_global").formValidation('enableFieldValidators', 'imagen', false);
        $("#form_global").formValidation('revalidateField', 'imagen');

        $previewImagen.removeClass("d-none");
        $inputImagen.addClass("d-none");
    });

    // Zoom
    $("#btn_plus").click(() => cropper?.zoom(0.1));
    $("#btn_minus").click(() => cropper?.zoom(-0.1));

    // Al cerrar modal de recorte
    $modalRecortarImagen.on("hidden.bs.modal", function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        $imagenCropper.attr("src", "");
        $inputImagen.val(""); // Reset input file si se cancela
    });

    // Al eliminar imagen
    $(document).on("click", "[data-btn='btn-delete-img']", function () {
        const idDivImagen = $(this).val();
        const $previewImagen = $("#"+idDivImagen);
        const $inputImagen = $("#"+idDivImagen.replace("preview-imagen-", ""));
        $previewImagen.addClass("d-none");
        $inputImagen.removeClass("d-none");
        $inputImagen.val("");
        $(this).closest(".form-group").find(".messages_error_eva").html("");
        $("#form_global").formValidation('enableFieldValidators', 'imagen', true);
        $("#form_global").formValidation('revalidateField', 'imagen');
    });

})
</script>

<?= $this->endSection() ?>