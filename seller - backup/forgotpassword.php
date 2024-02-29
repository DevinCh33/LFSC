<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Forgot Password</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
	<link rel="stylesheet prefetch" href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
	<link rel="stylesheet prefetch" href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
	<link rel="stylesheet prefetch" href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
	<link rel="icon" type="image/png" sizes="16x16" href="./../landing/logo.png">
	<link rel="stylesheet" href="css/login.css">
</head>

<?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
include("./../connection/connect.php"); // connection to database

if (isset($_SESSION["adm_id"])) // if already logged in
{
	header("refresh:0;url=dashboard.php"); // redirect to market.php page
}

if(isset($_POST['submit'])) // if submit button was preseed
{
	if(empty($_POST['username']) ||
	   empty($_POST['password']) ||
       empty($_POST['cpassword']))
   	{
      $message = "All fields are required to be filled!";
   	}

	else
	{
		$check_username = mysqli_query($db, "SELECT username FROM admin where username = '".$_POST['username']."' ");

		if($_POST['password'] != $_POST['cpassword']) // matching passwords
		{  
			$message = "Passwords do not match!";
		}

		elseif(mysqli_num_rows($check_username) == 0)
		{
			$message = 'User does not exist!';
		}

		else
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			$cpassword = $_POST['cpassword'];
			
			if(!empty($_POST['submit'])) // if records were not empty
			{
				$query = "UPDATE admin SET password = '".password_hash($password, PASSWORD_BCRYPT)."' WHERE username='$username'"; // update password

				if(mysqli_query($db, $query)) // if successful
				{
					header("refresh:1;url=index.php"); // redirect to index.php page
				} 
			}
		}
	}
}
?>

<body>
	<div class="container">
		<div class="info">
			<h1>Merchant </h1><span> New Password</span>
		</div>
	</div>

	<div class="form">
		<div class="thumbnail"><img src="images/manager.png"/></div>

		<span style="color:red;"><?php echo $message; ?></span>
		<span style="color:green;"><?php echo $success; ?></span>

		<form class="login-form" method="post">
			<input type="text" placeholder="Username" name="username"/>
			<input type="password" placeholder="Password" name="password"/>
			<input type="password" placeholder="Confirm Password" name="cpassword"/>
			<input type="submit" name="submit" value="Change" />
			Not registered?<a href="registration.php" style="color:#f30;"> Create an account</a>
		</form>
	</div>

	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src='js/index.js'></script>
</body>
</html>
