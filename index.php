<?php
session_start();

include("config/db.php");

$categorie_id = isset($_GET['categorie']) ? intval($_GET['categorie']) : 0;

$cats = $conn->query("SELECT * FROM categories ORDER BY nom ASC");

// 🔐 SAFE CHECK (important)
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

$cat_active = null;
if ($categorie_id > 0) {
    $c = $conn->prepare("SELECT nom FROM categories WHERE id = ?");
    $c->bind_param("i", $categorie_id);
    $c->execute();
    $cat_active = $c->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fashion Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            background: #111;
            height: 64px;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar-brand-custom {
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
        }
        .nav-right { display: flex; align-items: center; gap: 12px; }

        .nav-link-custom {
            color: #ccc;
            font-size: 14px;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all .2s;
        }
        .nav-link-custom:hover { color: #fff; background: rgba(255,255,255,0.1); }

        /* Dropdown catégories */
        .dropdown-wrap { position: relative; }
        .dropdown-btn {
            background: none;
            border: 1px solid rgba(255,255,255,0.25);
            color: #fff;
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all .2s;
        }
        .dropdown-btn:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.4); }
        .dropdown-btn .arrow { font-size: 10px; transition: transform .2s; }
        .dropdown-wrap:hover .arrow { transform: rotate(180deg); }

        .dropdown-menu-custom {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px;
            padding: 6px;
            min-width: 200px;
            display: none;
            z-index: 1000;
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
        }
        .dropdown-wrap:hover .dropdown-menu-custom { display: block; }

        .dropdown-item-custom {
            display: block;
            padding: 8px 12px;
            color: #ddd;
            font-size: 13px;
            text-decoration: none;
            border-radius: 6px;
            transition: all .15s;
        }
        .dropdown-item-custom:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .dropdown-item-custom.active-item { color: #fff; font-weight: 600; }
        .dropdown-divider-custom { height: 1px; background: rgba(255,255,255,0.1); margin: 4px 0; }

        /* Boutons login/signup */
        .btn-login {
            background: none;
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
            padding: 7px 16px;
            border-radius: 6px;
            font-size: 13px;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-login:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .btn-signup {
            background: #fff;
            border: none;
            color: #111;
            padding: 7px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-signup:hover { background: #e5e5e5; color: #111; }

        /* ===== HERO ===== */
        .hero {
            background: #111;
            padding: 80px 2rem;
            text-align: center;
            color: #fff;
        }
        .hero h1 { font-size: 42px; font-weight: 700; letter-spacing: -1px; line-height: 1.2; }
        .hero h1 span { color: #888; }
        .hero p { font-size: 16px; color: #888; margin-top: 12px; max-width: 480px; margin-left: auto; margin-right: auto; }
        .hero-btns { display: flex; gap: 10px; justify-content: center; margin-top: 28px; }
        .btn-hero-primary {
            background: #fff; color: #111; border: none;
            padding: 12px 28px; border-radius: 8px; font-size: 14px;
            font-weight: 600; cursor: pointer; text-decoration: none;
        }
        .btn-hero-secondary {
            background: none; color: #fff;
            border: 1px solid rgba(255,255,255,0.25);
            padding: 12px 28px; border-radius: 8px; font-size: 14px;
            cursor: pointer; text-decoration: none;
        }

        /* ===== CATÉGORIES GRID ===== */
        .cats-section { padding: 48px 2rem; max-width: 1100px; margin: auto; }
        .cats-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .cats-header h2 { font-size: 20px; font-weight: 600; }
        .cats-header a { font-size: 13px; color: #888; text-decoration: none; }
        .cats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; }

        .cat-card {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            padding: 28px 16px;
            text-align: center;
            text-decoration: none;
            color: #111;
            transition: all .2s;
        }
        .cat-card:hover { border-color: #bbb; transform: translateY(-2px); }
        .cat-card.active { background: #111; color: #fff; border-color: #111; }
        .cat-icon { font-size: 30px; margin-bottom: 10px; }
        .cat-name { font-size: 14px; font-weight: 600; }
        .cat-count { font-size: 12px; color: #999; margin-top: 4px; }
        .cat-card.active .cat-count { color: #aaa; }
        .add-category {
    color: #4f46e5;
    font-weight: 600;
}

.add-category:hover {
    background: rgba(79, 70, 229, 0.1);
    color: #6366f1;
}
.cat-card{
    background:#fff;
    border:1px solid #e5e5e5;
    border-radius:12px;
    padding:20px;
    text-align:center;
    transition:0.2s;
    position:relative;
}

.cat-card:hover{
    transform:translateY(-3px);
    border-color:#bbb;
}

.cat-icon{
    font-size:30px;
    margin-bottom:10px;
}

.cat-name{
    font-size:14px;
    font-weight:600;
}

.delete-btn{
    display:block;
    margin-top:10px;
    font-size:12px;
    color:#ef4444;
    text-decoration:none;
}

.delete-btn:hover{
    color:#dc2626;
}
.cat-card{
    position:relative;
}

.cat-link{
    text-decoration:none;
    color:inherit;
    display:block;
}

.cat-actions{
    position:absolute;
    top:8px;
    right:8px;
    display:flex;
    gap:6px;
}

.icon-btn{
    width:30px;
    height:30px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:6px;
    background:#fff;
    border:1px solid #eee;
    color:#333;
    font-size:13px;
    transition:0.2s;
}

.icon-btn:hover{
    transform:scale(1.1);
}

/* EDIT */
.icon-btn.edit:hover{
    background:#3b82f6;
    color:#fff;
    border-color:#3b82f6;
}

/* DELETE */
.icon-btn.delete:hover{
    background:#ef4444;
    color:#fff;
    border-color:#ef4444;
}

        /* ===== FOOTER ===== */
        footer { background: #111; color: #666; text-align: center; padding: 20px; font-size: 13px; margin-top: 60px; }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar-custom">
    <a class="navbar-brand-custom" href="index.php">✦ Fashion Shop</a>

    <div class="nav-right">
<div class="dropdown-wrap">
    <button class="dropdown-btn">
        Catégories <span class="arrow">▾</span>
    </button>

    <div class="dropdown-menu-custom">

        <!-- ALL -->
        <a class="dropdown-item-custom <?= $categorie_id === 0 ? 'active-item' : '' ?>" href="index.php">
            Toutes les catégories
        </a>

        <div class="dropdown-divider-custom"></div>

        <!-- CATEGORIES -->
        <?php
        $cats->data_seek(0);
        while ($cat = $cats->fetch_assoc()):
        ?>
            <a class="dropdown-item-custom <?= $categorie_id === (int)$cat['id'] ? 'active-item' : '' ?>"
               href="index.php?categorie=<?= (int)$cat['id'] ?>">
                <?= htmlspecialchars($cat['nom']) ?>
            </a>
        <?php endwhile; ?>

        <!-- ✅ ADD CATEGORY BUTTON (VISIBLE TO ALL) -->
        <div class="dropdown-divider-custom"></div>

     

    </div>
</div>
        <a href="#" class="nav-link-custom">Nouveautés</a>
       
      <?php if($isAdmin): ?>
  <?php if($isAdmin): ?>
    <a href="admin/dashboard.php" class="nav-link-custom">
        📊 Dashboard
    </a>
<?php endif; ?>
    <?php endif; ?>
            <!-- ✅ ADD THIS -->
  

        <?php if(isset($_SESSION['user_id'])): ?>
            <span style="color:#ccc;font-size:14px;">👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="logout.php" class="btn-login">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn-login">Login</a>
            <a href="register.php" class="btn-signup">Sign Up</a>
        <?php endif; ?>

    </div>
</nav>

<!-- ===== HERO ===== -->
<div class="hero">
    <h1>Style moderne,<br><span>prix honnête.</span></h1>
    <p>T-shirts, jeans, hoodies et accessoires — tout ce qu'il faut pour ta garde-robe.</p>
    <div class="hero-btns">
        <a href="#categories" class="btn-hero-primary">Découvrir la collection</a>
        <a href="#" class="btn-hero-secondary">Voir les soldes</a>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- ===== CATÉGORIES ===== -->
<div class="cats-section" id="categories">

    <div class="cats-header">
        <h2>Catégories</h2>
        <a href="index.php">Voir tout →</a>
    </div>

    <div class="cats-grid">

        <?php
        $cats->data_seek(0);
        while ($cat = $cats->fetch_assoc()):
        ?>

        <div class="cat-card <?= $categorie_id === (int)$cat['id'] ? 'active' : '' ?>">

            <!-- CATEGORY LINK -->
            <a href="category.php?id=<?= (int)$cat['id'] ?>" class="cat-link">

                <div class="cat-icon" style="color: <?= htmlspecialchars($cat['color']) ?>;">
                    <i class="<?= htmlspecialchars($cat['icon']) ?>"></i>
                </div>

                <div class="cat-name">
                    <?= htmlspecialchars($cat['nom']) ?>
                </div>

            </a>

        </div>

        <?php endwhile; ?>

    </div>
</div>
<!-- produits ici plus tard -->

<footer>
    © 2025 Fashion Shop — Tous droits réservés
</footer>

</body>
</html>