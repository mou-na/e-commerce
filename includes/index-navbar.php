<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
$page = basename($_SERVER['PHP_SELF']);

$cartCount = isset($_SESSION['cart'])
    ? array_sum(array_column($_SESSION['cart'], 'qty'))
    : 0;
?>

<nav class="navbar-custom">

    <!-- LEFT -->
    <div class="nav-left">

        <?php if (
            $page === 'decouvrir_collection.php' ||
            $page === 'product.php' ||
            $page === 'cart.php'
        ): ?>
            <a href="javascript:history.back()" class="back-btn">
                <i class="fa fa-arrow-left"></i>
            </a>
        <?php endif; ?>

        <a class="navbar-brand-custom" href="index.php">
            Fashion Shop
        </a>

    </div>

    <!-- RIGHT -->
    <div class="nav-right">

        <!-- CART (NEW FEATURE ADDED) -->
        <!-- CART -->
        <?php if (!$isAdmin): ?>
            <a href="cart.php" class="cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>

                <span class="cart-count" id="cartCount">
                    <?= $cartCount ?>
                </span>
            </a>
        <?php endif; ?>

        <!-- BACKOFFICE -->
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