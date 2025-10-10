<?= $this->extend('plantilla/layout') ?>

<?= $this->section('titulo') ?> 
    <?= $pagina ?> | <?= $titulo ?> <?= json_encode(session('usuario')['usuario']) ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
    
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/formvalidation/css/formValidation.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2.min.css" /> 
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap-3/select2-bootstrap.css" /> 
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap4.min.css" /> 

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
            return $.ajax({
                url: '<?= base_url(route_to('atributo.actions')) ?>',
                type: 'POST',
                data: data,
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
                        // ValidarCedula: {
                        //     message: 'El documento de identificación ingresado no es la correcto.'
                        // },
                        // stringLength: {
                        //     min: 10,
                        //     max: 10,
                        //     //message: 'The username must be more than 6 and less than 30 characters long'
                        // },
                        remote: {
                            message: 'La cédula ya se encuentra registrado',
                            url: '<?= base_url(route_to('atributo.validar.nombre')) ?>',
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
                            window.location = '<?= base_url(route_to('atributo')) ?>';
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
        window.location = '<?= base_url(route_to('atributo')) ?>';
    });
  })
</script>

<?= $this->endSection() ?>