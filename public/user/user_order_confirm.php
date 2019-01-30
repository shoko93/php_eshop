<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';
?>
<div class="content-wrapper">
  <p>以下の内容に間違いがないかご確認の上、完了をクリックしてください。</p>
  <table>
    <?php if ($_SESSION['address']['gift']): ?>
      <tr><td>宛名</td><td><?php echo $_SESSION['address']['name_to']; ?></td></tr>
    <?php endif; ?>
    <tr><td>郵便番号</td><td><?php echo $_SESSION['address']['postcode']; ?></td></tr>
    <tr><td>都道府県</td><td><?php echo $_SESSION['address']['prefecture']; ?></td></tr>
    <tr><td>住所</td><td><?php echo $_SESSION['address']['address']; ?></td></tr>
    <tr><td>お支払方法</td><td><?php echo $_SESSION['payment']; ?></td>
  </table>
  <form method="post" action="/order/order_complete.php">
    <input type="submit" value="完了" name="user_order_confirm">
  </form>
</div>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
