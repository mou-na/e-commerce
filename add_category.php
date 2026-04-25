<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Accès refusé");
}

include("config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = trim($_POST['nom']);
    $icon = trim($_POST['icon']);
    $color = trim($_POST['color']);

    if ($nom && $icon && $color) {

        $stmt = $conn->prepare("INSERT INTO categories (nom, icon, color) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nom, $icon, $color);
        $stmt->execute();

        header("Location: admin/getcategorie.php");
        exit;
    } else {
        $error = "Veuillez remplir tous les champs";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter une catégorie</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/indexnavbar.css">
    <link rel="stylesheet" href="css/add.css">
</head>

<body>

    <?php
    $showBack = true;
    $backLink = "admin/getcategorie.php";
    include("includes/navbar.php");
    ?>

    <div class="page">

        <div class="card-box">

            <div class="header">
                <h3>Ajouter une catégorie</h3>
                <p>Créer une nouvelle catégorie</p>
            </div>

            <!-- PREVIEW -->
            <div class="previewC">
                <i id="previewIcon" class="fa-solid fa-circle"></i>
            </div>

            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

            <form method="POST">

                <input type="text" name="nom" class="form-control" placeholder="Nom de la catégorie">

                <!-- COLOR (SAME AS EDIT) -->
                <input type="color" name="color" id="colorInput" class="form-control" value="#4f46e5">

                <!-- ICON -->
                <input type="hidden" name="icon" id="iconInput">

                <p style="font-size:13px;color:#777;margin-top:10px;">Choisir une icône</p>

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

                <button class="btn-submit">Ajouter</button>

            </form>

        </div>
    </div>

    <script>
        const icons = document.querySelectorAll(".icon-item");
        const iconInput = document.getElementById("iconInput");
        const preview = document.getElementById("previewIcon");
        const colorInput = document.getElementById("colorInput");

        /* ICON SELECT */
        icons.forEach(icon => {
            icon.addEventListener("click", () => {

                icons.forEach(i => i.classList.remove("active"));

                icon.classList.add("active");

                const value = icon.getAttribute("data-icon");
                iconInput.value = value;

                preview.className = value;
            });
        });

        /* COLOR CHANGE */
        colorInput.addEventListener("input", () => {
            preview.style.color = colorInput.value;
        });
    </script>

</body>

</html>