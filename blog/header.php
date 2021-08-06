<?php
  require_once("conn.php");
  require_once("utils.php");

  $uri = $_SERVER['REQUEST_URI'];
  $is_admin_page = strpos($uri, 'admin.php') !== false;
?>
<header class="nav">
    <div class="wrapper">
      <div class="wrapper__flex">
        <a class="nav__sitename" href="index.php">Jackie's Blog</a>
        <div class="nav__navbar">
          <a href="postlist.php">文章列表</a>
          <a href="#">分類專區</a>
          <a href="about.php">關於我</a>
        </div>
      </div>
      <div class="nav__navbar--admin">
        <?php if (!empty($_SESSION['username'])) { ?>
          <?php if ($is_admin_page === true) { ?>
            <a href="add.php">新增文章</a>
            <a href="handle_logout.php">登出</a>
          <?php }else { ?>
          <a href="admin.php">管理後台</a>
          <a href="handle_logout.php">登出</a>
          <?php } ?>
        <?php }else { ?>
          <a href="login.php">登入</a>
        <?php } ?>
      </div>
    </div>
</header>