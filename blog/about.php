<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>關於我 | Jackie's Blog</title>
  <link rel="stylesheet" href="normalize.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php include_once("header.php"); ?>
  <section class="banner">
    <div class="title-wrapper">
      <h1 class="banner__title">存放笑話之地 - 後台</h1>
      <div class="banner__welcome">Welcome to my blog</div>
    </div>
  </section>
  <img id="todd" src="todd.gif" alt="todd">
</body>
<footer>Copyright© 2021 Jackie's Blog All Rights Reserved.</footer>
</html>