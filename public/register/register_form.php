<?php
require_once __DIR__ . '/../inc/bootstrap.php';
require_once __DIR__ . '/../procedures/processRegister.php';

if (isset($_SESSION['name']) && isset($_SESSION['email']) && isset($_SESSION['pass'])) {
    header('Location: register_confirm.php');
}
?>
<div class="content-wrapper">
  <h2>会員登録</h2>
  <p><?php echo $error_message; ?></p>
  <form method="post" action="register_form.php">
    <label for="name">名前</label>
    <input type="text" name="name" value="<?php if (isset($name)) echo $name; ?>">
    <label for="email">メールアドレス</label>
    <input type="text" name="email" value="<?php if (isset($email)) echo $email; ?>">
    <label for="password">パスワード</label>
    <input type="password" name="pass">
    <div><input type="submit" name="register" value="登録"></div>
  </form>
</div>
<?php
require_once __DIR__ . '/../inc/footer.php';
?>
