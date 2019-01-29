<?php
session_start();
if (isset($_SESSION['user_id'])) {
    unset($_SESSION['login']);
    unset($_SESSION['user_id']);
}
header('Location: /index.php');
?>
