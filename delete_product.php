<?php
include("config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
}

if (!isset($_GET['id'])) {
    header("Location: admin/list_products.php");
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($product) {

    if (!empty($product['image']) && file_exists($product['image'])) {
        unlink($product['image']);
    }

    $delete = $conn->prepare("DELETE FROM products WHERE id = ?");
    $delete->bind_param("i", $id);
    $delete->execute();
}

header("Location: admin/list_products.php");
exit;
