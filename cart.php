<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Panier</title>

<style>
body{
    margin:0;
    font-family:-apple-system, BlinkMacSystemFont, "Segoe UI";
    background:#fff;
    color:#111;
}

/* TOP BAR */
.topbar{
    padding:25px 60px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #eee;
}

.topbar h1{
    font-size:20px;
    margin:0;
    font-weight:600;
}

.topbar a{
    text-decoration:none;
    color:#111;
    font-weight:500;
}

/* WRAPPER */
.wrapper{
    max-width:900px;
    margin:60px auto;
    padding:0 20px;
}

/* ITEM */
.item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:25px 0;
    border-bottom:1px solid #eee;
}

/* IMAGE */
.item img{
    width:80px;
    height:80px;
    object-fit:cover;
    border-radius:10px;
}

/* INFO */
.info{
    flex:1;
    margin-left:20px;
}

/* PRODUCT NAME LINK */
.name a{
    font-size:16px;
    font-weight:500;
    text-decoration:none;
    color:#111;
}

.price{
    font-size:13px;
    color:#777;
    margin-top:4px;
}

/* QTY */
.qty{
    display:flex;
    align-items:center;
    gap:12px;
}

.btn{
    border:none;
    background:none;
    font-size:18px;
    cursor:pointer;
    color:#111;
}

/* DELETE */
.delete{
    font-size:18px;
    cursor:pointer;
    color:#999;
}

.delete:hover{
    color:red;
}

/* TOTAL */
.total{
    margin-top:40px;
    text-align:right;
    font-size:22px;
    font-weight:600;
}

/* CHECKOUT */
.checkout{
    margin-top:20px;
    display:inline-block;
    padding:14px 22px;
    background:#111;
    color:white;
    text-decoration:none;
    border-radius:10px;
}

/* EMPTY */
.empty{
    text-align:center;
    padding:100px 20px;
    color:#888;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="topbar">
    <a href="decouvrir_collection.php">← Boutique</a>
    <h1>Panier</h1>
    <div></div>
</div>

<div class="wrapper">

<?php if(empty($cart)) { ?>

    <div class="empty">
        <h2>Votre panier est vide</h2>
        <p>Découvrez nos produits et commencez votre shopping</p>
    </div>

<?php } else { ?>

    <?php foreach($cart as $item){ 

        $subtotal = $item['price'] * $item['qty'];
        $total += $subtotal;

    ?>

    <div class="item">

        <!-- IMAGE -->
        <img src="<?= $item['image'] ?>" alt="product">

        <!-- INFO -->
        <div class="info">

            <!-- PRODUCT LINK (CORRIGÉ) -->
            <div class="name">
                <a href="product.php?id=<?= $item['id'] ?>">
                    <?= $item['name'] ?>
                </a>
            </div>

            <div class="price">
                <?= $item['price'] ?> DT
            </div>

        </div>

        <!-- QTY -->
        <div class="qty">

            <button class="btn" onclick="updateQty(<?= $item['id'] ?>,'minus')">−</button>

            <span id="qty-<?= $item['id'] ?>">
                <?= $item['qty'] ?>
            </span>

            <button class="btn" onclick="updateQty(<?= $item['id'] ?>,'plus')">+</button>

        </div>

        <!-- SUBTOTAL -->
        <div style="width:80px; text-align:right; font-weight:600;">
            <?= $subtotal ?> DT
        </div>

        <!-- DELETE -->
        <div class="delete" onclick="removeItem(<?= $item['id'] ?>)">✕</div>

    </div>

    <?php } ?>

    <!-- TOTAL -->
    <div class="total">
        Total: <?= $total ?> DT
    </div>

    <a class="checkout" href="checkout.php">Checkout →</a>

<?php } ?>

</div>

<script>
function updateQty(id,action){
    fetch("update_cart.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"id="+id+"&action="+action
    }).then(()=>location.reload());
}

function removeItem(id){
    fetch("remove_cart.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"id="+id
    }).then(()=>location.reload());
}
</script>

</body>
</html>