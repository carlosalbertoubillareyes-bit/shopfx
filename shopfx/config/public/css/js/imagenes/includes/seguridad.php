<?php
session_start();

function generar_csrf() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function validar_csrf($token) {
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

function limpiar($texto) {
    return htmlspecialchars(trim($texto), ENT_QUOTES, 'UTF-8');
}
?>