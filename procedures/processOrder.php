<?php
try {
    for ($i = 0; $i < count($cart); $i++) {
        $sql = 'INSERT INTO order_product (product_id, quantity, order_id)
                VALUES (?, ?, ?)';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $cart[$i], PDO::PARAM_INT);
        $stmt->bindValue(2, $quantity[$i], PDO::PARAM_INT);
        $stmt->bindValue(3, $order_id, PDO::PARAM_INT);
        $stmt->execute();
    }
} catch (Exception $e){
    echo 'Insertion Error: order_product<br>';
    echo $e->getMessage();
    $db_error = true;
}

if (!$db_error) {
    unset($_SESSION['cart']);
    unset($_SESSION['quantity']);
    unset($_SESSION['product_name']);
    unset($_SESSION['price']);

    /* Create email body */
    $email_body = "";
    $email_body .= "お名前: " . $name . "\n";
    $email_body .= "メールアドレス: " . $email . "\n";
    $email_body .= "郵便番号: " . substr($postcode, 0, 3) . '-' . substr($postcode, 3, 4) . "\n";
    $email_body .= "住所: " . $address . "\n";
    $email_body .= "電話番号: " . $phone . "\n";
    $email_body .= "商品情報\n";
    for ($i = 0; $i < count($product_names); $i++) {
        $email_body .= $product_names[$i] . ' * ' . $quantity[$i] . ": " . $prices[$i] . "円\n";
    }

	  //It's important not to use the submitter's address as the from address as it's forgery,
	  //which will cause your messages to fail SPF checks.
	  //Use an address in your own domain as the from address, put the submitter's address in a reply-to
	  $mail->setFrom(getenv('SMTP_FROM'), getenv('MAILTO_NAME'));
	  $mail->addAddress($email, $name);
	  $mail->Subject = '注文完了のお知らせ';
	  $mail->Body = $email_body;
	  if (!$mail->send()) {
		    echo "<p>メールエラー: " . $mail->ErrorInfo . '</p>';
        exit();
    }
} else {
    '<p>注文処理中にエラーが発生しました。</p>';
    exit();
}
