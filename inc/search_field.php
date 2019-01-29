<?php
require_once __DIR__ . '/connection.php';
try {
    $categories = get_categories($db);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
<div class="search-field">
  <form method="get" action="list.php">
    <select name="category">
      <option value="cat0">全カテゴリー</option>
      <?php for ($i = 0; $i < count($categories); $i++) {
        $category = $categories[$i];
        echo '<option value="cat' . ($i + 1) . '">' . CATEGORY_DISP_NAME[$category['name']] . '</option>';
      } ?>
    </select>
    <input type="text" name="s">
    <input type="submit" value="検索">
  </form>
</div>
