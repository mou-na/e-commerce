<?php
include("config/db.php");
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card shadow p-4">

                <h3 class="text-center mb-3">📝 Sign Up</h3>

                <form method="POST">

                    <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

                    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

                    <button type="submit" class="btn btn-success w-100">Create Account</button>

                </form>

                <?php
                if ($_POST) {

                    $email = $_POST['email'];
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                    $conn->query("INSERT INTO users(email,password) VALUES('$email','$password')");

                    echo "<div class='alert alert-success mt-3'>✔ Account created successfully</div>";
                }
                ?>

                <hr>

                <p class="text-center">Already have an account?</p>

                <a href="login.php" class="btn btn-primary w-100">
                    🔐 Login
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>