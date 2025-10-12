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
    M. Usuarios
  </h1>
</div>
<!--begin::Row-->
<div class="row">
    <div class="col-12 px-0 px-sm-3">
        <div class="mb-5">
            <p class="text-muted h6 fw-light">
                Gestión de roles y accesos del sistema.
            </p>
        </div>
        <!-- Tables Row -->
        <div class="row g-4">
            <div class="col-xl-12">
                <div class="d-flex justify-content-between align-items-sm-end">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs border-bottom-0 d-none d-sm-flex">
                        <li class="nav-item">
                            <a class="nav-link <?= isset($_GET['papelera']) ? '' : 'active' ?>" aria-current="page" href="<?= base_url(route_to('rol')) ?>">
                                Registros activos (<?= $registros_no_eliminados ?>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= !isset($_GET['papelera']) ? '' : 'active' ?>" href="<?= base_url(route_to('rol')) ?>?papelera=1">
                                Registros eliminados (<?= $registros_eliminados ?>)
                            </a>
                        </li>
                    </ul>

                    <!-- Dropdown a la derecha -->
                    <div class="dropdown ms-sm-auto mb-1">
                        <a class="btn btn-success rounded-0" href="<?= base_url(route_to('rol.crear')) ?>">
                            <i class="fas fa-plus"></i> Nuevo Registro
                        </a>
                    </div>
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

<!-- Modal -->
<div class="modal fade" id="permisosModal" tabindex="-1" aria-labelledby="permisosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-black">
                <h5 class="modal-title text-white" id="permisosModalLabel">
                    <i class="bi bi-person-badge"></i> Asignación de módulos del sistema
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Información del Usuario -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Rol:</strong> <span id="userRole">Editor</span></p>
                            </div>
                            <div class="col-md-12">
                                <button id="reset_permisos" type="button" class="btn btn-warning btn-sm mt-2">
                                    <i class="bi bi-arrow-clockwise"></i> Restablecer Permisos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Permisos -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-sm table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 30%;">Módulo/Página</th>
                                <th class="text-center" style="width: 17.5%;">
                                    <i class="bi bi-eye"></i><br>
                                    <span class="permission-label">Ver</span>
                                </th>
                                <th class="text-center" style="width: 17.5%;">
                                    <i class="bi bi-plus-circle"></i><br>
                                    <span class="permission-label">Crear</span>
                                </th>
                                <th class="text-center" style="width: 17.5%;">
                                    <i class="bi bi-pencil"></i><br>
                                    <span class="permission-label">Editar</span>
                                </th>
                                <th class="text-center" style="width: 17.5%;">
                                    <i class="bi bi-trash"></i><br>
                                    <span class="permission-label">Eliminar</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Cargando permisos...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
                <button type="button" class="btn btn-success d-none">
                    <i class="bi bi-check-circle"></i> Guardar Permisos
                </button>
            </div>
        </div>
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
    $(function() {
        var column = ['Nombre del rol'];
        var dibujarColumn = '<tr>';
        for (var i in column) {
            dibujarColumn += '<th>' + column[i] + '</th>';
        }
        dibujarColumn += '<th style="min-width: 10%;width:10%!important;" class="text-start text-sm-center">Acción</th>' + '</tr>';

        $('#thead').append(dibujarColumn);
        $('#tfoot').append(dibujarColumn);

        datatable = $('#listartable').DataTable({
            processing: true,
            serverSide: true,
            "ajax": {
                url: '<?php echo base_url(route_to('rol.actions')); ?>',
                "type": "POST",
                "data": function(d) {
                    // Agrega los parámetros necesarios a cada solicitud
                    d.eliminado = <?= isset($_GET['papelera']) ? '1' : '0' ?>;
                    d.action = "list";
                    d['<?= csrf_token() ?>'] = "<?= csrf_hash() ?>";
                    d.idrol = $('select[data-name="filtroTipo"]').val() ?? "";
                    return d;
                }
            },
            rowId: 'idrol', 
            pageLength: 10,
            autoWidth: false,
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Detalles de ' + data['nombre'];
                        }
                    }),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },
            language: {
                "sSearch": "<span class='fas fa-search'></span> ",
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
            columns: [{
                    "data": "nombre",
                    "name": "rol.nombre",
                    "render": function(d, t, f) {
                        return d;
                    },
                    sDefaultContent: "",
                    className: 'gradeA',
                    "orderable": true,
                    "responsivePriority": 1
                }, 
                {
                    "data": "accion",
                    "render": function(d, t, f) {
                        return d;
                    },
                    sDefaultContent: "",
                    className: 'gradeA btn-action text-start text-sm-center',

                    "orderable": false,
                    "searchable": false,
                    "responsivePriority": 1
                }
            ],
            "initComplete": function(settings, json) {
                // setTimeout(function() {
                //     datatable.responsive.rebuild();
                //     datatable.responsive.recalc();
                // }, 1500);
                $(".dt-paging ul.pagination").addClass("pagination-sm");

            }
        });

        $('#admin_cr').on('click', 'a[data-action="elim"]', function(e) {
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
                        url: '<?php echo base_url(route_to('rol.actions')); ?>',
                        type: 'POST',
                        data: {
                            '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                            'action': 'del',
                            'id': id
                        },
                        dataType: 'JSON',
                        beforeSend: function() {
                            //$('#icono_eliminar').html('<i class=" fa fa-refresh fa-spin fa-5x"></i>');
                            //$('#texto_eliminar').html('<h4>Espere</h4><p>Eliminando el dato</p>');
                            //$('#footer_eliminar').css('display', 'none');
                            $('a[data-action="elim"]').addClass('disabled');
                        }
                    }).done(function(data) {
                        if (data.resp) {
                            $('#listartable').DataTable().ajax.reload(function() {
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
                    }).fail(function() {
                        toastr.error("Existe un error", "No se pudo eliminar el registro");
                        $('a[data-action="elim"]').removeClass('disabled');
                    });

                }
            })
        });

        $('#admin_cr').on('click', 'a[data-action="restore"]', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: '<?php echo base_url(route_to('rol.actions')); ?>',
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    'action': 'restore',
                    'id': id
                },
                dataType: 'JSON',
                beforeSend: function() {
                    //$('#icono_eliminar').html('<i class=" fa fa-refresh fa-spin fa-5x"></i>');
                    //$('#texto_eliminar').html('<h4>Espere</h4><p>restaurando el dato</p>');
                    //$('#footer_eliminar').css('display', 'none');
                    $('a[data-action="restore"]').addClass('disabled');
                }
            }).done(function(data) {
                if (data.resp) {
                    $('#listartable').DataTable().ajax.reload(function() {
                        $('a[data-action="restore"]').removeClass('disabled');
                        Swal.fire(
                            'Dato restaurado!',
                            'El registro se restauró con éxito!.',
                            'success'
                        );

                        setTimeout(function() {
                            location.reload()
                        }, 1000);
                    });
                    return;
                } else {
                    toastr.error("Existe un error", "No se pudo restaurar el registro");
                    $('a[data-action="restore"]').removeClass('disabled');
                }
            }).fail(function() {
                toastr.error("Existe un error", "No se pudo restaurar el registro");
                $('a[data-action="restore"]').removeClass('disabled');
            });
        });


        $('#form_resetpass').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url() . route_to('rol.actions'); ?>',
                type: 'POST',
                data: {
                    'action': 'pass',
                    'id': $('#idlogin').val(),
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    'pass': $('#pass').val()
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('#save_resetpass').prop('disabled', true);
                }
            }).done(function(data) {
                if (data.resp) {
                    $('#listartable').DataTable().ajax.reload(function() {
                        $('#save_resetpass').prop('disabled', false);
                        Swal.fire(
                            'Contraseña cambiada!',
                            'El registro se guardó con éxito!.',
                            'success'
                        );
                        $('#resetpass').modal('hide');
                        $('#pass').val('');
                    });
                } else {
                    toastr.error("Existe un error", "No se pudo cambiar la contraseña");
                    $('#save_resetpass').prop('disabled', false);
                }
                return true;
            }).fail(function() {
                toastr.error("Existe un error", "No se pudo cambiar la contraseña");
                $('#save_resetpass').prop('disabled', false);
            });
        });

        $('#admin_cr').on('change', 'select[data-name="filtroTipo"]', function() {
            $('#listartable').DataTable().ajax.reload(function() {});
        });

        $('#admin_cr').on('click', 'a[data-action="edit-rol"]', function() {
            const url = $(this).data('id');
            window.location.href = url;
        });

        $('#admin_cr').on('click', 'a[data-action="asignacion-perfil"]', function() {
            const idrol = $(this).data('id') ?? 0;
            let datosRol = obtenerDatosPorId(idrol);
            // console.log("datosRol", datosRol)
            // Actualizar información del rol en el modal
            // $('#userName').text(datosRol.nombre || 'N/A');
            // $('#userEmail').text(datosRol.correo_elec || 'N/A');
            $('#userRole').text(datosRol.nombre || 'N/A');
            // $('#modal_estado_rol').html(datosRol.estado_rol_text || 'N/A');

            $('#permisosModal').modal('show');
            $('#reset_permisos').val(idrol);

            cargarPermisos(idrol).then(response => {
                let { resp = false, data : dataLocal } = response.data;
                dataLocal = dataLocal.sort((a, b) => a.opcion_menu - b.opcion_menu);

                if(dataLocal.length == 0){
                    $('#permisosModal tbody').html('<tr><td colspan="5" class="text-center text-muted">No hay permisos disponibles para este rol.</td></tr>');
                    return;
                }
                // Limpiar el cuerpo de la tabla antes de agregar nuevos permisos
                $('#permisosModal tbody').empty();

                for(var i in dataLocal){
                    const row = rowTemplatePermisos(dataLocal[i]);
                    // console.log(row)
                    $('#permisosModal tbody').append(row);
                }
                
            });

        });

        function obtenerDatosPorId(idPrincipal) {
            const tabla = $('#listartable').DataTable();
            const filas = tabla.rows().nodes();
            
            // Buscar la fila por ID
            const fila = $(filas).filter(`[id="${idPrincipal}"]`);
            
            if (fila.length) {
                return tabla.row(fila).data();
            }
            
            return {};
        }

        function rowTemplateCheck(checked = 0, permiso = 'leer'){
            if(checked == 0){
                return `<input permiso-tipo="${permiso}" class="form-check-input" type="checkbox">`;
            }

            return `<input permiso-tipo="${permiso}" class="form-check-input" type="checkbox" checked>`;

        }

        function rowTemplatePermisos(permiso){
            const {opcion_menu = '', leer = 0, crear = 0, actualizar = 0, eliminar = 0} = permiso;
            try {
                return `<tr id-detrol="${permiso.iddetalle_rol}">
                            <td class="module-name">
                                <div class="d-flex flex-row gap-1 align-items-center">
                                    <i class="fas fa-cog me-1"></i>${opcion_menu?.toLowerCase()}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check d-inline-block">
                                    ${rowTemplateCheck(leer, 'leer')}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check d-inline-block">
                                    ${rowTemplateCheck(crear, 'crear')}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check d-inline-block">
                                    ${rowTemplateCheck(actualizar, 'actualizar')}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check d-inline-block">
                                    ${rowTemplateCheck(eliminar, 'eliminar')}
                                </div>
                            </td>
                        </tr>`;
            } catch (error) {
                console.error("Error al generar la fila de permisos:", error);
                return [];
            }
        }

        async function cargarPermisos(idrol) {
            return $.ajax({
                url: '<?php echo base_url(route_to('rol.actions')); ?>',
                type: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    'action': 'get.permisos',
                    'id': idrol
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('#permisosModal tbody').html('<tr><td colspan="5" class="text-center text-muted">Cargando permisos...</td></tr>');
                }
            }).done(function(response) {
                if (response.resp) {
                    return response.data;
                } else {
                    throw new Error("No se pudieron cargar los permisos");
                }
            }).fail(function() {
                toastr.error("Existe un error", "No se pudo cargar los permisos");
                return []
            });
        }

        $('#permisosModal tbody').on('change', '.form-check-input', function() {
            const input = $(this);
            const row = $(this).closest('tr');
            const iddetalle_rol = row.attr('id-detrol');
            const permisoTipo = $(this).attr('permiso-tipo');
            const isChecked = $(this).is(':checked') ? 1 : 0;

            // Aquí puedes manejar el cambio de estado del permiso
            //console.log(`Permiso ID: ${permisoId}, Tipo: ${permisoTipo}, Estado: ${isChecked}`);
            $.ajax({
                url: '<?php echo base_url() . route_to('rol.actions'); ?>',
                type: 'POST',
                data: {
                    'action': 'post.permisos',
                    'iddetalle_rol': iddetalle_rol,
                    'tipo': permisoTipo,
                    'estado': isChecked,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                },
                dataType: 'JSON',
                beforeSend: function() {
                    input.prop('disabled', true);
                }
            }).done(function(data) {
                if (data.resp) {
                    input.prop('disabled', false);
                } else {
                    throw new Error("No se pudieron actualizar los permisos");
                }
                return true;
            }).fail(function() {
                toastr.error("Existe un error", "No se pudo editar el permiso");
                input.prop('disabled', false);
            });
        });

        $('#reset_permisos').on('click', function() {
            const btn = $(this);
            const idrol = btn.val();
            

            // Aquí puedes manejar el cambio de estado del permiso
            //console.log(`Permiso ID: ${permisoId}, Tipo: ${permisoTipo}, Estado: ${isChecked}`);
            $.ajax({
                url: '<?php echo base_url() . route_to('rol.actions'); ?>',
                type: 'POST',
                data: {
                    'action': 'reset.permisos',
                    'id': idrol,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                },
                dataType: 'JSON',
                beforeSend: function() {
                    btn.prop('disabled', true);
                }
            }).done(function(data) {
                if (data.resp) {
                    btn.prop('disabled', false);
                    cargarPermisos(idrol).then(response => {
                        let { resp = false, data : dataLocal } = response.data;
                        // console.log("data", dataLocal)
                        dataLocal = dataLocal.sort((a, b) => a.opcion_menu - b.opcion_menu);

                        if(dataLocal.length == 0){
                            $('#permisosModal tbody').html('<tr><td colspan="5" class="text-center text-muted">No hay permisos disponibles para este rol.</td></tr>');
                            return;
                        }
                        // Limpiar el cuerpo de la tabla antes de agregar nuevos permisos
                        $('#permisosModal tbody').empty();

                        for(var i in dataLocal){
                            const row = rowTemplatePermisos(dataLocal[i]);
                            // console.log(row)
                            $('#permisosModal tbody').append(row);
                        }
                        
                    });
                } else {
                    throw new Error("No se pudieron actualizar los permisos");
                }
                return true;
            }).fail(function() {
                toastr.error("Existe un error", "No se pudo resetear los permisos");
                btn.prop('disabled', false);
            });
        });

        // Simular guardado de permisos
        // document.querySelector('.btn-success').addEventListener('click', function() {
        //     const permisos = {};
        //     const rows = document.querySelectorAll('tbody tr');

        //     rows.forEach((row, index) => {
        //         const modulo = row.querySelector('.module-name').textContent.trim();
        //         const checkboxes = row.querySelectorAll('.form-check-input');

        //         permisos[modulo] = {
        //             ver: checkboxes[0].checked ? 1 : 0,
        //             crear: checkboxes[1].checked ? 1 : 0,
        //             editar: checkboxes[2].checked ? 1 : 0,
        //             eliminar: checkboxes[3].checked ? 1 : 0
        //         };
        //     });

        //     console.log('Permisos a guardar:', permisos);
        //     alert('Permisos guardados correctamente');

        //     // Cerrar modal
        //     const modal = bootstrap.Modal.getInstance(document.getElementById('permisosModal'));
        //     modal.hide();
        // });
    })
</script>

<?= $this->endSection() ?>