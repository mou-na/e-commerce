<?php
include("config/db.php");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="index.php">🛒 Fashion Shop</a>
</nav>

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
        <input type="text" name="firstname" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Last Name</label>
        <input type="text" name="lastname" class="form-control" required>
    </div>
</div>

<!-- USERNAME -->
<div class="mb-3">
    <label>Username</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-person"></i></span>
        <input type="text" name="username" class="form-control" placeholder="john_doe" required>
    </div>
</div>

<!-- PHONE -->
<div class="mb-3">
    <label>Phone</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
        <input type="text" name="phone" class="form-control" required>
    </div>
</div>

<!-- PASSWORD -->
<div class="mb-3">
    <label>Password</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-lock"></i></span>
        <input type="password" name="password" class="form-control" required>
    </div>
</div>

<!-- PHOTO -->
<div class="mb-3">
    <label>Profile Photo</label>
    <input type="file" name="photo" class="form-control" required>
</div>

<button type="submit" class="btn btn-success w-100">
    <i class="bi bi-person-plus"></i> Create Account
</button>

</form>

<?php
include("config/db.php");
session_start();

if ($_POST) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $photo = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    move_uploaded_file($tmp, "uploads/".$photo);

    $conn->query("INSERT INTO users(firstname,lastname,username,phone,password,photo)
    VALUES('$firstname','$lastname','$username','$phone','$password','$photo')");

    // ✅ SUCCESS ALERT + REDIRECT
    echo "<script>
            alert('✔ Account created successfully');
            window.location.href = 'login.php';
          </script>";
}
?>

<hr>

<a href="login.php" class="btn btn-primary w-100">🔐 Go to Login</a>

</div>
</div>
</div>
</div>
</div>

</body>
</html>