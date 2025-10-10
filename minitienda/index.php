<?php
require_once 'includes/config.php';
require_once 'includes/header.php';
?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Nuestros Productos</h1>
    
    <div class="row" id="productos-container">
        <!-- Los productos se cargarán dinámicamente aquí -->
    </div>
</div>

<!-- Modal del Carrito -->
<div class="modal fade" id="carritoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Carrito de Compras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="carrito-contenido"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Seguir Comprando</button>
                <button type="button" class="btn btn-primary" id="btn-checkout">Proceder al Pago</button>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>