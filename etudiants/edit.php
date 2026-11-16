<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Modifier un étudiant';
$error = '';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
$stmt->execute([$id]);
$e = $stmt->fetch();
if (!$e) die("Étudiant introuvable");

$departements = $pdo->query("SELECT * FROM departements ORDER BY nom")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricule = trim($_POST['matricule'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $tel = trim($_POST['telephone'] ?? '');
    $dn = $_POST['date_naissance'] ?? null;
    $sexe = $_POST['sexe'] ?? 'M';
    $depId = (int)($_POST['departement_id'] ?? 0);

    if ($matricule && $nom && $prenom && $email && $depId) {
        try {
            $stmt = $pdo->prepare("UPDATE etudiants SET matricule=?, nom=?, prenom=?, email=?, telephone=?, date_naissance=?, sexe=?, departement_id=? WHERE id=?");
            $stmt->execute([$matricule, $nom, $prenom, $email, $tel, $dn ?: null, $sexe, $depId, $id]);
            header('Location: index.php?msg=Étudiant+modifié');
            exit;
        } catch (PDOException $ex) { $error = "Erreur : " . $ex->getMessage(); }
    } else { $error = "Champs obligatoires manquants."; }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<h2 class="mb-3">✏️ Modifier un étudiant</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Matricule *</label>
        <input type="text" name="matricule" class="form-control" value="<?= htmlspecialchars($e['matricule']) ?>" required>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Nom *</label>
            <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($e['nom']) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Prénom *</label>
            <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($e['prenom']) ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Email *</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($e['email']) ?>" required>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($e['telephone'] ?? '') ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Date de naissance</label>
            <input type="date" name="date_naissance" class="form-control" value="<?= htmlspecialchars($e['date_naissance'] ?? '') ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Sexe</label>
            <select name="sexe" class="form-select">
                <option value="M" <?= $e['sexe'] === 'M' ? 'selected' : '' ?>>Masculin</option>
                <option value="F" <?= $e['sexe'] === 'F' ? 'selected' : '' ?>>Féminin</option>
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Département *</label>
        <select name="departement_id" class="form-select" required>
            <?php foreach ($departements as $d): ?>
                <option value="<?= $d['id'] ?>" <?= $d['id'] == $e['departement_id'] ? 'selected' : '' ?>>
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