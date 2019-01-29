<?php
session_start();
if (isset($_SESSION['login'])) {
    header('Location: address_pick.php');
} else {
    header('Location: order_form.php');
}
?>
