<?php
include("config/db.php");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
}

$cats = $conn->query("SELECT id, nom FROM categories ORDER BY nom ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $description = trim($_POST['description']);
    $category_id = $_POST['category_id'];

    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    $upload_dir = "uploads/";
    $image_path = $upload_dir . time() . "_" . $image_name;

    move_uploaded_file($image_tmp, $image_path);

    if ($name && $price && $image_path && $category_id) {

        $stmt = $conn->prepare("
            INSERT INTO products (name, price, image, description, category_id, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param("sdssi", $name, $price, $image_path, $description, $category_id);
        $stmt->execute();

        header("Location: admin/list_products.php");
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
    <title>Ajouter un Produit</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/indexnavbar.css">
    <link rel="stylesheet" href="css/add.css">

    <style>
        .preview img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }
    </style>

</head>

<body>

    <?php
    $showBack = true;
    $backLink = "admin/list_products.php";
    include("includes/navbar.php");
    ?>

    <div class="page">

        <div class="card-box">

            <div class="header">
                <h3>Ajouter un Produit</h3>
                <p>Créer un nouveau produit</p>
            </div>

            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

            <form method="POST" enctype="multipart/form-data">

                <input type="text" name="name" class="form-control" placeholder="Nom du produit">

                <input type="number" step="0.01" name="price" class="form-control" placeholder="Prix">

                <select name="category_id" class="form-control">
                    <option value="">Choisir catégorie</option>

                    <?php while ($cat = $cats->fetch_assoc()): ?>
                        <option value="<?= $cat['id'] ?>">
                            <?= htmlspecialchars($cat['nom']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <div class="preview">
                    <img id="previewImage" src="" style="display:none;">
                    <span id="previewText">Aucune image sélectionnée</span>
                </div>

                <input type="file" name="image" id="imageInput" class="form-control">

                <textarea name="description" class="form-control" placeholder="Description"></textarea>

                <button class="btn-submit">Ajouter Produit</button>

            </form>

        </div>

    </div>

    <script>
        const imageInput = document.getElementById("imageInput");
        const previewImage = document.getElementById("previewImage");
        const previewText = document.getElementById("previewText");

        imageInput.addEventListener("change", function() {

            const file = this.files[0];

            if (file) {

                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = "block";
                    previewText.style.display = "none";
                };

                reader.readAsDataURL(file);
            }

        });
    </script>

</body>

</html>