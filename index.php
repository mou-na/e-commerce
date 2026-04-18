<?php include("config/db.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Shop Vêtements</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<!-- 🔝 NAVBAR BOOTSTRAP -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">🛒 Fashion Shop</a>

    <div class="ms-auto">
        <a class="btn btn-outline-light btn-sm me-2" href="index.php">Accueil</a>
        <a class="btn btn-primary btn-sm" href="login.php">Login</a>
    </div>
</nav>

<!-- 📝 HERO -->
<div class="container text-center my-5">
    <h1>Bienvenue dans notre boutique de vêtements</h1>
    <p class="lead">
        Découvrez les meilleurs vêtements modernes : t-shirts, jeans, hoodies et plus encore.
        Qualité + style + meilleur prix.
    </p>
</div>

<!-- 👕 PRODUITS -->
<?php
/*
<div class="container">
    <h2 class="text-center mb-4">Nos Produits</h2>

    <div class="row">

    <?php
    $res = $conn->query("SELECT * FROM products");

    while($row = $res->fetch_assoc()){
    ?>

        <div class="col-md-3 mb-4">
            <div class="card shadow">

                <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top" style="height:200px; object-fit:cover;">

                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                    <p class="card-text"><?php echo $row['description']; ?></p>
                    <h6 class="text-success"><?php echo $row['price']; ?> TND</h6>
                </div>

            </div>
        </div>

    <?php } ?>

    </div>
</div>
*/
?>

</body>
</html>