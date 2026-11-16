<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$id = (int)($_GET['id'] ?? 0);
$pdo->prepare("DELETE FROM enseignants WHERE id = ?")->execute([$id]);
header('Location: index.php?msg=Enseignant+supprimé');
exit;