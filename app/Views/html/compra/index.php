<?= $this->extend('plantilla/layout') ?>

<?= $this->section('titulo') ?>
<?= $titulo ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">


<link rel="stylesheet" href="<?= base_url("assets/plugins/daterangepicker/daterangepicker.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>">
<link rel="stylesheet" href="<?= base_url("assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css") ?>">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2.min.css" /> 
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap-3/select2-bootstrap.css" /> 
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap4.min.css" /> 
<style>
    #listartable {
        border: 1px solid #dee2e6;
    }

    #listartable th,
    #listartable td {
        border: 1px solid #dee2e6;
    }

    .class-tipo {
        max-width: 160px;
    }

    .form-check-input:checked {
        background-color: var(--accent-green);
        border-color: var(--accent-green);
    }

    .table-hover tbody tr:hover {
        background-color: var(--light-gray);
    }

    #permisosModal .modal-header {
        background-color: var(--dark-gray);
        color: white;
    }

    #permisosModal .modal-header .btn-close {
        filter: invert(1);
    }

    .module-name {
        font-weight: 600;
        color: var(--dark-gray);
    }

    .permission-label {
        font-size: 0.875rem;
        color: #6b7280;
    }

    #permisosModal .modal-dialog {
        max-width: 600px;
    }

    /* search-box */
    .search-box {
        position: relative;
    }

    .search-box input {
        padding-left: 2.5rem;
        border-radius: 0.5rem;
        border: 1px solid #ced4da;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .select2-container--bootstrap4 .select2-selection__clear {
        padding-left: 0.19em;
        padding-top: 0.13em;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-42">
  <h1 class="display-6 fw-bold mb-3 text-dark">
    M. Compras
  </h1>
</div>
<!--begin::Row-->
<div class="row">
    <div class="col-12 px-0 px-sm-3">
        <!-- Tables Row -->
         <div class="row mb-3">
            <div class="col-12 col-sm-6 col-lg-4 px-sm-2 p-1">
                <div class="card card-metric card-shadow-dashboard">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <?php if($comprasDelMes['resp']): ?>
                                <div class="metric-value"><?= $comprasDelMes['data']['total_compras'] ?></div>
                            <?php endif; ?>
                            
                            <div class="metric-label">Compras del mes</div>
                        </div>
                        <div class="metric-icon icon-sales">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 px-sm-2 p-1">
                <div class="card card-metric card-shadow-dashboard">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <?php if($totalComprado['resp']): ?>
                            <div class="metric-value"><?= $totalComprado['data']['total_comprado'] ?></div>
                        <?php endif; ?>
                        <div class="metric-label">Total comprado</div>
                    </div>
                    <div class="metric-icon icon-sales">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 px-sm-2 p-1">
                <div class="card card-metric card-shadow-dashboard">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <?php if($totalProductosComprados['resp']): ?>
                            <div class="metric-value"><?= $totalProductosComprados['data']['productos'] ?></div>
                        <?php endif; ?>
                        <div class="metric-label">Productos Comprados</div>
                    </div>
                    <div class="metric-icon icon-sales">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
         </div>
         <div class="row">
            <div class="col-12">
                <input type="hidden" id="filtros_activos">
                <!-- Filtros y búsqueda -->
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-5">
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input id="fecha" type="text" class="form-control" placeholder="Buscar por fecha">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <select id="proveedor_filtro" class="form-select">
                                    <option value="">Todos los proveedores</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <button class="btn btn-success w-100" id="btn_filtrar">
                                    <i class="fas fa-filter me-2"></i>Filtrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
        <div class="row g-4">
            <div class="col-xl-12">
                <div class="d-flex justify-content-between align-items-sm-end">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs border-bottom-0 d-none d-sm-flex">
                        <li class="nav-item">
                            <a class="nav-link <?= isset($_GET['papelera']) ? '' : 'active' ?>" aria-current="page" href="<?= base_url(route_to('compra')) ?>">
                                Registros activos (<?= $registros_no_eliminados ?>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= !isset($_GET['papelera']) ? '' : 'active' ?>" href="<?= base_url(route_to('compra')) ?>?papelera=1">
                                Registros eliminados (<?= $registros_eliminados ?>)
                            </a>
                        </li>
                    </ul>

                    <!-- Dropdown a la derecha -->
                    <?php if ($esConsedido->crear): ?>
                        <!-- Dropdown a la derecha -->
                        <div class="dropdown ms-sm-auto mb-1">
                            <a class="btn btn-success rounded-0" href="<?= base_url(route_to('compra.crear')) ?>">
                                <i class="fas fa-plus"></i> Nuevo Registro
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card rounded-0">
                    <div class="card-body">
                        <table id="listartable" style="width:100%" class="table table-striped table-bordered nowrap">
                            <thead id="thead">
                            </thead>
                            <tbody id="tbody_">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- Responsive examples -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script> 
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>

<script src="<?= base_url("assets/plugins/daterangepicker/daterangepicker.js") ?>"></script>
<script src="<?= base_url("assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>"></script>
<script src="<?= base_url("assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js") ?>"></script>

<script src="<?= base_url() ?>/assets/plugins/select2/dist/js/select2.full.min.js"></script> 
<script src="<?= base_url() ?>/assets/plugins/select2/dist/js/i18n/es.js"></script> 
<script type="text/javascript">
    var datatable;
    $(function(){

        $("#proveedor_filtro").select2({
            placeholder: 'Seleccionar un proveedor',
            theme: 'bootstrap4',
            width: '80%',
            allowClear:true,
            ajax: {
                url: '<?= base_url(route_to('persona.select', 'proveedor')) ?>',
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

        $('#filtros_activos').val(
            JSON.stringify({
                fecha: $('#fecha').val() ?? '',
                idproveedor: $('#proveedor_filtro').val() ?? ''
            })
        );
        var column = ['Proveedor','Fecha de compra','Total de la compra', 'Cantidad comprado'];
        var dibujarColumn = '<tr>';
        for (var i in column) {
            dibujarColumn += '<th>' + column[i] + '</th>';
        }
        dibujarColumn += '<th style="min-width: 10%;width:10%!important;" class="text-center">Acción</th>' + '</tr>';
        
        $('#thead').append(dibujarColumn);
        $('#tfoot').append(dibujarColumn);

        datatable = $('#listartable').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    url: '<?php echo base_url(route_to('compra.actions')); ?>',
                    "type": "POST",
                    "data": function (d) {
                        // Agrega los parámetros necesarios a cada solicitud
                        d.eliminado = <?= isset($_GET['papelera'])?'1':'0' ?>;
                        d.action = "list";
                        d['<?= csrf_token() ?>'] = "<?= csrf_hash() ?>";
                        d['filtros_activos'] = $('#filtros_activos').val();
                        return d;
                    }
                },
                pageLength: 10,
                autoWidth: false,
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal( {
                            header: function ( row ) {
                                var data = row.data();
                                return 'Detalles de '+data['nombre'];
                            }
                        } ),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                            tableClass: 'table'
                        } )
                    }
                },
                language: {
                    // "sSearch": "<span class='fa fa-search'></span> ",
                    "sZeroRecords": "No se encontraron resultados",
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ":Activar para ordenar la columna de manera descendente"
                    },
                    "oPaginate": {
                      "sFirst": "Primero", 
                      "sLast": "Último", 
                      // "sNext": "<span class='fa fa-chevron-right'></span>", 
                      // "sPrevious": "<span class='fa fa-chevron-left'></span>"
                    },
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrando _MENU_",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ <b>Total: </b> _MAX_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros<br>",
                    "sInfoFiltered": "(de un total de _MAX_ registros)",
                    "sInfoPostFix": ""
                },
                columns: [
                  { 
                      "data": "proveedor", "name":"compra.idpersona", "render": function (d, t, f) {
                          return d;
                      },
                      sDefaultContent: "",
                      className: 'gradeA',
                      "orderable": true
                  },
                  { 
                      "data": "fecha", "name":"compra.fecha", "render": function (d, t, f) {
                            return d;
                        },
                        sDefaultContent: "",
                        className: 'gradeA',
                        "orderable": true
                  },
                  { 
                      "data": "compra_total", "name":"compra.idcompra", "render": function (d, t, f) {
                            return d;
                        },
                        sDefaultContent: "",
                        className: 'gradeA',
                        "orderable": true
                  },
                  { 
                      "data": "cantidad_pedido", "name":"compra.idcompra", "render": function (d, t, f) {
                            return d;
                        },
                        sDefaultContent: "",
                        className: 'gradeA',
                        "orderable": true
                  },
                  { 
                      "data": "accion", "render": function (d, t, f) {
                              return d;
                          },
                          sDefaultContent: "",
                          className: 'gradeA btn-action',
                          "orderable": false,
                          "searchable": false
                  }
                ],
                // "initComplete": function( settings, json ) {
                    // setTimeout(function() {
                    //     datatable.responsive.rebuild();
                    //     datatable.responsive.recalc();
                    // }, 1500);
                // }
        });

        $('#admin_cr').on('click', 'a[data-action="elim"]', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
              title: '¿Desea eliminar el registro?',
              text: "El registro se va a eliminar",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, deseo eliminar',
              cancelButtonText: 'Cerrar'
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url(route_to('compra.actions')); ?>',
                    type: 'POST',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                        'action': 'del', 
                        'id': id
                    },
                    dataType: 'JSON',
                    beforeSend: function () {
                        //$('#icono_eliminar').html('<i class=" fa fa-refresh fa-spin fa-5x"></i>');
                        //$('#texto_eliminar').html('<h4>Espere</h4><p>Eliminando el dato</p>');
                        //$('#footer_eliminar').css('display', 'none');
                        $('a[data-action="elim"]').addClass('disabled');
                    }
                }).done(function (data) {
                    if (data.resp) {
                        $('#listartable').DataTable().ajax.reload(function () {
                            $('a[data-action="elim"]').removeClass('disabled');
                            Swal.fire(
                              'Dato eliminado!',
                              'El registro se eliminó con éxito!.',
                              'success'
                            );
                        });
                        return;
                    } else {
                        toastr.error("Existe un error", "No se pudo eliminar el registro");
                        $('a[data-action="elim"]').removeClass('disabled');
                    }
                }).fail(function () {
                    toastr.error("Existe un error", "No se pudo eliminar el registro");
                    $('a[data-action="elim"]').removeClass('disabled');
                });
                
              }
            })
        });

        $('#admin_cr').on('click', 'a[data-action="restore"]', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: '<?php echo base_url(route_to('compra.actions')); ?>',
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    'action': 'restore', 
                    'id': id
                },
                dataType: 'JSON',
                beforeSend: function () {
                    //$('#icono_eliminar').html('<i class=" fa fa-refresh fa-spin fa-5x"></i>');
                    //$('#texto_eliminar').html('<h4>Espere</h4><p>restaurando el dato</p>');
                    //$('#footer_eliminar').css('display', 'none');
                    $('a[data-action="restore"]').addClass('disabled');
                }
            }).done(function (data) {
                if (data.resp) {
                    $('#listartable').DataTable().ajax.reload(function () {
                        $('a[data-action="restore"]').removeClass('disabled');
                        Swal.fire(
                          'Dato restaurado!',
                          'El registro se restauró con éxito!.',
                          'success'
                        );

                        setTimeout(function(){
                            location.reload()
                        }, 1000);
                    });
                    return;
                } else {
                    toastr.error("Existe un error", "No se pudo restaurar el registro");
                    $('a[data-action="restore"]').removeClass('disabled');
                }
            }).fail(function () {
                toastr.error("Existe un error", "No se pudo restaurar el registro");
                $('a[data-action="restore"]').removeClass('disabled');
            });
        });

        $('#admin_cr').on('click', 'a[data-action="estado"]', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var estado = $(this).data('estado');
            $.ajax({
                url: '<?php echo base_url(route_to('compra.actions')); ?>',
                type: 'POST',
                data: {
                    'action': 'estado', 
                    'id': id, 'estado':estado,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                },
                dataType: 'JSON',
                beforeSend: function () {
                    //$('#icono_eliminar').html('<i class=" fa fa-refresh fa-spin fa-5x"></i>');
                    //$('#texto_eliminar').html('<h4>Espere</h4><p>restaurando el dato</p>');
                    //$('#footer_eliminar').css('display', 'none');
                    $('a[data-action="estado"]').addClass('disabled');
                }
            }).done(function (data) {
                if (data.resp) {
                    $('#listartable').DataTable().ajax.reload(function () {
                        $('a[data-action="estado"]').removeClass('disabled');
                        Swal.fire(
                          'Dato actualizado!',
                          'El registro cambió de estado con éxito!.',
                          'success'
                        );
                    });
                    return;
                } else {
                    toastr.error("Existe un error", "No se pudo actualizar el registro");
                    $('a[data-action="estado"]').removeClass('disabled');
                }
            }).fail(function () {
                toastr.error("Existe un error", "No se pudo restaurar el registro");
                $('a[data-action="estado"]').removeClass('disabled');
            });
        });

        // Configuración de daterangepicker
        $('#fecha').daterangepicker({
            opens: 'left',
            "locale": {
                "format": "YYYY-MM-DD",
                "separator": " , ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Personalizado",
                "weekLabel": "S",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            }
        }, function(start, end, label) {

            console.log("Se realizó una nueva selección de fecha: " + start.format('YYYY-MM-DD') + ' a ' + end.format('YYYY-MM-DD'));
        });

        $('#btn_filtrar').click(function() {
            $('#filtros_activos').val(
                JSON.stringify({
                    fecha: $('#fecha').val() ?? '',
                    idproveedor: $('#proveedor_filtro').val() ?? ''
                })
            );

            $('#listartable').DataTable().ajax.reload(function() {});
        })
    })
</script>

<?= $this->endSection() ?>