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

    move_uploaded_file($tmp, "uploads/" . $photo);

    $stmt = $conn->prepare("INSERT INTO users(firstname,lastname,username,phone,password,photo)
    VALUES(?,?,?,?,?,?)");

    $stmt->bind_param("ssssss", $firstname, $lastname, $username, $phone, $password, $photo);
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

    <?php
    $navbarMode = 'auth';
    include("includes/index-navbar.php");
    ?>

    <div class="container">

        <div class="card register">

            <div class="title">Créer un compte</div>
            <div class="subtitle">Rejoignez-nous</div>

            <form method="POST" enctype="multipart/form-data">

                <input class="input" type="text" name="firstname" placeholder="Prénom" required>
                <input class="input" type="text" name="lastname" placeholder="Nom" required>
                <input class="input" type="text" name="username" placeholder="Nom d'utilisateur" required>
                <input class="input" type="text" name="phone" placeholder="Téléphone" required>
                <input class="input" type="password" name="password" placeholder="Mot de passe" required>

                <input class="input" type="file" name="photo" required>

                <button class="btn">Créer le compte</button>

            </form>

            <div class="footer">
                Déjà un compte ? <a href="login.php">Connexion</a>
            </div>

        </div>

    </div>

</body>

</html>