<?php
require_once __DIR__ . '/../inc/footstrap.php';
require_once __DRI__ . '/login_check.php';

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['address_id']) || !isset($_SESSION['payment'])) {
    header('location: address_pick.php');
}

$address_id = $_SESSION['address_id'];
try {
    $sql = 'SELECT * FROM user_address WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $address_id, PDO::PARAM_INT);
    $stmt->execute();
} catch (Exception $e) {
    echo $e->getMessage();
}
$address = $stmt->fetch(PDO::FETCH_ASSOC);

try {
    $sql = 'SELECT phone_number FROM user_phone WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $address['phone_id']);
    $stmt->execute();
} catch (Exceptino $e) {
    echo $e->getMessage();
}
$phone = $stmt->fetch(PDO::FETCH_ASSOC);

$payment = PAYMENT[$_SESSION['payment']];
?>
