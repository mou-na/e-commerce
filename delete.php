<?php
include("config/db.php");
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    die("Access denied");
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

/* Optional: delete related products first (if you have products table) */
// $conn->query("DELETE FROM products WHERE category_id = $id");

$stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Error deleting category";
}
?>