<?php
if (!isset($_SESSION['cart'])) {
    header('cart.php');
}

$cart = $_SESSION['cart'];
$quantity = $_SESSION['quantity'];

if (isset($_POST['update'])) {
    for ($i = 0; $i < count($cart); $i++) {
        $quantity[$i] = $_POST['quantity' . $i];
    }
} else if (isset($_POST['delete'])) {
    for ($i = count($cart) - 1; $i >= 0; $i--) {
        if (isset($_POST['remove'.$i])) {
            array_splice($cart, $i, 1);
            array_splice($quantity, $i, 1);
        }
    }
}

$_SESSION['cart'] = $cart;
$_SESSION['quantity'] = $quantity;
?>
