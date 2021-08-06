<?php
  $lifetime = 3600;
  $path = "/mtr04group1/jackie/week11/hw2";
  session_set_cookie_params($lifetime, $path);
  session_start();
  require_once("conn.php");

  // 表單驗證，沒填資料回傳 errCode 1 (請輸入帳號及密碼)
  if (
    empty($_POST['username']) || 
    empty($_POST['password'])
  ) {
    header("Location: login.php?errCode=1");
    exit;
  }

  // 查詢使用者名稱
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = "SELECT * from jackie_blog_admin WHERE username=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  // 查無使用者 → 導回登入頁面 (errCode=2 帳號或密碼有誤)
  if (!$row) {
    header("Location: login.php?errCode=2");
    exit;
  }
  // 查到使用者 → 核對密碼
  if (password_verify($password, $row['password'])) {
    session_set_cookie_params($lifetime, $path);
    session_regenerate_id();
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit;
  } else {
    // 密碼錯誤 → 導回登入頁面 (errCode=2 帳號或密碼有誤)
    header("Location: login.php?errCode=2");
    exit;
  }
?>