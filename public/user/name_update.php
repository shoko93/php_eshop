<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['update_name'])) {
    $new_name = filter_input(INPUT_POST, 'new_name', FILTER_SANITIZE_STRING);
    if (empty($new_name)) {
        $error_msg = '名前が入力されていません。';
    } else {
        $_SESSION['new_name'] = $new_name;
        header('Location: /user/name_update_confirm.php');
        exit();
    }
}
?>
<h2>名前の変更</h2>
<?php if (isset($error_msg)) echo '<p>' . $error_msg . '</p>';?>
<form method="post" action="name_update.php">
  <label for="new_name">新しい名前</label>
  <input type="text" name="new_name">
  <input type="submit" name="update_name" value="変更">
</form>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
