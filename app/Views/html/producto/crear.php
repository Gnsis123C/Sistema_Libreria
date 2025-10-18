<?= $this->extend('plantilla/layout') ?>

<?= $this->section('titulo') ?>
<?= $pagina ?> | <?= $titulo ?> <?= json_encode(session('usuario')['usuario']) ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/formvalidation/css/formValidation.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2.min.css" />
<link rel="stylesheet" type="text/css"
    href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap-3/select2-bootstrap.css" />
<link rel="stylesheet" type="text/css"
    href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap4.min.css" />


<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/summernote/summernote-bs5.min.css" />

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/cropperjs-main/dist/cropper.min.css" />
<style>
    .preview-imagen {
        max-width: 150px;
    }

    .preview-imagen img {
        width: 96%;
        height: auto;
        margin-top: 13px;
    }

    .btn-cr-accordeon-delete {
        top: 11px;
        right: 55px;
        z-index: 100;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!--begin::Row-->
<div class="row mt-3">
    <div class="col-12 col-md-12 col-lg-7 px-0 px-sm-3">
        <div class="card shadow-none">
            
            <div class="card-body">
                <form id="form_global" data-fv-icon-validating="bi bi-arrow-repeat bi-spin">
                    <input type="hidden" name="id" id="id" value="0">
                    <input type="hidden" name="action" id="action" value="add">
                    <input type="hidden" name="stock" id="stock" value="0">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="codigo_barras" class="form-label">Código de barras</label>
                        <div class="form-group position-relative">
                            <input required maxlength="20" value="0" type="text" class="form-control" id="codigo_barras"
                                name="codigo_barras">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <div class="form-group position-relative">
                            <input required type="text" class="form-control" id="nombre" name="nombre"
                                aria-describedby="nombreHelp">
                        </div>
                        <div id="nombreHelp" class="form-text">Ingrese el nombre del producto.</div>
                    </div>
                    <div class="mb-3">
                        <label for="idatributo" class="form-label">Atributo</label>
                        <div class="input-group position-relative">
                            <select required class="form-select" multiple="multiple" id="idatributo" name="idatributo"></select>
                            <a target="_blank" href="<?= base_url(route_to('atributo')) ?>"
                                class="btn btn-outline-secondary" type="button"><i class="bi bi-link-45deg"></i>
                                Agregar</a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="idcategoria" class="form-label">Categoria</label>
                        <div class="form-group position-relative">
                            <div class="input-group mb-3">
                                <select required multiple="multiple" class="form-select" id="idcategoria"
                                    name="idcategoria">
                                    <option>...</option>
                                </select>
                                <a target="_blank" href="<?= base_url(route_to('categoria')) ?>"
                                    class="btn btn-outline-secondary" type="button"><i class="bi bi-link-45deg"></i>
                                    Agregar</a>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <div class="position-relative">
                            <select required class="form-select" id="estado" name="estado">
                                <option selected>Seleccione un estado</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="precio_venta" class="form-label">Precio de venta</label>
                        <div class="form-group position-relative">
                            <input required maxlength="20" value="0" type="text" class="form-control" id="precio_venta"
                                name="precio_venta">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="stock_minimo" class="form-label">Cantidad(Stock) mínima para aviso notificaciones</label>
                        <div class="form-group position-relative">
                            <input required maxlength="20" value="0" type="text" class="form-control" id="stock_minimo"
                                name="stock_minimo">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-group position-relative has-feedback">
                            <label for="imagen" class="control-label">
                                Selecciona la imagen del producto <small id="asterisco-requerido-imagen"
                                    class="asterisco-danger text-danger">*</small>
                            </label>
                            <div class="file-loading">
                                <input type="file" id="imagen" name="imagen" class="form-control" required=""
                                    accept="image/*" data-fv-field="imagen">
                            </div>
                            <div class="messages_error_eva" id="messages_error_imagen"></div>
                            <div id="preview-imagen-imagen" class="position-relative preview-imagen mt-2 d-none">
                                <img src="" alt="Imagen recortada" class="rounded">
                                <button type="button" value="preview-imagen-imagen" data-btn="btn-delete-img"
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 p-none">
                        <label for="stock" class="form-label">Descripción del producto</label>
                        <div class="form-group position-relative">
                            <textarea required class="form-control" id="descripcion" name="descripcion"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" id="cancelar">Cancelar</button>
                
                    <div id="alert-msg-general" class="alert alert-danger alert-dismissible fade show mt-4 d-none" role="alert">
                        <div id="messages" class="d-flex flex-column"></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <!-- <div class="card-footer">Footer</div> -->
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
    </div>
    <div class="col-12 col-md-12 col-lg-5 px-0 px-sm-3">
        <div class="accordion" id="accordionAtributo">
            
        </div>
    </div>
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

<script src="<?= base_url() ?>/assets/plugins/summernote/summernote-bs5.min.js"></script>

<script src="<?= base_url() ?>/assets/plugins/cropperjs-main/dist/cropper.min.js"></script>

<script type="text/javascript">
    let accordeonAtributo = {};
    $(function () {
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
                objData.forEach(function (value, key) {
                    formDataGlobal.append(key, value);
                });

                formDataGlobal.append('atributos', JSON.stringify(accordeonAtributo.CRUD.atributos || []));

                return $.ajax({
                    url: '<?= base_url(route_to('producto.actions')) ?>',
                    type: 'POST',
                    data: formDataGlobal,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'JSON',
                    beforeSend: function () {
                        $('#form_global').find('input, textarea, button, select').prop('disabled', true);
                        $('#form_global').find('button[type="submit"]').html('Guardando... <i class="bi bi-arrow-repeat bi-spin"></i>');
                    },
                    complete: function () {
                        $('#form_global').find('button[type="submit"]').html('Guardar');
                    }
                });
            }
        };

        var init_form = function () {
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
            return $('#form_global')
            .on('init.field.fv', function(e, data) {
                // lugar para mensajes custom por campo si deseas
            })
            .on('err.field.fv', function(e, data) {
                $('#alert-msg-general').removeClass('d-none');
            })
            .on('success.field.fv', function(e, data) {
                $('#alert-msg-general').addClass('d-none');
            }).formValidation({
                framework: 'bootstrap',
                err: {
                    container: '#messages'
                },
                icon: {
                    valid: 'bi bi-check',
                    invalid: 'bi bi-x',
                    validating: 'bi bi-arrow-repeat bi-spin'
                },
                // live: 'enabled',
                fields: {
                    codigo_barras: {
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
                                message: 'El código de barras ya se encuentra registrado',
                                url: '<?= base_url(route_to('producto.validar.codigo_barras')) ?>',
                                data: function (validator, $field, value) {
                                    return {
                                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                                        codigo_barras: validator.getFieldElements('codigo_barras').val(),
                                        id: validator.getFieldElements('id').val() == '' ? 0 : validator.getFieldElements('id').val()
                                    };
                                },
                                type: 'GET'
                            }
                        }
                    },
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
                                url: '<?= base_url(route_to('producto.validar.nombre')) ?>',
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


        /**precio_venta */
        $('#precio_venta').on('input', function () {
            this.value = this.value.replace(/[^0-9.]/g, '');
        });
        /**FIN precio_venta */


        /**stock_minimo */
        $('#stock_minimo').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        /**FIN stock_minimo */

        // SELECT2
        $("#idcategoria").select2({
            placeholder: 'Seleccionar una categoría',
            theme: 'bootstrap4',
            width: '80%',
            ajax: {
                url: '<?= base_url(route_to('categoria.select')) ?>',
                dataType: 'json',
                type: "post",
                delay: 250,
                data: function (data) {
                    var query = {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                        searchTerm: data.term,
                        page: data.page || 1,
                        size: data.size || 10
                    }
                    // Query parameters will be ?search=[term]&page=[page]
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (obj) {
                            //const texto = "nombre",
                            //regex = /([^}]*){}/g;
                            //regex = /}([^}]*){/g;
                            /*var grupos;
                            var i = 0;
                            while ((grupos = regex.exec(texto)) !== null) {
                                console.log(grupos);
                            }*/
                            return {
                                id: obj.idcategoria,
                                text: obj.nombre
                            };
                        }),
                        pagination: {
                            more: ((data.page * data.size) < data.count_filtered)
                        }
                    };
                },
                templateResult: function (item) {
                    // Display institution name as tag option
                    return $("<div>" + item.name + "</div>");
                },
                instructions: 'To find a book, search the <strong>Book\'s Title</strong>, <strong>ISBN</strong>, or <strong>Authors</strong>',
                cache: true,
                allowClear: true,
                minimumInputLength: 1
            }
        });
        $("#idatributo").select2({
            placeholder: 'Seleccionar atributos',
            theme: 'bootstrap4',
            width: '80%',
            tags: true, // ✅ Permite agregar nuevos
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') return null;

                return {
                    id: '__new__:' + term, // prefijo para identificar nuevos
                    text: term,
                    isNew: true
                };
            },
            ajax: {
                url: '<?= base_url(route_to('atributo.select')) ?>',
                dataType: 'json',
                type: "post",
                delay: 250,
                data: function (data) {
                    var query = {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                        searchTerm: data.term,
                        page: data.page || 1,
                        size: data.size || 10
                    }
                    // Query parameters will be ?search=[term]&page=[page]
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.results, function (obj) {
                            //const texto = "nombre",
                            //regex = /([^}]*){}/g;
                            //regex = /}([^}]*){/g;
                            /*var grupos;
                            var i = 0;
                            while ((grupos = regex.exec(texto)) !== null) {
                                console.log(grupos);
                            }*/
                            return {
                                id: obj.id,
                                text: obj.nombre
                            };
                        }),
                        pagination: {
                            more: ((data.page * data.size) < data.count_filtered)
                        }
                    };
                },
                templateResult: function (item) {
                    // Display institution name as tag option
                    return $("<div>" + item.name + "</div>");
                },
                instructions: 'To find a book, search the <strong>Book\'s Title</strong>, <strong>ISBN</strong>, or <strong>Authors</strong>',
                cache: true,
                allowClear: true,
                minimumInputLength: 1
            }
        });
        // FIN SELECT2

        $('#descripcion').summernote({
            placeholder: 'Ingrese la descripción del producto',
            tabsize: 2,
            lang: 'es-ES',
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', []],
                ['insert', ['link']],
                ['view', []],
            ],
        });
        form = init_form();
        function ShowMensaje(mensaje, accion) {
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
                        toastr.success("Proceso terminado", "Tus datos fueron guardados");
                        setTimeout(function () {
                            window.location = '<?= base_url(route_to('producto')) ?>';
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
            window.location = '<?= base_url(route_to('producto')) ?>';
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
                aspectRatio: (1 / 1.5),
                zoomOnWheel: false
            });
        });

        // Guardar imagen recortada
        $btnGuardarImagen.off("click").on("click", function () {
            if (!cropper) return;

            const canvas = cropper.getCroppedCanvas({
                fillColor: '#ffffff', // Fondo blanco para JPEG
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });

            canvas.toBlob(function (blob) {
                // Opcional: convertir a WebP en lugar de JPEG
                // canvas.toBlob(callback, "image/webp", 0.85);

                if (!blob) {
                    alert("Error al generar la imagen");
                    return;
                }

                // Añadir al formData
                formDataGlobal.append("image_real", blob, "imagen_recortada.jpg");

                const croppedImageUrl = URL.createObjectURL(blob);
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

            }, "image/jpeg", 0.85); // Ajusta calidad entre 0.7 y 0.9 según preferencia
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
            const $previewImagen = $("#" + idDivImagen);
            const $inputImagen = $("#" + idDivImagen.replace("preview-imagen-", ""));
            $previewImagen.addClass("d-none");
            $inputImagen.removeClass("d-none");
            $inputImagen.val("");
            $(this).closest(".form-group").find(".messages_error_eva").html("");
            $("#form_global").formValidation('enableFieldValidators', 'imagen', true);
            $("#form_global").formValidation('revalidateField', 'imagen');
        });

        //Accordeon atributo
        accordeonAtributo = {
            id: "accordionAtributo",
            CRUD: {
                atributos: [],
                existe: function(atributo){
                    try {
                        const atributos = this.atributos;
                        for(var i in atributos){
                            const attr = atributos[i];
                            if(attr.id == atributo.id){
                                return true;
                            }
                        }
                        return false;
                    } catch (error) {
                        console.log("Error existe atributo", error);
                        return false;
                    } 
                },
                add: function(atributo){
                   try {
                       if(this.existe(atributo)){
                           toastr.error("Error", "El atributo ya existe");
                           return;
                       }

                       this.atributos.push(atributo);
                       this.list();
                       return true;
                   } catch (error) {
                       console.log(error);
                       return false;
                   } 
                },
                edit: function (atributo, id) {
                    try {
                        if (!this.existe(atributo)) {
                            toastr.error("Error", "El atributo no existe");
                            return false;
                        }

                        const index = this.atributos.findIndex(item => item.indice == atributo.indice);
                        if (index === -1) {
                            toastr.error("Error", "No se encontró el atributo con el ID proporcionado");
                            return false;
                        }

                        // Actualizar el atributo en la lista
                        this.atributos[index] = atributo;

                        // Refrescar visualización del atributo editado
                        const nodo = document.getElementById(`accordeon-atributo-${atributo.indice}`);
                        if (nodo) {
                            nodo.innerHTML = accordeonAtributo.htmlTemplate(atributo, atributo.indice);

                            // Re-inicializar select2 si es necesario
                            this.createSelect2(atributo);
                        }

                        return true;
                    } catch (error) {
                        console.log(error);
                        return false;
                    }
                },
                deleteAll: function(){
                   try {
                       this.atributos = [];
                       this.list();
                       return true;
                   } catch (error) {
                       console.log(error);
                       return false;
                   } 

                },
                delete: function(indice){
                   try {
                        // Eliminar el nodo HTML asociado al índice
                        const nodo = document.getElementById(`accordeon-atributo-${indice}`);
                        if (nodo) nodo.remove();

                        const idSelectTemp = "select[data-indice='"+indice+"']";

                        if ($(idSelectTemp).data('select2')) {
                            $(idSelectTemp).select2('destroy'); // Elimina select2 del elemento
                        }

                        // Eliminar del array
                        for(let i = 0; i < this.atributos.length; i++){
                            if(this.atributos[i]["indice"] == indice){
                                this.atributos.splice(i, 1);
                                return true;
                            }
                        }
                       return true;
                   } catch (error) {
                       console.log(error);
                       return false;
                   } 
                },
                list: function(){
                   try {
                        if(document.getElementById(accordeonAtributo.id)){
                            const ultimoIndice = this.atributos.length - 1;
                            const ultimoRegistro = this.atributos[ultimoIndice];
                            
                            this.atributos[ultimoIndice]["data"] = {
                                nombre: "",
                                isSelect2: false
                            };

                            $("#"+accordeonAtributo.id).append(accordeonAtributo.htmlTemplate(this.atributos[ultimoIndice], ultimoIndice));
                            this.createSelect2(this.atributos[ultimoIndice]);
                        }
                       return true;
                   } catch (error) {
                       console.log(error);
                       return false;
                   } 
                },
                idDinamico: function(){
                    if(this.atributos.length == 0){
                        return 0;
                    }

                    const ultimoIndice = this.atributos.length - 1;
                    let { indice } = this.atributos[ultimoIndice] || {};
                    return indice + 1;
                },
                createSelect2: function(atributo){
                    try {
                        const idSelectTemp = "select[data-indice='"+atributo.indice+"']";
                        if($(idSelectTemp) && !$(idSelectTemp).data('select2')){
                            for(var i in this.atributos){
                                this.atributos[i].data.isSelect2 = true;
                            }
                            $(idSelectTemp).select2({
                                placeholder: 'Seleccionar atributos',
                                theme: 'bootstrap4',
                                width: '100%',
                                tags: true,
                                createTag: function (params) {
                                    var term = $.trim(params.term);
                                    if (term === '') return null;

                                    return {
                                        id: '__new__:' + term,
                                        text: term,
                                        isNew: true
                                    };
                                },
                                ajax: {
                                    url: '<?= base_url(route_to('valoratributo.select')) ?>',
                                    dataType: 'json',
                                    type: "post",
                                    delay: 250,
                                    data: function (data) {
                                        var query = {
                                            "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                                            searchTerm: data.term,
                                            page: data.page || 1,
                                            size: data.size || 10
                                        }

                                        if(!query?.isNew){
                                            query.idatributo = atributo.id;
                                        }
                                        // console.log(query)
                                        // Query parameters will be ?search=[term]&page=[page]
                                        return query;
                                    },
                                    processResults: function (data) {
                                        return {
                                            results: $.map(data.results, function (obj) {
                                                //const texto = "nombre",
                                                //regex = /([^}]*){}/g;
                                                //regex = /}([^}]*){/g;
                                                /*var grupos;
                                                var i = 0;
                                                while ((grupos = regex.exec(texto)) !== null) {
                                                    console.log(grupos);
                                                }*/
                                                return {
                                                    // id: obj.idvaloratributo,
                                                    id: obj.id,
                                                    text: obj.nombre
                                                };
                                            }),
                                            pagination: {
                                                more: ((data.page * data.size) < data.count_filtered)
                                            }
                                        };
                                    },
                                    templateResult: function (item) {
                                        // Display institution name as tag option
                                        return $("<div>" + item.name + "</div>");
                                    },
                                    instructions: 'To find a book, search the <strong>Book\'s Title</strong>, <strong>ISBN</strong>, or <strong>Authors</strong>',
                                    cache: true,
                                    allowClear: true,
                                    minimumInputLength: 1
                                }
                            });
                        }
                        return true;
                    } catch (error) {
                        console.log(error);
                        return false;
                    }
                }
            },
            htmlTemplate: function(atributo, i){
                let indice = atributo.indice;
                let classShow = i == 0 ? "show" : "";
                let classCloseButton = i == 0 ? "" : "collapsed";
                try {
                    const html = `
                        <div class="accordion-item" id="accordeon-atributo-${indice}">
                            <h2 class="accordion-header" id="heading_${indice}" data-id="${atributo.id}" data-indice="${indice}">
                                <div class="position-relative" style="cursor: default;" type="button">
                                    <button type="button" class="accordion-button ${classCloseButton}"  aria-expanded="${i==0}" data-bs-toggle="collapse" data-bs-target="#collapse_${indice}"  aria-controls="collapse_${indice}">
                                        ${atributo.nombre}
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm position-absolute btn-cr-accordeon-delete rounded-circle" data-indice="${indice}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </h2>
                            <div id="collapse_${indice}" class="accordion-collapse collapse ${classShow}" aria-labelledby="heading_${indice}" data-bs-parent="#${accordeonAtributo.id}">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="nombre_${indice}" class="form-label">Nombre</label>
                                        <div class="form-group position-relative">
                                            <select id="nombre_${indice}" class="form-select" multiple="multiple" data-input="accordeon-atributo" data-accordeon-select data-key="nombre" data-indice="${indice}" data-id="${atributo.id}"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    return html;
                } catch (error) {
                    return "";
                }
            }
        }

        const deleteSelect2ItemsAtributo = function(valorAQuitar, indice = null){
            let valoresActuales = $('#idatributo').val() || [];

            let nuevosValores = valoresActuales.filter(v => v !== valorAQuitar);
            $('#idatributo').val(nuevosValores).trigger('change');
            
            if(indice){
                accordeonAtributo.CRUD.delete(indice);
            }else{
                accordeonAtributo.CRUD.atributos.find((atributo, index) => {
                    if(atributo.id == valorAQuitar){
                        accordeonAtributo.CRUD.delete(atributo.indice);
                        return true;
                    }
                })
            }
        }

        $("#idatributo").on("select2:select", function (e) {
            const data = e.params.data;
            const { id, text, isNew = false} = data;
            const atributo = {
                indice: accordeonAtributo.CRUD.idDinamico(),
                id: id,
                nombre: text,
                isNew: isNew,
                data: {}
            }

            accordeonAtributo.CRUD.add(atributo);
        });

        $('#idatributo').on('select2:unselect', function (e) {
            const data = e.params.data;
            const { id, text, isNew} = data;
            deleteSelect2ItemsAtributo(id);
        });

        $(document).on("click", ".btn-cr-accordeon-delete", function(e){
            const indice = $(this).data("indice");
            const { id:valorAQuitar} = accordeonAtributo.CRUD.atributos.find((atributo) => atributo.indice == indice);
            deleteSelect2ItemsAtributo(valorAQuitar, indice);
        })

        $("#accordionAtributo").on("select2:select", "select[data-accordeon-select]", function(e){
            const indice = $(this).data("indice");
            const key = $(this).data("key");
            const idTemp = $(this).data("id");
            const idSelectTemp = "select[data-indice='"+indice+"']";
            const valoresSeleccionados = $(idSelectTemp).select2('data');
            const data = e.params.data; //Valor último seleccionado
            
            accordeonAtributo.CRUD.atributos.find((atributo) => {
                if(atributo.indice == indice){
                    atributo.data[key] = valoresSeleccionados;
                    return true;
                }
            })
        })
    })
</script>

<?= $this->endSection() ?>