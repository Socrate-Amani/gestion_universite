<?php
// includes/auth.php
require_once __DIR__ . '/../config/config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'admin/login.php');
    exit;
}