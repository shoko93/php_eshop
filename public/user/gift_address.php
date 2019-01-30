<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['add_gift_address'])) {
    $name_to = trim(filter_input(INPUT_POST, 'name_to', FILTER_SANITIZE_STRING));
    $postcode1 = trim(filter_input(INPUT_POST, 'postcode1', FILTER_SANITIZE_STRING));
    $postcode2 = trim(filter_input(INPUT_POST, 'postcode2', FILTER_SANITIZE_STRING));
    $address = trim(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING));
    $phone_label = trim(filter_input(INPUT_POST, 'phone_label', FILTER_SANITIZE_STRING));
    $phone_number = trim(filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING));

    // Check if the post code and phone number contains valid string.
    if (preg_match('/\A\d{3}\z/', $postcode1) == 0) {
        $postcode1 = '';
    }
    if (preg_match('/\A\d{4}\z/', $postcode2) == 0) {
        $postcode2 = '';
    }
    if (preg_match('/\A\d{3}-?\d{3}-?\d{4}\z/', $phone_number) == 0) {
        $phone_number = '';
    }

    if (empty($name_to) || empty($postcode1) || empty($postcode2) ||
        empty($address) || empty($phone_number)) {
        $error_msg = '正しく入力されていない項目があります。';
    } else {
        $pr_index = intval(substr($_POST['prefecture'], strlen('pr')));
        if (0 > $pr_index || count(PREFECTURES_JP) <= $pr_index) {
            $error_msg = '都道府県に不正な値が設定されています。';
        }
    }

    if (!isset($error_msg)) {
        try {
            $label = 'gift';
            $postcode = $postcode1 . $postcode2;
            $prefecture = PREFECTURES_JP[$pr_index];
            $phone_id = add_phone($db, $user_id, $phone_label, $phone_number);
            add_address($db, $user_id, $label, $name_to, $postcode, $prefecture, $address, $phone_id, true);
            echo '<div class="content-wrapper">';
            echo '<p>ギフト用住所を追加しました</p>';
            echo '<p><a hreF="address_list.php">住所一覧</a></p>';
            echo '</div>';
            require_once __DIR__ . '/../../inc/footer.php';
            exit();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>

<div class="content-wrapper">
  <h2>ギフト用住所の登録</h2>
  <p><?php if (isset($error_msg)) echo $error_msg; ?></p>
  <form method="post" action="gift_address.php">
    <label for="name_to">宛名</label>
    <input type="text" name="name_to">
    <label for="postcode1">郵便番号</label>
    <input type="text" name="postcode1">
    -
    <input type="text" name="postcode2">
    <p>都道府県</p>
    <div class="select-wrapper">
      <select name="prefecture">
        <?php for ($i = 0; $i < count(PREFECTURES_JP); $i++) {
            echo '<option value="pr' . $i . '">' . PREFECTURES_JP[$i] . '</option>';
        } ?>
      </select>
    </div>
    <label for="address">住所</label>
    <input type="text" name="address">
    <p>電話番号</p>
    <p>配達に関する連絡に使用する電話番号を入力してください。</p>
    <div class="select-wrapper">
      <select name="phone_label">
        <option value="phone_home">自宅</option>
        <option value="phone_mobile">携帯</option>
        <option value="phone_office">会社</option>
      </select>
    </div>
    <input type="text" name="phone_number">
    <div>
      <label for="gift_memo">メモ（任意）</labeL>
      <textarea name="gift_memo" rows="5" cols="70"
        placeholder="この住所に関するメモを残すことができます。この情報は配達には使用されません。"></textarea>
    </div>
    <input type="submit" name="add_gift_address" value="送信">
  </form>
</div>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
