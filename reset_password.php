<?php
include("config/connect.php");  
require 'vendor/autoload.php';

$message = '';
$redirect = false;
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists and is not expired
    $query = "SELECT * FROM users WHERE email_token = '$token' AND token_expiration > NOW()";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (isset($_POST['updatePassword'])) {
            $newPassword = mysqli_real_escape_string($db, $_POST['password']);
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateQuery = "UPDATE users SET password = '$hashedPassword', email_token = NULL, token_expiration = NULL WHERE email_token = '$token'";
            if (mysqli_query($db, $updateQuery)) {
                $message = "<div class='alert alert-success' role='alert'>Your password has been updated successfully. You will be redirected back to the login page in 3 seconds.</div>";
                $redirect = true;
            } else {
                $message = "<div class='alert alert-danger' role='alert'>Failed to update your password. Please try again.</div>";
            }
        }
    } else {
        $message = "<div class='alert alert-danger' role='alert'>Invalid or expired token!</div>";
    }
} else {
    $message = "<div class='alert alert-danger' role='alert'>No token provided!</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/bootstrapLogin.css" />
    <?php if ($redirect) {
        echo '<meta http-equiv="refresh" content="3;url=login.php">';
    } ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="images/logo.png" class="img-fluid" alt="Logo" style="width: 100%; height: 100%" />
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form class="login-form" action="" method="POST">
                    <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                        <h1 class="fw-normal mb-0 me-3">Reset Password</h1>
                    </div>
                    <hr />
                    <?php echo $message; ?>
                    <?php if (!$redirect): ?>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">New Password</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter your new password" required />
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <input type="submit" name="updatePassword" value="Update Password" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" />
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
