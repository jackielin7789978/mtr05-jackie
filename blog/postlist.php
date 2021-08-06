<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");

  $sql = "SELECT * from jackie_blog_posts WHERE is_deleted is null ORDER BY id desc";
  $stmt = $conn->prepare($sql);
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
  <title>文章列表 | Jackie's Blog</title>
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
  <section class="list">
    <?php while ($row = $result->fetch_assoc()) { ?>
    <div class="list__card">
      <a href="post.php?id=<?php echo escape($row['id']); ?>" class="list__card__title"><?php echo escape($row['title']); ?></a>
      <div class="list__card__info">
        <span class="list__card__info__time"><?php echo escape($row['created_at']); ?></span>
      </div>
    </div>
    <?php } ?>
  </section>
  <footer>Copyright© 2021 Jackie's Blog All Rights Reserved.</footer>
</body>
</html>