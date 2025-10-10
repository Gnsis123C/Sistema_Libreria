<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

// Verificar si el usuario está logueado
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Procesar formulario de producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = limpiar_entrada($_POST['nombre']);
    $descripcion = limpiar_entrada($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    
    // Procesar imagen
    $imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['imagen']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $newname = uniqid() . '.' . $ext;
            $upload_dir = '../assets/img/productos/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $upload_dir . $newname)) {
                $imagen = 'assets/img/productos/' . $newname;
            }
        }
    }
    
    // Insertar producto
    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, imagen) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $precio, $stock, $imagen]);
    
    header('Location: productos.php?success=1');
    exit;
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="index.php" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="productos.php" class="list-group-item list-group-item-action active">Productos</a>
                <a href="pedidos.php" class="list-group-item list-group-item-action">Pedidos</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Gestión de Productos</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productoModal">
                    Nuevo Producto
                </button>
            </div>

            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success mt-3">Producto guardado exitosamente.</div>
            <?php endif; ?>

            <div class="table-responsive mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->query("SELECT * FROM productos ORDER BY id DESC");
                        while ($producto = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                        <tr>
                            <td><?= $producto['id'] ?></td>
                            <td>
                                <?php if ($producto['imagen']): ?>
                                <img src="/<?= $producto['imagen'] ?>" alt="" style="width: 50px; height: 50px; object-fit: cover;">
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($producto['nombre']) ?></td>
                            <td>$<?= number_format($producto['precio'], 2) ?></td>
                            <td><?= $producto['stock'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-info editar-producto" data-id="<?= $producto['id'] ?>">✏️</button>
                                <button class="btn btn-sm btn-danger eliminar-producto" data-id="<?= $producto['id'] ?>">🗑️</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Nuevo/Editar Producto -->
<div class="modal fade" id="productoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="productoForm" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" class="form-control" name="precio" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control" name="stock" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagen</label>
                        <input type="file" class="form-control" name="imagen" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>