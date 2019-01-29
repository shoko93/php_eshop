<?php
require_once __DIR__ . '/../inc/bootstrap.php';

if (empty($_SESSION['address'])) {
    header('location:order_form.php');
}

$name = $_SESSION['name'];
$email = $_SESSION['email'];
$postcode = $_SESSION['postcode'];
$prefecture = $_SESSION['prefecture'];
$address = $_SESSION['address'];
$phone = $_SESSION['phone'];
$payment = $_SESSION['payment'];

?>
<div class="content-wrapper">
  <h2>以下の内容で注文してよろしいですか？</h2>
  <p>お名前</p>
  <p><?php echo $name; ?></p>
  <p>メールアドレス</p>
  <p><?php echo $email; ?></p>
  <p>郵便番号</p>
  <p><?php echo substr($postcode, 0, 3) . '-' . substr($postcode, 3, 4); ?></p>
  <p>住所</p>
  <p><?php echo $address; ?></p>
  <p>電話番号</p>
  <p><?php echo $phone; ?></p>
  <p>お支払方法</p>
  <p><?php echo PAYMENT[$payment]; ?></p>
  <form method="post">
    <input type="submit" formaction="order_complete.php" name="confirm" value="OK">
    <input type="submit" formaction="order_form.php" name="edit" value="修正">
  </form>
</div>
<?php
require_once __DIR__ . '/../inc/footer.php';
?>
