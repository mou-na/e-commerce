<?php
include("config/db.php");

$cat_id = isset($_GET['cat']) ? intval($_GET['cat']) : 0;

$cat_name = "Tous les produits";
$cat_icon = "fa-solid fa-layer-group";

if ($cat_id > 0) {

    $stmt = $conn->prepare("SELECT nom, icon FROM categories WHERE id = ?");
    $stmt->bind_param("i", $cat_id);
    $stmt->execute();

    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        $cat_name = $row['nom'];
        $cat_icon = $row['icon'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Découvrir la collection</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/indexnavbar.css">
    <link rel="stylesheet" href="css/dec.css">
</head>

<body>

    <?php include("includes/index-navbar.php"); ?>

    <div class="container">

        <div class="sidebar">

            <h3>Catégories</h3>

            <a href="?cat=0" class="<?= ($cat_id == 0) ? 'active' : '' ?>">
                <i class="fa-solid fa-layer-group"></i>
                Tous les produits
            </a>

            <?php
            $cats = $conn->query("SELECT * FROM categories");

            while ($cat = $cats->fetch_assoc()) {

                $active = ($cat_id == $cat['id']) ? "active" : "";

                echo "
                <a class='$active' href='?cat=" . $cat['id'] . "'>
                    <i class='" . htmlspecialchars($cat['icon']) . "'></i>
                    " . htmlspecialchars($cat['nom']) . "
                </a>";
            }
            ?>

        </div>

        <div class="products">

            <h2 class="category-title">
                <i class="<?= htmlspecialchars($cat_icon) ?>"></i>
                <?= htmlspecialchars($cat_name) ?>
            </h2>

            <div class="grid">

                <?php
                if ($cat_id == 0) {

                    $result = $conn->query("
                        SELECT * FROM products
                        ORDER BY created_at DESC
                    ");
                } else {

                    $stmt = $conn->prepare("
                        SELECT * FROM products
                        WHERE category_id = ?
                    ");

                    $stmt->bind_param("i", $cat_id);
                    $stmt->execute();

                    $result = $stmt->get_result();
                }

                if ($result->num_rows > 0) {

                    while ($p = $result->fetch_assoc()) {

                        $imagePath = htmlspecialchars($p['image']);

                        if (!file_exists($imagePath)) {
                            $imagePath = "uploads/default.png";
                        }
                ?>

                        <div class="card">

                            <div class="image-container">
                                <img src="<?= $imagePath ?>" alt="">
                            </div>

                            <div class="card-body">

                                <div class="card-title">
                                    <?= htmlspecialchars($p['name']) ?>
                                </div>

                                <div class="price">
                                    <?= $p['price'] ?> DT
                                </div>

                                <a href="product.php?id=<?= $p['id']; ?>" class="btn">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                            </div>

                        </div>

                <?php
                    }
                } else {

                    echo "<p class='empty'>Aucun produit trouvé</p>";
                }
                ?>

            </div>

        </div>

    </div>

</body>

</html>