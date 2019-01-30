<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['new_email_confirm'])) {
    try {
        $sql = 'SELECT password FROM user_login WHERE id=?';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_pass = $user['password'];
    $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
    if (password_verify($pass, $user_pass)) {
        $new_email = $_SESSION['new_email'];
        try {
            $sql = 'UPDATE user_login SET email = ?';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $new_email, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        echo '<h2>メールアドレスを変更しました</h2>';
        echo '<p>' . $_SESSION['new_email'] . '</p>';
        unset($_SESSION['new_email']);
        exit();
    } else {
        $error_msg = 'パスワードが間違っています。';
    }
}

if (!isset($_SESSION['new_email'])) {
    header('Location: /user/email_update.php');
}
$new_email = $_SESSION['new_email'];
?>

<h2>変更内容の確認</h2>
<p>メールアドレスを<?php echo $new_email; ?>に変更します。</p>
<p>確認のためパスワードを入力してください</p>
<?php if (isset($error_msg)) echo '<p>' . $error_msg .'</p>'; ?>
<form method="post" action="email_update_confirm.php">
  <label for="pass">パスワード</label>
  <input type="password" name="pass">
  <input type="submit" name="new_email_confirm" value="送信">
</form>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
