<?php
session_start();
require_once __DIR__ . '/../bd_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['add'])) {
    $id = $_GET['add'];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }

    header("Location: cart.php");
    exit;
}

if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit;
}

if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit;
}

if (isset($_GET['checkout']) && !empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total = 0;

    foreach ($products as $product) {
        $quantity = $_SESSION['cart'][$product['id']];
        $total += $product['price'] * $quantity;
    }

    $stmt = $db->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user']['id'], $total]);

    $order_id = $db->lastInsertId();

    foreach ($products as $product) {
        $quantity = $_SESSION['cart'][$product['id']];

        $stmt = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price)
                              VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $product['id'], $quantity, $product['price']]);
    }

    $_SESSION['cart'] = [];

    header("Location: orders.php");
    exit;
}

$products = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
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
    <h1>Panier</h1>

    <?php if (empty($products)): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Sous-total</th>
                <th>Action</th>
            </tr>

            <?php foreach ($products as $product): ?>
                <?php
                    $quantity = $_SESSION['cart'][$product['id']];
                    $subtotal = $product['price'] * $quantity;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= $product['price'] ?> DT</td>
                    <td><?= $quantity ?></td>
                    <td><?= $subtotal ?> DT</td>
                    <td>
                        <a href="cart.php?remove=<?= $product['id'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Total : <?= $total ?> DT</h2>

        <a class="btn" href="cart.php?checkout=1">Valider commande</a>
        <a class="btn-danger" href="cart.php?clear=1">Vider panier</a>
    <?php endif; ?>
</div>