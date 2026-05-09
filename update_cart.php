<?php
session_start();

$id = $_POST['id'];
$action = $_POST['action'];

if(isset($_SESSION['cart'][$id])){

    if($action=="plus"){
        $_SESSION['cart'][$id]['qty']++;
    }

    if($action=="minus"){
        $_SESSION['cart'][$id]['qty']--;

        if($_SESSION['cart'][$id]['qty']<=0){
            unset($_SESSION['cart'][$id]);
        }
    }
}

echo json_encode(["status"=>"ok"]);