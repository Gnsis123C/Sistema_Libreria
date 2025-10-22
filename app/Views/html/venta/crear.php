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
<div class="row mt-5">
  <div class="col-12 col-md-6 px-0 px-sm-3">
    <div class="card shadow-none rounded-0">
      <div class="card-header rounded-0">
        <h4 class="card-title fs-6 mb-0">
            Información de Venta
        </h4>
      </div>
      <div class="card-body">
        <div class="frm-info-venta pb-3">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="cliente">Cliente</label>
                <select class="form-select" id="cliente">
                </select>
              </div>
            </div>
            <div class="col-md-6 mt-3 mt-md-0">
              <div class="form-group">
                <label for="fecha">Fecha de Venta</label>
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
        <div class="frm-info-venta pb-3">
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
          Resumen de Venta
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
        
        <button type="button" class="btn btn-success w-100 py-2 mb-3" id="guardarVenta">
            <i class="fas fa-save me-2"></i>
            Guardar Venta
        </button>

        <button type="button" class="btn btn-outline-secondary w-100" id="limpiarVenta">
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
    
    $("#cliente").select2({
        placeholder: 'Seleccionar un cliente',
        theme: 'bootstrap4',
        width: '80%',
        ajax: {
            url: '<?= base_url(route_to('persona.select', 'cliente')) ?>',
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
        '<span><img width="15" src="<?= base_url() ?>'+ state.imagen + '" class="img-flag" /> ' + state.text + ' (' + state.stock + ')</span>'
      );
      return $state;
    };

    function formatStateSelection(state) {
      if (!state.id) {
        return state.text;
      }
      var $state = $(
        '<div><img width="15" class="img-flag" /><span id="title-select2"></span> <span id="stock-select2"></span></div>'
      );

      // Use .text() instead of HTML string concatenation to avoid script injection issues
      $state.find("#title-select2").text(state.text);
      $state.find("#stock-select2").text(state.stock || 0);
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
                    tipo: 'venta',
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
                            stock: obj.stock,
                            precio_venta: obj.precio_venta,
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
          localStorage.setItem(venta.nameLocalStorage, JSON.stringify(data));
      },

      get: function(key) {
          const data = localStorage.getItem(venta.nameLocalStorage);
          return data ? JSON.parse(data) : null;
      },

      update: function(key, newData) {
          let data = this.get(venta.nameLocalStorage);
          if (data) {
              data = {...data, ...newData};
              this.save(venta.nameLocalStorage, data);
              return true;
          }
          return false;
      },

      delete: function(key) {
          localStorage.removeItem(venta.nameLocalStorage);
      },

      clear: function() {
          localStorage.clear();
      },

      exists: function(key) {
          return localStorage.getItem(venta.nameLocalStorage) !== null;
      },

      appendToArray: function(key, item) {
          let array = this.get(venta.nameLocalStorage) || [];
          array.push(item);
          this.save(venta.nameLocalStorage, array);
      },

      removeFromArray: function(key, index) {
          let array = this.get(venta.nameLocalStorage);
          if (array && array.length > index) {
              array.splice(index, 1);
              this.save(venta.nameLocalStorage, array);
              return true;
          }
          return false;
      }
    }
    // Lógica de añadir productos a la venta
    const venta = {
        nameLocalStorage:"venta",
        productos: [],
        subtotal: 0,
        iva: 0,
        ivaPorc: 0.15,
        total: 0,
        cabecera:{
          cliente: {
            id:0,
            nombre:""
          },
          fecha:""
        },
        id: () => new Date().getTime(),
        agregarProducto: (producto, cantidad) => {
            const productoExistente = venta.productos?.find(p => p.idProducto == producto.idProducto);
            if (productoExistente) {
                productoExistente.cantidad += cantidad;
                if(producto.stock < productoExistente.cantidad){
                  productoExistente.cantidad = producto.stock;
                }
            } else {
                producto.cantidad = cantidad;
                if(producto.stock < producto.cantidad){
                  producto.cantidad = producto.stock;
                }
                venta.productos.push(producto);
            }

            venta.listar();
            return true;
        },

        listar: () => {
          const tabla = $("#tabla-productos");
          // Limpiar solo las filas del cuerpo
          tabla.find("tr").remove();
          if (tabla.length === 0) return;
          if (venta.productos.length === 0) {
              tabla.append(`<tr class="empty-state">
                  <td colspan="5">
                      <i class="fas fa-cart-arrow-down fa-3x d-block mb-2"></i>
                      No hay productos agregados
                  </td>
              </tr>`);
              localStorageCrud.save("venta", venta);
              return;
          }
          
          let totalDetalle = 0;
          const tbody = tabla.find("tbody").length ? tabla.find("tbody") : tabla;
          
          venta.productos.forEach((producto, index) => {
            const fila = $("<tr>").data("index", index);
            const subtotal = parseFloat(producto.precioVenta * producto.cantidad);
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
                venta.productos[index].cantidad = newCantidad;
                if(venta.productos[index].stock < venta.productos[index].cantidad){
                  venta.productos[index].cantidad = venta.productos[index].stock;
                  $(this).val(venta.productos[index].cantidad);
                }
                venta.actualizarSubtotal(fila);
              });
            fila.append($("<td>").append(inputCantidad));
            
            // Columna Precio (input editable)
            const inputPrecio = $("<input>")
              .attr("type", "number")
              .addClass("form-control form-control-sm precio")
              .val(producto.precioVenta)
              .on("change", function() {
                const newPrecio = parseFloat($(this).val()) || 0;
                venta.productos[index].precioVenta = newPrecio;
                venta.actualizarSubtotal(fila);
              });
            fila.append($("<td>").append(inputPrecio));
            
            // Columna Subtotal
            fila.append($("<td>").addClass("subtotal").text(subtotal.toFixed(2)));
            
            // Columna Acciones
            const btnEliminar = $("<button>")
              .addClass("btn btn-danger btn-sm")
              .text("Eliminar")
              .on("click", () => venta.eliminarProducto(index));
            
            fila.append($("<td>").addClass("text-center").append(btnEliminar));
            tbody.append(fila);
          });

          // Actualizar total
          $("#total-detalle").text(totalDetalle.toFixed(2));
          venta.actualizarTotal();
          return true;
        },
        
        actualizarSubtotal: (fila) => {
          const index = fila.data("index");
          const producto = venta.productos[index];
          
          // Calcular nuevo subtotal
          const subtotal = producto.cantidad * producto.precioVenta;
          fila.find(".subtotal").text(subtotal.toFixed(2));
          
          // Recalcular total general
          let totalDetalle = 0;
          $("#tabla-productos tbody tr").each(function() {
            totalDetalle += parseFloat($(this).find(".subtotal").text());
          });
          
          $("#total-detalle").text(totalDetalle.toFixed(2));

          venta.actualizarTotal();
          
        },

        actualizarTotal: () => {
          let subtotal = 0;
          venta.productos.forEach(producto => {
              subtotal += producto.precioVenta * producto.cantidad;
          });

          // Calculate IVA (15%)
          const iva = subtotal * venta.ivaPorc;

          // Calculate total
          const total = subtotal + iva;

          // Update display values
          $('#subtotal').text('$' + subtotal.toFixed(2));
          $('#iva').text('$' + iva.toFixed(2)); 
          $('#total').text('$' + total.toFixed(2));

          // Store values in venta object
          venta.subtotal = subtotal;
          venta.iva = iva;
          venta.total = total;

          localStorageCrud.save("venta", venta);

          return true;
        },
        
        eliminarProducto: (index) => {
          venta.productos.splice(index, 1);
          venta.listar();
        },

        cargarVentaGuardada: () => {
            const ventaGuardada = localStorageCrud.get("venta");
            if (ventaGuardada) {
                // Restore saved purchase data
                venta.productos = ventaGuardada.productos.map(e => {
                  return {
                    ...e,
                    cantidad:0,
                    stock:0,
                  }
                }) || [];
                venta.subtotal = ventaGuardada.subtotal || 0;
                venta.iva = ventaGuardada.iva || 0;
                venta.total = ventaGuardada.total || 0;
                venta.cabecera = ventaGuardada.cabecera || {
                    cliente: { id: 0, nombre: "" },
                    fecha: ""
                };

                // Restore provider if exists
                if (venta.cabecera.cliente.id) {
                    const clienteOption = new Option(
                        venta.cabecera.cliente.nombre,
                        venta.cabecera.cliente.id,
                        true,
                        true
                    );
                    $("#cliente").append(clienteOption).trigger('change');
                    // $("#cliente").val(venta.cabecera.cliente.id).trigger('change');
                }

                // Restore date if exists
                if (venta.cabecera.fecha) {
                    $("#fecha").datepicker('update', venta.cabecera.fecha);
                }

                // Refresh products table
                venta.listar();
                return true;
            }
            return false;
        },

        guardarVenta: () => {
          // Validate provider and date before saving purchase
          if (!$("#cliente").val()) {
              toastr.error("Debe seleccionar un cliente para la venta");
              return;
          }

          if (!$("#fecha").val()) {
              toastr.error("Debe seleccionar una fecha válida para la venta"); 
              return;
          }

          if (venta.productos.length === 0) {
              toastr.error("Debe agregar al menos un producto a la venta");
              return;
          }

          const ventaLocal = localStorageCrud.get('venta');

          // console.log("ventaLocal", ventaLocal)

          // Get provider data
          const cliente = $("#cliente").select2("data")[0];
          venta.cabecera.cliente = {
              id: cliente.id,
              nombre: cliente.text
          };

          // Get purchase date
          venta.cabecera.fecha = $("#fecha").val();
          venta.cabecera.subtotal = ventaLocal.subtotal;

          venta.actualizarTotal();

          // Save purchase data
          $.ajax({
              url: '<?= base_url(route_to('venta.actions')) ?>',
              method: 'POST',
              data: {
                  "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                  action: "add",
                  venta: {
                      cabecera: venta.cabecera,
                      detalle: venta.productos
                  }
              },
              success: function(response) {
                  if (response.resp) {
                      toastr.success("Venta guardada exitosamente");
                      // Clear local storage and reset form
                      localStorageCrud.delete("venta");
                      venta.productos = [];
                      venta.listar();
                      $("#cliente").val(null).trigger('change');
                      $("#fecha").datepicker('update', '<?= date("Y-m-d") ?>');
                      window.location = '<?= base_url(route_to('venta')) ?>'
                  } else {
                      toastr.error("Error al guardar la venta: " + response.message);
                  }
              },
              error: function(xhr, status, error) {
                  toastr.error("Error al procesar la solicitud: " + error);
              }
          });
        },

        limpiarTodo: () => {
          venta.productos = [];
          venta.listar();
          localStorageCrud.delete("venta");
        }
    }

    $( "#agregarDetalle" ).click(()=>{
      const producto = $("#producto-select").select2("data")[0] ?? {};
      const { stock = 0, precio_venta = 0 } = producto;
      if(producto && stock != 0){
        const productoJson = {
          id: venta.id(),
          nombre: producto?.text || "",
          idProducto: producto?.id || "",
          precioVenta: precio_venta,
          cantidad: 1,
          stock,
          imagen: producto?.imagen || ""
        }
        venta.agregarProducto(productoJson, 1);
      }else{
        toastr.error("Existe un error, no hay productos que agregar al detalle");
      }
    })

    $( "#guardarVenta" ).click(function(){
      venta.guardarVenta();
    })

    $( "#limpiarVenta" ).click(function(){
      venta.limpiarTodo();
    })

    venta.cargarVentaGuardada();
  })
</script>

<?= $this->endSection() ?>  