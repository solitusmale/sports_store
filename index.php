<?php
session_start();
include 'db.php';

// Prikaz flash poruke
$message = '';
if(isset($_SESSION['message'])){
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Dohvati proizvode iz baze
$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proizvodi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-4">

<!-- Logout / Admin / Korpa linkovi -->
<div class="mb-3">
    <a href="logout.php" class="btn btn-secondary">Logout</a>
    <?php if(isset($_SESSION['role']) && $_SESSION['role']=='user'): ?>
        <a href="cart.php" class="btn btn-primary">Pogledaj korpu</a>
    <?php endif; ?>
    <?php if(isset($_SESSION['role']) && $_SESSION['role']=='admin'): ?>
        <a href="admin.php" class="btn btn-warning">Admin panel</a>
    <?php endif; ?>
</div>

<!-- Bootstrap toast poruka -->
<?php if($message): ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
  <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        <?= htmlspecialchars($message) ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
<script>
  window.addEventListener('load', () => {
    const toastEl = document.querySelector('.toast');
    if(toastEl){
      const toast = new bootstrap.Toast(toastEl, {delay: 3000});
      toast.show();
    }
  });
</script>
<?php endif; ?>

<h1 class="mb-4">Proizvodi</h1>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
<?php foreach($products as $p): ?>
    <div class="col">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($p['name']) ?> (<?= htmlspecialchars($p['category_name']) ?>)</h5>
                <p class="card-text"><?= htmlspecialchars($p['description']) ?></p>
                <p class="card-text"><strong><?= $p['price'] ?> RSD</strong></p>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'user'): ?>
                    <form method="POST" action="add_to_cart.php" class="d-flex gap-2">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <input type="number" name="quantity" value="1" min="1" class="form-control" style="width:80px">
                        <button type="submit" class="btn btn-success">Dodaj u korpu</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

</body>
</html>
