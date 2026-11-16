<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Ajouter un enseignant';
$error = '';
$departements = $pdo->query("SELECT * FROM departements ORDER BY nom")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $tel = trim($_POST['telephone'] ?? '');
    $grade = trim($_POST['grade'] ?? '');
    $depId = (int)($_POST['departement_id'] ?? 0);

    if ($nom && $prenom && $email && $depId) {
        try {
            $stmt = $pdo->prepare("INSERT INTO enseignants (nom, prenom, email, telephone, grade, departement_id) VALUES (?,?,?,?,?,?)");
            $stmt->execute([$nom, $prenom, $email, $tel, $grade, $depId]);
            header('Location: index.php?msg=Enseignant+ajouté');
            exit;
        } catch (PDOException $e) { $error = "Erreur : " . $e->getMessage(); }
    } else { $error = "Champs obligatoires manquants."; }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<h2 class="mb-3">➕ Ajouter un enseignant</h2>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="card"><div class="card-body">
<form method="POST">
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
        <div class="col-md-6 mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" name="telephone" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Grade</label>
            <input type="text" name="grade" class="form-control" placeholder="Professeur, Assistant...">
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