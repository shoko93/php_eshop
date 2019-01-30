<?php
require_once __DIR__ . '/../inc/bootstrap.php';
require_once __DIR__ . '/../inc/search_field.php';

$num  = 10;
$offset = 0;

try {
    $sql = 'SELECT products.id AS id, products.name AS name,
                   categories.name AS category, price FROM products
            JOIN categories ON products.category_id = categories.id';

    if (isset($_GET['s']) && !empty($_GET['s'])) {
        $search = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRING);
        $sql .= ' WHERE products.name LIKE ?';
    }

    if (isset($_GET['category'])) {
        $category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_STRING);
        if (!empty($category) && intval($category{3}) > 0) {
            $category_id =  intval($category{3});
            if (isset($search)) {
                $sql .= ' AND category_id = ?';
            } else {
                $sql .= ' WHERE category_id = ?';
            }
        }
    }

    $sql .= ' ORDER BY products.name LIMIT ? OFFSET ?';

    if (isset($_GET['page'])) {
        $offset = $num * (intval($_GET['page']) - 1);
    }
    $stmt = $db->prepare($sql);
    if (isset($search)) {
        $stmt->bindValue(1, '%'.$search.'%', PDO::PARAM_STR);
        if (isset($category_id)) {
            $stmt->bindValue(2, $category_id, PDO::PARAM_INT);
            $stmt->bindValue(3, $num, PDO::PARAM_INT);
            $stmt->bindValue(4, $offset, PDO::PARAM_INT);
        } else {
            $stmt->bindValue(2, $num, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        }
    } else if (isset($category_id)) {
        $stmt->bindValue(1, $category_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $num, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
    } else {
        $stmt->bindValue(1, $num, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    }
    $stmt->execute();
} catch (Exception $e) {
    echo $e->getMessage();
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($search) && isset($category_id)) {
    $sql  = 'SELECT COUNT(*) FROM products WHERE name LIKE ? AND category_id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $search, PDO::PARAM_STR);
    $stmt->bindValue(2, $category_id, PDO::PARAM_INT);
} else if (isset($search)) {
    $sql  = 'SELECT COUNT(*) FROM products WHERE name LIKE ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $search, PDO::PARAM_STR);
} else if (isset($category_id)) {
    $sql  = 'SELECT COUNT(*) FROM products WHERE category_id = ?';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $category_id, PDO::PARAM_INT);
} else {
    $sql = 'SELECT COUNT(*) FROM products';
    $stmt = $db->prepare($sql);
}
$stmt->execute();
$records = $stmt->fetchColumn();
$max_page = ceil($records/$num);
?>
<div class="container">
  <h2>検索結果</h2>
  <table>
    <?php foreach ($products as $product): ?>
      <tr>
        <td class=="td_date"><?php echo $product['r_date'];?></td>
        <td class="td-name">
          <a href="detail.php?id=<?php echo $product['id'];?>">
            <?php echo $product['name'];?></a>
        </td>
        <td class="td-cat">[<?php echo CATEGORY_DISP_NAME[$product['category']];?>]</td>
        <td class="td-price"><?php echo number_format($product['price']);?>円</td>
      </tr>
    <?php endforeach; ?>
  </table>
  <div class="pagination" style="text-align:center;">
  <?php
  echo '<p>';
  for ($i = 1; $i <= $max_page; $i++) {
      $link = 'list.php?page=' . $i;
      if (isset($search)) {
          $link .= '&s='. $search;
      }
      if (isset($category_id)) {
          $link .= '&category=cat' . $category_id;
      }
      echo '<a href="' . $link . '">' . $i . '</a>&nbsp;';
  }
  echo '</p>';
  ?>
  </div>
</div>
<?php include('inc/footer.php'); ?>
