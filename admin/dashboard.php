<?php
session_start();
include("../config/db.php");

// 🔒 SECURITY
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    die("Access denied");
}

// 📊 STATS
$totalUsers = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$totalCategories = $conn->query("SELECT COUNT(*) as total FROM categories")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    background:#f5f6fa;
    font-family:'Segoe UI';
}

/* NAVBAR */
.navbar{
    background:#111;
}
.navbar-brand{
    color:#fff !important;
    font-weight:600;
}

/* DASHBOARD */
.dashboard{
    padding:40px;
}

/* CARDS */
.card-box{
    background:#fff;
    border-radius:14px;
    padding:25px;
    box-shadow:0 6px 20px rgba(0,0,0,0.05);
    text-align:center;
    transition:0.3s;
}

.card-box:hover{
    transform:translateY(-3px);
}

.card-box h2{
    font-size:36px;
    font-weight:700;
}

.card-box p{
    color:#888;
}

/* ACTIONS */
.actions{
    margin-top:50px;
    display:flex;
    justify-content:center;
    gap:15px;
    flex-wrap:wrap;
}

/* BASE BUTTON */
.actions a{
    display:flex;
    align-items:center;
    gap:8px;
    padding:12px 20px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
    transition:0.25s;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

/* ADD CATEGORY */
.btn-add{
    background:linear-gradient(135deg,#111,#333);
    color:#fff;
    border:1px solid #111;
}

.btn-add:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

/* VIEW SITE */
.btn-view{
    background:#fff;
    color:#111;
    border:1px solid #ddd;
}

.btn-view:hover{
    background:#f2f2f2;
    transform:translateY(-3px);
}

/* 🍏 APPLE BUTTON */
.btn-apple{
    background:linear-gradient(135deg,#000,#444);
    color:#fff;
    border:1px solid #000;
}

.btn-apple:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(0,0,0,0.25);
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark px-4">
    <span class="navbar-brand">
        <i class="fa-solid fa-gauge"></i> Admin Panel
    </span>

    <div>
        <span style="color:#ccc;">👤 <?= $_SESSION['username'] ?></span>
        <a href="../logout.php" class="btn btn-sm btn-light ms-3">Logout</a>
    </div>
</nav>

<!-- DASHBOARD -->
<div class="container dashboard">

    <h2 class="mb-4">📊 Dashboard Overview</h2>

    <div class="row g-4">

        <!-- USERS -->
        <div class="col-md-6">
            <div class="card-box">
                <h2><?= $totalUsers ?></h2>
                <p>👤 Utilisateurs</p>
            </div>
        </div>

        <!-- CATEGORIES -->
        <div class="col-md-6">
            <div class="card-box">
                <h2><?= $totalCategories ?></h2>
                <p>📦 Catégories</p>
            </div>
        </div>

    </div>

    <!-- ACTION BUTTONS -->
    <div class="actions">

     

        <a href="../index.php" class="btn-view">
            <i class="fa-solid fa-globe"></i>
            Voir le Site
        </a>

   <a href="getcategorie.php" class="btn-apple">
    Catégorie
</a>

    </div>

</div>

</body>
</html>