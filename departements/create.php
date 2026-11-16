<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Ajouter un département';
$error = '';
$facultes = $pdo->query("SELECT * FROM facultes ORDER BY nom")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $code = strtoupper(trim($_POST['code'] ?? ''));
    $desc = trim($_POST['description'] ?? '');
    $facId = (int)($_POST['faculte_id'] ?? 0);

    if ($nom && $code && $facId) {
        try {
            $stmt = $pdo->prepare("INSERT INTO departements (nom, code, description, faculte_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $code, $desc, $facId]);
            header('Location: index.php?msg=Département+ajouté');
            exit;
        } catch (PDOException $e) {
            $error = "Erreur : " . $e->getMessage();
        }
    } else { $error = "Champs obligatoires manquants."; }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<h2 class="mb-3">➕ Ajouter un département</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Faculté *</label>
        <select name="faculte_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($facultes as $f): ?>
                <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Nom *</label>
        <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Code *</label>
        <input type="text" name="code" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
    </div>
    <button class="btn btn-success">Enregistrer</button>
    <a href="index.php" class="btn btn-secondary">Annuler</a>
</form>
</div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>