<?php
session_start();
require_once __DIR__ . '/bd_connect.php';

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header("Location: dashboard.php");
    } else {
        header("Location: views/products.php");
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user'] = $user;

        if ($user['role'] === 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: views/products.php");
        }

        exit;
    } else {
        $error = "Email ou mot de passe incorrect";
    }
}
?>

<link rel="stylesheet" href="assets/style.css">

<div class="login-page">
    <form method="POST" class="login-card">
        <h1>Digital Store</h1>
        <p>Connexion</p>

        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>

        <button type="submit">Se connecter</button>
        <br><br>
        <a href="register.php">Créer un compte client</a>
    </form>
</div>