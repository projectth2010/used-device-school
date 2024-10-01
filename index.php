<?php
session_start();
include('my_function.php');
include('init_lang.php');

$submit = "";

$status = "OK";
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  if (empty($email)) {
    $msg .= "<center><font size='4px' face='Verdana' color='red'>{$labels['please_enter_email']}</font></center>";
    $status = "NOTOK";
  }

  if (empty($password)) {
    $msg .= "<center><font size='4px' face='Verdana' color='red'>{$labels['please_enter_password']}</font></center>";
    $status = "NOTOK";
  }

  if ($status == "OK") {
    include('db_connect.php');

    $stmt = $con->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

      $_SESSION['email'] = $row['email'];
      $_SESSION['key'] = mt_rand(1000, 9999);
      $_SESSION['user_type'] = $row['user_type'];

      header("location:dashboard.php");
      exit();
    } else {
      $msg = "<center><font size='4px' face='Verdana' color='red'>{$labels['wrong_email_or_password']}</font></center>";
    }

    $stmt->close();
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $labels['erp_goods'] ?> | <?= $labels['login'] ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<style>
  .logo-container {
    display: flex;
    align-items: center;
    /* Align images vertically in the center */
  }

  .logo-container img {
    margin-right: 10px;
    max-height: 128px;
    /* Adds some space between the images */
  }
</style>

<body class="hold-transition login-page">
  <div class="logo-container">
    <img src="dist/img/lg.png" /> 
  </div>
  <div class="login-box">
    <div class="login-logo">

    ตารางการใช้งาน<br/>นวัตกรรมการเรียนการสอน<br/>สำนักงานเขตบางแค <br />
      <!-- <b>ฟอร์มเข้าใช้ระบบ</b> -->
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg"><?= $labels['sign_in_to_start'] ?></p>

        <form action="index.php" method="post">
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="ผู้ใช้งานระบบ" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div>
            <div>
              <button type="submit" class="btn btn-primary btn-block">เข้าใช้งานระบบ</button>
            </div>
          </div>
          <?php
          if (!empty($msg)) {
            echo "<div align='center'>$msg</div>";
          }
          ?>
        </form>
      </div>
    </div>
  </div>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
</body>

</html>