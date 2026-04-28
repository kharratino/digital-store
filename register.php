<?php
session_start();
require_once __DIR__ . '/bd_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db->prepare("INSERT INTO users (name, email, password, role)
                          VALUES (?, ?, ?, 'client')");
    $stmt->execute([$name, $email, $password]);

    header("Location: index.php");
    exit;
}
?>

<link rel="stylesheet" href="assets/style.css">

<div class="login-page">
    <form method="POST" class="login-card">
        <h1>Créer compte</h1>
        <p>Nouveau client</p>

        <input type="text" name="name" placeholder="Nom complet" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>

        <button type="submit">Créer le compte</button>

        <br><br>
        <a href="index.php">Déjà un compte ? Connexion</a>
    </form>
</div>