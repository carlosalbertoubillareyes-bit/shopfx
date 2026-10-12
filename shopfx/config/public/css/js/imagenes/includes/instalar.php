<?php
$host = 'localhost';
$usuario = 'root';
$contraseña = '';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $usuario, $contraseña);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Conectado a MySQL<br>";
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS shopfx CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Base de datos shopfx creada<br>";
    
    $pdo->exec("USE shopfx");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nombre VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        contraseña_hash VARCHAR(255) NOT NULL,
        tipo_usuario ENUM('cliente','admin') DEFAULT 'cliente',
        fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "✅ Tabla usuarios lista<br>";
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS productos (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT,
        precio DECIMAL(10,2) NOT NULL,
        stock INT NOT NULL DEFAULT 0,
        imagen VARCHAR(255),
        activo BOOLEAN DEFAULT TRUE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "✅ Tabla productos lista<br>";
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS carrito (
        id INT PRIMARY KEY AUTO_INCREMENT,
        usuario_id INT NOT NULL,
        producto_id INT NOT NULL,
        cantidad INT NOT NULL DEFAULT 1,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
        FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE,
        UNIQUE(usuario_id, producto_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    echo "✅ Tabla carrito lista<br>";
    
    echo "<br>🎉 ¡Todo listo! Base de datos configurada correctamente.";
    
} catch (PDOException $e) {
    die("❌ Error: " . $e->getMessage());
}
?>