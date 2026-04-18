<?php
include("config/db.php");
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow p-4">

<h3 class="text-center mb-3">📝 Create Account</h3>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="firstname" class="form-control mb-2" placeholder="First Name" required>

    <input type="text" name="lastname" class="form-control mb-2" placeholder="Last Name" required>

    <input type="text" name="phone" class="form-control mb-2" placeholder="Phone" required>

    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

    <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

    <input type="file" name="photo" class="form-control mb-3" required>

    <button type="submit" class="btn btn-success w-100">Register</button>

</form>

<?php
if ($_POST) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // upload image
    $photo = $_FILES['photo']['name'];
    $tmp = $_FILES['photo']['tmp_name'];

    move_uploaded_file($tmp, "uploads/".$photo);

    // insert DB
    $conn->query("INSERT INTO users(firstname,lastname,phone,email,password,photo)
    VALUES('$firstname','$lastname','$phone','$email','$password','$photo')");

    echo "<div class='alert alert-success mt-3'>✔ Account created successfully</div>";
}
?>

<hr>

<a href="login.php" class="btn btn-primary w-100">🔐 Go to Login</a>

</div>

</div>

</div>

</div>

</body>
</html>