<?php
session_start();
if (isset($_SESSION['login'])) {
    header('Location: /user/address_pick.php');
} else {
    header('Location: order_form.php');
}
?>
