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
    // 導回編輯頁面並帶上 errCode: 2 (標題或內文不可留空)
    $id = intval($_POST['id']);
    header("Location: edit.php?errCode=2&id={$id}");
    exit;
  }

  // 把表單資料存進 db
  $id = ($_POST['id']);
  $title = $_POST['title'];
  $content = $_POST['content'];
  $previous_page = $_POST['page'];

  $sql = "update jackie_blog_posts set title=?, content=? where id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssi', $title, $content, $id);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  header("Location: {$previous_page}");
  exit;
?>