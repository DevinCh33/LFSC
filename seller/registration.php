<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" />
    <link rel="stylesheet prefetch" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900" />
    <link rel="stylesheet prefetch" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/login.css" />
    <link rel="icon" type="image/png" sizes="16x16" href="landing/logo.png" />
    <?php
    // Conditional meta tag for redirection
    if (isset($_POST['register']) && isset($success) && $success === true) {
        echo '<meta http-equiv="refresh" content="5;url=login.php">';
    }
    ?>
</head>

<body>

    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include("connect.php");
    require '../vendor/autoload.php';
    require 'send_verification_email.php';

    $message = '';
    $success = false;

    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $code = 'SUPP';
        $u_role = 'SELLER';
        $token = bin2hex(random_bytes(50));

        $checkUser = "SELECT * FROM admin WHERE username='$username' OR email='$email'";
        $result = mysqli_query($db, $checkUser);
        if (mysqli_num_rows($result) > 0) {
            $message = "Username or Email already exists!";
        } else {
			$shopQuery = "INSERT INTO restaurant () VALUES ()";
			$result = mysqli_query($db, $shopQuery);
			$rs_id = mysqli_insert_id($db);
			
            $registerQuery = "INSERT INTO admin (username, email, password, code, u_role, email_token,store, email_verified) VALUES ('$username', '$email', '$password', 'SUPP', 'SELLER', '$token','$rs_id', 0)";

            if (mysqli_query($db, $registerQuery)) {
                if (sendVerificationEmail($email, $token)) {
                    $message = "Registration successful! Please check your email to verify.";
                    $success = true;
                } else {
                    $message = "Registration successful but failed to send verification email.";
                }
            } else {
                $message = "Error: " . mysqli_error($db);
            }
        }
    }
    ?>

    <div class="pen-title">
        <h1>Registration Form</h1>
    </div>

    <div class="module form-module">
        <div class="form">
            <h2>Create a seller account</h2>
            <span style="color:red;"><?php echo $message; ?></span>
            <form action="" method="post">
                <input type="text" placeholder="Username" name="username" required />
                <input type="email" placeholder="Email" name="email" required />
                <input type="password" placeholder="Password" name="password" required />
                <input type="submit" name="register" value="Register" />
            </form>
        </div>
        <div class="cta">
            Already registered?<a href="index.php" style="color:#f30;"> Login here</a>
        </div>
    </div>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</body>
</html>
