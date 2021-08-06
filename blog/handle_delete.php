<?php
  session_start();
  require_once("conn.php");
  require_once("utils.php");
  // 權限檢查
  require_once("check_permission.php");

  // 如果沒帶 id，就導回首頁
  if (empty($_GET['id'])) {
    header("index.php");
    exit;
  }

  // 到 db 刪除資料
  $id = $_GET['id'];
  $sql = "update jackie_blog_posts set is_deleted=1 where id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  header("Location: admin.php");
  exit;
?>