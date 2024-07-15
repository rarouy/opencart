<?php
include 'Connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure the path is correct for your setup

function sendResetEmail($email, $token) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'teara269@gmail.com'; // Your Gmail address
        $mail->Password = 'nqaiaybnhlttfbvr'; // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // TCP port for TLS

        // Recipients
        $mail->setFrom('teara269@gmail.com', 'My Shop');
        $mail->addAddress($email);

        // Content
        $resetLink = "http://localhost/opencart/forgot_reset_password.php?token=$token";
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "To reset your password, click the following link: <a href=\"$resetLink\">Reset Password</a>";
        $mail->AltBody = "To reset your password, click the following link: $resetLink";

        $mail->send();
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

// Handle the password reset request
if (isset($_POST['btnreset'])) {
    $Email = $_POST['email'];

    // Check if the email exists
    $stmt = $conn->prepare("SELECT `user_name` FROM `tbl_user` WHERE `user_name` = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('s', $Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $expires = date("U") + 3600; // 1 hour expiration time

        // Insert the token into the database
        $stmt = $conn->prepare("INSERT INTO `password_resets` (`email`, `token`, `expires`) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('ssi', $Email, $token, $expires);

        if ($stmt->execute()) {
            // Send the password reset email
            sendResetEmail($Email, $token);
            echo '
            <div class="alert alert-success alert-dismissible" id="alert-success">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Success!</strong> A password reset link has been sent to your email.
            </div>
            ';
        } else {
            echo '
            <div class="alert alert-danger alert-dismissible" id="alert-danger">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Error!</strong> Could not process the request.
            </div>
            ';
        }
    } else {
        echo '
        <div class="alert alert-danger alert-dismissible" id="alert-danger">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Error!</strong> Email address not found.
        </div>
        ';
    }
}

// Handle the password reset process
if (isset($_POST['btnresetpassword'])) {
    $token = $_POST['token'];
    $Psw = $_POST['psw'];
    $Cpsw = $_POST['cfpsw'];

    if ($Psw === $Cpsw) {
        $hashedPsw = password_hash($Psw, PASSWORD_BCRYPT);

        $current_time = date("U");
        $stmt = $conn->prepare("SELECT `email` FROM `password_resets` WHERE `token` = ? AND `expires` >= ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('si', $token, $current_time);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $Email = $row['email'];

            $stmt = $conn->prepare("UPDATE `tbl_user` SET `user_password` = ? WHERE `user_name` = ?");
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param('ss', $hashedPsw, $Email);

            if ($stmt->execute()) {
                $stmt = $conn->prepare("DELETE FROM `password_resets` WHERE `token` = ?");
                if (!$stmt) {
                    die("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param('s', $token);
                $stmt->execute();

                echo '
                <div class="alert alert-success alert-dismissible" id="alert-success">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Success!</strong> Your password has been reset.
                </div>
                ';
                header('Refresh: 1; URL=login.php'); // Redirect after 1 second
            } else {
                echo '
                <div class="alert alert-danger alert-dismissible" id="alert-danger">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Error!</strong> Could not reset the password.
                </div>
                ';
            }
        } else {
            echo '
            <div class="alert alert-danger alert-dismissible" id="alert-danger">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>Error!</strong> Invalid or expired token.
            </div>
            ';
        }
    } else {
        echo '
        <div class="alert alert-danger alert-dismissible" id="alert-danger">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Error!</strong> Passwords do not match.
        </div>
        ';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forgot / Reset Password</title>
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
            <?php if (!isset($_GET['token'])) { ?>
                <p class="login-box-msg">Forgot your password? Enter your email to receive a reset link.</p>
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" name="btnreset" style="width: 300px;">Send Reset Link</button>
                    </div>
                </form>
            <?php } else { ?>
                <p class="login-box-msg">Enter your new password.</p>
                <form method="post">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="New Password" name="psw" required>
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
                    <div class="col-8 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-block" name="btnresetpassword" style="width: 300px;">Reset Password</button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
<script>
    $(document).ready(function () {
        $('#confirmDelete').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    });

    $("#alert-success").fadeTo(1000, 500).slideUp(300, function(){
        $("#alert-success").slideUp(500);
        window.location=("forgot_reset_password.php");
    });
</script>
