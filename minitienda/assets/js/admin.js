// Actualizar estadísticas del dashboard
function actualizarEstadisticas() {
    $.ajax({
        url: 'api/estadisticas.php',
        method: 'GET',
        success: function(response) {
            $('#total-productos').text(response.total_productos);
            $('#pedidos-pendientes').text(response.pedidos_pendientes);
            $('#total-ventas').text('$' + response.total_ventas.toFixed(2));
        }
    });
}

// Eliminar producto
$(document).on('click', '.eliminar-producto', function() {
    const id = $(this).data('id');
    if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
        $.ajax({
            url: 'api/eliminar_producto.php',
            method: 'POST',
            data: { id: id },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error al eliminar el producto');
                }
            }
        });
    }
});

// Editar producto
$(document).on('click', '.editar-producto', function() {
    const id = $(this).data('id');
    
    $.ajax({
        url: 'api/obtener_producto.php',
        method: 'GET',
        data: { id: id },
        success: function(producto) {
            $('#productoForm [name=nombre]').val(producto.nombre);
            $('#productoForm [name=descripcion]').val(producto.descripcion);
            $('#productoForm [name=precio]').val(producto.precio);
            $('#productoForm [name=stock]').val(producto.stock);
            
            $('#productoForm').append('<input type="hidden" name="id" value="' + producto.id + '">');
            $('.modal-title').text('Editar Producto');
            $('#productoModal').modal('show');
        }
    });
});

// Inicialización
$(document).ready(function() {
    // Si estamos en el dashboard, actualizar estadísticas
    if ($('#total-productos').length) {
        actualizarEstadisticas();
        // Actualizar cada 5 minutos
        setInterval(actualizarEstadisticas, 300000);
    }
});