<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';

$user_id = $_SESSION['user_id'];

$address_label = filter_input(INPUT_POST, 'address_label', FILTER_SANITIZE_STRING);
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

$error_msg = array();
if (isset($_POST['add_address'])) {
    if (empty($postcode1) || empty($postcode2)) {
        $error_msg[] = '郵便番号が正しく入力されていません。';
    }
    if (empty($address)) {
        $error_msg[] = '住所が入力されていません。';
    }
    if (!isset($_POST['saved_phone']) && empty($phone_number)) {
        $error_msg[] = '電話番号が正しく入力されていません。';
    }
    $pr_index = intval(substr($_POST['prefecture'], strlen('pr')));
    if (0 > $pr_index || count(PREFECTURES_JP) <= $pr_index) {
        $error_msg[] = '都道府県に不正な値が設定されています。';
    }

    if (count($error_msg) == 0) {
        // Get name of user
        try {
            $sql = 'SELECT name FROM user_login WHERE id=?';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        try {
            $user_name = $user['name'];
            $label = substr($address_label, strlen('address_'));
            $postcode = $postcode1 . $postcode2;
            $prefecture = PREFECTURES_JP[$pr_index];
            if (!isset($_POST['saved_phone'])) {
                $label = substr($phone_label, strlen('phone_'));
                $phone_id = add_phone($db, $user_id, $label, $phone_number);
            } else {
                $phone_id = substr($_POST['phone_id'], strlen('phone_'));
            }
            add_address($db, $user_id, $label, $user_name, $postcode, $prefecture, $address, $phone_id);
            echo '<div class="content-wrapper">';
            echo '<p>住所を追加しました</p>';
            echo '<p><a hreF="address_list.php">住所一覧</a></p>';
            require_once __DIR__ . '/../../inc/footer.php';
            echo '</div>';
            exit();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

try {
    $sql = 'SELECT id, label, phone_number FROM user_phone';
    $stmt = $db->prepare($sql);
    $stmt->execute();
} catch (Exception $e){
    echo $e->getMessage();
}
$record = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content-wrapper">
  <h2>住所登録</h2>
    <?php if (count($error_msg) > 0) {
        foreach ($error_msg as $msg) {
            echo '<p>' . $msg . '</p>';
        }
    } ?>
  <p><a href="gift_address.php">ギフト用の住所を登録</a></p>
  <form method="post" action="address_form.php">
    <div class="select-wrapper">
      <select name="address_label">
        <option value="address_home">自宅</option>
        <option value="address_office">会社</option>
        <option value="address_other">その他</option>
      </select>
    </div>
  <label for="postcode1">郵便番号</label>
    <input type="text" name="postcode1" class="postcode1">
    -
    <input type="text" name="postcode2" class="postcode2">
  <p>都道府県</p>
  <div class="select-wrapper">
    <select name="prefecture">
      <?php for ($i = 0; $i < count(PREFECTURES_JP); $i++) {
          echo '<option value="pr' . $i . '">' . PREFECTURES_JP[$i] . '</option>';
      } ?>
    </select>
  </div>
  <label for="address">住所</label>
  <input type="text" name="address" class="address">
  <p>電話番号</p>
  <!-- display the option to chose from saved phone number -->
  <?php if (count($record) > 0) : ?>
    <input type="checkbox" name="saved_phone"><span>以前使用した番号から選ぶ</span>
    <div class="select-wrapper">
      <select name="phone_id">
        <?php
        foreach ($record as $phone) {
            echo '<option value=phone_' . $phone['id'] . '>' .
            PHONE_LABEL[$phone['label']] . ': ' . $phone['phone_number'] .'</option>';
        } ?>
      </select>
    </div>
  <?php endif; ?>
    <div class="select-wrapper">
      <select name="phone_label">
        <option value="phone_home">自宅</option>
        <option value="phone_mobile">携帯</option>
        <option value="phone_office">会社</option>
        <option value="phone_other">その他</option>
      </select>
    </div>
    <input type="text" name="phone_number">
    <div><input type="submit" name="add_address" value="送信"></div>
  </form>
</div>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
