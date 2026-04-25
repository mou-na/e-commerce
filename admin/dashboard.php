<?php
session_start();
include("../config/db.php");

// 🔒 SECURITY
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Accès refusé");
}

// 📊 STATS
$totalUsers = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$totalCategories = $conn->query("SELECT COUNT(*) as total FROM categories")->fetch_assoc()['total'];
$totalProducts = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/indexnavbar.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>

    <?php include("../includes/navbar.php"); ?>

    <!-- DASHBOARD -->
    <div class="container dashboard">

        <h2 class="mb-4">
            <i class="fa-solid fa-chart-line"></i> Tableau de bord
        </h2>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card-box">
                    <h2><?= $totalUsers ?></h2>
                    <p><i class="fa-solid fa-users"></i> Utilisateurs</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-box">
                    <h2><?= $totalCategories ?></h2>
                    <p><i class="fa-solid fa-list"></i> Catégories</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-box">
                    <h2><?= $totalProducts ?></h2>
                    <p><i class="fa-solid fa-box"></i> Produits</p>
                </div>
            </div>

        </div>

        <!-- ACTION BUTTONS -->
        <div class="actions">

            <a href="../index.php" class="btn-admin">
                <i class="fa-solid fa-globe"></i>
                Voir le site
            </a>


            <a href="getcategorie.php" class="btn-admin">
                <i class="fa-solid fa-list"></i>
                Catégories
            </a>

            <a href="list_products.php" class="btn-admin">
                <i class="fa-solid fa-box"></i>
                Produits
            </a>

        </div>

    </div>

</body>

</html>