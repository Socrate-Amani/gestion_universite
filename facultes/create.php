<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Ajouter une faculté';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom  = trim($_POST['nom'] ?? '');
    $code = strtoupper(trim($_POST['code'] ?? ''));
    $desc = trim($_POST['description'] ?? '');

    if ($nom && $code) {
        try {
            $stmt = $pdo->prepare("INSERT INTO facultes (nom, code, description) VALUES (?, ?, ?)");
            $stmt->execute([$nom, $code, $desc]);
            header('Location: index.php?msg=Faculté+ajoutée+avec+succès');
            exit;
        } catch (PDOException $e) {
            $error = "Ce code existe déjà ou erreur : " . $e->getMessage();
        }
    } else {
        $error = "Le nom et le code sont obligatoires.";
    }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<h2 class="mb-3">➕ Ajouter une faculté</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="card"><div class="card-body">
<form method="POST">
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