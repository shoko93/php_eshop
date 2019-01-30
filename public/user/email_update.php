<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['update_email'])) {
    $new_email = filter_input(INPUT_POST, 'new_email', FILTER_SANITIZE_EMAIL);
    if (empty($new_email)) {
        $error_msg = 'メールアドレスが入力されていません。';
    } else {
        $_SESSION['new_email'] = $new_email;
        header('Location: /user/email_update_confirm.php');
        exit();
    }
}
?>
<h2>メールアドレスの変更</h2>
<?php if (isset($error_msg)) echo '<p>' . $error_msg . '</p>';?>
<form method="post" action="email_update.php">
  <label for="new_email">新しいメールアドレス</label>
  <input type="text" name="new_email">
  <input type="submit" name="update_email" value="変更">
</form>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
