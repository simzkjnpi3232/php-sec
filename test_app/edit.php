<?php
require_once('functions.php');
$todo = getSelectedTodo($_GET['id']);
setToken(); // 追記
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>編集</title>
</head>
<body>
  <!-- 追記 -->
  <?php if (!empty($_SESSION['err'])): ?>
    <p><?= $_SESSION['err']; ?></p>
  <?php endif; ?>
  <form action="store.php" method="post">
    <!-- 追記 -->
    <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
    <input type="hidden" name="id" value="<?= e($_GET['id']); ?>">
    <input type="text" name="content" value="<?= e($todo); ?>">
    <input type="submit" value="更新">
  </form>
  <div>
    <a href="index.php">一覧へもどる</a>
  </div>
  <!-- 追記 -->
  <?php unsetError(); ?>
</body>
</html>

<!-- 更新前データ取得
getSelectedTodo()編集ページのテキストボックスに更新前の入力値を表示するためにデータを取得する処理
→functions.php
-->
<!-- 表示内容
  -->
