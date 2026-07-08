<?php
include 'includes/header.php';
session_start();
?>

<div class="container">
    <h1>🔐 Sistema de Autenticación</h1>
    
    <?php if(isset($_SESSION['user_id'])): ?>
        <div class="alert alert-success">
            ✅ Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="dashboard.php" class="btn" style="display: inline-block;">Ir al Dashboard</a>
        </div>
    <?php else: ?>
        <div style="text-align: center; margin-bottom: 30px;">
            <p style="color: #666; font-size: 1.1rem;">Inicia sesión o regístrate para acceder</p>
        </div>
        <div style="display: flex; gap: 15px; flex-direction: column;">
            <a href="login.php" class="btn">Iniciar Sesión</a>
            <a href="register.php" class="btn btn-secondary">Registrarse</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>