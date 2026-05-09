<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
}

$cats = $conn->query("SELECT * FROM categories ORDER BY id DESC");
$total = $cats->num_rows;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des Catégories</title>

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

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar">

            <div class="title">Gestion des catégories</div>

            <!-- ➕ ADD CATEGORY -->
            <a href="../add_category.php" class="btn-add">
                <i class="fa-solid fa-plus"></i>
                Ajouter une catégorie
            </a>

        </div>

        <!-- CARD -->
        <div class="cards">
            <div class="card-box">
                <h2><?= $total ?></h2>
                <p>Total des catégories</p>
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-box">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Icône</th>
                        <th>Couleur</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php while ($cat = $cats->fetch_assoc()): ?>
                        <tr>

                            <!-- NAME -->
                            <td><strong><?= htmlspecialchars($cat['nom']) ?></strong></td>

                            <!-- ICON -->
                            <td class="icon-cell"><i class="<?= $cat['icon'] ?>"></i></td>

                            <!-- COLOR -->
                            <td class="color-cell">
                                <span class="color-only" style="background:<?= $cat['color'] ?>"></span>
                            </td>

                            <!-- ACTIONS -->
                            <td class="action">

                                <a href="../edit_category.php?id=<?= $cat['id'] ?>" class="edit">
                                    <i class="fa fa-pen"></i>
                                </a>

                                <a href="../delete_category.php?id=<?= $cat['id'] ?>"
                                    onclick="return confirm('Supprimer cette catégorie ?')"
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