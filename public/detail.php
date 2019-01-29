<?php
require_once __DIR__ . '/../inc/bootstrap.php';
require_once __DIR__ . '/../inc/search_field.php';

$product_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (empty($product_id)) {
    header('Location: /index.php');
    exit();
}

$product = get_product_info($db, $product_id);
if (!$product) {
    echo '<p>商品が見つかりませんでした。</p>';
    exit();
}

$details = get_product_details($db, $product_id, $product['category']);
?>
<div class="details-container">
  <h2>詳細</h2>
  <table>
    <tr>
      <td class="p-label">名前</td><td class="p-content"><?php echo $product['name']; ?></td>
    </tr>
    <tr>
      <td class="p-label">価格</td><td class="p-content"><?php echo number_format($product['price']); ?>円</td>
    </tr>
    <?php if ($product['category'] == 'books'): ?>
      <tr>
        <td class="p-label">著者</td><td class="p-content"><?php echo $details['author']; ?></td>
      </tr>
      <tr>
        <td class="p-label">出版社</td><td class="p-content"><?php echo $details['publisher']; ?></td>
      </tr>
      <tr>
        <td class="p-label">フォーマット</td><td class="p-content"><?php echo BOOK_FORMAT[$details['format']]; ?></td>
      </tr>
    <?php elseif ($product['category'] == 'electronics'): ?>
      <tr>
        <td class="p-label">ブランド</td><td class="p-content"><?php echo $details['brand']; ?></td>
      </tr>
      <tr>
        <td class="p-label">型番</td><td class="p-content"><?php echo $details['model_number']; ?></td>
      </tr>
    <?php elseif ($product['category'] == 'groceries'): ?>
      <tr>
        <td class="p-label">メーカー</td><td class="p-content"><?php echo $details['brand']; ?></td>
      </tr>
    <?php endif; ?>
      <tr>
        <td colspan="2" class="p-content"><a href="/cart.php?id=<?php echo $product_id;?>">カートに入れる</a></td>
      </tr>
  </table>
</div>
<?php
require_once __DIR__ . '/../inc/footer.php';
?>
