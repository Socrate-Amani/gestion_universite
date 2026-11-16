<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Modifier un cours';
$error = '';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM cours WHERE id = ?");
$stmt->execute([$id]);
$c = $stmt->fetch();
if (!$c) die("Cours introuvable");

$departements = $pdo->query("SELECT * FROM departements ORDER BY nom")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $code = strtoupper(trim($_POST['code'] ?? ''));
    $credits = (int)($_POST['credits'] ?? 3);
    $desc = trim($_POST['description'] ?? '');
    $depId = (int)($_POST['departement_id'] ?? 0);

    if ($nom && $code && $depId) {
        try {
            $stmt = $pdo->prepare("UPDATE cours SET nom=?, code=?, credits=?, description=?, departement_id=? WHERE id=?");
            $stmt->execute([$nom, $code, $credits, $desc, $depId, $id]);
            header('Location: index.php?msg=Cours+modifié');
            exit;
        } catch (PDOException $ex) { $error = "Erreur : " . $ex->getMessage(); }
    } else { $error = "Champs obligatoires manquants."; }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<h2 class="mb-3">✏️ Modifier un cours</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Nom *</label>
        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($c['nom']) ?>" required>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Code *</label>
            <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($c['code']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Crédits</label>
            <input type="number" name="credits" class="form-control" value="<?= (int)$c['credits'] ?>" min="1" max="20">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($c['description'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Département *</label>
        <select name="departement_id" class="form-select" required>
            <?php foreach ($departements as $d): ?>
                <option value="<?= $d['id'] ?>" <?= $d['id'] == $c['departement_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="btn btn-primary">Mettre à jour</button>
    <a href="index.php" class="btn btn-secondary">Annuler</a>
</form>
</div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>