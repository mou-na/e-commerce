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

    if($user && password_verify($password, $user['password'])){

        session_start();

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // 🔥 REDIRECTION SELON ROLE
        if($user['role'] === 'admin'){
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;

    } else {
        echo "Login failed";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Segoe UI',sans-serif;
    background:#0f0f10;
    color:#e5e5e5;
}

/* NAVBAR */
.navbar{
    height:60px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 40px;
    border-bottom:1px solid #1f1f22;
}
.logo{font-weight:600;}
.navbar a{
    color:#aaa;
    text-decoration:none;
    font-size:14px;
}
.navbar a:hover{color:#fff;}

/* CENTER */
.container{
    min-height:calc(100vh - 60px);
    display:flex;
    justify-content:center;
    align-items:center;
}

/* CARD */
.card{
    width:100%;
    max-width:400px;
    background:#18181b;
    padding:30px;
    border-radius:12px;
    border:1px solid #262626;
    box-shadow:0 10px 30px rgba(0,0,0,.4);
}

.title{font-size:22px;font-weight:600;}
.subtitle{font-size:13px;color:#888;margin-bottom:20px;}

/* INPUT */
.input{
    width:100%;
    padding:11px;
    margin-bottom:12px;
    border-radius:8px;
    border:1px solid #2a2a2e;
    background:#111;
    color:#fff;
}
.input:focus{
    outline:none;
    border-color:#4f46e5;
    box-shadow:0 0 0 2px rgba(79,70,229,.2);
}

/* BUTTON */
.btn{
    width:100%;
    padding:11px;
    background:#4f46e5;
    border:none;
    border-radius:8px;
    color:#fff;
    cursor:pointer;
}
.btn:hover{background:#4338ca;}

/* FOOTER */
.footer{
    margin-top:15px;
    text-align:center;
    font-size:13px;
    color:#888;
}
.footer a{color:#fff;text-decoration:none;}

.error{
    background:#2a1414;
    color:#ff6b6b;
    padding:10px;
    border-radius:6px;
    margin-bottom:10px;
}
</style>
</head>

<body>

<div class="navbar">
    <div class="logo">🛒 Fashion Shop</div>
    <a href="register.php">Create account</a>
</div>

<div class="container">

    <div class="card">

        <div class="title">Sign in</div>
        <div class="subtitle">Welcome back</div>

        <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

        <form method="POST">
            <input class="input" type="text" name="username" placeholder="Username" required>
            <input class="input" type="password" name="password" placeholder="Password" required>
            <button class="btn">Login</button>
        </form>

        <div class="footer">
            No account? <a href="register.php">Sign up</a>
        </div>

    </div>

</div>

</body>
</html>