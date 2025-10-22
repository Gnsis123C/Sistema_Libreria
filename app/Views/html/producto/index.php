<?= $this->extend('plantilla/layout') ?>

<?= $this->section('titulo') ?>
<?= $titulo ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
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
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="mb-4">
  <h1 class="display-6 fw-bold mb-2 text-dark">
    M. Productos
  </h1>
</div>
<!--begin::Row-->
<div class="row">
    <div class="col-12 px-0 px-sm-3">
        <!-- Tables Row -->
        <div class="row g-4">
            <div class="col-xl-12">
                <div class="d-flex justify-content-between align-items-sm-end">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs border-bottom-0 d-none d-sm-flex">
                        <li class="nav-item">
                            <a class="nav-link <?= isset($_GET['papelera']) ? '' : 'active' ?>" aria-current="page" href="<?= base_url(route_to('producto')) ?>">
                                Registros activos (<?= $registros_no_eliminados ?>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= !isset($_GET['papelera']) ? '' : 'active' ?>" href="<?= base_url(route_to('producto')) ?>?papelera=1">
                                Registros eliminados (<?= $registros_eliminados ?>)
                            </a>
                        </li>
                    </ul>

                    <!-- Dropdown a la derecha -->
                    <?php if ($esConsedido->crear): ?>
                        <!-- Dropdown a la derecha -->
                        <div class="dropdown ms-sm-auto mb-1">
                            <a class="btn btn-success rounded-0" href="<?= base_url(route_to('producto.crear')) ?>">
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
<script src="<?= base_url() ?>/assets/plugins/lightbox2/js/lightbox.js"></script> 

<script type="text/javascript">
    var datatable;
    $(function(){
        var column = ['Nombre','Imagen','Categoría','Descripción','Precio de venta','Stock restante', 'Stock notificación','Estado'];
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
                    url: '<?php echo base_url(route_to('producto.actions')); ?>',
                    "type": "POST",
                    "data": function (d) {
                        // Agrega los parámetros necesarios a cada solicitud
                        d.eliminado = <?= isset($_GET['papelera'])?'1':'0' ?>;
                        d.action = "list";
                        d['<?= csrf_token() ?>'] = "<?= csrf_hash() ?>";
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
                      "data": "nombre", "name":"producto.nombre", "render": function (d, t, f) {
                            return d;
                        },
                        sDefaultContent: "",
                        className: 'gradeA',
                        "orderable": true
                  },
                  { 
                      "data": "imagen", "name":"producto.imagen", "render": function (d, t, f) {
                            return d;
                        },
                        sDefaultContent: "",
                        className: 'gradeA img-producto',
                        "orderable": true
                  },
                  { 
                      "data": "categoria", "name":"categoria.nombre", "render": function (d, t, f) {
                          return d;
                      },
                      sDefaultContent: "",
                      className: 'gradeA',
                      "orderable": true
                  },
                  { 
                      "data": "descripcion", "name":"producto.descripcion", "render": function (d, t, f) {
                            return d;
                        },
                        sDefaultContent: "",
                        className: 'gradeA none', // Added 'none' class to hide in responsive mode
                        "orderable": true,
                        responsivePriority: 6 // Lower priority number means higher display priority
                  },
                  { 
                      "data": "precio_venta", "name":"producto.precio_venta", "render": function (d, t, f) {
                            return `${d} $`;
                        },
                        sDefaultContent: "",
                        className: 'gradeA none', // Added 'none' class to hide in responsive mode
                        "orderable": true,
                        responsivePriority: 6 // Lower priority number means higher display priority
                  },
                //   { 
                //       "data": "stock", "name":"producto.stock", "render": function (d, t, f) {
                //           return d;
                //       },
                //       sDefaultContent: "",
                //       className: 'gradeA',
                //       "orderable": true
                //   },
                  { 
                      "data": "stock_restante", "name":"producto.idproducto", "render": function (d, t, f) {
                          return d;
                      },
                      sDefaultContent: "",
                      className: 'gradeA',
                      "orderable": true
                  },
                  { 
                      "data": "stock_minimo", "name":"producto.stock_minimo", "render": function (d, t, f) {
                          return `<i class="fas fa-bell"></i> stock <= ${d}`;
                      },
                      sDefaultContent: "",
                      className: 'gradeA',
                      "orderable": true
                  },
                  { 
                      "data": "estado", "name":"producto.estado", "render": function (d, t, f) {
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
                        "searchable": false,
                        responsivePriority: 1 // Lower priority number means higher display priority
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
                    url: '<?php echo base_url(route_to('producto.actions')); ?>',
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
                url: '<?php echo base_url(route_to('producto.actions')); ?>',
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
                url: '<?php echo base_url(route_to('producto.actions')); ?>',
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
    })
</script>

<?= $this->endSection() ?>