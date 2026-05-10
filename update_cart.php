<?php
include("config/db.php");

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: index.php");
    exit();
}

$id = $_POST['id'];
$action = $_POST['action'];

if (isset($_SESSION['cart'][$id])) {

    if ($action == "plus") {
        $_SESSION['cart'][$id]['qty']++;
    }

    if ($action == "minus") {
        $_SESSION['cart'][$id]['qty']--;

        if ($_SESSION['cart'][$id]['qty'] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }
}

echo json_encode(["status" => "ok"]);
