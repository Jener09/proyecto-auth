<?php
include 'includes/header.php';
session_start();

if(isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once __DIR__ . '/config/database.php';  // ← Línea corregida
    
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if(empty($email) || empty($password)) {
        $error = 'Todos los campos son obligatorios';
    } else {
        try {
            $hashed_password = md5($password);
            
            $stmt = $pdo->prepare("SELECT id, nombre, email FROM usuarios WHERE email = ? AND password = ?");
            $stmt->execute([$email, $hashed_password]);
            
            if($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_email'] = $user['email'];
                
                header('Location: dashboard.php');
                exit();
            } else {
                $error = 'Email o contraseña incorrectos';
            }
        } catch(PDOException $e) {
            $error = 'Error al iniciar sesión: ' . $e->getMessage();
        }
    }
}
?>

<div class="container">
    <h1>🔑 Iniciar Sesión</h1>
    
    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn">Iniciar Sesión</button>
    </form>
    
    <div class="text-center" style="margin-top: 20px;">
        <p>¿No tienes cuenta? <a href="register.php" class="link">Regístrate</a></p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>