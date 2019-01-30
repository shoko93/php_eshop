<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user_id = $_SESSION['user_id'];
    if (!isset($_GET['address']) || intval($_GET['address']) == 0) {
        header('Location: /user/address_pick.php');
    }
    $_SESSION['address_id'] = intval($_GET['address']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['payment_next'])) {
      header('Location: /user/address_pick.php');
    }
    $payment = intval(substr($_POST['payment'], strlen('payment_')));
    if ($payment < 1) {
      header('Location: /user/address_pick.php');
    }
    $_SESSION['payment'] = $payment;
    header('Location: /user/user_order_confirm.php');
}

$address_id = $_SESSION['address_id'];
try {
    $sql = 'SELECT * FROM user_address WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $address_id, PDO::PARAM_INT);
    $stmt->execute();
} catch (Exception $e) {
    echo $e->getMessage();
}
$address = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['address'] = $address
?>

<div class="content-wrapper">
  <h2>お支払方法の選択</h2>
  <table>
    <?php if ($address['gift']): ?>
      <tr><td>宛名</td><td><?php echo $address['name_to']; ?></td></tr>
    <?php endif; ?>
    <tr><td>郵便番号</td><td><?php echo $address['postcode']; ?></td></tr>
    <tr><td>都道府県</td><td><?php echo $address['prefecture']; ?></td></tr>
    <tr><td>住所</td><td><?php echo $address['address']; ?></td></tr>
  </table>
  <form method="post" action="user_order_payment.php">
    <label class="payment-method">お支払方法</label>
    <select name="payment">
      <option value="payment_1">代金引換</option>
      <option vlaue="payment_2">銀行振込</option>
    </select>
    <div><input type="submit" name="payment_next" value="次へ"></div>
  </form>
</div>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
