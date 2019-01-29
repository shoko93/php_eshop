<?php
/* Create email body */
$email_body = "";
$email_body .= "お名前: " . $enq_name . "\n";
$email_body .= "メールアドレス: " . $enq_email . "\n";
$email_body .= "お問い合わせ内容: ";

if (isset($_POST['enq_about'])) {
    switch ($_POST['enq_about']) {
        case 'enq1':
            $email_body .= "注文\n";
            break;
        case 'enq2';
            $email_body .= "アカウント\n";
            break;
        case 'enq3':
            $email_body .= "その他\n";
            break;
    }
}

if (isset($_POST['enq_title'])) {
    $enq_title = filter_input(INPUT_POST, 'enq_name', FILTER_SANITIZE_STRING);
    $email_body .= "タイトル: " . $enq_title . "\n";
}

$email_body .= "本文: " . $enq_contents . "\n";

//It's important not to use the submitter's address as the from address as it's forgery,
//which will cause your messages to fail SPF checks.
//Use an address in your own domain as the from address, put the submitter's address in a reply-to
$mail->setFrom(getenv('SMTP_FROM'), getenv('MAILTO_NAME'));
$mail->addReplyTo($enq_email, $enq_name);
$mail->addAddress(getenv('MAILTO_EMAIL'), getenv('MAILTO_NAME'));
$mail->Subject = 'お問い合わせフォームより';
$mail->Body = $email_body;
if ($mail->send()) {
    $msg = "メールを送信しました。";
} else {
    $msg = "メールエラー: " . $mail->ErrorInfo;
}
