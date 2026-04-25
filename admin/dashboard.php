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

<style>
body{
    background:#f5f5f5;
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

/* CARDS */
.dashboard{
    padding:30px;
}

.card-box{
    background:#fff;
    border-radius:12px;
    padding:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    text-align:center;
}

.card-box h2{
    font-size:32px;
    font-weight:700;
}

.card-box p{
    color:#888;
}

/* ACTIONS */
.actions{
    margin-top:30px;
}

.actions a{
    display:inline-block;
    margin:10px;
    padding:12px 20px;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    transition:0.2s;
}

.btn-add{
    background:#111;
    color:#fff;
}

.btn-add:hover{
    background:#333;
}

.btn-view{
    border:1px solid #ccc;
    color:#111;
}

.btn-view:hover{
    background:#eee;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark px-4">
    <span class="navbar-brand">Admin Panel</span>

    <div>
        <span style="color:#ccc;">👤 <?= $_SESSION['username'] ?></span>
        <a href="../logout.php" class="btn btn-sm btn-light ms-3">Logout</a>
    </div>
</nav>

<!-- DASHBOARD -->
<div class="container dashboard">

    <h2 class="mb-4">📊 Dashboard</h2>

    <div class="row g-4">

        <!-- USERS -->
        <div class="col-md-6">
            <div class="card-box">
                <h2><?= $totalUsers ?></h2>
                <p>Utilisateurs</p>
            </div>
        </div>

        <!-- CATEGORIES -->
        <div class="col-md-6">
            <div class="card-box">
                <h2><?= $totalCategories ?></h2>
                <p>Catégories</p>
            </div>
        </div>

    </div>

    <!-- ACTIONS -->
    <div class="actions text-center">

        <a href="../add_category.php" class="btn-add">
            ➕ Ajouter Catégorie
        </a>

        <a href="../index.php" class="btn-view">
            🌐 Voir Site
        </a>

    </div>

</div>

</body>
</html>