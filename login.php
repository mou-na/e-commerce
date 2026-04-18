<?php
include("config/db.php");
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<!-- 🔝 NAVBAR BOOTSTRAP -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">🛒 Fashion Shop</a>

    <div class="ms-auto">
        <a class="btn btn-outline-light btn-sm me-2" href="index.php">Accueil</a>
   
    </div>
</nav>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card shadow p-4">

                <h3 class="text-center mb-3">🔐 Login</h3>

                <form method="POST">

                    <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>

                    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

                    <button type="submit" class="btn btn-primary w-100">Login</button>

                </form>

                <?php
                if ($_POST) {

                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
                    $user = $result->fetch_assoc();

                    if ($user && password_verify($password, $user['password'])) {

                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['email'] = $user['email'];

                        header("Location: index.php");
                        exit;

                    } else {
                        echo "<div class='alert alert-danger mt-3'>❌ Email ou mot de passe incorrect</div>";
                    }
                }
                ?>

                <!-- 🔽 SIGN UP BUTTON -->
                <hr>

                <p class="text-center">
                    Vous n'avez pas de compte ?
                </p>

                <a href="register.php" class="btn btn-success w-100">
                    📝 Sign Up
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>