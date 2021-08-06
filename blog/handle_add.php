<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");
  // 權限檢查
  require_once("check_permission.php");

  // 表單驗證
  if (
    empty($_POST['title']) ||
    empty($_POST['content'])
  ) {
    // 導回編輯頁面並帶上 errCode: 2 (標題和內文不可留空)
    header("Location: edit.php?errCode=2");
    exit;
  }

  // 把表單資料存進 db
  $title = $_POST['title'];
  $content = $_POST['content'];

  $sql = "insert into jackie_blog_posts(title, content) values(?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $title, $content);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  header("Location: admin.php");
  exit;
?>