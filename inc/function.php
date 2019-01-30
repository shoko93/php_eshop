<?php
function get_categories($db) {
    $sql = 'SELECT name FROM categories';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_random_items($db) {
    $sql = 'SELECT products.id AS id, products.name AS name,
                   categories.name AS category, price FROM products
            JOIN categories ON products.category_id = categories.id
            ORDER BY RANDOM() LIMIT 5';
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

function get_product_info ($db, $id) {
    // Get common produtc details
    try {
        $sql = 'SELECT products.name AS name, categories.name AS category, price
                FROM products
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

function get_product_details ($db, $id, $category) {
    try {
        $sql = "SELECT * FROM $category WHERE product_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_user($db, $id) {
    $sql = 'SELECT name, email FROM user_login WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_user_address_order($db, $id) {
    $sql = 'SELECT * FROM user_address WHERE user_id = ? ORDER BY label DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function delete_user_address($db, $id) {
    $sql = 'DELETE FROM user_address WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
}

function delete_user_phone($db, $id) {
    $sql = 'SELECT COUNT(*) FROM user_address WHERE phone_id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $num = $stmt->fetchColumn();
    if ($num == 0) {
        $sql = 'DELETE FROM user_phone WHERE id = ?';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

function get_user_phone($db, $id) {
    $sql = 'SELECT phone_number FROM user_phone WHERE id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_user_address($db, $id) {
    $sql = 'SELECT * FROM user_address WHERE user_id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
