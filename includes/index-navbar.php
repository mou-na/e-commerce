<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
$page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar-custom">

    <a class="navbar-brand-custom" href="index.php">
        Fashion Shop
    </a>

    <div class="nav-right">

        <!-- ================= INDEX MODE ================= -->
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

            <a href="#" class="btn-login">Nouveautés</a>

            <?php if ($isAdmin): ?>
                <a href="admin/dashboard.php" class="btn-login">Backoffice</a>
            <?php endif; ?>

        <?php endif; ?>


        <!-- ================= AUTH MODE ================= -->
        <?php if ($page === 'login.php'): ?>
            <a href="register.php" class="btn-login">S'inscrire</a>
        <?php elseif ($page === 'register.php'): ?>
            <a href="login.php" class="btn-login">Connexion</a>
        <?php endif; ?>


        <!-- ================= USER ================= -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <span class="username">
                <i class="fa-solid fa-user"></i>
                <?= htmlspecialchars($_SESSION['username']) ?>
            </span>

            <a href="logout.php" class="btn-login">Déconnexion</a>
        <?php endif; ?>

    </div>
</nav>