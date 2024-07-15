<?php 
include 'Connect.php';

if (isset($_REQUEST['btnregister'])) {
    $Name = $_REQUEST['fname'];
    $Email = $_REQUEST['email'];
    $Psw = $_REQUEST['psw'];
    $Cpsw = $_REQUEST['cfpsw'];

    // Prepare a statement to check if the email already exists
    $stmt = $conn->prepare("SELECT `user_name` FROM `tbl_user` WHERE `user_name` = ?");
    $stmt->bind_param('s', $Email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user already exists
    if ($result->num_rows > 0) {
        echo '
        <div class="alert alert-danger alert-dismissible" id="alert-danger">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Error!</strong> Please choose another username.
        </div>
        ';
    } elseif ($Psw !== $Cpsw) {
        echo '
        <div class="alert alert-danger alert-dismissible" id="alert-danger">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Error!</strong> Passwords do not match.
        </div>
        ';
    } else {
        // Hash the password
        $hashedPsw = password_hash($Psw, PASSWORD_BCRYPT);

        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO `tbl_user` (`name`, `user_name`, `user_password`, `user_role`, `remember_token`) VALUES (?, ?, ?, '', '')");
        $stmt->bind_param('sss', $Name, $Email, $hashedPsw);

        if ($stmt->execute()) {
            echo '
            <div class="alert alert-success alert-dismissible" id="alert-success">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Success!</strong> Data has been inserted.
            </div>
            <script>
                setTimeout(function() {
                    $("#uploadModal").modal("show");
                }, 1000);
            </script>
            ';
        } else {
            echo '
            <div class="alert alert-danger alert-dismissible" id="alert-danger">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Error!</strong> Data could not be inserted.
            </div>
            ';
        }
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body class="hold-transition login-page bg-dark">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b class="text-warning text-uppercase text-bold">my shop</b></a>
  </div>
  <div class="card">
    <div class="card-body login-card-body bg-danger">
      <p class="login-box-msg">Register to start your session</p>
      <form method="post" enctype="multipart/form-data">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full Name" name="fname" value="<?php echo htmlspecialchars($Name ?? '', ENT_QUOTES); ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email" name="email" value="<?php echo htmlspecialchars($Email ?? '', ENT_QUOTES); ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="psw" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirm Password" name="cfpsw" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="col-5 d-flex justify-content-center">
          <button type="submit" class="btn btn-primary btn-block" name="btnregister">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal for Image Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadModalLabel">Upload Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <label for=""><h1>Please Upload Image</h1> </label>
        <form id="imageUploadForm" action="upload_image.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="exampleInputFile">File input</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="txtimage" id="imgInp" accept="image/*" required>
                <label class="custom-file-label" for="imgInp">Choose file</label>
              </div>
              <div class="input-group-append">
                <span class="input-group-text" id="uploadBtn">Upload</span>
              </div>
            </div>
          </div>
        </form>
        <img id="imgbox" src="images/no-image.png" alt="" style="max-width:100%; height:258px;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="document.getElementById('imageUploadForm').submit();">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function () {
    $('#confirmDelete').on('show.bs.modal', function (e) {
      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });

    $('#alert-success').fadeTo(1000, 500).slideUp(300, function(){
      $('#alert-success').slideUp(500);
    });
    $("#alert-danger").fadeTo(1000, 500).slideUp(300, function(){
    $("#alert-danger").slideUp(500);
    window.location=("register.php");
      });
  });

  $('#uploadBtn').click(function() {
    $('#imgInp').click();
  });

  $('#imgInp').change(function() {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#imgbox').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
  });
</script>
</body>
</html>
