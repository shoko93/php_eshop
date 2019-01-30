<?php
require_once __DIR__ . '/../../inc/bootstrap.php';

try {
    $sql = 'SELECT name FROM user_login WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
<div class="content-wrapper">
  <h2>アカウントサービス</h1>
  <h3><?php echo $rec['name']; ?> 様</h2>
  <p><a href="order_history.php">注文履歴</a></p>
  <p><a href="user_info_update.php">アカウント情報の変更</a></p>
  <p><a href="address_list.php">アドレス帳</a></p>
</div>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
