<?php
session_start();
include '../includes/db.php';
include '../includes/seguridad.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validar_csrf($_POST['csrf_token'] ?? '')) {
        die("Solicitud inválida");
    }

    $nombre = limpiar($_POST['nombre'] ?? '');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $contraseña = $_POST['contraseña'] ?? '';

    if ($nombre && $email && strlen($contraseña) >= 6) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $mensaje = "Este correo ya está registrado";
            } else {
                $hash = password_hash($contraseña, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, contraseña_hash) VALUES (:nombre, :email, :hash)");
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':hash', $hash);
                $stmt->execute();
                
                $mensaje = "¡Registro exitoso! Ya puedes iniciar sesión";
            }
        } catch (PDOException $e) {
            $mensaje = "Error al registrar. Intenta más tarde.";
        }
    } else {
        $mensaje = "Completa todos los campos correctamente (contraseña mínimo 6 caracteres)";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro — ShopFX</title>
</head>
<body>
    <h1>Crear Cuenta</h1>
    
    <?php if ($mensaje): ?>
        <p><strong><?= limpiar($mensaje) ?></strong></p>
    <?php endif; ?>

    <form method="POST" action="registro.php">
        <input type="hidden" name="csrf_token" value="<?= generar_csrf() ?>">
        
        <div>
            <label>Nombre completo:</label>
            <input type="text" name="nombre" required>
        </div>
        
        <div>
            <label>Correo electrónico:</label>
            <input type="email" name="email" required>
        </div>
        
        <div>
            <label>Contraseña (mínimo 6 caracteres):</label>
            <input type="password" name="contraseña" required>
        </div>
        
        <button type="submit">Registrarse</button>
    </form>
    
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    <p><a href="index.php">← Volver al inicio</a></p>
</body>
</html>