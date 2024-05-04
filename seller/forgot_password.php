<?php
include("../config/connect.php"); 
require '../vendor/autoload.php'; 

$message = '';
if (isset($_POST['forgotPassword'])) {
    $email = $_POST['email'];
    $query = "SELECT * FROM admin WHERE email = '$email'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        $token = bin2hex(random_bytes(50));
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $updateToken = "UPDATE admin SET email_token = '$token', token_expiration = '$expiration' WHERE email = '$email'";
        if (mysqli_query($db, $updateToken)) {
            require 'send_reset_email.php';
            if (sendResetEmail($email, $token)) {
                $message = "<div class='alert alert-success' role='alert'>Reset link has been sent to your email address.</div>";
            } else {
                $message = "<div class='alert alert-danger' role='alert'>Failed to send reset link.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger' role='alert'>Error updating token information.</div>";
        }
    } else {
        $message = "<div class='alert alert-warning' role='alert'>No account found with that email address.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../css/bootstrapLogin.css" />
</head>
<body>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="../images/logo.png" class="img-fluid" alt="Logo" style="width: 100%; height: 100%" />
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form class="login-form" action="" method="POST">
                    <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                        <h1 class="fw-normal mb-0 me-3">Forgot Password</h1>
                    </div>
                    <hr />
                    <?php echo $message; ?>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Enter your email address" required />
                    </div>
                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" name="forgotPassword" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Reset Password</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">Remembered your password? <a href="index.php" class="link-danger">Login here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
