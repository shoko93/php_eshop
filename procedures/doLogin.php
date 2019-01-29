<?php
if (isset($_POST['login'])) {
    try {
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $pass = trim(filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING));

        if (empty($email)) {
            $error_msg = 'メールアドレスが入力されていません。';
        }
        if (empty($pass)) {
            $error_msg = 'パスワードが入力されていません。';
        }

        if (!isset($error_msg)) {
            $sql = 'SELECT id, password FROM user_login WHERE email = ?';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $email, PDO::PARAM_STR);
            $stmt->execute();

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rec && password_verify($pass, $rec['password'])) {
                $_SESSION['login'] = 1;
                $_SESSION['user_id'] = $rec['id'];
            } else {
                $error_msg = 'メールアドレスかパスワードが間違っています。';
            }
        }
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}
