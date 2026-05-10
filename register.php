<?php
include("config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users(firstname,lastname,username,phone,password)
    VALUES(?,?,?,?,?)");

    $stmt->bind_param("sssss", $firstname, $lastname, $username, $phone, $password);
    $stmt->execute();

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/logreg.css">
    <link rel="stylesheet" href="css/indexnavbar.css">
</head>

<body>

    <?php include("includes/index-navbar.php"); ?>

    <div class="container">

        <div class="card register">

            <div class="title">Créer un compte</div>
            <div class="subtitle">Rejoignez-nous</div>

            <form method="POST">

                <input class="input" type="text" name="firstname" placeholder="Prénom" required>
                <input class="input" type="text" name="lastname" placeholder="Nom" required>
                <input class="input" type="text" name="username" placeholder="Nom d'utilisateur" required>
                <input class="input" type="text" name="phone" placeholder="Téléphone" required>
                <input class="input" type="password" name="password" placeholder="Mot de passe" required>

                <button class="btn">Créer le compte</button>

            </form>

            <div class="footer">
                Déjà un compte ? <a href="login.php">Connexion</a>
            </div>

        </div>

    </div>

</body>

</html>