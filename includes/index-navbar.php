<?php
include(__DIR__ . "/../config/db.php");

$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
$page = basename($_SERVER['PHP_SELF']);

$isAuthPage = ($page === 'login.php' || $page === 'register.php');

$cartCount = isset($_SESSION['cart'])
    ? array_sum(array_column($_SESSION['cart'], 'qty'))
    : 0;
?>

<nav class="navbar-custom">

    <div class="nav-left">

        <!-- BACK -->
        <?php if (
            $page === 'decouvrir_collection.php' ||
            $page === 'product.php' ||
            $page === 'cart.php' ||
            $page === 'checkout.php'
        ): ?>
            <a href="javascript:history.back()" class="back-btn">
                <i class="fa fa-arrow-left"></i>
            </a>
        <?php endif; ?>

        <!-- LOGO -->
        <a class="navbar-brand-custom" href="index.php">
            Fashion Shop
        </a>

        <!-- CATEGORIE + PRODUITS -->
        <?php if (!$isAuthPage): ?>

            <!-- CATEGORIE DROPDOWN -->
            <div class="category-dropdown">

                <button class="cat-btn" onclick="toggleMenu()">
                    Catégories <i class="fa fa-chevron-down"></i>
                </button>

                <div class="dropdown-menu" id="catMenu">

                    <a href="decouvrir_collection.php?cat=0">
                        <i class="fa-solid fa-layer-group"></i>
                        Tous les produits
                    </a>

                    <?php
                    $cats = $conn->query("SELECT * FROM categories");

                    while ($cat = $cats->fetch_assoc()) {

                        $icon = !empty($cat['icon'])
                            ? htmlspecialchars($cat['icon'])
                            : 'fa-solid fa-tag';

                        echo '
                <a href="decouvrir_collection.php?cat=' . $cat['id'] . '">
                    <i class="' . $icon . '"></i>
                    ' . htmlspecialchars($cat['nom']) . '
                </a>
            ';
                    }
                    ?>

                </div>

            </div>

            <!-- PRODUITS -->
            <a href="decouvrir_collection.php" class="btn-login">
                Produits
            </a>

        <?php endif; ?>

    </div>

    <div class="nav-right">

        <!-- CART -->
        <?php if (!$isAdmin && !$isAuthPage): ?>
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
                <?= htmlspecialchars($_SESSION['firstname'] ?? '') . ' ' . htmlspecialchars($_SESSION['lastname'] ?? '') ?>
            </span>


            <a href="logout.php" class="btn-login">Déconnexion</a>

        <?php else: ?>

            <?php if (!$isAuthPage): ?>
                <a href="login.php" class="btn-login">Connexion</a>
            <?php endif; ?>

        <?php endif; ?>

    </div>

</nav>

<script>
    function toggleMenu() {
        document.getElementById("catMenu").classList.toggle("show");
    }

    document.addEventListener("click", function(e) {
        let menu = document.getElementById("catMenu");
        let btn = document.querySelector(".cat-btn");

        if (!btn.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove("show");
        }
    });
</script>