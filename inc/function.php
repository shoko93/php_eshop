<?php
function get_categories($db) {
    $sql = 'SELECT name FROM categories';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function add_address ($db, $id, $label, $name_to, $postcode, $prefecture, $address,
                      $phone_id, $is_gift = 0, $comment = null) {
    try {
        $sql = 'INSERT INTO user_address (user_id, label, name_to,
                postcode, prefecture, address, phone_id, gift, comment)
                VALUES (:id, :label, :name_to, :postcode, :prefecture, :address,
                        :phone_id, :gift, :comment)';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':label', $label, PDO::PARAM_STR);
        $stmt->bindValue(':name_to', $name_to, PDO::PARAM_STR);
        $stmt->bindValue(':postcode', $postcode, PDO::PARAM_STR);
        $stmt->bindValue(':prefecture', $prefecture, PDO::PARAM_STR);
        $stmt->bindValue(':address', $address, PDO::PARAM_STR);
        $stmt->bindValue(':phone_id', $phone_id, PDO::PARAM_INT);
        $stmt->bindValue(':gift', $is_gift);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function add_phone ($db, $id, $label, $phone_number) {
    $phone_number = str_replace("-", "", $phone_number);
    try {
        $sql = 'INSERT INTO user_phone (user_id, label, phone_number)
                VALUES (?, ?, ?)';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->bindValue(2, $label);
        $stmt->bindValue(3, $phone_number);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return $db->lastInsertId();
}

function get_product_info ($id) {
    include('connection.php');
    // Get common produtc details
    try {
        $sql = 'SELECT products.name AS name, categories.name AS category,
                price, release_date FROM products
                JOIN categories ON categories.id = products.category_id
                WHERE products.id = ?';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_product_details ($id, $category) {
    include('connection.php');
    try {
        $sql = 'SELECT * FROM ' . $category . ' WHERE product_id = ?';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function checkPassword ($user_id, $pass, $db) {
    try {
        $sql = 'SELECT password FROM user_login WHERE id=?';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_pass = $user['password'];
    return $pass == $user_pass;
}
