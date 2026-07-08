<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'includes/header.php';
require_once __DIR__ . '/config/database.php';
?>

<div class="container dashboard-container">
    <div class="dashboard-header">
        <h1>📊 Dashboard</h1>
        <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
    </div>
    
    <div class="user-info">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋</h2>
        <p>Email: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
        <p>ID de Usuario: <?php echo $_SESSION['user_id']; ?></p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px;">
        <div style="background: white; padding: 25px; border-radius: 15px; text-align: center;">
            <h3>📋 Listado de Productos</h3>
            <p style="color: #666; margin: 10px 0;">Ver todos los productos</p>
            <a href="listado.php" class="btn">Ver Listado</a>
        </div>
        <div style="background: white; padding: 25px; border-radius: 15px; text-align: center;">
            <h3>👤 Mi Perfil</h3>
            <p style="color: #666; margin: 10px 0;">Información personal</p>
            <button class="btn btn-secondary" onclick="alert('Perfil de usuario')">Ver Perfil</button>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>