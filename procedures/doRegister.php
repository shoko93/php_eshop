<?php
require_once __DIR__ . '/../inc/mailer.php';

if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $pass = $_SESSION['pass'];

    try {
        $result = $db->prepare('INSERT INTO user_login (name, email, password) VALUES (?, ?, ?)');
        $result->bindValue(1, $name, PDO::PARAM_STR);
        $result->bindValue(2, $email, PDO::PARAM_STR);
        $result->bindValue(3, $pass, PDO::PARAM_STR);
        $result->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    /* Create email body */
    $email_body = "";
    $email_body .= "お名前: " . $name . "\n";
    $email_body .= "メールアドレス: " . $email . "\n";
	  $mail->setFrom(getenv('SMTP_FROM'), $name);
    $mail->addAddress($email, $name);
	  $mail->Subject = '登録完了のお知らせ';
	  $mail->Body = $email_body;
	  if (!$mail->send()) {
		    echo "<p>メールエラー: " . $mail->ErrorInfo . '</p>';
        exit();
    }
    unset($_SESSION['name']);
    unset($_SESSION['email']);
    unset($_SESSION['pass']);
}
