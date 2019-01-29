<?php
$product_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    $quantity = $_SESSION['quantity'];
    if (in_array($product_id, $cart)) {
        header('location: /cart.php');
        exit();
    }
}

if (!empty($product_id)) {
    $cart[] = $product_id;
    $quantity[] = 1;
    $_SESSION['cart'] = $cart;
    $_SESSION['quantity'] = $quantity;
}

if (empty($cart)) {
    echo '<div class="content-wrapper">';
    echo '<p>ショッピングカートは空です。</p>';
    echo '</div>';
    include('../inc/footer.php');
    exit();
}

// Get items to display
$product_names = array();
$prices = array();
foreach ($cart as $id) {
    try {
        $sql = 'SELECT name, price FROM products WHERE id = ?';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $product_names[] = $product['name'];
        $prices[] = $product['price'];
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
$_SESSION['product_name'] = $product_names;
$_SESSION['price'] = $prices;
?>
