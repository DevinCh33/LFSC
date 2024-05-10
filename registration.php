<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Registration</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrapLogin.css">
</head>
<?php
	function validateEmail($email) {
		// Define a regular expression pattern for email validation
		$pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

		// Use preg_match to perform the validation
		if (preg_match($pattern, $email)) {
			return true; // Valid email
		} else {
			return false; // Invalid email
		}
	}

    include("config/connect.php"); 
    require 'vendor/autoload.php'; 
    require 'send_verification_email.php'; 

    $message = '';
    $success = '';
	
    if (isset($_POST['register'])) {
		$text = "";
		if($_POST['username'] == "" || $_POST['email'] == "" || $_POST['txtPass'] == "" || $_POST['txtConPass'] == ""){
			$text = "Please make sure all fields have been filled!";
		}else if($_POST['txtPass'] != $_POST['txtConPass']){
			$text = "Confirm Password and Password do not match!";
		}else if(strlen($_POST['username'])< 5){
			$text = "Username length must be more than 5 characters!";
		}else{
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = password_hash($_POST['txtPass'], PASSWORD_DEFAULT);
      $token = bin2hex(random_bytes(50)); 

      if (validateEmail($email)) {
          $checkUser = "SELECT * FROM users WHERE username='$username' OR email='$email'";
          $result = mysqli_query($db, $checkUser);
          if (mysqli_num_rows($result) > 0) {
              $message = "Username or Email already exists!";
          } else {
              $registerQuery = "INSERT INTO users (username, email, password, email_token, email_verified) VALUES ('$username', '$email', '$password', '$token', 0)";
  
              if (mysqli_query($db, $registerQuery)) {
                  if (sendVerificationEmail($email, $token)) {
                      $success = "<div class='alert alert-success'>Registration successful! Please check your email to verify.</div>"; 
                  } else {
                      $message = "<div class='alert alert-danger'>Registration successful but failed to send verification email.</div>";
                  }
              } else {
                  $message = "<div class='alert alert-danger'>Error: " . mysqli_error($db)."</div>";
              }
          }
      } else {
          $text = "Invalid email address!";
      }
    }
	}
?>

<body>
  <div class="container-fluid">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="images/logo.png" class="img-fluid" alt="Logo" style="width: 100%; height: 100%">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form class="login-form" action="#" method="POST">
			<div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
        <h1 class="fw-normal mb-0 me-3">Customer Registration Form</h1>
			</div>
			<hr>
          <!-- Email input -->
		  <div class="alertCSS"><?php echo $text; ?></div>
      <?php echo $message; ?>
      <?php echo $success; ?>

     	<div data-mdb-input-init class="form-outline mb-4">
        <label class="form-label" for="name">Username</label>
        <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Enter a valid username" />    
      </div>
			
      <div data-mdb-input-init class="form-outline mb-4">
        <label class="form-label" for="name">Email</label>
        <input type="text" id="email" name="email" class="form-control form-control-lg" placeholder="Enter a valid email" />    
      </div>

          <!-- Password input -->
      <div data-mdb-input-init class="form-outline mb-3">
        <label class="form-label" for="txtPass">Password</label>
        <input type="password" id="txtPass" name="txtPass" value="123456" class="form-control form-control-lg" placeholder="Enter password" />
      </div>
			
      <div data-mdb-input-init class="form-outline mb-3">
        <label class="form-label" for="txtPass">Confirm Password</label>
         <input type="password" id="txtConPass" name="txtConPass" value="123456" class="form-control form-control-lg" placeholder="Confirm password" />
      </div>

      <div class="text-center text-lg-start mt-4 pt-2">
        <input type="submit" value="Register" name="register" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">
    
        <p class="small fw-bold mt-2 pt-1 mb-0">Already Registered? <a href="login.php" class="link-danger">Login</a></p>
      </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
