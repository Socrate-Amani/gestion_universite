<?php
// includes/sidebar.php
?>
<nav class="sidebar bg-dark text-white p-3 d-flex flex-column" style="width: 260px; min-height: 100vh;">
    <a href="<?= BASE_URL ?>admin/dashboard.php" class="d-flex align-items-center mb-4 text-white text-decoration-none">
        <i class="bi bi-mortarboard-fill fs-4 me-2"></i>
        <span class="fs-5 fw-semibold">Gestion Université</span>
    </a>
    
    <hr class="text-secondary">
    
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-1">
            <a href="<?= BASE_URL ?>admin/dashboard.php" class="nav-link text-white <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
                <i class="bi bi-speedometer2 me-2"></i> Tableau de bord
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="<?= BASE_URL ?>facultes/index.php" class="nav-link text-white <?= basename(dirname($_SERVER['PHP_SELF'])) == 'facultes' ? 'active' : '' ?>">
                <i class="bi bi-building me-2"></i> Facultés
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="<?= BASE_URL ?>departements/index.php" class="nav-link text-white <?= basename(dirname($_SERVER['PHP_SELF'])) == 'departements' ? 'active' : '' ?>">
                <i class="bi bi-diagram-3 me-2"></i> Départements
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="<?= BASE_URL ?>enseignants/index.php" class="nav-link text-white <?= basename(dirname($_SERVER['PHP_SELF'])) == 'enseignants' ? 'active' : '' ?>">
                <i class="bi bi-person-badge me-2"></i> Enseignants
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="<?= BASE_URL ?>etudiants/index.php" class="nav-link text-white <?= basename(dirname($_SERVER['PHP_SELF'])) == 'etudiants' ? 'active' : '' ?>">
                <i class="bi bi-people me-2"></i> Étudiants
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="<?= BASE_URL ?>cours/index.php" class="nav-link text-white <?= basename(dirname($_SERVER['PHP_SELF'])) == 'cours' ? 'active' : '' ?>">
                <i class="bi bi-book me-2"></i> Cours
            </a>
        </li>
    </ul>

    <hr class="text-secondary">
    
    <a href="<?= BASE_URL ?>admin/logout.php" class="btn btn-outline-danger w-100 mt-auto">
        <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
    </a>
</nav>
<main class="flex-grow-1 p-4 bg-light">