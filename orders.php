<?php
session_start();
require_once __DIR__ . '/../bd_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: products.php");
    exit;
}

$selectedOrder = null;
$items = [];

if (isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $selectedOrder = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $db->prepare("SELECT order_items.*, products.name AS product_name
                          FROM order_items
                          LEFT JOIN products ON order_items.product_id = products.id
                          WHERE order_items.order_id = ?");
    $stmt->execute([$_GET['id']]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$stmt = $db->query("SELECT orders.*, users.name AS user_name
                   FROM orders
                   LEFT JOIN users ON orders.user_id = users.id
                   ORDER BY orders.id DESC");

$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <h1>Commandes</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Total</th>
            <th>Date</th>
            <th>Détails</th>
        </tr>

        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= htmlspecialchars($order['user_name']) ?></td>
                <td><?= $order['total'] ?> DT</td>
                <td><?= $order['order_date'] ?></td>
                <td>
                    <a href="orders.php?id=<?= $order['id'] ?>">Voir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($selectedOrder): ?>
        <h2>Détails commande #<?= $selectedOrder['id'] ?></h2>

        <table>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Sous-total</th>
            </tr>

            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td><?= $item['price'] ?> DT</td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= $item['price'] * $item['quantity'] ?> DT</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>