<?php
require_once __DIR__ . '/../../inc/bootstrap.php';

if (isset($_POST['edit'])) {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $postcode = $_SESSION['postcode'];
    $prefecture = $_SESSION['prefecture'];
    $address = $_SESSION['address'];
    $phone = $_SESSION['phone'];
}

if (isset($_POST['order'])) {
    // Check if all the fields are entered correctly
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $prefecture = trim(filter_input(INPUT_POST, 'prefecture', FILTER_SANITIZE_STRING));
    $address = trim(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING));

    require_once __DIR__ . '/../../procedures/validateOrder.php';

    if (empty($name) || empty($email) || empty($postcode) || empty($payment) ||
        empty($prefecture) || empty($address) || empty($phone)) {
        $error_msg = "正しく入力されていない項目があります。";
    } else {
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['postcode'] = $postcode;
        $_SESSION['prefecture'] = $prefecture;
        $_SESSION['address'] = $address;
        $_SESSION['phone'] = $phone;
        $_SESSION['payment'] = $payment;
        header('Location: /order/order_confirm.php');
        exit();
    }
}
?>

<div class="content-wrapper">
  <h2>購入手続き</h2>
  <?php if (isset($error_msg)) {
      echo '<p>' . $error_msg . '</p>';
  } ?>
  <form method="post" action="order_form.php">
    <label for="name">お名前</label>
    <input type="text" name="name" value="<?php if(isset($name)) echo $name;?>">
    <label for="email">メールアドレス</label>
    <input type="text" name="email" value="<?php if(isset($email)) echo $email;?>">
    <label for="postcode1">郵便番号</label>
    <input type="text" name="postcode1" value="<?php
      if(isset($postcode)) echo substr($postcode, 0, 3);?>"> -
    <input type="text" name="postcode2" value="<?php
      if(isset($postcode)) echo substr($postcode, 3, 4);?>">
    <p>都道府県</p>
    <div class="select-wrapper">
      <select name="prefecture">
        <?php for ($i = 0; $i < count(PREFECTURES_JP); $i++) {
            if (isset($prefecture) && $prefecture == PREFECTURES_JP[$i]) {
                echo '<option value="pr' . $i . '" selected>' . PREFECTURES_JP[$i] . '</option>';
            } else {
                echo '<option value="pr' . $i . '">' . PREFECTURES_JP[$i] . '</option>';
            }
        } ?>
      </select>
    </div>
    <label for="address">住所</label>
    <input type="text" name="address" value="<?php if(isset($address)) echo $address;?>">
    <label for="phone">電話番号</label>
    <input type="text" name="phone" value="<?php if(isset($phone)) echo $phone;?>"><br>
    <label class="payment-method">お支払方法</label>
    <select name="payment">
      <option value="payment_1">代金引換</option>
      <option vlaue="payment_2">銀行振込</option>
    </select>
    <div><input type="submit" value="次へ" name="order"></div>
  </form>
</div>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
