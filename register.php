<?php
include 'includes/header.php';
session_start();

if(isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once __DIR__ . '/config/database.php'; 
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if(empty($nombre) || empty($email) || empty($password)) {
        $error = 'Todos los campos son obligatorios';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email inválido';
    } elseif(strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres';
    } elseif($password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden';
    } else {
        try {
            // Verificar si el email ya existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            
            if($stmt->rowCount() > 0) {
                $error = 'Este email ya está registrado';
            } else {
                // Hash MD5 (para cumplir con el requisito)
                $hashed_password = md5($password);
                
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$nombre, $email, $hashed_password]);
                
                $success = 'Registro exitoso. Ahora puedes iniciar sesión.';
            }
        } catch(PDOException $e) {
            $error = 'Error al registrar: ' . $e->getMessage();
        }
    }
}
?>

<div class="container">
    <h1>📝 Registro</h1>
    
    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="login.php" class="btn">Iniciar Sesión</a>
        </div>
    <?php else: ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
                <small style="color: #666;">Mínimo 6 caracteres</small>
            </div>
            <div class="form-group">
                <label>Confirmar Contraseña</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn">Registrarse</button>
        </form>
        
        <div class="text-center" style="margin-top: 20px;">
            <p>¿Ya tienes cuenta? <a href="login.php" class="link">Inicia Sesión</a></p>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>