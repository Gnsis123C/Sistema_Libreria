// Clase para manejar el carrito
class Carrito {
    constructor() {
        this.items = JSON.parse(localStorage.getItem('carrito')) || [];
        this.actualizarContador();
    }

    // Agregar item al carrito
    agregar(producto) {
        const itemExistente = this.items.find(item => item.id === producto.id);
        
        if (itemExistente) {
            itemExistente.cantidad++;
        } else {
            this.items.push({...producto, cantidad: 1});
        }

        this.guardar();
        this.actualizarContador();
        this.mostrarMensaje('Producto agregado al carrito');
    }

    // Remover item del carrito
    remover(productoId) {
        this.items = this.items.filter(item => item.id !== productoId);
        this.guardar();
        this.actualizarContador();
        this.actualizarContenido();
    }

    // Actualizar cantidad
    actualizarCantidad(productoId, cantidad) {
        const item = this.items.find(item => item.id === productoId);
        if (item) {
            item.cantidad = parseInt(cantidad);
            if (item.cantidad <= 0) {
                this.remover(productoId);
            } else {
                this.guardar();
                this.actualizarContador();
                this.actualizarContenido();
            }
        }
    }

    // Guardar en localStorage
    guardar() {
        localStorage.setItem('carrito', JSON.stringify(this.items));
    }

    // Actualizar contador del carrito
    actualizarContador() {
        const total = this.items.reduce((sum, item) => sum + item.cantidad, 0);
        $('#carrito-cantidad').text(total);
    }

    // Actualizar contenido del modal
    actualizarContenido() {
        const contenido = this.items.map(item => `
            <div class="row mb-2 align-items-center">
                <div class="col-2">
                    <img src="${item.imagen}" class="img-fluid" alt="${item.nombre}">
                </div>
                <div class="col">
                    <h5 class="mb-0">${item.nombre}</h5>
                    <p class="mb-0">Precio: $${item.precio}</p>
                </div>
                <div class="col-3">
                    <input type="number" class="form-control cantidad-input" 
                           value="${item.cantidad}" min="1" 
                           data-id="${item.id}">
                </div>
                <div class="col-2">
                    <button class="btn btn-danger btn-sm remover-item" 
                            data-id="${item.id}">🗑️</button>
                </div>
            </div>
        `).join('');

        const total = this.items.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);

        $('#carrito-contenido').html(`
            ${this.items.length ? contenido : '<p class="text-center">El carrito está vacío</p>'}
            ${this.items.length ? `<hr><h4 class="text-end">Total: $${total.toFixed(2)}</h4>` : ''}
        `);

        // Actualizar visibilidad del botón de checkout
        $('#btn-checkout').toggle(this.items.length > 0);
    }

    // Mostrar mensaje
    mostrarMensaje(mensaje) {
        const alert = $('<div class="alert alert-success position-fixed top-0 end-0 m-3">').text(mensaje);
        $('body').append(alert);
        setTimeout(() => alert.remove(), 2000);
    }
}

// Inicializar carrito
const carrito = new Carrito();

// Event listeners
$(document).ready(function() {
    // Abrir modal del carrito
    $('#carritoModal').on('show.bs.modal', function() {
        carrito.actualizarContenido();
    });

    // Actualizar cantidad
    $(document).on('change', '.cantidad-input', function() {
        const id = $(this).data('id');
        const cantidad = $(this).val();
        carrito.actualizarCantidad(id, cantidad);
    });

    // Remover item
    $(document).on('click', '.remover-item', function() {
        const id = $(this).data('id');
        carrito.remover(id);
    });

    // Proceder al checkout
    $('#btn-checkout').click(function() {
        window.location.href = '/checkout.php';
    });
});