<?php
session_start();
include 'db.php';
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') exit('Nije dozvoljen pristup');

$id = $_GET['id'] ?? null;
if(!$id) exit('Proizvod nije definisan');

// Dohvati proizvod za prikaz imena
$stmt = $pdo->prepare("SELECT name FROM products WHERE id=?");
$stmt->execute([$id]);
$product = $stmt->fetch();
if(!$product) exit('Proizvod ne postoji');

$message = '';
if(isset($_POST['confirm_delete'])){
    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Obriši proizvod</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-4 bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 400px;">
        <h3 class="card-title mb-3 text-center">Potvrda brisanja</h3>
        <p>Da li ste sigurni da želite da obrišete proizvod: <strong><?= htmlspecialchars($product['name']) ?></strong>?</p>

        <form method="POST" class="d-flex justify-content-between">
            <button type="submit" name="confirm_delete" class="btn btn-danger">Obriši</button>
            <a href="admin.php" class="btn btn-secondary">Odustani</a>
        </form>
    </div>
</div>

</body>
</html>
