<?php
include("config/db.php");

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    echo json_encode([
        "status" => "error",
        "message" => "Admin cannot use cart"
    ]);
    exit();
}

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "status" => "login_required"
    ]);

    exit();
}

$id = intval($_POST['id'] ?? 0);

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$res = $stmt->get_result();

if ($res->num_rows === 0) {

    echo json_encode([
        "status" => "error",
        "message" => "Produit introuvable"
    ]);

    exit();
}

$product = $res->fetch_assoc();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (!isset($_SESSION['cart'][$id])) {

    $_SESSION['cart'][$id] = [
        "id" => $product['id'],
        "name" => $product['name'],
        "price" => $product['price'],
        "image" => $product['image'],
        "qty" => 1
    ];
} else {

    $_SESSION['cart'][$id]['qty']++;
}

echo json_encode([
    "status" => "ok",
    "count" => array_sum(array_column($_SESSION['cart'], 'qty'))
]);
