<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");

  $id = null;
  if (empty($_GET['id'])) {
    header("Location: index.php");
    exit;
  }
  $id = $_GET['id'];
  $sql = "SELECT * from jackie_blog_posts WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>文章標題 | Jackie's Blog</title>
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
  <section class="post">
    <div class="post__card">
      <div class="post__card__title">
        <?php echo escape($row['title']); ?>
      </div>
      <div class="post__card__info">
        <?php echo escape($row['created_at']); ?>
      </div>
      <div class="post__card__content">
        <?php echo ($row['content']); ?>
      </div>
    </div>
  </section>
  <footer>Copyright© 2021 Jackie's Blog All Rights Reserved.</footer>

  <script src="build/ckeditor.js"></script>
  <script>
  ClassicEditor.create( document.querySelector( '#editor' ), {
    // 這裡可以設定 plugin
  })
    .then( editor => {
      console.log( 'Editor was initialized', editor );
    })
    .catch( err => {
      console.error( err.stack );
    });
  </script>
</body>
</html>