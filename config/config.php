<?php
// config/config.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', 'http://localhost/gestion_universite/');
define('APP_NAME', 'Gestion Université');