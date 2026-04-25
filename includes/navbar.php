<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* BACK BUTTON SYSTEM (KEEP THIS) */
$showBack = $showBack ?? false;
$backLink = $backLink ?? ($_SERVER['HTTP_REFERER'] ?? 'dashboard.php');
?>
<nav class="navbar-custom">

    <div class="nav-left">

        <!-- BACK BUTTON (only if needed) -->
        <?php if ($showBack): ?>
            <a href="<?= htmlspecialchars($backLink) ?>" class="back-btn">
                <i class="fa fa-arrow-left"></i>
            </a>
        <?php endif; ?>

        <a class="navbar-brand-custom" href="dashboard.php">
            Backoffice
        </a>

    </div>

    <div class="nav-right">

        <span class="username">
            <i class="fa-solid fa-user"></i>
            <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?>
        </span>

        <a href="../logout.php" class="btn-login">Déconnexion</a>

    </div>

</nav>