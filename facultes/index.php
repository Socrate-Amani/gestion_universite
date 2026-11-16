<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
$pageTitle = 'Facultés';

$facultes = $pdo->query("SELECT * FROM facultes ORDER BY nom")->fetchAll();

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>🏛️ Facultés</h2>
    <a href="create.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Ajouter</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
<?php endif; ?>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th><th>Nom</th><th>Code</th><th>Description</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($facultes as $f): ?>
                <tr>
                    <td><?= $f['id'] ?></td>
                    <td><?= htmlspecialchars($f['nom']) ?></td>
                    <td><span class="badge bg-secondary"><?= htmlspecialchars($f['code']) ?></span></td>
                    <td><?= htmlspecialchars($f['description'] ?? '-') ?></td>
                    <td>
                        <a href="edit.php?id=<?= $f['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <a href="delete.php?id=<?= $f['id'] ?>" class="btn btn-sm btn-danger btn-delete"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($facultes)): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">Aucune faculté enregistrée.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>