<?php
session_start();
include("config/db.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

/* CATEGORY */
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();

if (!$category) {
    echo "Category not found";
    exit;
}

/* PRODUCTS */
$products = $conn->prepare("SELECT * FROM products WHERE category_id = ?");
$products->bind_param("i", $id);
$products->execute();
$result = $products->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($category['nom']) ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    font-family:Segoe UI, sans-serif;
    background:#fff;
    color:#111;
}

/* HEADER (very clean) */
.topbar{
    border-bottom:1px solid #eee;
    padding:25px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.title{
    display:flex;
    align-items:center;
    gap:10px;
}

.title i{
    font-size:20px;
    color:<?= htmlspecialchars($category['color']) ?>;
}

.title h1{
    font-size:18px;
    margin:0;
    font-weight:600;
}

.back{
    font-size:13px;
    color:#666;
    text-decoration:none;
}

.back:hover{
    color:#000;
}

/* GRID */
.container-grid{
    max-width:1200px;
    margin:30px auto;
    padding:0 20px;

    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
    gap:20px;
}

/* PRODUCT CARD */
.product{
    border:1px solid #eee;
    border-radius:10px;
    overflow:hidden;
    transition:0.2s ease;
    background:#fff;
}

.product:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.product img{
    width:100%;
    height:220px;
    object-fit:cover;
    background:#f5f5f5;
}

.product-body{
    padding:12px;
}

.product-name{
    font-size:14px;
    font-weight:600;
    margin-bottom:5px;
}

.product-price{
    font-size:13px;
    color:#333;
}

/* EMPTY STATE */
.empty{
    grid-column:1/-1;
    text-align:center;
    padding:60px;
    color:#999;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="topbar">

    <div class="title">
        <i class="<?= htmlspecialchars($category['icon']) ?>"></i>
        <h1><?= htmlspecialchars($category['nom']) ?></h1>
    </div>

    <a href="index.php" class="back">← Back to categories</a>

</div>

<!-- PRODUCTS GRID -->
<div class="container-grid">

<?php if ($result->num_rows > 0): ?>

    <?php while ($p = $result->fetch_assoc()): ?>

        <div class="product">

            <img src="images/<?= htmlspecialchars($p['image']) ?>" alt="product image">

            <div class="product-body">

                <div class="product-name">
                    <?= htmlspecialchars($p['name']) ?>
                </div>

                <div class="product-price">
                    $<?= htmlspecialchars($p['price']) ?>
                </div>

            </div>

        </div>

    <?php endwhile; ?>

<?php else: ?>

    <div class="empty">
        No products found in this category
    </div>

<?php endif; ?>

</div>

</body>
</html>