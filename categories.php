<?php
session_start();
require_once __DIR__ . '/../bd_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

$editCategory = null;

if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: categories.php");
    exit;
}

if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editCategory = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    if (!empty($_POST['id'])) {
        $stmt = $db->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->execute([$name, $_POST['id']]);
    } else {
        $stmt = $db->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$name]);
    }

    header("Location: categories.php");
    exit;
}

$categories = $db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../assets/style.css">

<div class="menu">
    <a href="../dashboard.php">Accueil</a>
    <a href="products.php">Produits</a>
    <a href="categories.php">Catégories</a>
    <a href="cart.php">Panier</a>
    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
    <a href="orders.php">Commandes</a>
<?php endif; ?>
</div>

<div class="container">
    <h1>Gestion des catégories</h1>

    <form method="POST" class="form-card">
        <input type="hidden" name="id" value="<?= $editCategory['id'] ?? '' ?>">
        <input type="text" name="name" placeholder="Nom catégorie"
               value="<?= htmlspecialchars($editCategory['name'] ?? '') ?>" required>

        <button type="submit">
            <?= $editCategory ? 'Modifier' : 'Ajouter' ?>
        </button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['id'] ?></td>
                <td><?= htmlspecialchars($category['name']) ?></td>
                <td>
                    <a href="categories.php?edit=<?= $category['id'] ?>">Modifier</a>
                    |
                    <a href="categories.php?delete=<?= $category['id'] ?>"
                       onclick="return confirm('Supprimer cette catégorie ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>