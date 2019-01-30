<?php
require_once __DIR__ . '/../inc/bootstrap.php';
require_once __DIR__ . '/../procedures/doLogin.php';
if (isset($_SESSION['login'])) {
    header('Location: index.php');
}
?>
<div class="content-wrapper">
  <h2>ログイン</h2>
  <p><?php if(isset($error_msg)) echo $error_msg; ?></p>
  <form method="post" action="login.php">
    <label for="email">メールアドレス</label>
    <input type="text" name="email">
    <label for="pass">パスワード</label>
    <input type="password" name="pass">
    <div><input type="submit" name="login" value="ログイン"></div>
  </form>
</div>
<?php
require_once __DIR__ . '/../inc/footer.php';
?>
