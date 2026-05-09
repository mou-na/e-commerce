<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
$page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar-custom">

    <!-- LEFT SIDE -->
    <div class="nav-left">

        <?php if ($page === 'decouvrir_collection.php' || $page === 'product.php'): ?>
            <a href="javascript:history.back()" class="back-btn">
                <i class="fa fa-arrow-left"></i>
            </a>
        <?php endif; ?>

        <a class="navbar-brand-custom" href="index.php">
            Fashion Shop
        </a>

    </div>

    <!-- RIGHT SIDE -->
    <div class="nav-right">

        <!-- INDEX MODE ONLY -->
        <?php if ($page === 'index.php'): ?>

            <div class="dropdown-wrap">
                <button class="dropdown-btn">
                    Catégories <span class="arrow">▾</span>
                </button>

                <div class="dropdown-menu-custom">
                    <a class="dropdown-item-custom" href="index.php">
                        Toutes les catégories
                    </a>
                </div>
            </div>

        <?php endif; ?>

        <!-- 🔥 BACKOFFICE ALWAYS FOR ADMIN -->
        <?php if ($isAdmin): ?>
            <a href="admin/dashboard.php" class="btn-login">Backoffice</a>
        <?php endif; ?>

        <!-- AUTH -->
        <?php if ($page === 'login.php'): ?>
            <a href="register.php" class="btn-login">S'inscrire</a>

        <?php elseif ($page === 'register.php'): ?>
            <a href="login.php" class="btn-login">Connexion</a>
        <?php endif; ?>

        <!-- USER -->
        <?php if (isset($_SESSION['user_id'])): ?>

            <span class="username">
                <i class="fa-solid fa-user"></i>
                <?= htmlspecialchars($_SESSION['username']) ?>
            </span>

            <a href="logout.php" class="btn-login">Déconnexion</a>

        <?php else: ?>

            <?php if ($page !== 'login.php' && $page !== 'register.php'): ?>
                <a href="login.php" class="btn-login">Connexion</a>
            <?php endif; ?>

        <?php endif; ?>

    </div>
</nav>