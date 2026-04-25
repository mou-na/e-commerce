<?php
session_start();


if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    die("Access denied");
}
include("config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST['nom'];
    $icon = $_POST['icon'];
    $color = $_POST['color'];

    if (!empty($nom) && !empty($icon) && !empty($color)) {

        $stmt = $conn->prepare("INSERT INTO categories (nom, icon, color) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nom, $icon, $color);
        $stmt->execute();

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
<title>Add Category</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    font-family:'Segoe UI';
    background:#0f0f10;
    color:#fff;
}

.container{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    width:420px;
    background:#18181b;
    padding:30px;
    border-radius:14px;
    border:1px solid #262626;
    box-shadow:0 10px 40px rgba(0,0,0,0.5);
}

h3{
    margin-bottom:15px;
}

/* INPUT */
input[type="text"]{
    width:100%;
    padding:10px;
    border-radius:8px;
    border:none;
    background:#111;
    color:#fff;
    margin-bottom:12px;
}

/* COLOR PICKER */
.color-grid{
    display:flex;
    gap:10px;
    margin-bottom:15px;
}

.color-item{
    width:30px;
    height:30px;
    border-radius:50%;
    cursor:pointer;
    border:2px solid transparent;
    transition:0.2s;
}

.color-item:hover{
    transform:scale(1.1);
}

.color-item.active{
    border:2px solid #fff;
}

/* ICON GRID */
.icon-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:10px;
    margin:10px 0 15px;
}

.icon-item{
    font-size:22px;
    padding:12px;
    border-radius:10px;
    background:#111;
    text-align:center;
    cursor:pointer;
    border:1px solid transparent;
    transition:0.2s;
}

.icon-item:hover{
    border-color:#4f46e5;
    transform:scale(1.08);
}

.icon-item.active{
    border-color:#4f46e5;
    background:#1f1f3a;
}

/* PREVIEW */
.preview{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:15px;
    padding:10px;
    background:#111;
    border-radius:8px;
}

.preview i{
    font-size:20px;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    background:#4f46e5;
    border:none;
    color:#fff;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
    transition:0.2s;
}

button:hover{
    background:#4338ca;
}

.error{
    color:#f87171;
    font-size:13px;
    margin-bottom:10px;
}
</style>
</head>

<body>

<div class="container">

<div class="card">

<h3>➕ Add Category</h3>

<?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

<form method="POST">

<!-- NAME -->
<input type="text" name="nom" placeholder="Category name" required>

<!-- HIDDEN FIELDS -->
<input type="hidden" name="icon" id="iconInput">
<input type="hidden" name="color" id="colorInput">

<!-- PREVIEW -->
<div class="preview">
    <i id="previewIcon" class="fa-solid fa-circle"></i>
    <span id="previewText">Preview</span>
</div>

<!-- COLORS -->
<p style="font-size:13px;color:#aaa;">Choose color:</p>

<div class="color-grid">

    <div class="color-item active" style="background:#4f46e5" data-color="#4f46e5"></div>
    <div class="color-item" style="background:#ef4444" data-color="#ef4444"></div>
    <div class="color-item" style="background:#22c55e" data-color="#22c55e"></div>
    <div class="color-item" style="background:#f59e0b" data-color="#f59e0b"></div>
    <div class="color-item" style="background:#06b6d4" data-color="#06b6d4"></div>

</div>

<!-- ICONS -->
<p style="font-size:13px;color:#aaa;">Choose icon:</p>

<div class="icon-grid">

    <i class="fa-solid fa-shirt icon-item" data-icon="fa-solid fa-shirt"></i>
    <i class="fa-solid fa-user icon-item" data-icon="fa-solid fa-user"></i>
    <i class="fa-solid fa-shoe-prints icon-item" data-icon="fa-solid fa-shoe-prints"></i>
    <i class="fa-solid fa-hat-cowboy icon-item" data-icon="fa-solid fa-hat-cowboy"></i>

    <i class="fa-solid fa-bag-shopping icon-item" data-icon="fa-solid fa-bag-shopping"></i>
    <i class="fa-solid fa-glasses icon-item" data-icon="fa-solid fa-glasses"></i>
    <i class="fa-solid fa-gem icon-item" data-icon="fa-solid fa-gem"></i>
    <i class="fa-solid fa-socks icon-item" data-icon="fa-solid fa-socks"></i>

</div>

<button>Add Category</button>

</form>

</div>

</div>

<script>
const icons = document.querySelectorAll(".icon-item");
const colors = document.querySelectorAll(".color-item");

const iconInput = document.getElementById("iconInput");
const colorInput = document.getElementById("colorInput");

const previewIcon = document.getElementById("previewIcon");

/* DEFAULT COLOR */
colorInput.value = "#4f46e5";

/* ICON SELECT */
icons.forEach(icon => {
    icon.addEventListener("click", () => {

        icons.forEach(i => i.classList.remove("active"));
        icon.classList.add("active");

        let selected = icon.getAttribute("data-icon");
        iconInput.value = selected;

        previewIcon.className = selected;
    });
});

/* COLOR SELECT */
colors.forEach(color => {
    color.addEventListener("click", () => {

        colors.forEach(c => c.classList.remove("active"));
        color.classList.add("active");

        let selected = color.getAttribute("data-color");
        colorInput.value = selected;

        previewIcon.style.color = selected;
    });
});
</script>

</body>
</html>