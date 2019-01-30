<?php
require_once __DIR__ . '/../../inc/bootstrap.php';
require_once __DIR__ . '/../login/logincheck.php';

try {
    $sql = 'SELECT id, shipped FROM order_record WHERE user_id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $_SESSION['user_id']);
    $stmt->execute();
} catch (Exception $e) {
    echo $e->getMessage();
}

$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content-wrapper">
  <h2>注文履歴</h2>
  <?php foreach($orders as $order): ?>
    <p>注文ID: <?php echo $order['id']; ?>
      <?php if ($order['shipped']) {
          echo ' (発送済み)';
      } else {
          echo ' (未発送)';
      }?>
    </p>
    <table>
    <?php
        try {
            $sql = 'SELECT * FROM order_product WHERE order_id = ?';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $order['id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($products as $product):
            try {
                $sql = 'SELECT name, price FROM products WHERE id = ?';
                $stmt = $db->prepare($sql);
                $stmt->bindValue(1, $product['product_id'], PDO::PARAM_INT);
                $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            $product_detail = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <tr>
          <td><?php echo $product_detail['name'];?> * </td>
          <td><?php echo $product['quantity'];?></td>
          <td> :<?php echo number_format($product_detail['price'] * $product['quantity']);?>円</td>
        </tr>
        <?php endforeach; ?>
    </table>
  <?php endforeach;?>
</div>
<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
