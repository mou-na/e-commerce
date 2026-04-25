<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied");
}

/* CHECK ID */
if (!isset($_GET['id'])) {
    header("Location: admin/list_products.php");
    exit;
}

$id = intval($_GET['id']);

/* GET PRODUCT (to delete image too) */
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

/* If product exists */
if ($product) {

    /* DELETE IMAGE FILE */
    if (!empty($product['image']) && file_exists($product['image'])) {
        unlink($product['image']);
    }

    /* DELETE PRODUCT FROM DB */
    $delete = $conn->prepare("DELETE FROM products WHERE id = ?");
    $delete->bind_param("i", $id);
    $delete->execute();
}

/* REDIRECT BACK */
header("Location: admin/list_products.php");
exit;
