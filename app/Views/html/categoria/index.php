<?= $this->extend('plantilla/layout') ?>

<?= $this->section('titulo') ?> 
    <?= $pagina ?> | <?= $titulo ?> <?= json_encode(session('usuario')['usuario']) ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <style type="text/css">
        .table.dataTable thead .sorting_desc,
        .table.dataTable thead .sorting_asc,
        .table.dataTable thead .sorting {
          background: none;
        }
        .btn-action{
            width: 12%;
            text-align: center;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0px !important;
            border: 0px !important;
        }
        .gradeA.estado{
            min-width: 65px!important;
            width: 65px!important;
        }
    </style> 
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!--begin::Row-->
<div class="row">
  <div class="col-12 px-0 px-sm-3">
    <!-- Default box -->
     <div class="d-flex justify-content-between mb-2">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['papelera'])?'':'active' ?>" aria-current="page" href="<?= base_url(route_to('categoria')) ?>">Registros (<?= $registros_no_eliminados ?>)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isset($_GET['papelera'])?'active':'' ?>" href="<?= base_url(route_to('categoria')) ?>?papelera=1">Eliminados (<?= $registros_eliminados ?>)</a>
            </li>
        </ul>
        <a class="btn btn-success" href="<?= base_url(route_to('categoria.crear')) ?>">
            <i class="bi bi-plus-lg"></i>
            Crear Registro
        </a>
    </div>
    <div class="card shadow-none">
      <div class="card-header">
        <h3 class="card-title">
          Listado de <?= $titulo ?>
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
        <table id="listartable" style="width:100%" class="table table-striped table-bordered nowrap">
          <thead id="thead">
          </thead>
          <tbody id="tbody_">
          </tbody>
        </table>
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
<!-- Responsive examples -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script> 
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>

<script type="text/javascript">
    var datatable;
    $(function(){
        var column = ['Empresa vinculado','Nombre','Estado'];
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
                    url: '<?php echo base_url(route_to('categoria.actions')); ?>',
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
                      "data": "empresa", "name":"empresa.nombre", "render": function (d, t, f) {
                          return d;
                      },
                      sDefaultContent: "",
                      className: 'gradeA',
                      "orderable": true
                  },
                  { 
                      "data": "nombre", "name":"categoria.nombre", "render": function (d, t, f) {
                            return d;
                        },
                        sDefaultContent: "",
                        className: 'gradeA',
                        "orderable": true
                  },
                  { 
                      "data": "estado", "name":"categoria.estado", "render": function (d, t, f) {
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
                    url: '<?php echo base_url(route_to('categoria.actions')); ?>',
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
                url: '<?php echo base_url(route_to('categoria.actions')); ?>',
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
                url: '<?php echo base_url(route_to('categoria.actions')); ?>',
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