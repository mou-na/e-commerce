<?php
include("config/db.php");

if ($conn->connect_error) {
    die("Erreur DB");
}

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

$user_id = $_SESSION['user_id'];

$total = 0;

foreach ($cart as $item) {
    $total += $item['price'] * $item['qty'];
}

/* INSERT COMMANDE */
$stmt = $conn->prepare("
    INSERT INTO commande(user_id, total)
    VALUES(?, ?)
");

$stmt->bind_param("id", $user_id, $total);
$stmt->execute();

$commande_id = $conn->insert_id;

/* INSERT LIGNES */
foreach ($cart as $item) {

    $stmt = $conn->prepare("
        INSERT INTO ligne_commande
        (commande_id, produit_id, quantite, prix)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "iiid",
        $commande_id,
        $item['id'],
        $item['qty'],
        $item['price']
    );

    $stmt->execute();
}

/* EMPTY CART */
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Commande validée</title>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            background: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: white;
            padding: 50px;
            border-radius: 14px;
            text-align: center;
            max-width: 500px;
        }

        h1 {
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            margin-top: 25px;
            padding: 14px 20px;
            background: black;
            color: white;
            text-decoration: none;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="box">

        <h1>Commande effectuée avec succès</h1>

        <p>Merci pour votre achat.</p>

        <a href="index.php">
            Retour à la boutique
        </a>

    </div>

</body>

</html>