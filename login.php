<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrapLogin.css">

    <style>
        body {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <?php
include("config/connect.php"); // connection to database
include("includes/checks.php"); // for PWS dictionary

if (isset($_SESSION["user_id"])) // if already logged in
{
	header("refresh:0;url=market.php"); // redirect to market.php page
}

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!empty($_POST['submit'])) {
            // Update the query to also select the email_verified field
            $loginquery = "SELECT u_id, password, email_verified FROM users WHERE username='$username'";
            $result = mysqli_query($db, $loginquery);
            $row = mysqli_fetch_array($result);

            // First check if the user is found and then if the email is verified
            if ($row && password_verify($password, $row['password'])) {
                if ($row['email_verified']) {
                    $_SESSION['user_id'] = $row['u_id'];
                    $_SESSION['loginStatus'] = true;
                    $_SESSION['pricesCheck'] = new PricesCheck();
                    $_SESSION['pricesCheck']->Refresh($db);

                    header("refresh:1;url=market.php");
                } else {
                    $message = "You must verify your email to log in.";
                }
            } else {
                $message = "Invalid Username or Password!";
            }
        }
    }

    ?>
  
    <section>
        <div class="container-fluid">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="images/logo.png" class="img-fluid" alt="Sample image" style="width: 100%; height: 100%">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form class="login-form" action="" method="POST">
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <h1 class="fw-normal mb-0 me-3">Customer Login Form</h1>
                        </div>
                        <hr>
                        <div class="alertCSS"><?php echo $message ?></div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="name">Username</label>
                            <input type="text" id="name" name="username" class="form-control form-control-lg" placeholder="Enter a valid username" />
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-3">
                            <label class="form-label" for="txtPass">Password</label>
                            <input type="password" id="txtPass" name="password" value="123456" class="form-control form-control-lg" placeholder="Enter password" />
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <a href="forgot_password.php" class="text-body">Forgot password?</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <input type="submit" value="Login" name="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">
                            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="registration.php" class="link-danger">Register</a> or <a href="portal.php" class="link-danger">return to login portal</a>.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
