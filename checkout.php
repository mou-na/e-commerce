<?php
session_start();

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

    <link rel="stylesheet" href="css/indexnavbar.css">
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            background: #f8f8f8;
        }

        .container {
            max-width: 700px;
            margin: 60px auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
        }

        h1 {
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
        }

        .total {
            margin-top: 30px;
            font-size: 22px;
            font-weight: 700;
        }

        button {
            margin-top: 30px;
            width: 100%;
            padding: 16px;
            border: none;
            background: black;
            color: white;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #222;
        }
    </style>
</head>

<body>

    <?php
    $hideCart = true;
    include("includes/index-navbar.php");
    ?>

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

            <button type="submit">
                Confirmer la commande
            </button>

        </form>

    </div>

</body>

</html>