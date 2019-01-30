<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['confirm_new_pass'])) {
    $curr_pass = filter_input(INPUT_POST, 'curr_pass', FILTER_SANITIZE_STRING);
    $new_pass = filter_input(INPUT_POST, 'new_pass', FILTER_SANITIZE_STRING);
    $new_pass_confirm = filter_input(INPUT_POST, 'new_pass_confirm', FILTER_SANITIZE_STRING);

    if (empty($curr_pass) || empty($new_pass) ||
        empty($new_pass_confirm)) {
        $error_msg = '入力されていない項目があります。';
    } else if ($new_pass != $new_pass_confirm) {
        $error_msg = '新しいパスワードが確認用と一致しません。';
    } else {
      try {
          $sql = 'SELECT password FROM user_login WHERE id=?';
          $stmt = $db->prepare($sql);
          $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
          $stmt->execute();
      } catch (Exception $e) {
          echo $e->getMessage();
      }
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if (password_verify($curr_pass, $user['password'])) {
          try {
              $sql = 'UPDATE user_login SET password = ?';
              $stmt = $db->prepare($sql);
              $stmt->bindValue(1, password_hash($new_pass, PASSWORD_DEFAULT), PDO::PARAM_STR);
              $stmt->execute();
          } catch (Exception $e) {
              echo $e->getMessage();
          }
          echo '<h2>パスワードを変更しました</h2>';
          require_once __DIR__ . '/../../inc/footer.php';
          exit();
      } else {
          $error_msg = '現在のパスワードが間違っています。';
      }
    }
}
?>
<h2>パスワードの変更</h2>
<?php if (isset($error_msg)) echo '<p>' . $error_msg .'</p>'; ?>
<form method="post" action="password_update.php">
  <div class="password-update">
    <label for="curr_pass">現在のパスワード</label>
    <input type="password" name="curr_pass">
    <label for="new_pass">新しいパスワード</label>
    <input type="password" name="new_pass">
    <label for="new_pass_confirm">新しいパスワード（確認用）</label>
    <input type="password" name="new_pass_confirm">
  </div>
  <input type="submit" name="confirm_new_pass" value="送信">
</form>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
