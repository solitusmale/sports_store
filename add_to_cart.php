<?php
session_start();

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if(isset($_POST['product_id'], $_POST['quantity'])){
    $id = $_POST['product_id'];
    $qty = (int)$_POST['quantity'];

    if($qty < 1) $qty = 1; // minimalna količina

    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }

    // Flash poruka
    $_SESSION['message'] = "Proizvod je uspešno dodat u korpu!";
}

// Redirect nazad na index.php
header("Location: index.php");
exit(); // OBAVEZNO da se prekine izvršavanje
