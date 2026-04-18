<?php
include("config/db.php");
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<!-- 🔝 NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="index.php">🛒 Fashion Shop</a>
</nav>

<!-- 🧾 FORM -->
<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card shadow-lg border-0 rounded-4">

<div class="card-body p-4">

<h3 class="text-center mb-4">📝 Create Account</h3>

<form method="POST" enctype="multipart/form-data">

<!-- FIRST + LAST NAME -->
<div class="row">
    <div class="col-md-6 mb-3">
        <label>First Name</label>
        <input type="text" name="firstname" class="form-control" placeholder="John" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Last Name</label>
        <input type="text" name="lastname" class="form-control" placeholder="Doe" required>
    </div>
</div>

<!-- PHONE -->
<div class="mb-3">
    <label>Phone</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
        <input type="text" name="phone" class="form-control" placeholder="+216 99 999 999" required>
    </div>
</div>

<!-- EMAIL -->
<div class="mb-3">
    <label>Email</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
        <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
    </div>
</div>

<!-- PASSWORD -->
<div class="mb-3">
    <label>Password</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-lock"></i></span>
        <input type="password" name="password" class="form-control" placeholder="******" required>
    </div>
</div>

<!-- PHOTO -->
<div class="mb-3">
    <label>Profile Photo</label>
    <input type="file" name="photo" class="form-control" required>
</div>

<!-- BUTTON -->
<button type="submit" class="btn btn-success w-100 py-2">
    <i class="bi bi-person-plus"></i> Create Account
</button>

</form>

<?php
if ($_POST) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $photo = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    move_uploaded_file($tmp, "uploads/".$photo);

    $conn->query("INSERT INTO users(firstname,lastname,phone,email,password,photo)
    VALUES('$firstname','$lastname','$phone','$email','$password','$photo')");

    echo "<div class='alert alert-success mt-3'>✔ Account created successfully</div>";
}
?>

<hr>

<p class="text-center">Already have an account?</p>

<a href="login.php" class="btn btn-primary w-100">
    🔐 Go to Login
</a>

</div>

</div>

</div>

</div>

</div>

</body>
</html>