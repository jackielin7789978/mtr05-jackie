<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登入 | Jackie's Blog</title>
  <link rel="stylesheet" href="normalize.css"> 
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="card">
    <div class="card__title">Log In</div>
    <form class="card__login-form" action="handle_login.php" method="POST">
    <?php
        if (!empty($_GET['errCode'])) {
          $msg = '';
          $errCode = $_GET['errCode'];
          switch($errCode) {
            case '1':
              $msg = '請輸入帳號及密碼';
              break;
            case '2':
              $msg = '帳號或密碼有誤';
              break;
          }
          echo('<h3 class="error">' . $msg . '</h3>');
        }
    ?>
      <label for="username">USERNAME<br><input type="text" name="username" id="username"></label>
      <label for="password">PASSWORD<br><input type="password" name="password" id="password"></label>
      <input type="submit" value="SIGN IN">
    </form>
  </div>
</body>
</html>