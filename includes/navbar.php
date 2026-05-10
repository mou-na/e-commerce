<?php
include(__DIR__ . "/../config/db.php");

$showBack = $showBack ?? false;
$backLink = $backLink ?? ($_SERVER['HTTP_REFERER'] ?? 'dashboard.php');
?>
<nav class="navbar-custom">

    <div class="nav-left">

        <!-- BACK -->
        <?php if ($showBack): ?>
            <a href="<?= htmlspecialchars($backLink) ?>" class="back-btn">
                <i class="fa fa-arrow-left"></i>
            </a>
        <?php endif; ?>

        <!-- TITRE -->
        <a class="navbar-brand-custom" href="dashboard.php">
            Backoffice
        </a>

    </div>

    <div class="nav-right">
        <!-- USER -->
        <span class="username">
            <i class="fa-solid fa-user"></i>
            <?= htmlspecialchars(($_SESSION['firstname'] ?? '') . ' ' . ($_SESSION['lastname'] ?? 'Admin')) ?>
        </span>
        <!-- AUTH -->
        <a href="../logout.php" class="btn-login">Déconnexion</a>

    </div>

</nav>