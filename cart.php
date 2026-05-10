<?php
include("config/db.php");
$cart = $_SESSION['cart'] ?? [];
$total = 0;

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Panier</title>

    <link rel="stylesheet" href="css/indexnavbar.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <!-- ✅ KEEP YOUR OLD NAVBAR -->
    <?php
    $navbarMode = 'default';
    $hideCart = true;
    include("includes/index-navbar.php");
    ?>

    <div class="wrapper">

        <?php if (empty($cart)) { ?>

            <div class="empty">
                <h2>Votre panier est vide</h2>
                <p>Découvrez nos produits et commencez votre shopping</p>
            </div>

        <?php } else { ?>

            <?php foreach ($cart as $item) {

                $subtotal = $item['price'] * $item['qty'];
                $total += $subtotal;

            ?>

                <div class="item">

                    <img src="<?= $item['image'] ?>" alt="">

                    <div class="info">
                        <div class="name">
                            <a href="product.php?id=<?= $item['id'] ?>">
                                <?= htmlspecialchars($item['name']) ?>
                            </a>
                        </div>

                        <div class="price">
                            <?= $item['price'] ?> DT
                        </div>
                    </div>

                    <div class="qty">
                        <button class="btn" onclick="updateQty(<?= $item['id'] ?>,'minus')">−</button>
                        <span><?= $item['qty'] ?></span>
                        <button class="btn" onclick="updateQty(<?= $item['id'] ?>,'plus')">+</button>
                    </div>

                    <div style="width:80px; text-align:right; font-weight:600;">
                        <?= $subtotal ?> DT
                    </div>

                    <div class="delete" onclick="removeItem(<?= $item['id'] ?>)">✕</div>

                </div>

            <?php } ?>

            <div class="total">
                Total: <?= $total ?> DT
            </div>

            <a class="checkout" href="checkout.php">
                Checkout
            </a>

        <?php } ?>

    </div>

    <script>
        function updateQty(id, action) {
            fetch("update_cart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id=" + id + "&action=" + action
            }).then(() => location.reload());
        }

        function removeItem(id) {
            fetch("remove_cart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id=" + id
            }).then(() => location.reload());
        }
    </script>

</body>

</html>