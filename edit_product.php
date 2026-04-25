<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Accès refusé");
}

include("config/db.php");

/* GET ID */
if (!isset($_GET['id'])) {
    header("Location: admin/list_products.php");
    exit();
}

$id = intval($_GET['id']);

/* GET PRODUCT */
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die("Produit introuvable");
}

/* GET CATEGORIES */
$cats = $conn->query("SELECT id, nom FROM categories ORDER BY nom ASC");

/* UPDATE */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    $image_path = $product['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

        $upload_dir = "uploads/";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $image_name = time() . "_" . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    if ($name && $price && $category_id) {

        $update = $conn->prepare("
            UPDATE products 
            SET name=?, price=?, image=?, description=?, category_id=? 
            WHERE id=?
        ");

        $update->bind_param(
            "sdssii",
            $name,
            $price,
            $image_path,
            $description,
            $category_id,
            $id
        );

        $update->execute();

        header("Location: admin/list_products.php");
        exit();
    } else {
        $error = "Veuillez remplir les champs obligatoires";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier Produit</title>

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
            border: 1px solid #eee;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .preview span {
            font-size: 12px;
            color: #777;
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
                <h3>Modifier Produit</h3>
                <p>Mettre à jour les informations du produit</p>
            </div>

            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

            <form method="POST" enctype="multipart/form-data">

                <input type="text" name="name"
                    class="form-control"
                    value="<?= htmlspecialchars($product['name']) ?>">

                <input type="number" step="0.01" name="price"
                    class="form-control"
                    value="<?= $product['price'] ?>">

                <!-- IMAGE -->
                <div class="preview">
                    <img id="previewImage" src="<?= $product['image'] ?>">
                </div>

                <input type="file" name="image" class="form-control" onchange="previewFile(event)">

                <textarea name="description" class="form-control"><?= htmlspecialchars($product['description']) ?></textarea>

                <select name="category_id" class="form-control">
                    <?php while ($cat = $cats->fetch_assoc()): ?>
                        <option value="<?= $cat['id'] ?>"
                            <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nom']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <button class="btn-submit">Mettre à jour</button>

            </form>

        </div>

    </div>

    <script>
        function previewFile(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById("previewImage").src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>

</html>