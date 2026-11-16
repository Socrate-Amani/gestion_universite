<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Modifier une faculté';
$error = '';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM facultes WHERE id = ?");
$stmt->execute([$id]);
$fac = $stmt->fetch();

if (!$fac) { die("Faculté introuvable"); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom  = trim($_POST['nom'] ?? '');
    $code = strtoupper(trim($_POST['code'] ?? ''));
    $desc = trim($_POST['description'] ?? '');

    if ($nom && $code) {
        try {
            $stmt = $pdo->prepare("UPDATE facultes SET nom=?, code=?, description=? WHERE id=?");
            $stmt->execute([$nom, $code, $desc, $id]);
            header('Location: index.php?msg=Faculté+modifiée');
            exit;
        } catch (PDOException $e) {
            $error = "Erreur : " . $e->getMessage();
        }
    } else {
        $error = "Le nom et le code sont obligatoires.";
    }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<h2 class="mb-3">✏️ Modifier une faculté</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="card"><div class="card-body">
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Nom *</label>
        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($fac['nom']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Code *</label>
        <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($fac['code']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($fac['description'] ?? '') ?></textarea>
    </div>
    <button class="btn btn-primary">Mettre à jour</button>
    <a href="index.php" class="btn btn-secondary">Annuler</a>
</form>
</div></div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>