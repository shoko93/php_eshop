<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../../inc/mailer.php';

$cart = $_SESSION['cart'];
$quantity = $_SESSION['quantity'];
$product_names = $_SESSION['product_name'];
$prices = $_SESSION['price'];

$db_error = false;

if (isset($_POST['confirm'])) {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $postcode = $_SESSION['postcode'];
    $prefecture = $_SESSION['prefecture'];
    $address = $_SESSION['address'];
    $phone = $_SESSION['phone'];
    $payment = $_SESSION['payment'];
    require_once __DIR__ . '/../../procedures/processCustomerOrder.php';
}

if (isset($_POST['user_order_confirm'])) {
    require_once __DIR__ . '/../../procedures/processUserOrder.php';
}

require_once __DIR__ . '/../../procedures/processOrder.php';
?>
<div class="content-wrapper">
  <p>以下の内容で注文を受け付けました。</p>
  <p>お名前：<?php echo $name;?></p>
  <p>メールアドレス：<?php echo $email;?></p>
  <p>郵便番号<?php echo substr($postcode, 0, 3) . '-' . substr($postcode, 3, 4);?></p>
  <p>住所：<?php echo $address ?></p>
  <p>電話番号：<?php echo $phone ?></p>
  <p>商品情報</p>
  <?php for ($i = 0; $i < count($product_names); $i++) {
      echo '<p>' . $product_names[$i] . ' * ' . $quantity[$i] . ": " . $prices[$i] . '円</p>';
  } ?>
</div>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
