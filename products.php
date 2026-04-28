<?php
session_start();
require_once __DIR__ . '/../bd_connect.php';
require_once __DIR__ . '/../Uploader.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

$editProduct = null;

if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: products.php");
    exit;
}

if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editProduct = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    if (!empty($_POST['id'])) {
        $image = $_POST['old_image'];

        if (!empty($_FILES['image']['name'])) {
            $image = Uploader::uploadImage($_FILES['image']);
        }

        $stmt = $db->prepare("UPDATE products 
                              SET name = ?, price = ?, image = ?, category_id = ?
                              WHERE id = ?");
        $stmt->execute([$name, $price, $image, $category_id, $_POST['id']]);
    } else {
        $image = Uploader::uploadImage($_FILES['image']);

        $stmt = $db->prepare("INSERT INTO products (name, price, image, category_id)
                              VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $price, $image, $category_id]);
    }

    header("Location: products.php");
    exit;
}

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

$sql = "SELECT products.*, categories.name AS category_name
        FROM products
        LEFT JOIN categories ON products.category_id = categories.id
        WHERE products.name LIKE ?";

$params = ['%' . $search . '%'];

if (!empty($category)) {
    $sql .= " AND products.category_id = ?";
    $params[] = $category;
}

$stmt = $db->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = $db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../assets/style.css">

<div class="topbar">
    <div class="logo">DIGITAL<span>STORE</span></div>

    <form class="search-box" method="GET">
        <input type="text" name="search" placeholder="Rechercher..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">🔍</button>
    </form>

    <div class="user-box">
        <?= $_SESSION['user']['name'] ?><br>
        <a href="../logout.php">Déconnexion</a>
    </div>
</div>

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
    <h1>Gestion des produits</h1>
    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
    <form method="POST" enctype="multipart/form-data" class="form-card">
        <input type="hidden" name="id" value="<?= $editProduct['id'] ?? '' ?>">
        <input type="hidden" name="old_image" value="<?= $editProduct['image'] ?? '' ?>">

        <input type="text" name="name" placeholder="Nom produit"
               value="<?= htmlspecialchars($editProduct['name'] ?? '') ?>" required>

        <input type="number" step="0.01" name="price" placeholder="Prix"
               value="<?= htmlspecialchars($editProduct['price'] ?? '') ?>" required>

        <select name="category_id" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"
                    <?= isset($editProduct['category_id']) && $editProduct['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="file" name="image">

        <button type="submit">
            <?= $editProduct ? 'Modifier' : 'Ajouter' ?>
        </button>
    </form>
    <?php endif; ?>

    <div class="shop-layout">
        <aside class="filters">
            <h3>Filtrer</h3>

            <form method="GET">
                <input type="text" name="search" placeholder="Nom produit" value="<?= htmlspecialchars($search) ?>">

                <select name="category">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $category == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Appliquer</button>
            </form>
        </aside>

        <main class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <?php if (!empty($product['image'])): ?>
                            <img src="../uploads/<?= htmlspecialchars($product['image']) ?>">
                        <?php else: ?>
                            <div class="no-img">Image</div>
                        <?php endif; ?>
                    </div>

                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="category"><?= htmlspecialchars($product['category_name']) ?></p>
                    <p class="price"><?= $product['price'] ?> DT</p>

                    <div class="actions">
    <a class="cart-btn" href="cart.php?add=<?= $product['id'] ?>">Ajouter au panier</a>

    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
        <a href="products.php?edit=<?= $product['id'] ?>">Modifier</a>
        <a href="products.php?delete=<?= $product['id'] ?>"
           onclick="return confirm('Supprimer ce produit ?')">Supprimer</a>
    <?php endif; ?>
</div>
                </div>
            <?php endforeach; ?>
        </main>
    </div>
</div>