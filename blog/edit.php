<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");
  require_once("check_permission.php");

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
  <title>編輯文章 | Jackie's Blog</title>
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
  <section class="editor">
    <form method="POST" action="handle_edit.php" class="editor__form">
      <div class="editor__form__title">發表文章：</div>
      <?php
        if (!empty($_GET['errCode'])) {
          $msg = '';
          $errCode = $_GET['errCode'];
          switch($errCode) {
            case '2':
              $msg = '標題或內文不可留空';
              break;
          }
          echo('<h3 class="error">' . $msg . '</h3>');
        }
      ?>
      <input type="number" class="hide" name="id" value="<?php echo escape($row['id']); ?>">
      <input type="text" class="hide" name="page" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
      <input type="text" placeholder="請輸入文章標題" name="title" value="<?php echo escape($row['title']); ?>">
      <textarea id="editor" name="content" placeholder="請在這裡填寫內容"><?php echo $row['content']; ?></textarea>
      <input type="submit" value="送出文章">
    </form>
  </section>
  <footer>Copyright© 2021 Jackie's Blog All Rights Reserved.</footer>

  <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
  <script>
    ClassicEditor
      .create( document.querySelector( '#editor' ) )
      .then( editor => {
              console.log( editor );
      } )
      .catch( error => {
              console.error( error );
      } );
  </script>
</body>
</html>