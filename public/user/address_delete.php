<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';

if (isset($_POST['go_to_list'])) {
    header('Location: /user/address_list.php');
}

if (isset($_POST['address_delete_conf'])) {
    try {
        delete_user_address($db, $_SESSION['address_id']);
    } catch (Exception $e) {
        echo 'アドレスの削除: ';
        echo $e->getMessage();
    }
    try {
        delete_user_phone($db, $_SESSION['phpe_id']);
        echo '<div class="content-wrapper">';
        echo '<p>住所を削除しました</p>';
        echo '<p><a href="address_list.php">住所一覧に戻る</a></p>';
        echo '</div>';
        require_once __DIR__ . '/../../inc/footer.php';
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user_id = $_SESSION['user_id'];
    if (!isset($_GET['address']) || intval($_GET['address']) == 0) {
        header('Location: /address/address_list.php');
    }
    $_SESSION['address_id'] = intval($_GET['address']);
}

$address_id = $_SESSION['address_id'];
try {
    $address = get_user_address($db, $address_id);
} catch (Exception $e) {
    echo $e->getMessage();
}

$phone_id = $address['phone_id'];
try {
    $phone = get_user_phone($db, $phone_id);
} catch (Exception $e) {
    echo $e->getMessage();
}
$_SESSION['phone_id'] = $phone_id;
?>
<div class="content-wrapper">
  <p>この住所を削除します。よろしいですか？</p>
  <table>
    <?php if ($address['gift']): ?>
      <tr><td>宛名</td><td><?php echo $address['name_to']; ?></td></tr>
    <?php endif; ?>
    <tr><td>郵便番号</td><td><?php echo $address['postcode']; ?></td></tr>
    <tr><td>都道府県</td><td><?php echo $address['prefecture']; ?></td></tr>
    <tr><td>住所</td><td><?php echo $address['address']; ?></td></tr>
    <tr><td>電話番号</td><td><?php echo $phone['phone_number']; ?></td></tr>
  </table>
  <form method="post" action="address_delete.php">
    <input type="submit" name="address_delete_conf" value="はい">
    <input type="button" onclick="window.location.href='address_list.php'" value="戻る">
  </form>
</div>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
