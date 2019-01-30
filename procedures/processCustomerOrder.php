<?php
try {
    $sql = 'INSERT INTO temp_customer (name, email, phone_number, postcode, prefecture, address)
            VALUES (?, ?, ?, ?, ?, ?)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $name);
    $stmt->bindValue(2, $email);
    $stmt->bindValue(3, $phone);
    $stmt->bindValue(4, $postcode);
    $stmt->bindValue(5, $prefecture);
    $stmt->bindValue(6, $address);
    $stmt->execute();
} catch (Exception $e) {
    echo 'Insertion Error: temp_customer<br>';
    echo $e->getMessage();
    $db_error = true;
}
try {
    $customer_id = $db->lastInsertId();
    $sql = 'INSERT INTO order_record (customer_id, payment) VALUES (?, ?)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $customer_id);
    $stmt->bindValue(2, $payment);
    $stmt->execute();
    $order_id = $db->lastInsertId();
} catch (Exception $e) {
    echo 'Insertion Error: order_record<br>';
    echo $e->getMessage();
    $db_error = true;
}

if (!$db_error) {
    unset($_SESSION['name']);
    unset($_SESSION['email']);
    unset($_SESSION['postcode']);
    unset($_SESSION['prefecture']);
    unset($_SESSION['address']);
    unset($_SESSION['phone']);
}
