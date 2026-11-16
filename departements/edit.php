<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Modifier un département';
$error = '';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM departements WHERE id = ?");
$stmt->execute([$id]);
$dep = $stmt->fetch();
if (!$dep) die("Département introuvable");

$facultes = $pdo->query("SELECT * FROM facultes ORDER BY nom")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $code = strtoupper(trim($_POST['code'] ?? ''));
    $desc = trim($_POST['description'] ?? '');
    $facId = (int)($_POST['faculte_id'] ?? 0);

    if ($nom && $code && $facId) {
        try {
            $stmt = $pdo->prepare("UPDATE departements SET nom=?, code=?, description=?, faculte_id=? WHERE id=?");
            $stmt->execute([$nom, $code, $desc, $facId, $id]);
            header('Location: index.php?msg=Département+modifié');
            exit;
        } catch (PDOException $e) { $error = "Erreur : " . $e->getMessage(); }
    } else { $error = "Champs obligatoires manquants."; }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<h2 class="mb-3">✏️ Modifier un département</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Faculté *</label>
        <select name="faculte_id" class="form-select" required>
            <?php foreach ($facultes as $f): ?>
                <option value="<?= $f['id'] ?>" <?= $f['id'] == $dep['faculte_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($f['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Nom *</label>
        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($dep['nom']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Code *</label>
        <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($dep['code']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($dep['description'] ?? '') ?></textarea>
    </div>
    <button class="btn btn-primary">Mettre à jour</button>
    <a href="index.php" class="btn btn-secondary">Annuler</a>
</form>
</div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>