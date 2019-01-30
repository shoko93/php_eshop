<?php
try {
    $sql = 'SELECT * FROM user_login WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $_SESSION['user_id']);
    $stmt->execute();
} catch (Exception $e) {
    $e->getMessage();
    $db_error = true;
}
$user_info = $stmt->fetch(PDO::FETCH_ASSOC);
$name = $user_info['name'];
$email = $user_info['email'];

try {
    $sql = 'SELECT * FROM user_address WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $_SESSION['address_id']);
    $stmt->execute();
} catch (Exception $e) {
    $e->getMessage();
    $db_error = true;
}
$user_address = $stmt->fetch(PDO::FETCH_ASSOC);
$postcode = $user_address['postcode'];
$prefecture = $user_address['prefecture'];
$address = $user_address['address'];

try {
    $sql = 'SELECT * FROM user_phone WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $user_address['phone_id']);
    $stmt->execute();
} catch (Exception $e) {
    $e->getMessage();
    $db_error = true;
}
$user_phone = $stmt->fetch(PDO::FETCH_ASSOC);
$phone = $user_phone['phone_number'];

try {
    $sql = 'INSERT INTO order_record (user_id, address_id, payment) VALUES (?, ?, ?)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(2, $_SESSION['address_id'], PDO::PARAM_INT);
    $stmt->bindValue(3, $_SESSION['payment'], PDO::PARAM_INT);
    $stmt->execute();
    $order_id = $db->lastInsertId();
} catch (Exception $e) {
    echo 'Insertion Error: order_record<br>';
    echo $e->getMessage();
    $db_error = true;
}
