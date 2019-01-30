<?php
if (!empty($prefecture)) {
    $pr_index = intval(substr($_POST['prefecture'], strlen('pr')));
    $prefecture = PREFECTURES_JP[$pr_index];
}

$postcode1 = isset($_POST['postcode1']) ? $_POST['postcode1'] : '';
$postcode2 = isset($_POST['postcode2']) ? $_POST['postcode2'] : '';
if (preg_match('/\A[0-9]{3}\z/', $_POST['postcode1']) == 0 ||
    preg_match('/\A[0-9]{4}\z/', $_POST['postcode2']) == 0) {
    $postcode1 = '';
    $postcode2 = '';
}
if (!empty($postcode1) && !empty($postcode2)) {
    $postcode = $postcode1 . $postcode2;
} else {
    $postcode = '';
}

$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
if (preg_match('/\A\d{3}-?\d{3}-?\d{4}\z/', $_POST['phone']) == 0) {
    $phone = '';
} else {
    $phone = $_POST['phone'];
}

$payment = intval(substr($_POST['payment'], strlen('payment_')));
if ($payment < 1) {
    $payment = '';
} else {
    $_SESSION['payment'] = $payment;
}
?>
