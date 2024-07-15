<?php 
session_start();
include 'Connect.php';

// Check if already logged in
if (isset($_SESSION['HELLO'])) {
  header("Location: indexadmin.php");
  exit(); // Ensure that no further code is executed
}

if(isset($_REQUEST['btnlogin'])){
  $txtname = $conn->real_escape_string($_REQUEST['txtname']);
  $txtpsw = $conn->real_escape_string($_REQUEST['txtpsw']);
  $sql = "SELECT * FROM `tbl_user` WHERE user_name = '$txtname'";
  $qr = $conn->query($sql);
  $row = $qr->fetch_assoc();

  if($row && password_verify($txtpsw, $row['user_password'])){
    $_SESSION['HELLO'] = $row['user_id'];
    $_SESSION['USERROLE'] = $row['user_role']; // Store the user role in the session
    $_SESSION['USERNAME'] = $row['user_name'];
    $_SESSION['NAME'] = $row['name'];
   
    header("Location: indexadmin.php");
    exit(); // Ensure that no further code is executed
  } else {
    echo '<p class="text-white">Incorrect username or password</p>';
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page bg-dark">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b class="text-warning text-uppercase text-bold">my shop</b></a>
  </div>
  <div class="card">
    <div class="card-body login-card-body bg-danger">
      <p class="login-box-msg">Sign in to start your session</p>
      <form method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email" name="txtname" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="txtpsw" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3 d-flex justify-content-center">
        <a href="register.php">Register</a>
        <a class="ml-3" href="forgot_reset_password.php">Forget</a>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="btnlogin">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
