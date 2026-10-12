<?php
session_start();
include '../includes/db.php';
include '../includes/seguridad.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validar_csrf($_POST['csrf_token'] ?? '')) {
        die("Solicitud inválida");
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $contraseña = $_POST['contraseña'] ?? '';

    if ($email && $contraseña) {
        try {
            $stmt = $pdo->prepare("SELECT id, nombre, contraseña_hash FROM usuarios WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $usuario = $stmt->fetch();

            if ($usuario && password_verify($contraseña, $usuario['contraseña_hash'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                header("Location: index.php");
                exit;
            } else {
                $mensaje = "Correo o contraseña incorrectos";
            }
        } catch (PDOException $e) {
            $mensaje = "Error del sistema. Intenta más tarde.";
        }
    } else {
        $mensaje = "Ingresa tu correo y contraseña";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión — ShopFX</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    
    <?php if ($mensaje): ?>
        <p><strong><?= limpiar($mensaje) ?></strong></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <input type="hidden" name="csrf_token" value="<?= generar_csrf() ?>">
        
        <div>
            <label>Correo electrónico:</label>
            <input type="email" name="email" required>
        </div>
        
        <div>
            <label>Contraseña:</label>
            <input type="password" name="contraseña" required>
        </div>
        
        <button type="submit">Ingresar</button>
    </form>
    
    <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    <p><a href="index.php">← Volver al inicio</a></p>
</body>
</html>