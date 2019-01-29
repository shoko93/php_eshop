<?php
require_once __DIR__ . '/../inc/bootstrap.php';
require_once __DIR__ . '/../inc/search_field.php';

try {
    $products = get_random_items($db);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
<div class="container">
  <h2>Welcome!</h2>
  <p>Use the search box to search for more products.</p>
  <table>
    <?php foreach ($products as $product): ?>
      <tr>
        <td class="td-name">
          <a href="detail.php?id=<?php echo $product['id'];?>">
            <?php echo $product['name'];?></a>
        </td>
        <td class="td-cat">[<?php echo CATEGORY_DISP_NAME[$product['category']];?>]</td>
        <td class="td-price"><?php echo number_format($product['price']);?>円</td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php
require_once __DIR__ . '/../inc/footer.php';
?>
