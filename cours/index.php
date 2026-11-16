<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Cours';

$sql = "SELECT c.*, d.nom AS departement_nom 
        FROM cours c 
        JOIN departements d ON c.departement_id = d.id 
        ORDER BY c.nom";
$cours = $pdo->query($sql)->fetchAll();

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>📖 Cours</h2>
    <a href="create.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Ajouter</a>
</div>
<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
<?php endif; ?>
<div class="card"><div class="table-responsive">
<table class="table table-hover mb-0">
    <thead><tr>
        <th>#</th><th>Nom</th><th>Code</th><th>Crédits</th><th>Département</th><th>Actions</th>
    </tr></thead>
    <tbody>
    <?php foreach ($cours as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['nom']) ?></td>
            <td><span class="badge bg-secondary"><?= htmlspecialchars($c['code']) ?></span></td>
            <td><?= (int)$c['credits'] ?></td>
            <td><?= htmlspecialchars($c['departement_nom']) ?></td>
            <td>
                <a href="edit.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <a href="delete.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-danger btn-delete"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($cours)): ?>
        <tr><td colspan="6" class="text-center text-muted py-4">Aucun cours.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>