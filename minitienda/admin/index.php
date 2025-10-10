<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

// Verificar si el usuario está logueado
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="index.php" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="productos.php" class="list-group-item list-group-item-action">Productos</a>
                <a href="pedidos.php" class="list-group-item list-group-item-action">Pedidos</a>
            </div>
        </div>
        <div class="col-md-9">
            <h2>Dashboard</h2>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Productos</h5>
                            <p class="card-text h2" id="total-productos">0</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Pedidos Pendientes</h5>
                            <p class="card-text h2" id="pedidos-pendientes">0</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Ventas</h5>
                            <p class="card-text h2" id="total-ventas">$0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>