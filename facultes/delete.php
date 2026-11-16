<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("DELETE FROM facultes WHERE id = ?");
$stmt->execute([$id]);
header('Location: index.php?msg=Faculté+supprimée');
exit;