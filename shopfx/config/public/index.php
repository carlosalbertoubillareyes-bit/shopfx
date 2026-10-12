<?php 
include '../includes/db.php'; 
include '../includes/seguridad.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ShopFX — Inicio</title>
</head>
<body>
    <h1>Bienvenido a ShopFX</h1>
    <nav>
        <a href="index.php">Inicio</a> |
        <a href="carrito.php">Carrito</a> |
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <a href="cerrar_sesion.php">Cerrar sesión</a>
        <?php else: ?>
            <a href="login.php">Iniciar sesión</a> |
            <a href="registro.php">Registrarse</a>
        <?php endif; ?>
    </nav>

    <h2>Nuestros Productos</h2>
    <?php
    $stmt = $pdo->query("SELECT * FROM productos WHERE activo = 1");
    $productos = $stmt->fetchAll();
    ?>
    
    <?php if (count($productos) > 0): ?>
        <?php foreach ($productos as $p): ?>
            <div>
                <h3><?= limpiar($p['nombre']) ?></h3>
                <p><?= limpiar($p['descripcion']) ?></p>
                <p>Precio: $<?= number_format($p['precio'], 0, ',', '.') ?></p>
                <?php if ($p['stock'] > 0): ?>
                    <p>Stock: <?= $p['stock'] ?> unidades</p>
                <?php else: ?>
                    <p>Agotado</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos disponibles en este momento.</p>
    <?php endif; ?>
</body>
</html>