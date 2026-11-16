<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Enseignants';

$sql = "SELECT e.*, d.nom AS departement_nom 
        FROM enseignants e 
        JOIN departements d ON e.departement_id = d.id 
        ORDER BY e.nom";
$enseignants = $pdo->query($sql)->fetchAll();

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>👨‍🏫 Enseignants</h2>
    <a href="create.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Ajouter</a>
</div>
<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
<?php endif; ?>
<div class="card"><div class="table-responsive">
<table class="table table-hover mb-0">
    <thead><tr>
        <th>#</th><th>Nom complet</th><th>Email</th><th>Grade</th><th>Département</th><th>Actions</th>
    </tr></thead>
    <tbody>
    <?php foreach ($enseignants as $e): ?>
        <tr>
            <td><?= $e['id'] ?></td>
            <td><?= htmlspecialchars($e['nom'] . ' ' . $e['prenom']) ?></td>
            <td><?= htmlspecialchars($e['email']) ?></td>
            <td><?= htmlspecialchars($e['grade'] ?? '-') ?></td>
            <td><?= htmlspecialchars($e['departement_nom']) ?></td>
            <td>
                <a href="edit.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <a href="delete.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-danger btn-delete"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($enseignants)): ?>
        <tr><td colspan="6" class="text-center text-muted py-4">Aucun enseignant.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>