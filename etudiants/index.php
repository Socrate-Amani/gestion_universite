<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Étudiants';

$sql = "SELECT e.*, d.nom AS departement_nom 
        FROM etudiants e 
        JOIN departements d ON e.departement_id = d.id 
        ORDER BY e.nom";
$etudiants = $pdo->query($sql)->fetchAll();

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>🎓 Étudiants</h2>
    <a href="create.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Ajouter</a>
</div>
<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
<?php endif; ?>
<div class="card"><div class="table-responsive">
<table class="table table-hover mb-0">
    <thead><tr>
        <th>#</th><th>Matricule</th><th>Nom complet</th><th>Email</th><th>Département</th><th>Actions</th>
    </tr></thead>
    <tbody>
    <?php foreach ($etudiants as $e): ?>
        <tr>
            <td><?= $e['id'] ?></td>
            <td><span class="badge bg-info"><?= htmlspecialchars($e['matricule']) ?></span></td>
            <td><?= htmlspecialchars($e['nom'] . ' ' . $e['prenom']) ?></td>
            <td><?= htmlspecialchars($e['email']) ?></td>
            <td><?= htmlspecialchars($e['departement_nom']) ?></td>
            <td>
                <a href="edit.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <a href="delete.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-danger btn-delete"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($etudiants)): ?>
        <tr><td colspan="6" class="text-center text-muted py-4">Aucun étudiant.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>