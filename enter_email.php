<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet prefetch" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900">
    <link rel="stylesheet prefetch" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/png" sizes="16x16" href="landing/logo.png">

    <style type="text/css">
        #buttn {
            color: #fff;
            background-color: #ff3300;
        }

        #countdownMessage {
            display: none;
            color: blue; /* Choose your desired color */
        }
    </style>
</head>

<body>
    <?php
    session_start(); // temp session
    error_reporting(0); // hide undefined index errors
    include("connection/connect.php"); // connection to the database

    function obtainPriceDictionary($db)
    {
        $priceDictionary = [];
        $query = "SELECT product_id, price from product";
        $products = mysqli_query($db, $query); // executing

        if (!empty($products)) {
            foreach ($products as $product) {
                $priceDictionary[$product['product_id']] = $product['price'];
            }
        }

        $_SESSION['prices'] = $priceDictionary;
    }

    if (isset($_SESSION["user_id"])) // if already logged in
    {
        header("refresh:0;url=market.php"); // redirect to market.php page
    }

    if (isset($_POST['submit'])) // if submit button was pressed
    {
        $email = $_POST['email']; // fetch records from login form

        if (!empty($_POST['submit'])) // if records were not empty
        {
            // Check if the email exists in your database
            $check_email = mysqli_query($db, "SELECT u_id, email FROM users WHERE email='$email'");
            $row = mysqli_fetch_array($check_email);

            if (mysqli_num_rows($check_email) > 0) {
                // Generate a unique token for the password reset link
                $token = bin2hex(random_bytes(32));

                // Store the token and email in a temporary table (e.g., password_reset_tokens)
                $insert_token_query = "INSERT INTO password_reset_tokens (email, token) VALUES ('$email', '$token')";
                mysqli_query($db, $insert_token_query);

                // Send an email with the password reset link
                $reset_link = "forgotpassword.php?token=$token";
                $subject = "Password Reset";
                $message = "Click on the following link to reset your password: $reset_link";
                $headers = "From: yiling0177@gmail.com"; // Replace with your email address

                mail($email, $subject, $message, $headers);

                $success_message = "Password reset link has been sent to your email. Please check your inbox.";

                 // Output the message to be displayed on the page
                $countdown_message = "Email will be sent within";

                echo "<script>
                    var countdown = $countdown_time;
                    var countdownInterval = setInterval(function() {
                        var minutes = Math.floor(countdown / 60);
                        var seconds = countdown % 60;
                        document.getElementById('countdown').innerHTML = '$countdown_message ' + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
                        countdown--;

                        if (countdown < 0) {
                            clearInterval(countdownInterval);
                            document.getElementById('countdown').innerHTML = 'Time expired';
                        }
                    }, 1000);

                    document.getElementById('countdownMessage').style.display = 'block';
                </script>";
            } else {
                $message = "Invalid email!";
            }
        }
    }
    ?>

    <!-- Form Mixin-->
    <!-- Input Mixin-->
    <!-- Button Mixin-->
    <!-- Pen Title-->
    <div class="pen-title">
        <h1>Reset Password Form</h1>
    </div>

    <!-- Form Module-->
    <div class="module form-module">
        <div class="toggle">
        </div>
        <div class="form">
            <h2>Please Enter Your E-mail</h2>
            <span id="countdownMessage">Sending email within <span id="countdown"></span>.</span>
            <span style="color:red;"><?php echo $message; ?></span>
            <span style="color:green;"><?php echo $success_message; ?></span>
            <form action="" method="post">
                <input type="email" placeholder="ivan@gmail.com" name="email" />
                <input type="submit" id="buttn" name="submit" value="Submit" />
            </form>
        </div>
    </div>

    <div class="cta">
        Not registered?<a href="registration.php" style="color:#f30;"> Create an account</a>
        or <a href="enter_email.php" style="color:#f30;">Forgot password?</a>
    </div>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</body>

</html>
