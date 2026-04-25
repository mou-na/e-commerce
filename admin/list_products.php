<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Accès refusé");
}

/* PRODUITS */
$products = $conn->query("
    SELECT p.*, c.nom AS category_name 
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    ORDER BY p.id DESC
");

$total = $products->num_rows;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des Produits</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/indexnavbar.css">
    <link rel="stylesheet" href="../css/list.css">
</head>

<body>

    <?php
    $showBack = true;
    $backLink = "dashboard.php";
    include("../includes/navbar.php");
    ?>

    <div class="main">

        <div class="topbar">

            <div class="title">Gestion des produits</div>

            <a href="../add_product.php" class="btn-add">
                <i class="fa-solid fa-plus"></i>
                Ajouter un produit
            </a>

        </div>

        <div class="cards">
            <div class="card-box">
                <h2><?= $total ?></h2>
                <p>Total des produits</p>
            </div>
        </div>

        <div class="table-box">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Catégorie</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php while ($p = $products->fetch_assoc()): ?>
                        <tr>

                            <td>
                                <img src="../<?= $p['image'] ?>" class="product-img">
                            </td>

                            <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>

                            <td><?= $p['price'] ?> TND</td>

                            <td><?= htmlspecialchars($p['category_name']) ?></td>

                            <td>
                                <?= substr(htmlspecialchars($p['description']), 0, 40) ?>...
                            </td>

                            <td class="action">

                                <a href="../edit_product.php?id=<?= $p['id'] ?>" class="edit">
                                    <i class="fa fa-pen"></i>
                                </a>

                                <a href="../delete_product.php?id=<?= $p['id'] ?>"
                                    onclick="return confirm('Supprimer ce produit ?')"
                                    class="delete">
                                    <i class="fa fa-trash"></i>
                                </a>

                            </td>

                        </tr>
                    <?php endwhile; ?>

                </tbody>
            </table>

        </div>

    </div>

</body>

</html>