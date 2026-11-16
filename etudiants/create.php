<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Ajouter un étudiant';
$error = '';
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
            $stmt = $pdo->prepare("INSERT INTO etudiants (matricule, nom, prenom, email, telephone, date_naissance, sexe, departement_id) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->execute([$matricule, $nom, $prenom, $email, $tel, $dn ?: null, $sexe, $depId]);
            header('Location: index.php?msg=Étudiant+ajouté');
            exit;
        } catch (PDOException $e) { $error = "Erreur : " . $e->getMessage(); }
    } else { $error = "Champs obligatoires manquants."; }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<h2 class="mb-3">➕ Ajouter un étudiant</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Matricule *</label>
        <input type="text" name="matricule" class="form-control" required>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Nom *</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Prénom *</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Email *</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" name="telephone" class="form-control">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Date de naissance</label>
            <input type="date" name="date_naissance" class="form-control">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Sexe</label>
            <select name="sexe" class="form-select">
                <option value="M">Masculin</option>
                <option value="F">Féminin</option>
            </select>
        </div>
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