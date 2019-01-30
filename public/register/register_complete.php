<?php
require_once __DIR__ . '/../inc/bootstrap.php';
require_once __DIR__ . '/../procedures/doRegister.php';
?>
<div class="content-wrapper">
  <h2>登録完了</h2>
  <p>名前： <?php echo $name; ?></p>
  <p>Eメール： <?php echo $email; ?></p>
</div>
<?php
require_once __DIR__ . '/../inc/footer.php';
?>
