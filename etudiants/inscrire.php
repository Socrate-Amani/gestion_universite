<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Inscrire à des cours';
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
$stmt->execute([$id]);
$etu = $stmt->fetch();
if (!$etu) die("Étudiant introuvable");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coursIds = $_POST['cours'] ?? [];
    $pdo->prepare("DELETE FROM inscriptions WHERE etudiant_id = ?")->execute([$id]);
    $ins = $pdo->prepare("INSERT INTO inscriptions (etudiant_id, cours_id) VALUES (?, ?)");
    foreach ($coursIds as $cid) $ins->execute([$id, (int)$cid]);
    header("Location: index.php?msg=Inscriptions+enregistrées");
    exit;
}

$tousCours = $pdo->query("SELECT * FROM cours ORDER BY nom")->fetchAll();
$stmt = $pdo->prepare("SELECT cours_id FROM inscriptions WHERE etudiant_id = ?");
$stmt->execute([$id]);
$inscrits = array_column($stmt->fetchAll(), 'cours_id');

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<h2>📝 Inscrire <?= htmlspecialchars($etu['nom'] . ' ' . $etu['prenom']) ?> à des cours</h2>
<div class="card"><div class="card-body">
<form method="POST">
    <?php foreach ($tousCours as $c): ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="cours[]" 
                   value="<?= $c['id'] ?>" id="c<?= $c['id'] ?>"
                   <?= in_array($c['id'], $inscrits) ? 'checked' : '' ?>>
            <label class="form-check-label" for="c<?= $c['id'] ?>">
                <?= htmlspecialchars($c['nom']) ?> (<?= htmlspecialchars($c['code']) ?>)
            </label>
        </div>
    <?php endforeach; ?>
    <button class="btn btn-success mt-3">Enregistrer</button>
    <a href="index.php" class="btn btn-secondary mt-3">Annuler</a>
</form>
</div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>