<?php
session_start();
include 'db.php';

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$total = 0;
$cart_items = [];

foreach($_SESSION['cart'] as $id => $qty){
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    if($product){
        $subtotal = $product['price'] * $qty;
        $total += $subtotal;
        $cart_items[] = [
            'name' => $product['name'],
            'qty' => $qty,
            'price' => $product['price'],
            'subtotal' => $subtotal
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Korpa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-4 bg-light">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Vaša korpa</h1>
        <a href="index.php" class="btn btn-secondary">Nazad na proizvode</a>
    </div>

    <?php if(empty($cart_items)): ?>
        <div class="alert alert-info">Vaša korpa je prazna.</div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Proizvod</th>
                    <th>Količina</th>
                    <th>Cena po komadu</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($cart_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td><?= $item['price'] ?> RSD</td>
                    <td><?= $item['subtotal'] ?> RSD</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <h4>Ukupno: <?= $total ?> RSD</h4>
            <span>Vreme kupovine: <?= date('d.m.Y H:i:s') ?></span>
        </div>

        <div class="mt-3">
            <button class="btn btn-success">Nastavi na plaćanje</button>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
