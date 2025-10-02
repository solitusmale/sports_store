<?php
session_start();
include 'db.php';
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') exit('Nije dozvoljen pristup');

$id = $_GET['id'] ?? null;
if(!$id) exit('Proizvod nije definisan');

// Dohvati proizvod
$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);
$product = $stmt->fetch();

// Dohvati kategorije
$stmt2 = $pdo->query("SELECT * FROM categories");
$categories = $stmt2->fetchAll();

$message = '';
if(isset($_POST['edit_product'])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, price=?, category_id=? WHERE id=?");
    $stmt->execute([$name, $description, $price, $category, $id]);

    $message = "Proizvod je uspešno ažuriran!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Izmeni proizvod</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-4 bg-light">

<div class="container">
    <h1 class="mb-4">Izmeni proizvod</h1>

    <?php if($message): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow mb-3">
        <div class="mb-3">
            <label class="form-label">Ime</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Opis</label>
            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Cena (RSD)</label>
            <input type="number" name="price" step="0.01" class="form-control" value="<?= $product['price'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategorija</label>
            <select name="category" class="form-select" required>
                <?php foreach($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id']==$product['category_id']?'selected':'' ?>>
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="edit_product" class="btn btn-primary">Sačuvaj</button>
        <a href="admin.php" class="btn btn-secondary mt-2">Nazad na admin panel</a>
    </form>
</div>

</body>
</html>
