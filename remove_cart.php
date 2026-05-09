<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: index.php");
    exit();
}

$id = $_POST['id'];

unset($_SESSION['cart'][$id]);

echo json_encode(["status" => "ok"]);
