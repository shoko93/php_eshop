<?php
require_once __DIR__ . '/../inc/bootstrap.php';
require_once __DIR__ . '/../inc/mailer.php';

if (isset($_SESSION['login'])) {
    try {
        $user = get_user($db, $_SESSION['user_id']);
        $name = $user['name'];
        $email = $user['email'];
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST['send'])) {
    $enq_name = filter_input(INPUT_POST, 'enq_name', FILTER_SANITIZE_STRING);
    $enq_email = filter_input(INPUT_POST, 'enq_email', FILTER_SANITIZE_EMAIL);
    $enq_contents = filter_input(INPUT_POST, 'enq_contents', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($enq_name) || empty($enq_email) || empty($enq_contents)) {
        $msg = "入力されていない項目があります。";
    } else {
        require_once __DIR__ . '/../procedures/processEnquiry.php';
    }
}
?>
<div class="content-wrapper">
  <h2>お問い合わせフォーム</h2>
  <?php if(isset($msg)) echo '<p>' . $msg . '</p>'; ?>
  <form method="post" action="contact.php">
    <label for="enq_name">お名前（必須）</label>
    <input type="text" name="enq_name" value="<?php
      if (isset($name)) echo $name; ?>">
    <label for="enq_email">メールアドレス（必須）</label>
    <input type="text" name="enq_email" value="<?php
      if (isset($email)) echo $email; ?>">
    <p>問い合わせ内容</p>
    <div class="select-wrapper">
      <select name="enq_about">
        <option value="enq1">注文</option>
        <option value="enq2">アカウント</option>
        <option value="enq3">その他</option>
      </select>
    </div>
    <label for="enq_title">タイトル</label>
    <input type="text" name="enq_title">
    <label for="enq_contents">本文（必須）</label>
    <textarea name="enq_contents" cols="50" rows="5"></textarea>
    <div><input type="submit" value="送信" name="send"></div>
  </form>
</div>
<?php
require_once __DIR__ . '/../inc/footer.php';
?>
