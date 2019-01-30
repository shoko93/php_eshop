<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';

$user_id = $_SESSION['user_id'];

try {
    $sql = 'SELECT name, email FROM user_login WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $user_id);
    $stmt->execute();
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exceptino $e) {
    $e->getMessage();
}
?>
<div class="content-wrapper">
  <h2>アカウント情報の変更</h2>
  <table>
    <tr>
      <td class="td-update-label">名前</td>
      <td class="td-update-value"><?php echo $user_info['name'];?></td>
      <td><a href="name_update.php">変更</a></td>
    </tr>
    <tr>
      <td class="td-update-label">メールアドレス</td>
      <td class="td-update-value"><?php echo $user_info['email'];?></td>
      <td><a href="email_update.php">変更</a></td>
    </tr>
  </table>
  <p><a href="password_update.php">パスワードの変更</a></p>
</div>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
