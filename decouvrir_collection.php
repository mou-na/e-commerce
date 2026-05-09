<?php
$conn = new mysqli("localhost", "root", "", "ecommerce");

if ($conn->connect_error) {
    die("Erreur connexion DB");
}

$cat_id = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Découvrir la collection</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #f5f5f5;
}

/* NAVBAR */
.navbar {
    background: #111;
    color: white;
    padding: 15px 30px;
    font-size: 20px;
    display: flex;
    justify-content: space-between;
}

/* LAYOUT */
.container {
    display: flex;
}

/* SIDEBAR */
.sidebar {
    width: 250px;
    background: #fff;
    padding: 20px;
    border-right: 1px solid #ddd;
    min-height: 100vh;
}

.sidebar h3 {
    margin-bottom: 15px;
}

.sidebar a {
    display: block;
    padding: 10px;
    margin-bottom: 8px;
    text-decoration: none;
    color: #333;
    border-radius: 8px;
    transition: 0.3s;
}

.sidebar a.active,
.sidebar a:hover {
    background: black;
    color: white;
}

/* PRODUCTS */
.products {
    flex: 1;
    padding: 30px;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 20px;
}

/* CARD */
.card {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-6px);
}

/* IMAGE */
.image-container {
    width: 100%;
    height: 220px;
    background: #f9f9f9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: 0.4s;
}

.card:hover img {
    transform: scale(1.08);
}

/* CONTENT */
.card-body {
    padding: 15px;
}

.card-title {
    font-size: 15px;
    margin-bottom: 10px;
}

.price {
    font-weight: bold;
    margin-bottom: 10px;
}

/* BUTTON */
.btn {
    display: inline-block;
    padding: 8px 12px;
    background: black;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
}

.btn:hover {
    background: #333;
}

.empty {
    color: #777;
    font-size: 18px;
}
</style>
</head>

<body>

<div class="navbar">
    <div>Mon E-commerce</div>
    <div><a href="index.php" style="color:white;text-decoration:none;">Accueil</a></div>
</div>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3>Catégories</h3>

        <!-- 🔥 VIEW ALL -->
        <a href="?cat=0" class="<?php echo ($cat_id == 0) ? 'active' : ''; ?>">
            🔥 View All
        </a>

        <?php
        $cats = $conn->query("SELECT * FROM categories");

        while ($cat = $cats->fetch_assoc()) {
            $active = ($cat_id == $cat['id']) ? "active" : "";
            echo "<a class='$active' href='?cat=".$cat['id']."'>".$cat['nom']."</a>";
        }
        ?>
    </div>

    <!-- PRODUCTS -->
    <div class="products">

        <h2>
        <?php
        if ($cat_id == 0) {
            echo "Tous les produits";
        } else {
            echo "Produits";
        }
        ?>
        </h2>

        <div class="grid">

        <?php
        if ($cat_id == 0) {

            // 🔥 TOUS LES PRODUITS
            $result = $conn->query("SELECT * FROM products");

        } else {

            // 🔥 PRODUITS PAR CATÉGORIE
            $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ?");
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
                    <img src="<?php echo $imagePath; ?>" alt="">
                </div>

                <div class="card-body">
                    <div class="card-title"><?php echo htmlspecialchars($p['name']); ?></div>
                    <div class="price"><?php echo $p['price']; ?> DT</div>
                    <a href="#" class="btn">Voir produit</a>
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