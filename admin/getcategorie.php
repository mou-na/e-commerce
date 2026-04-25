<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    die("Access denied");
}

$cats = $conn->query("SELECT * FROM categories ORDER BY id DESC");
$total = $cats->num_rows;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin Categories</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#f4f6fb;
}

/* NAVBAR */
.navbar{
    background:#111;
}

.navbar-brand{
    color:#fff !important;
    font-weight:600;
}

/* BACK BUTTON */
.back-btn{
    width:35px;
    height:35px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border-radius:8px;
    background:#222;
    color:#fff;
    text-decoration:none;
    margin-right:10px;
    transition:0.2s;
}

.back-btn:hover{
    background:#444;
    transform:scale(1.05);
}

/* MAIN */
.main{
    padding:30px;
}

/* TOPBAR */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.title{
    font-size:24px;
    font-weight:700;
}

/* ADD BUTTON */
.btn-add{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 14px;
    background:#111;
    color:#fff;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    transition:0.2s;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.btn-add:hover{
    background:#333;
    transform:translateY(-2px);
    color:#fff;
}

/* CARDS */
.cards{
    display:flex;
    gap:15px;
    margin-bottom:25px;
}

.card-box{
    flex:1;
    background:#fff;
    padding:20px;
    border-radius:14px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

/* TABLE */
.table-box{
    background:#fff;
    padding:20px;
    border-radius:14px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

table{
    width:100%;
}

thead{
    background:#111;
    color:#fff;
}

tbody tr:hover{
    background:#f1f5ff;
}

/* COLOR ONLY */
.color-only{
    display:inline-block;
    width:22px;
    height:22px;
    border-radius:50%;
    border:2px solid #fff;
    box-shadow:0 0 0 1px #ddd;
    transition:0.2s;
}

.color-only:hover{
    transform:scale(1.2);
}

/* ACTIONS */
.action a{
    display:inline-flex;
    justify-content:center;
    align-items:center;
    width:35px;
    height:35px;
    border-radius:8px;
    margin:0 2px;
    text-decoration:none;
    transition:0.2s;
}

.edit{background:#ffc107;color:#000;}
.delete{background:#dc3545;color:#fff;}

.action a:hover{
    transform:scale(1.1);
}

</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark px-4">

    <div class="d-flex align-items-center">

        <a href="dashboard.php" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>

        <span class="navbar-brand">
            <i class="fa-solid fa-gauge"></i> Admin Panel
        </span>

    </div>

    <div>
        <span style="color:#ccc;">👤 <?= $_SESSION['username'] ?></span>
        <a href="../logout.php" class="btn btn-sm btn-light ms-3">Logout</a>
    </div>

</nav>

<!-- MAIN -->
<div class="main">

<!-- TOPBAR -->
<div class="topbar">

    <div class="title">📦 Categories Management</div>

    <!-- ➕ ADD CATEGORY -->
    <a href="../add_category.php" class="btn-add">
        <i class="fa-solid fa-plus"></i>
        Ajouter Catégorie
    </a>

</div>

<!-- CARD -->
<div class="cards">
    <div class="card-box">
        <h2><?= $total ?></h2>
        <p>Total Categories</p>
    </div>
</div>

<!-- TABLE -->
<div class="table-box">

<table class="table align-middle">

<thead>
<tr>
    <th>Name</th>
    <th>Icon</th>
    <th>Color</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

<?php while($cat = $cats->fetch_assoc()): ?>
<tr>

    <!-- NAME -->
    <td><strong><?= htmlspecialchars($cat['nom']) ?></strong></td>

    <!-- ICON -->
    <td><i class="<?= $cat['icon'] ?>"></i></td>

    <!-- COLOR -->
    <td>
        <span class="color-only" style="background:<?= $cat['color'] ?>"></span>
    </td>

    <!-- ACTIONS -->
    <td class="action">

        <a href="edit_category.php?id=<?= $cat['id'] ?>" class="edit">
            <i class="fa fa-pen"></i>
        </a>

        <a href="delete_category.php?id=<?= $cat['id'] ?>"
           onclick="return confirm('Delete this category?')"
           class="delete">
            <i class="fa fa-trash"></i>
        </a>

    </td>

</tr>
<?php endwhile; ?>

</tbody>
</table>

</div>

</div>

</body>
</html>