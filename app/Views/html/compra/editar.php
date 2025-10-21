<?= $this->extend('plantilla/layout') ?>

<?= $this->section('titulo') ?>
<?= $pagina ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2.min.css" /> 
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap-3/select2-bootstrap.css" /> 
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/select2/dist/css/select2-bootstrap4.min.css" /> 
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" /> 
    <style>
      .summary-box {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            border-radius: 12px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .summary-row:last-child {
            margin-bottom: 0;
            padding-top: 0.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: 600;
        }

        
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!--begin::Row-->
<div class="row">
  <div class="col-12 col-md-6 px-0 px-sm-3">
    <div class="card shadow-none rounded-0">
      <div class="card-header rounded-0">
        <h4 class="card-title fs-6 mb-0">
          Información de Compra
      </h4>
      </div>
      <div class="card-body">
        <div class="frm-info-compra pb-3">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="proveedor">Proveedor</label>
                <select class="form-select" id="proveedor">
                </select>
              </div>
            </div>
            <div class="col-md-6 mt-3 mt-md-0">
              <div class="form-group">
                <label for="fecha">Fecha de Compra</label>
                <input type="text" class="form-control" id="fecha" value="<?= date("Y-m-d") ?>">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 px-0 px-sm-3">
    <div class="card shadow-none rounded-0">
      <div class="card-header rounded-0">
        <h4 class="card-title fs-6 mb-0">
          Agregar Productos
        </h4>
      </div>
      <div class="card-body">
        <div class="frm-info-compra pb-3">
          <div class="row">
          <div class="col-md-8">
              <div class="form-group">
                <label for="producto-select" class="form-label">Seleccionar Producto</label>
                <select class="form-select" id="producto-select">
                </select>
              </div>
            </div>
            <div class="col-md-4 d-flex align-items-end mt-3 mt-md-0">
              <button type="button" class="btn btn-primary w-100" id="agregarDetalle">
                <i class="fas fa-plus me-1"></i>
                Agregar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-12 px-0 px-sm-3 mt-3">
    <div class="card shadow-none rounded-0">
      <div class="card-header rounded-0">
        <h4 class="card-title fs-6 mb-0">
          Detalle de Productos
        </h4>
      </div>
      <div class="card-body">
        <div class="table-container">
          <table class="table table-hover mb-0">
              <thead>
                  <tr>
                      <th>Producto</th>
                      <th class="text-left">Cantidad</th>
                      <th class="text-left">Precio Unit.</th>
                      <th class="text-left">Total</th>
                      <th class="text-center">Acción</th>
                  </tr>
              </thead>
              <tbody id="tabla-productos">
                  <tr class="empty-state">
                      <td colspan="5">
                          <i class="fas fa-cart-arrow-down fa-3x d-block mb-2"></i>
                          No hay productos agregados
                      </td>
                  </tr>
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-5 px-sm-3 px-0 mt-3">
    <div class="card shadow-none rounded-0">
      <div class="card-header rounded-0">
        <h4 class="card-title fs-6 mb-0">
          Resumen de Compra
        </h4>
      </div>
      <div class="card-body">
        <div class="summary-box p-3 mb-3">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span id="subtotal">$0.00</span>
            </div>
            <div class="summary-row">
                <span>IVA (15%):</span>
                <span id="iva">$0.00</span>
            </div>
            <div class="summary-row">
                <span>Total:</span>
                <span id="total">$0.00</span>
            </div>
        </div>
        
        <button type="button" class="btn btn-success w-100 py-2 mb-3" id="guardarCompra">
            <i class="fas fa-save me-2"></i>
            Guardar Compra
        </button>

        <button type="button" class="btn btn-outline-secondary w-100" id="limpiarCompra">
            <i class="fas fa-broom me-2"></i>
            Limpiar Todo
        </button>
      </div>
    </div>
  </div>
</div>
<!--end::Row-->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url() ?>/assets/plugins/cedulayruc.js" type="text/javascript"></script>
<script src="<?= base_url() ?>/assets/plugins/select2/dist/js/select2.full.min.js"></script> 
<script src="<?= base_url() ?>/assets/plugins/select2/dist/js/i18n/es.js"></script> 

<script src="<?= base_url() ?>/assets/plugins/moment/moment.min.js"></script> 
<script src="<?= base_url() ?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> 
<script src="<?= base_url() ?>/assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script> 
<script type="text/javascript">
  $(function(){
    $('#fecha').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        orientation:"bottom",
        language: 'es'
    }).on('changeDate', function(e) {});
    
    $("#proveedor").select2({
        placeholder: 'Seleccionar un proveedor',
        theme: 'bootstrap4',
        width: '80%',
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

    function formatState (state) {
      if (!state.id) {
        return state.text;
      }

      var $state = $(
        '<span><img width="15" src="<?= base_url() ?>'+ state.imagen + '" class="img-flag" /> ' + state.text + '</span>'
      );
      return $state;
    };

    function formatStateSelection(state) {
      if (!state.id) {
        return state.text;
      }
      var $state = $(
        '<span><img width="15" class="img-flag" /> <span></span></span>'
      );

      // Use .text() instead of HTML string concatenation to avoid script injection issues
      $state.find("span").text(state.text);
      $state.find("img").attr("src", "<?= base_url() ?>" + state.imagen);

      return $state;
    };

    $("#producto-select").select2({
        placeholder: 'Seleccionar un producto',
        theme: 'bootstrap4',
        templateResult: formatState,
        templateSelection: formatStateSelection,
        width: '80%',
        ajax: {
            url: '<?= base_url(route_to('producto.select')) ?>',
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
                            id: obj.idproducto,
                            text: obj.nombre,
                            imagen: obj.imagen,
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

    const localStorageCrud = {
      save: function(key, data) {
          localStorage.setItem(compra.nameLocalStorage, JSON.stringify(data));
      },

      get: function(key) {
          const data = localStorage.getItem(compra.nameLocalStorage);
          return data ? JSON.parse(data) : null;
      },

      update: function(key, newData) {
          let data = this.get(compra.nameLocalStorage);
          if (data) {
              data = {...data, ...newData};
              this.save(compra.nameLocalStorage, data);
              return true;
          }
          return false;
      },

      delete: function(key) {
          localStorage.removeItem(compra.nameLocalStorage);
      },

      clear: function() {
          localStorage.clear();
      },

      exists: function(key) {
          return localStorage.getItem(compra.nameLocalStorage) !== null;
      },

      appendToArray: function(key, item) {
          let array = this.get(compra.nameLocalStorage) || [];
          array.push(item);
          this.save(compra.nameLocalStorage, array);
      },

      removeFromArray: function(key, index) {
          let array = this.get(compra.nameLocalStorage);
          if (array && array.length > index) {
              array.splice(index, 1);
              this.save(compra.nameLocalStorage, array);
              return true;
          }
          return false;
      }
    }
    // Lógica de añadir productos a la compra
    const compra = {
        nameLocalStorage:"compraEdit",
        productos: [],
        subtotal: 0,
        iva: 0,
        ivaPorc: 0.15,
        total: 0,
        cabecera:{
          proveedor: {
            id:0,
            nombre:""
          },
          fecha:""
        },
        id: () => new Date().getTime(),
        agregarProducto: (producto, cantidad) => {
            const productoExistente = compra.productos?.find(p => p.idProducto == producto.idProducto);
            if (productoExistente) {
                productoExistente.cantidad += cantidad;
            } else {
                producto.cantidad = cantidad;
                compra.productos.push(producto);
            }

            compra.listar();
            return true;
        },
        listar: () => {
          const tabla = $("#tabla-productos");
          // Limpiar solo las filas del cuerpo
          tabla.find("tr").remove();
          if (tabla.length === 0) return;
          if (compra.productos.length === 0) {
              tabla.append(`<tr class="empty-state">
                  <td colspan="5">
                      <i class="fas fa-cart-arrow-down fa-3x d-block mb-2"></i>
                      No hay productos agregados
                  </td>
              </tr>`);
              return;
          }
          
          let totalDetalle = 0;
          const tbody = tabla.find("tbody").length ? tabla.find("tbody") : tabla;
          
          compra.productos.forEach((producto, index) => {
            const fila = $("<tr>").data("index", index);
            const subtotal = parseFloat(producto.precioCompra * producto.cantidad);
            totalDetalle += subtotal;

            // Columna Nombre
            fila.append($("<td>").text(producto.nombre));
            
            // Columna Cantidad (input editable)
            const inputCantidad = $("<input>")
              .attr("type", "number")
              .addClass("form-control form-control-sm cantidad")
              .val(producto.cantidad)
              .on("change", function() {
                const newCantidad = parseFloat($(this).val()) || 0;
                compra.productos[index].cantidad = newCantidad;
                compra.actualizarSubtotal(fila);
              });
            fila.append($("<td>").append(inputCantidad));
            
            // Columna Precio (input editable)
            const inputPrecio = $("<input>")
              .attr("type", "number")
              .addClass("form-control form-control-sm precio")
              .val(producto.precioCompra)
              .on("change", function() {
                const newPrecio = parseFloat($(this).val()) || 0;
                compra.productos[index].precioCompra = newPrecio;
                compra.actualizarSubtotal(fila);
              });
            fila.append($("<td>").append(inputPrecio));
            
            // Columna Subtotal
            fila.append($("<td>").addClass("subtotal").text(subtotal.toFixed(2)));
            
            // Columna Acciones
            const btnEliminar = $("<button>")
              .addClass("btn btn-danger btn-sm")
              .text("Eliminar")
              .on("click", () => compra.eliminarProducto(index));
            
            fila.append($("<td>").addClass("text-center").append(btnEliminar));
            tbody.append(fila);
          });

          // Actualizar total
          $("#total-detalle").text(totalDetalle.toFixed(2));
          compra.actualizarTotal();
          return true;
        },
        
        actualizarSubtotal: (fila) => {
          const index = fila.data("index");
          const producto = compra.productos[index];
          
          // Calcular nuevo subtotal
          const subtotal = producto.cantidad * producto.precioCompra;
          fila.find(".subtotal").text(subtotal.toFixed(2));
          
          // Recalcular total general
          let totalDetalle = 0;
          $("#tabla-productos tbody tr").each(function() {
            totalDetalle += parseFloat($(this).find(".subtotal").text());
          });
          
          $("#total-detalle").text(totalDetalle.toFixed(2));

          compra.actualizarTotal();
        },

        actualizarTotal: () => {
          let subtotal = 0;
          compra.productos.forEach(producto => {
              subtotal += producto.precioCompra * producto.cantidad;
          });

          // Calculate IVA (15%)
          const iva = subtotal * compra.ivaPorc;

          // Calculate total
          const total = subtotal + iva;

          // Update display values
          $('#subtotal').text('$' + subtotal.toFixed(2));
          $('#iva').text('$' + iva.toFixed(2)); 
          $('#total').text('$' + total.toFixed(2));

          // Store values in compra object
          compra.subtotal = subtotal;
          compra.iva = iva;
          compra.total = total;

          localStorageCrud.save("compra", compra);

          return true;
        },
        
        eliminarProducto: (index) => {
          compra.productos.splice(index, 1);
          compra.listar();
        },

        cargarCompraGuardada: () => {
            const compraGuardada = localStorageCrud.get("compra");
            if (compraGuardada) {
                // Restore saved purchase data
                compra.productos = compraGuardada.productos || [];
                compra.subtotal = compraGuardada.subtotal || 0;
                compra.iva = compraGuardada.iva || 0;
                compra.total = compraGuardada.total || 0;
                compra.cabecera = compraGuardada.cabecera || {
                    proveedor: { id: 0, nombre: "" },
                    fecha: ""
                };

                // Restore provider if exists
                if (compra.cabecera.proveedor.id) {
                    const proveedorOption = new Option(
                        compra.cabecera.proveedor.nombre,
                        compra.cabecera.proveedor.id,
                        true,
                        true
                    );
                    $("#proveedor").append(proveedorOption).trigger('change');
                    // $("#proveedor").val(compra.cabecera.proveedor.id).trigger('change');
                }

                // Restore date if exists
                if (compra.cabecera.fecha) {
                    $("#fecha").datepicker('update', compra.cabecera.fecha);
                }

                // Refresh products table
                compra.listar();
                return true;
            }
            return false;
        },

        guardarCompra: () => {
          // Validate provider and date before saving purchase
          if (!$("#proveedor").val()) {
              toastr.error("Debe seleccionar un proveedor para la compra");
              return;
          }

          if (!$("#fecha").val()) {
              toastr.error("Debe seleccionar una fecha válida para la compra"); 
              return;
          }

          if (compra.productos.length === 0) {
              toastr.error("Debe agregar al menos un producto a la compra");
              return;
          }

          // Get provider data
          const proveedor = $("#proveedor").select2("data")[0];
          compra.cabecera.proveedor = {
              id: proveedor.id,
              nombre: proveedor.text
          };

          // Get purchase date
          compra.cabecera.fecha = $("#fecha").val();

          compra.actualizarTotal();

          // Save purchase data
          $.ajax({
              url: '<?= base_url(route_to('compra.actions')) ?>',
              method: 'POST',
              data: {
                  "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                  action: "edit",
                  id: <?= $idValue ?>,
                  compra: {
                      cabecera: compra.cabecera,
                      detalle: compra.productos
                  }
              },
              success: function(response) {
                  if (response.resp) {
                      toastr.success("Compra guardada exitosamente");
                      // Clear local storage and reset form
                      localStorageCrud.delete("compra");
                      compra.productos = [];
                      compra.listar();
                      $("#proveedor").val(null).trigger('change');
                      $("#fecha").datepicker('update', '<?= date("Y-m-d") ?>');
                      window.location = '<?= base_url(route_to('compra')) ?>'
                  } else {
                      toastr.error("Error al guardar la compra: " + response.message);
                  }
              },
              error: function(xhr, status, error) {
                  toastr.error("Error al procesar la solicitud: " + error);
              }
          });
        },
        limpiarTodo: () => {
          compra.productos = [];
          compra.listar();
          localStorageCrud.delete("compra");
        }
    }

    $( "#agregarDetalle" ).click(()=>{
      const producto = $("#producto-select").select2("data")[0];
      if(producto){
        const productoJson = {
          id: compra.id(),
          nombre: producto?.text || "",
          idProducto: producto?.id || "",
          precioCompra: 1,
          cantidad: 1,
          imagen: producto?.imagen || ""
        }
        compra.agregarProducto(productoJson, 1);
      }else{
        toastr.error("Existe un error, no hay productos que agregar al detalle");
      }
    })

    $( "#guardarCompra" ).click(function(){
      compra.guardarCompra();
    })

    $( "#limpiarCompra" ).click(function(){
      compra.limpiarTodo();
    })

    const initEditar = () => {
        const compraEdit = <?= json_encode($data) ?>;

        const detalleData = compraEdit?.detalle;
        const cabecera = compraEdit?.cabecera;

        for(var i in detalleData){
            const producto = detalleData[i];
            const productoJson = {
                id: compra.id(),
                nombre: producto?.nombreProducto || "",
                idProducto: producto?.idproducto || "",
                precioCompra: producto?.precio_compra,
                cantidad: producto?.cantidad,
                imagen: producto?.imagen || ""
            }
            compra.agregarProducto(productoJson, producto?.cantidad);
        }

        // Restore provider if exists
        if (cabecera.idpersona) {
            const proveedorOption = new Option(
                cabecera.nombreCliente,
                cabecera.idpersona,
                true,
                true
            );
            $("#proveedor").append(proveedorOption).trigger('change');
            // $("#proveedor").val(compra.cabecera.proveedor.id).trigger('change');
        }

        // Restore date if exists
        if (cabecera.fecha) {
            $("#fecha").datepicker('update', cabecera.fecha);
        }
    }

    initEditar();
  })
</script>

<?= $this->endSection() ?>  