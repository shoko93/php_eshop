<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';

$user_id = $_SESSION['user_id'];
try {
    $addresses = get_user_address_order($db, $user_id);
} catch (Exception $e){
    echo 'エラー: ' . $e->getMessage();
}
?>
<div class="content-wrapper">
  <h2>住所一覧</h2>
  <p><a href="address_form.php">住所の追加</a></p>
  <h3>自分用の住所</h3>
  <table>
    <?php for ($i = 0; $i < count($addresses); $i++):
      $address = $addresses[$i];
      if ($address['gift']) break; ?>
      <th>住所 #<?php echo ($i+1);?></th>
      <tr><td>郵便番号</td><td><?php echo $address['postcode']; ?></td></tr>
      <tr><td>都道府県</td><td><?php echo $address['prefecture']; ?></td></tr>
      <tr><td>住所</td><td><?php echo $address['address']; ?></td></tr>
      <tr><td><a href="address_delete.php?address=<?php
          echo $address['id'];?>">削除</a></td></tr>
    <?php endfor; ?>
  </table>
  <h3>ギフト用の住所</h3>
  <table>
    <?php for (; $i < count($addresses); $i++):
      $address = $addresses[$i]; ?>
      <th>住所 #<?php echo ($i+1);?></th>
      <tr><td>宛名</td><td><?php echo $address['name_to']; ?></td></tr>
      <tr><td>郵便番号</td><td><?php echo $address['postcode']; ?></td></tr>
      <tr><td>都道府県</td><td><?php echo $address['prefecture']; ?></td></tr>
      <tr><td>住所</td><td><?php echo $address['address']; ?></td></tr>
      <?php if (!empty($address['comment'])) {
          echo '<tr><td>コメント</td><td>' . $address['comment'] . '</td></tr>';
      } ?>
      <tr><td><a href="address_delete.php?address=<?php
          echo $address['id'];?>">削除</a></td></tr>
    <?php endfor; ?>
  </table>
</div>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
