<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'includes/header.php';
require_once 'config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM productos ORDER BY id DESC");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = 'Error al cargar productos: ' . $e->getMessage();
}
?>

<div class="container" style="max-width: 1200px;">
    <div class="dashboard-header">
        <h1>📋 Listado de Productos</h1>
        <a href="dashboard.php" class="btn" style="width: auto; padding: 10px 20px;">Volver</a>
    </div>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <div class="table-container">
        <?php if(isset($productos) && count($productos) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($productos as $producto): ?>
                        <tr>
                            <td><?php echo $producto['id']; ?></td>
                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                            <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                            <td><span class="badge"><?php echo $producto['cantidad']; ?></span></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($producto['fecha_creacion'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="margin-top: 20px; text-align: center; color: #666;">
                Total de productos: <?php echo count($productos); ?>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: #666; padding: 40px 0;">No hay productos registrados</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>