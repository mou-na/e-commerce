<?php
session_start();

$conn = new mysqli("localhost", "root", "", "ecommerce");

if ($conn->connect_error) {
    die("Erreur DB");
}

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

<style>
body{
    margin:0;
    font-family: system-ui, Segoe UI, Arial;
    background:#f6f6f6;
    color:#111;
}

/* NAVBAR PRO */
.navbar{
    background:white;
    padding:15px 50px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #eee;
    position:sticky;
    top:0;
    z-index:1000;
}

.navbar a{
    text-decoration:none;
    color:#111;
    font-weight:600;
}

/* CART */
.cart{
    position:relative;
    font-size:22px;
    cursor:pointer;
}

.cart span{
    position:absolute;
    top:-8px;
    right:-10px;
    background:#e60023;
    color:white;
    font-size:11px;
    padding:2px 6px;
    border-radius:50%;
}

/* LAYOUT */
.container{
    max-width:1100px;
    margin:60px auto;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:70px;
    padding:0 20px;
}

/* IMAGE */
.image-box{
    background:white;
    border-radius:18px;
    padding:40px;
    height:520px;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 20px 50px rgba(0,0,0,0.06);
}

.image-box img{
    max-width:100%;
    max-height:100%;
    transition:0.4s;
}

.image-box img:hover{
    transform:scale(1.05);
}

/* INFO */
.title{
    font-size:36px;
    font-weight:700;
    margin-bottom:10px;
}

.price{
    font-size:28px;
    font-weight:600;
    margin-bottom:20px;
}

.desc{
    color:#666;
    line-height:1.7;
    margin-bottom:30px;
}

/* BUTTON */
.btn{
    width:100%;
    padding:16px;
    background:#111;
    color:white;
    border:none;
    border-radius:12px;
    cursor:pointer;
    font-size:15px;
    font-weight:600;
    transition:0.3s;
}

.btn:hover{
    background:#333;
    transform:translateY(-2px);
}

/* META */
.meta{
    margin-top:20px;
    font-size:13px;
    color:#888;
    line-height:1.6;
}

/* TOAST */
.toast{
    position:fixed;
    top:20px;
    right:20px;
    background:#111;
    color:white;
    padding:12px 18px;
    border-radius:10px;
    font-size:14px;
    animation:fade 0.3s ease;
}
.cart{
    position:relative;
    font-size:22px;
    cursor:pointer;
    text-decoration:none;
    color:#111;
}

@keyframes fade{
    from{opacity:0; transform:translateY(-10px);}
    to{opacity:1; transform:translateY(0);}
}

/* RESPONSIVE */
@media(max-width:768px){
    .container{
        grid-template-columns:1fr;
        gap:40px;
    }

    .image-box{
        height:380px;
    }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">

    <a href="decouvrir_collection.php">← Boutique</a>

   <a href="cart.php" class="cart">
    🛒
    <span id="cartCount">
        <?= isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0 ?>
    </span>
</a>

</div>

<!-- PRODUCT -->
<div class="container">

    <!-- IMAGE -->
    <div class="image-box">
        <img src="<?= $imagePath ?>" alt="">
    </div>

    <!-- INFO -->
    <div>

        <div class="title">
            <?= htmlspecialchars($product['name']); ?>
        </div>

        <div class="price">
            <?= $product['price']; ?> DT
        </div>

        <div class="desc">
            <?= htmlspecialchars($product['description'] ?? "Produit premium de haute qualité."); ?>
        </div>

        <button class="btn" onclick="addToCart(<?= $product['id']; ?>)">
            🛒 Ajouter au panier
        </button>

        <div class="meta">
            ✔ Livraison rapide<br>
            ✔ Paiement sécurisé<br>
            ✔ Retour sous 7 jours
        </div>

    </div>

</div>

<!-- SCRIPT AJAX -->
<script>
function addToCart(id){

    fetch("add_to_cart.php", {
        method:"POST",
        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },
        body:"id="+id
    })
    .then(res => res.json())
    .then(data => {

        if(data.status === "ok"){

            document.getElementById("cartCount").innerText = data.count;

            let toast = document.createElement("div");
            toast.className = "toast";
            toast.innerText = "✅ Produit ajouté au panier";

            document.body.appendChild(toast);

            setTimeout(() => toast.remove(), 2000);
        }
    });
}
</script>

</body>
</html>