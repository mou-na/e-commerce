<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Accès refusé");
}

include("config/db.php");

/* GET ID */
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);

/* GET CATEGORY */
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();

if (!$category) {
    echo "Catégorie introuvable";
    exit;
}

/* UPDATE */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST['nom']);
    $icon = trim($_POST['icon']);
    $color = trim($_POST['color']);

    if ($nom && $icon && $color) {

        $update = $conn->prepare("UPDATE categories SET nom=?, icon=?, color=? WHERE id=?");
        $update->bind_param("sssi", $nom, $icon, $color, $id);
        $update->execute();

        header("Location: admin/getcategorie.php");
        exit;
    } else {
        $error = "Veuillez remplir tous les champs";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Modifier la catégorie</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/indexnavbar.css">
    <link rel="stylesheet" href="css/edit.css">

    <style>
        .preview {
            text-align: center;
            padding: 18px;
            border-radius: 12px;
            background: #f8f9fb;
            margin-bottom: 15px;
        }

        .preview i {
            font-size: 42px;
            color: <?= htmlspecialchars($category['color']) ?>;
        }
    </style>
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
                <h3>Modifier la catégorie</h3>
                <p>Mettre à jour les informations de la catégorie</p>
            </div>

            <div class="preview">
                <i class="<?= htmlspecialchars($category['icon']) ?>"></i>
                <span>Aperçu en direct</span>
            </div>

            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

            <form method="POST">

                <input type="text"
                    name="nom"
                    class="form-control"
                    value="<?= htmlspecialchars($category['nom']) ?>"
                    placeholder="Nom de la catégorie">

                <input type="color"
                    name="color"
                    class="form-control"
                    value="<?= htmlspecialchars($category['color']) ?>">

                <input type="hidden" name="icon" id="iconInput"
                    value="<?= htmlspecialchars($category['icon']) ?>">

                <p style="font-size:13px;color:#777;margin-top:10px;">Choisir une icône</p>

                <div class="icon-grid">

                    <i class="fa-solid fa-shirt icon-item <?= $category['icon'] == 'fa-solid fa-shirt' ? 'active' : '' ?>" data-icon="fa-solid fa-shirt"></i>
                    <i class="fa-solid fa-user icon-item <?= $category['icon'] == 'fa-solid fa-user' ? 'active' : '' ?>" data-icon="fa-solid fa-user"></i>
                    <i class="fa-solid fa-shoe-prints icon-item <?= $category['icon'] == 'fa-solid fa-shoe-prints' ? 'active' : '' ?>" data-icon="fa-solid fa-shoe-prints"></i>
                    <i class="fa-solid fa-hat-cowboy icon-item <?= $category['icon'] == 'fa-solid fa-hat-cowboy' ? 'active' : '' ?>" data-icon="fa-solid fa-hat-cowboy"></i>
                    <i class="fa-solid fa-bag-shopping icon-item <?= $category['icon'] == 'fa-solid fa-bag-shopping' ? 'active' : '' ?>" data-icon="fa-solid fa-bag-shopping"></i>
                    <i class="fa-solid fa-glasses icon-item <?= $category['icon'] == 'fa-solid fa-glasses' ? 'active' : '' ?>" data-icon="fa-solid fa-glasses"></i>
                    <i class="fa-solid fa-gem icon-item <?= $category['icon'] == 'fa-solid fa-gem' ? 'active' : '' ?>" data-icon="fa-solid fa-gem"></i>
                    <i class="fa-solid fa-socks icon-item <?= $category['icon'] == 'fa-solid fa-socks' ? 'active' : '' ?>" data-icon="fa-solid fa-socks"></i>

                </div>

                <button class="btn-update" type="submit">
                    Mettre à jour
                </button>

            </form>

        </div>

    </div>

    <script>
        const icons = document.querySelectorAll(".icon-item");
        const input = document.getElementById("iconInput");
        const preview = document.querySelector(".preview i");

        icons.forEach(icon => {
            icon.addEventListener("click", () => {

                icons.forEach(i => i.classList.remove("active"));

                icon.classList.add("active");

                const value = icon.getAttribute("data-icon");
                input.value = value;

                preview.className = value;
            });
        });
    </script>

</body>

</html>