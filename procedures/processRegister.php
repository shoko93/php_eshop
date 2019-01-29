<?php
$error_message = '';

if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
}
if (isset($_POST['register'])) {
    // Check if all the fields are entered correctly
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $pass = trim(filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING));

    if (empty($name) || empty($email) || empty($pass)) {
        $error_message = "入力されていない項目があります。";
    } else {
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['pass'] = password_hash($pass, PASSWORD_DEFAULT);
        header('location:register_confirm.php');
        exit();
    }
}
