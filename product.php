<?php
include("config/db.php");

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
if (!file_exists($imagePath) || empty($imagePath)) {
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

    <?php include("includes/index-navbar.php"); ?>

    <div class="wrapper">

        <div class="product-image">
            <img src="<?= $imagePath ?>" alt="">
        </div>

        <div class="product-info">

            <div class="title">
                <?= htmlspecialchars($product['name']); ?>
            </div>

            <div class="price">
                <?= $product['price']; ?> DT
            </div>

            <div class="description">
                <?= htmlspecialchars($product['description']); ?>
            </div>

            <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'): ?>
                <button class="btn" onclick="addToCart(<?= $product['id']; ?>)">
                    <i class="fa-solid fa-cart-plus"></i> Ajouter au panier
                </button>
            <?php endif; ?>

            <div class="meta">
                <div><i class="fa-solid fa-truck-fast"></i> Livraison rapide</div>
                <div><i class="fa-solid fa-lock"></i> Paiement sécurisé</div>
                <div><i class="fa-solid fa-rotate-left"></i> Retour sous 7 jours</div>
            </div>

        </div>

    </div>

    <script>
        function addToCart(id) {

            fetch("add_to_cart.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "id=" + id
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status === "login_required") {

                        window.location.href = "login.php";
                        return;
                    }

                    if (data.status === "ok") {

                        const counter = document.getElementById("cartCount");

                        if (counter) {
                            counter.innerText = data.count;
                        }


                    }

                    if (data.status === "error") {
                        alert(data.message);
                        return;
                    }
                });
        }
    </script>

</body>

</html>