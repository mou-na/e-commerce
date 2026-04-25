<?php
session_start();

include("config/db.php");

$categorie_id = isset($_GET['categorie']) ? intval($_GET['categorie']) : 0;

$cats = $conn->query("SELECT * FROM categories ORDER BY nom ASC");

// 🔐 SAFE CHECK (important)
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
            <a href="#categories" class="btn-hero-primary">Découvrir la collection</a>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- ===== CATÉGORIES ===== -->
    <div class="cats-section" id="categories">

        <div class="cats-header">
            <h2>Catégories</h2>
        </div>

        <div class="cats-grid">

            <?php
            $cats->data_seek(0);
            while ($cat = $cats->fetch_assoc()):
            ?>

                <div class="cat-card <?= $categorie_id === (int)$cat['id'] ? 'active' : '' ?>">

                    <!-- CATEGORY LINK -->
                    <a href="category.php?id=<?= (int)$cat['id'] ?>" class="cat-link">

                        <div class="cat-icon" style="color: <?= htmlspecialchars($cat['color']) ?>;">
                            <i class="<?= htmlspecialchars($cat['icon']) ?>"></i>
                        </div>

                        <div class="cat-name">
                            <?= htmlspecialchars($cat['nom']) ?>
                        </div>

                    </a>

                </div>

            <?php endwhile; ?>

        </div>
    </div>
    <!-- produits ici plus tard -->

    <footer>
        © 2025 Fashion Shop — Tous droits réservés
    </footer>

</body>

</html>