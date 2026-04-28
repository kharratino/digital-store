<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
?>

<link rel="stylesheet" href="assets/style.css">

<div class="topbar">
    <div class="logo">DIGITAL<span>STORE</span></div>

    <form class="search-box" action="views/products.php" method="GET">
        <input type="text" name="search" placeholder="Rechercher un produit...">
        <button type="submit">🔍</button>
    </form>

    <div class="user-box">
        <?= $_SESSION['user']['name'] ?><br>
        <a href="logout.php">Déconnexion</a>
    </div>
</div>

<div class="menu">
    <a href="dashboard.php">Accueil</a>
    <a href="views/products.php">Produits</a>
    <a href="views/categories.php">Catégories</a>
    <a href="views/cart.php">Panier</a>
    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
    <a href="views/orders.php">Commandes</a>
<?php endif; ?>
</div>

<div class="hero">
    <h1>Bienvenue sur Digital Store</h1>
    <p>Gérez vos produits, catégories, paniers et commandes.</p>
    <a href="views/products.php" class="btn">Voir les produits</a>
</div>