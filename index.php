<?php
session_start();

include("config/db.php");

$categorie_id = isset($_GET['categorie']) ? intval($_GET['categorie']) : 0;

$cats = $conn->query("SELECT * FROM categories ORDER BY nom ASC");

// 🔐 SAFE CHECK
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

$cat_active = null;
if ($categorie_id > 0) {
    $c = $conn->prepare("SELECT nom FROM categories WHERE id = ?");
    $c->bind_param("i", $categorie_id);
    $c->execute();
    $cat_active = $c->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Fashion Shop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/indexnavbar.css">
</head>

<body>

    <?php
    $navbarMode = 'default';
    include("includes/index-navbar.php");
    ?>

    <!-- ===== HERO ===== -->
    <div class="hero">
        <h1>Style moderne,<br><span>prix honnête.</span></h1>
        <p>T-shirts, jeans, hoodies et accessoires — tout ce qu'il faut pour ta garde-robe.</p>

        <div class="hero-btns">
           <a href="decouvrir_collection.php" class="btn-hero-primary">Découvrir la collection</a>
        </div>
    </div>

    <!-- ===== NEW PRODUCTS ===== -->
    <div class="new-products-section">

        <div class="new-products-header">
            <div class="title-block">
                <span>NOUVEAUTÉS</span>
                <h2>Nouvelle collection</h2>
            </div>
        </div>

        <div class="products-grid">

            <?php
            $products = $conn->query("
            SELECT * FROM products
            ORDER BY created_at DESC
            LIMIT 4
        ");

            while ($product = $products->fetch_assoc()):
            ?>

                <div class="product-card">

                    <div class="product-image">
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="product">
                    </div>

                    <div class="product-info">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="product-price">
                            <?= number_format($product['price'], 2) ?> DT
                        </p>
                    </div>

                </div>

            <?php endwhile; ?>

        </div>
    </div>

    <footer>
        © 2025 Fashion Shop — Tous droits réservés
    </footer>

</body>

</html>