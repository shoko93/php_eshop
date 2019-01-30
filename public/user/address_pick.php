<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';

$user_id = $_SESSION['user_id'];

try {
    $addresses = get_user_address($db, $user_id);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
<div class="content-wrapper">
  <h2>使用するアドレスをクリックしてください。</h2>
  <p><a href="address_list.php">住所の追加</a></p>
  <h3>自分用の住所</h3>
  <table>
    <?php for ($i = 0; $i < count($addresses); $i++):
      $address = $addresses[$i];
      if ($address['gift']) break; ?>
      <th><a href="user_order_payment.php?address=<?php
          echo $address['id'];?>">住所 #<?php echo ($i+1);?></a></th>
      <tr><td>郵便番号</td><td><?php echo $address['postcode']; ?></td></tr>
      <tr><td>都道府県</td><td><?php echo $address['prefecture']; ?></td></tr>
      <tr><td>住所</td><td><?php echo $address['address']; ?></td></tr>
    <?php endfor; ?>
  </table>
  <h3>ギフト用の住所</h3>
  <table>
    <?php for (; $i < count($addresses); $i++):
      $address = $addresses[$i]; ?>
      <th><a href="user_order_payment.php?address=<?php
          echo $address['id'];?>">住所 #<?php echo ($i+1);?></a></th>
      <tr><td>宛名</td><td><?php echo $address['name_to']; ?></td></tr>
      <tr><td>郵便番号</td><td><?php echo $address['postcode']; ?></td></tr>
      <tr><td>都道府県</td><td><?php echo $address['prefecture']; ?></td></tr>
      <tr><td>住所</td><td><?php echo $address['address']; ?></td></tr>
      <?php if (!empty($address['comment'])) {
          echo '<tr><td>コメント</td><td>' . $address['comment'] . '</td></tr>';
      } ?>
    <?php endfor; ?>
  </table>
</div>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
