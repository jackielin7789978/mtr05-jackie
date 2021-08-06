<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");

  // 設定每一頁的留言數量和 offset 值
  $page = 1;
  if(!empty($_GET['page'])) {
    $page = intval($_GET['page']);
  }
  $items_per_page = 5;
  $offset = ($page - 1) * $items_per_page;

  // 根據頁數抓取文章 (id, comment, created_at, nickname 和 username)
  $sql = "SELECT * from jackie_blog_posts where is_deleted is null ORDER BY id desc limit ? offset ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ii', $items_per_page, $offset);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jackie's Blog</title>
  <link rel="stylesheet" href="normalize.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php include_once("header.php"); ?>
  <section class="banner">
    <div class="title-wrapper">
      <h1 class="banner__title">存放笑話之地</h1>
      <div class="banner__welcome">Welcome to my blog</div>
    </div>
  </section>
  <section class="posts">
    <?php while ($row = $result->fetch_assoc()) { ?>
      <div class="posts__card">
        <a href="post.php?id=<?php echo escape($row['id']); ?>" class="posts__card__title"><?php echo escape($row['title']); ?></a>
        <?php if (!empty($_SESSION['username'])) { ?>
          <a href="edit.php?id=<?php echo escape($row['id']); ?>" class="posts__card__edit-btn">編輯</a>
        <?php } ?>
        <div class="posts__card__info">
          <span class="posts__card__info__time"><?php echo escape($row['created_at']); ?></span>
        </div>
        <div class="posts__card__content__wrapper">
          <div class="posts__card__content">
            <?php echo substr($row['content'], 0, 100);?>
          </div>
        </div>
        <div class="posts__card__more-btn">
          <a href="post.php?id=<?php echo escape($row['id']); ?>">READ MORE</a>
        </div>
      </div>
    <?php } ?>
  </section>
  <?php
    // 取得總留言數
    $sql = "SELECT count(id) as count from jackie_blog_posts where is_deleted is null";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];
    $total_page_num = ceil($count / $items_per_page);
  ?>
  <section class="page">
    <div class="page__info">
      <span>總共有 <?php echo($count); ?> 篇文章，頁數：</span>
      <span><?php echo($page); ?> / <?php echo($total_page_num); ?></span>
    </div>
    <div class="page__paginator">
      <?php if ($page != 1) {?>
        <a href="index.php?page=1">首頁</a>
        <a href="index.php?page=<?php echo($page - 1) ?>">上一頁</a>
      <?php } ?>
      <?php if ($page != $total_page_num) { ?>
        <a href="index.php?page=<?php echo($page + 1) ?>">下一頁</a>
        <a href="index.php?page=<?php echo($total_page_num) ?>">最後一頁</a>
      <?php } ?>
    </div>
  </section>
  <footer>Copyright© 2021 Jackie's Blog All Rights Reserved.</footer>
</body>
</html>