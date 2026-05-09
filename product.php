<?php
session_start();

$conn = new mysqli("localhost", "root", "", "ecommerce");

if ($conn->connect_error) {
    die("Erreur DB");
}

if (!isset($_GET['id'])) {
    die("Produit introuvable");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Produit non trouvé");
}

$product = $result->fetch_assoc();

$imagePath = $product['image'];
if (!file_exists($imagePath)) {
    $imagePath = "uploads/default.png";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']); ?></title>

    <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="css/indexnavbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <!-- 🔥 YOUR MAIN NAVBAR -->
    <?php
    $navbarMode = 'default';
    include("includes/index-navbar.php");
    ?>

    <div class="wrapper">

        <!-- IMAGE -->
        <div class="product-image">
            <img src="<?= $imagePath; ?>" alt="">
        </div>

        <!-- INFO -->
        <div class="product-info">

            <div class="title">
                <?= htmlspecialchars($product['name']); ?>
            </div>

            <div class="price">
                <?= $product['price']; ?> DT
            </div>

            <div class="description">
                <?= htmlspecialchars($product['description'] ?? "Produit premium de haute qualité."); ?>
            </div>

            <button class="btn">Ajouter au panier</button>

            <div class="meta">
                <div><i class="fa-solid fa-truck-fast"></i> Livraison rapide</div>
                <div><i class="fa-solid fa-lock"></i> Paiement sécurisé</div>
                <div><i class="fa-solid fa-rotate-left"></i> Retour sous 7 jours</div>
            </div>

        </div>

    </div>

</body>

</html>