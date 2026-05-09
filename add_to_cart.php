<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ecommerce");

$id = intval($_POST['id']);

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

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
