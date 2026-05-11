<?php
include("config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: index.php");
    exit();
}

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: cart.php");
    exit();
}

$total = 0;

foreach ($cart as $item) {
    $total += $item['price'] * $item['qty'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/indexnavbar.css">
    <link rel="stylesheet" href="css/check.css">
</head>

<body>

    <?php include("includes/index-navbar.php"); ?>

    <div class="container">

        <h1>Checkout</h1>

        <form action="place_order.php" method="POST">

            <div class="input-group">
                <label>Nom complet</label>
                <input type="text" name="nom" required>
            </div>

            <div class="input-group">
                <label>Téléphone</label>
                <input type="text" name="telephone" required>
            </div>

            <div class="input-group">
                <label>Adresse</label>
                <input type="text" name="adresse" required>
            </div>

            <div class="total">
                Total : <?= $total ?> DT
            </div>

            <button type="submit" class="checkout-btn">
                Confirmer la commande
            </button>

        </form>

    </div>

</body>

</html>