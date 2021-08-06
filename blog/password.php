<!-- 沒有用處 記得刪掉 -->
<?php
  session_start();
  require_once("conn.php");

  $sql = "update jackie_blog_admin set password=? where id=1";
  $stmt = $conn->prepare($sql);
  $password = password_hash("jackie", PASSWORD_DEFAULT);
  $stmt->bind_param('s', $password);
  $result = $stmt->execute();
  // header("Location: index.php");
?>