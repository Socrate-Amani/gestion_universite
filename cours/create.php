<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Ajouter un cours';
$error = '';
$departements = $pdo->query("SELECT * FROM departements ORDER BY nom")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $code = strtoupper(trim($_POST['code'] ?? ''));
    $credits = (int)($_POST['credits'] ?? 3);
    $desc = trim($_POST['description'] ?? '');
    $depId = (int)($_POST['departement_id'] ?? 0);

    if ($nom && $code && $depId) {
        try {
            $stmt = $pdo->prepare("INSERT INTO cours (nom, code, credits, description, departement_id) VALUES (?,?,?,?,?)");
            $stmt->execute([$nom, $code, $credits, $desc, $depId]);
            header('Location: index.php?msg=Cours+ajouté');
            exit;
        } catch (PDOException $e) { $error = "Erreur : " . $e->getMessage(); }
    } else { $error = "Champs obligatoires manquants."; }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<h2 class="mb-3">➕ Ajouter un cours</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Nom *</label>
        <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Code *</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Crédits</label>
            <input type="number" name="credits" class="form-control" value="3" min="1" max="20">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Département *</label>
        <select name="departement_id" class="form-select" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($departements as $d): ?>
                <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="btn btn-success">Enregistrer</button>
    <a href="index.php" class="btn btn-secondary">Annuler</a>
</form>
</div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>