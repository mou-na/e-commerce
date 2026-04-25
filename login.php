<?php
session_start();
include("config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/logreg.css">
    <link rel="stylesheet" href="css/indexnavbar.css">
</head>

<body>

    <?php
    $navbarMode = 'auth';
    include("includes/index-navbar.php");
    ?>
    <div class="container">

        <div class="card login">

            <div class="title">Connexion</div>
            <div class="subtitle">Bienvenue</div>

            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

            <form method="POST">
                <input class="input" type="text" name="username" placeholder="Nom d'utilisateur" required>
                <input class="input" type="password" name="password" placeholder="Mot de passe" required>
                <button class="btn">Se connecter</button>
            </form>

            <div class="footer">
                Pas de compte ? <a href="register.php">S'inscrire</a>
            </div>

        </div>

    </div>

</body>

</html>