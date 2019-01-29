<?php
require_once __DIR__ . '/../inc/bootstrap.php';
require_once __DIR__ . '/../inc/search_field.php';
require_once __DIR__ . '/../procedures/addItem.php';

if (isset($_POST['delete']) || isset($_POST['update'])) {
    require_once __DIR__ . '/../procedures/updateCart.php';
}
?>
<div class="content-wrapper">
  <h2>ショッピングカート</h2>
  <form method='post' action='/cart.php'>
  <?php for ($i = 0; $i < count($cart); $i++): ?>
    <div>
      <input type="checkbox" name="remove<?php echo $i; ?>">
      <label for="quantity<?php echo $i; ?>" class="cart-title"><?php
        echo $product_names[$i]; ?></label>
      <input type="number" name="quantity<?php echo $i; ?>" class="cart-quantity"
             min="1" max="10" value="<?php echo $quantity[$i]; ?>">
      <?php echo number_format($prices[$i] * $quantity[$i]) . '円'; ?>
    </div>
  <?php endfor; ?>
    <div style="margin-top: 20px">
      <input type="submit" name="delete" value="選択した項目を削除">
      <input type="submit" name="update" value="注文数を更新">
    </div>
  </form>
  <p><a href="/order_branch.php">購入手続きに進む</a></p>
</div>
<?php
require_once __DIR__ . '/../inc/footer.php';
?>
