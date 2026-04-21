<?php
session_start();
include("config/db.php");

/* GET ID */
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

/* GET CATEGORY */
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();

if (!$category) {
    echo "Category not found";
    exit;
}

/* UPDATE */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST['nom']);
    $icon = trim($_POST['icon']);
    $color = trim($_POST['color']);

    if ($nom && $icon && $color) {

        $update = $conn->prepare("UPDATE categories SET nom=?, icon=?, color=? WHERE id=?");
        $update->bind_param("sssi", $nom, $icon, $color, $id);
        $update->execute();

        header("Location: index.php");
        exit;

    } else {
        $error = "Please fill all fields";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Category</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    background: linear-gradient(135deg,#f6f7fb,#eef1f7);
    font-family: "Segoe UI", sans-serif;
}

/* CENTER */
.page{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* CARD */
.card-box{
    width:480px;
    background:#fff;
    border-radius:16px;
    padding:28px;
    box-shadow:0 20px 50px rgba(0,0,0,0.08);
    border:1px solid #eee;
}

/* HEADER */
.header{
    text-align:center;
    margin-bottom:15px;
}

.header h3{
    font-weight:700;
}

.header p{
    font-size:13px;
    color:#777;
}

/* PREVIEW */
.preview{
    text-align:center;
    padding:18px;
    border-radius:12px;
    background:#f8f9fb;
    margin-bottom:15px;
}

.preview i{
    font-size:42px;
    color: <?= htmlspecialchars($category['color']) ?>;
}

.preview span{
    font-size:12px;
    color:#777;
}

/* INPUTS */
.form-control{
    border-radius:10px;
    padding:10px;
    margin-bottom:10px;
    border:1px solid #ddd;
}

.form-control:focus{
    border-color:#6366f1;
    box-shadow:none;
}

/* COLOR */
input[type="color"]{
    height:45px;
}

/* ICON GRID */
.icon-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:10px;
    margin:12px 0 15px;
}

.icon-item{
    font-size:20px;
    padding:12px;
    border-radius:10px;
    background:#f3f4f6;
    text-align:center;
    cursor:pointer;
    border:2px solid transparent;
    transition:0.2s;
}

.icon-item:hover{
    border-color:#6366f1;
    transform:scale(1.05);
}

.icon-item.active{
    border-color:#6366f1;
    background:#eef2ff;
    color:#4f46e5;
}

/* BUTTON */
.btn-update{
    width:100%;
    padding:11px;
    border:none;
    border-radius:10px;
    background:#111;
    color:#fff;
    font-weight:600;
    transition:0.2s;
}

.btn-update:hover{
    background:#333;
}

/* BACK */
.back{
    display:block;
    text-align:center;
    margin-top:12px;
    font-size:13px;
    color:#666;
    text-decoration:none;
}

.back:hover{
    color:#000;
}

/* ERROR */
.error{
    background:#fee2e2;
    color:#b91c1c;
    padding:10px;
    border-radius:8px;
    font-size:13px;
    text-align:center;
    margin-bottom:10px;
}
</style>
</head>

<body>

<div class="page">

<div class="card-box">

    <div class="header">
        <h3>Edit Category</h3>
        <p>Update category information</p>
    </div>

    <!-- PREVIEW -->
    <div class="preview">
        <i class="<?= htmlspecialchars($category['icon']) ?>"></i>
        <span>Live preview</span>
    </div>

    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="POST">

        <!-- NAME -->
        <input type="text"
               name="nom"
               class="form-control"
               value="<?= htmlspecialchars($category['nom']) ?>"
               placeholder="Category name">

        <!-- COLOR -->
        <input type="color"
               name="color"
               class="form-control"
               value="<?= htmlspecialchars($category['color']) ?>">

        <!-- ICON SELECT -->
        <input type="hidden" name="icon" id="iconInput"
               value="<?= htmlspecialchars($category['icon']) ?>">

        <p style="font-size:13px;color:#777;margin-top:10px;">Choose icon</p>

        <div class="icon-grid">

            <i class="fa-solid fa-shirt icon-item <?= $category['icon']=='fa-solid fa-shirt'?'active':'' ?>" data-icon="fa-solid fa-shirt"></i>

            <i class="fa-solid fa-user icon-item <?= $category['icon']=='fa-solid fa-user'?'active':'' ?>" data-icon="fa-solid fa-user"></i>

            <i class="fa-solid fa-shoe-prints icon-item <?= $category['icon']=='fa-solid fa-shoe-prints'?'active':'' ?>" data-icon="fa-solid fa-shoe-prints"></i>

            <i class="fa-solid fa-hat-cowboy icon-item <?= $category['icon']=='fa-solid fa-hat-cowboy'?'active':'' ?>" data-icon="fa-solid fa-hat-cowboy"></i>

            <i class="fa-solid fa-bag-shopping icon-item <?= $category['icon']=='fa-solid fa-bag-shopping'?'active':'' ?>" data-icon="fa-solid fa-bag-shopping"></i>

            <i class="fa-solid fa-glasses icon-item <?= $category['icon']=='fa-solid fa-glasses'?'active':'' ?>" data-icon="fa-solid fa-glasses"></i>

            <i class="fa-solid fa-gem icon-item <?= $category['icon']=='fa-solid fa-gem'?'active':'' ?>" data-icon="fa-solid fa-gem"></i>

            <i class="fa-solid fa-socks icon-item <?= $category['icon']=='fa-solid fa-socks'?'active':'' ?>" data-icon="fa-solid fa-socks"></i>

        </div>

        <button class="btn-update" type="submit">
            Update Category
        </button>

    </form>

    <a href="index.php" class="back">← Back to categories</a>

</div>

</div>

<!-- JS -->
<script>
const icons = document.querySelectorAll(".icon-item");
const input = document.getElementById("iconInput");
const preview = document.querySelector(".preview i");

icons.forEach(icon => {
    icon.addEventListener("click", () => {

        icons.forEach(i => i.classList.remove("active"));

        icon.classList.add("active");

        const value = icon.getAttribute("data-icon");
        input.value = value;

        preview.className = value;
    });
});
</script>

</body>
</html>