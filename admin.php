<?php
session_start();
include 'db.php';
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') exit('Nije dozvoljen pristup');

$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-4 bg-light">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Admin panel</h1>
        <div>
            <a href="admin_add_product.php" class="btn btn-success me-2">Dodaj proizvod</a>
            <a href="index.php" class="btn btn-secondary">Nazad na početnu</a>
        </div>
    </div>

    <?php if(empty($products)): ?>
        <div class="alert alert-info">Nema unetih proizvoda.</div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ime</th>
                    <th>Kategorija</th>
                    <th>Cena</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= htmlspecialchars($p['category_name']) ?></td>
                    <td><?= $p['price'] ?> RSD</td>
                    <td>
                        <a href="admin_edit_product.php?id=<?= $p['id'] ?>" class="btn btn-primary btn-sm me-1">Izmeni</a>
                        <a href="admin_delete_product.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm">Obriši</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
