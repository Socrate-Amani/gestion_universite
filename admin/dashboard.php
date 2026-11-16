<?php
// admin/dashboard.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Tableau de bord';

$nbFacultes    = $pdo->query("SELECT COUNT(*) FROM facultes")->fetchColumn();
$nbDepartements= $pdo->query("SELECT COUNT(*) FROM departements")->fetchColumn();
$nbEnseignants = $pdo->query("SELECT COUNT(*) FROM enseignants")->fetchColumn();
$nbEtudiants   = $pdo->query("SELECT COUNT(*) FROM etudiants")->fetchColumn();
$nbCours       = $pdo->query("SELECT COUNT(*) FROM cours")->fetchColumn();

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark">Bienvenue, <?= htmlspecialchars($_SESSION['admin_nom']) ?> 👋</h2>
</div>

<div class="row g-4">
    <?php
    $cards = [
        ['Facultés', $nbFacultes, 'primary', 'building', 'facultes/index.php'],
        ['Départements', $nbDepartements, 'success', 'diagram-3', 'departements/index.php'],
        ['Enseignants', $nbEnseignants, 'warning', 'person-badge', 'enseignants/index.php'],
        ['Étudiants', $nbEtudiants, 'info', 'people', 'etudiants/index.php'],
        ['Cours', $nbCours, 'danger', 'book', 'cours/index.php'],
    ];
    foreach ($cards as [$label, $val, $color, $icon, $link]): ?>
    <div class="col-md-6 col-lg-4 col-xl">
        <a href="<?= BASE_URL . $link ?>" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm card-hover">
                <div class="card-body text-center p-4">
                    <div class="icon-box bg-<?= $color ?>-subtle text-<?= $color ?> rounded-circle mx-auto mb-3">
                        <i class="bi bi-<?= $icon ?> fs-3"></i>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark"><?= $val ?></h3>
                    <small class="text-muted text-uppercase fw-semibold"><?= $label ?></small>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>