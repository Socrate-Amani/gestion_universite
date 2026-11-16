<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Départements';

$sql = "SELECT d.*, f.nom AS faculte_nom 
        FROM departements d 
        JOIN facultes f ON d.faculte_id = f.id 
        ORDER BY f.nom, d.nom";
$departements = $pdo->query($sql)->fetchAll();

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>📚 Départements</h2>
    <a href="create.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Ajouter</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
<?php endif; ?>

<div class="card"><div class="table-responsive">
<table class="table table-hover mb-0">
    <thead><tr>
        <th>#</th><th>Nom</th><th>Code</th><th>Faculté</th><th>Actions</th>
    </tr></thead>
    <tbody>
    <?php foreach ($departements as $d): ?>
        <tr>
            <td><?= $d['id'] ?></td>
            <td><?= htmlspecialchars($d['nom']) ?></td>
            <td><span class="badge bg-secondary"><?= htmlspecialchars($d['code']) ?></span></td>
            <td><?= htmlspecialchars($d['faculte_nom']) ?></td>
            <td>
                <a href="edit.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                <a href="delete.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-danger btn-delete"><i class="bi bi-trash"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($departements)): ?>
        <tr><td colspan="5" class="text-center text-muted py-4">Aucun département.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</div></div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>