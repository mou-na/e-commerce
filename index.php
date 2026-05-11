<?php
include("config/db.php");

$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

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

    <?php include("includes/index-navbar.php"); ?>

    <div class="hero">
        <h1>Style moderne,<br><span>prix honnête.</span></h1>
        <p>T-shirts, jeans, hoodies et accessoires — tout ce qu'il faut pour ta garde-robe.</p>

        <div class="hero-btns">
            <a href="decouvrir_collection.php" class="btn-hero-primary">Découvrir la collection</a>
        </div>
    </div>

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
        ");

            while ($product = $products->fetch_assoc()):
                $imagePath = $product['image'];
                if (!file_exists($imagePath) || empty($imagePath)) {
                    $imagePath = "uploads/default.png";
                }
            ?>

                <div class="product-card">

                    <div class="product-image">
                        <img src="<?= htmlspecialchars($imagePath) ?>" alt="product">
                    </div>

                    <div class="product-info">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="product-price">
                            <?= $product['price'] ?> DT
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