<?php
require_once __DIR__ . '/../inc/bootstrap.php';

if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $pass = $_SESSION['pass'];
} else {
    header('location:register.php');
}
?>
<div class="content-wrapper">
  <h2>会員登録</h2>
  <p>以下の情報で登録してよろしいでしょうか？</p>
  <p>名前:　<?php echo $name; ?></p>
  <p>メールアドレス:　<?php echo $email; ?></p>
  <form method="post">
    <input type="submit" formaction="register_complete.php" value="OK">
    <input type="submit" formaction="register.php" value="修正">
  </form>
</div>
<?php
require_once __DIR__ . '/../inc/footer.php';
?>
