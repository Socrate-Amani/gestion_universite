<?php
// config/config.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si on est sur Render, on utilise l'URL de Render, sinon on utilise localhost
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$domain = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('BASE_URL', $protocol . '://' . $domain . '/');
define('APP_NAME', 'Gestion Université');
