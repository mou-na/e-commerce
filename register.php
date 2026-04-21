<?php
session_start();
include("config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $photo = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    move_uploaded_file($tmp, "uploads/".$photo);

    $stmt = $conn->prepare("INSERT INTO users(firstname,lastname,username,phone,password,photo)
    VALUES(?,?,?,?,?,?)");

    $stmt->bind_param("ssssss",$firstname,$lastname,$username,$phone,$password,$photo);
    $stmt->execute();

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Segoe UI',sans-serif;
    background:#0f0f10;
    color:#e5e5e5;
}

.navbar{
    height:60px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 40px;
    border-bottom:1px solid #1f1f22;
}
.logo{font-weight:600;}
.navbar a{color:#aaa;text-decoration:none;}
.navbar a:hover{color:#fff;}

.container{
    min-height:calc(100vh - 60px);
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    width:100%;
    max-width:450px;
    background:#18181b;
    padding:30px;
    border-radius:12px;
    border:1px solid #262626;
    box-shadow:0 10px 30px rgba(0,0,0,.4);
}

.title{font-size:22px;font-weight:600;}
.subtitle{font-size:13px;color:#888;margin-bottom:20px;}

.input{
    width:100%;
    padding:11px;
    margin-bottom:12px;
    border-radius:8px;
    border:1px solid #2a2a2e;
    background:#111;
    color:#fff;
}

.input:focus{
    outline:none;
    border-color:#4f46e5;
    box-shadow:0 0 0 2px rgba(79,70,229,.2);
}

.btn{
    width:100%;
    padding:11px;
    background:#4f46e5;
    border:none;
    border-radius:8px;
    color:#fff;
    cursor:pointer;
}

.btn:hover{background:#4338ca;}

.footer{
    margin-top:15px;
    text-align:center;
    font-size:13px;
    color:#888;
}
.footer a{color:#fff;text-decoration:none;}
</style>
</head>

<body>

<div class="navbar">
    <div class="logo">🛒 Fashion Shop</div>
    <a href="login.php">Login</a>
</div>

<div class="container">

<div class="card">

<div class="title">Create account</div>
<div class="subtitle">Join us today</div>

<form method="POST" enctype="multipart/form-data">

<input class="input" type="text" name="firstname" placeholder="First name" required>
<input class="input" type="text" name="lastname" placeholder="Last name" required>
<input class="input" type="text" name="username" placeholder="Username" required>
<input class="input" type="text" name="phone" placeholder="Phone" required>
<input class="input" type="password" name="password" placeholder="Password" required>

<input class="input" type="file" name="photo" required>

<button class="btn">Create account</button>

</form>

<div class="footer">
Already have an account? <a href="login.php">Login</a>
</div>

</div>

</div>

</body>
</html>