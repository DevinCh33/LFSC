<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrapLogin.css">
	
</head>
<?php
session_start(); // Start session
error_reporting(0); // Hide undefined index errors
include("./../config/connect.php"); // Include database connection

if (isset($_SESSION["adm_id"])) // Redirect if already logged in
{
	header("refresh:0;url=dashboard.php"); // Redirect to dashboard
}

if (isset($_POST['submit'])) // Check if login form is submitted
{
	$username = $_POST['name']; // Get username from form
	$password = $_POST['txtPass']; // Get password from form

	if (!empty($_POST["submit"])) 
    {
		// Query to fetch admin account details
		$loginquery = "SELECT adm_id, code, password, u_role, store, storeStatus FROM admin WHERE username='$username'";
		$result = mysqli_query($db, $loginquery);
		$escapedLoginQuery = addslashes($loginquery);
		
		if(mysqli_num_rows($result) >0){
			
			$row = mysqli_fetch_array($result);
			if ($row['storeStatus'] == 10) {
				$message = "Store Unverified, Please Verify Your Store First Or Contact System Admin";
			} else {
				// Check password
				if (password_verify($password, $row['password'])) // Password verification
				{
					$_SESSION["adm_id"] = $row['adm_id'];
					$_SESSION["adm_co"] = $row['code'];
					$_SESSION["u_role"] = $row['u_role'];
					$_SESSION['store'] = $row['store'];
					$_SESSION['status'] = $row['storeStatus'];

					if ($_SESSION['adm_co'] != "SUPA" && $_SESSION['adm_co'] != "VSUPA")
						header("refresh:1;url=dashboard.php");
					else
						header("refresh:1;url=admin/dashboard.php");
				} 
				else
				{
					$message = "Admin Invalid Username or Password!";
				}
			}
		} 
		else // If admin account not found, check employee account
		{
			$loginquery = "SELECT e.empID, e.code, e.password, e.u_role, e.empstore, e.empstatus, a.storeStatus
						   FROM tblemployee e 
						   JOIN admin a ON e.empstore = a.store 
						   WHERE e.username='$username'";

			$result = mysqli_query($db, $loginquery);

			if (mysqli_num_rows($result) > 0) // If employee account found
			{
				$row = mysqli_fetch_array($result);
				if ($row['storeStatus'] == 10) {
					$message = "Store Unverified, Please Verify Your Store First Or Contact System Admin";
				} else if ($row['storeStatus'] == 2) {
					$message = "Store Banned, Please Contact System Admin";
				} else if ($row['empstatus'] == 10) {
					$message = "Account Unverified, Please Verify Your Account First Or Contact System Admin";
				} else if ($row['empstatus'] != 1) { // Check if account is inactive
					$message = "Cannot login. Your account is inactive.";
				} else {
					// Check password
					if (password_verify($password, $row['password'])) // Password verification
					{
						$_SESSION["adm_id"] = $row['empID'];
						$_SESSION["adm_co"] = $row['code'];
						$_SESSION["u_role"] = $row['u_role'];
						$_SESSION['store'] = $row['empstore'];
						$_SESSION['status'] = $row['storeStatus'];

						if ($_SESSION['adm_co'] != "SUPA" && $_SESSION['adm_co'] != "VSUPA")
							header("refresh:1;url=dashboard.php");
						else
							header("refresh:1;url=admin/dashboard.php");
					}
					else
					{
						$message = "Seller Invalid Username or Password!";
					}
				}
			}
			else {
				$message = "Seller account not found.";
			}
		}
	}
}
?>

<body style="width: 100%; height: 100%">
	<section>
  <div class="container-fluid">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="img/logo.png" class="img-fluid" alt="Sample image" style="width: 100%; height: 100%">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form class="login-form" action="index.php" method="POST">

          <!-- Email input -->
          <div data-mdb-input-init class="form-outline mb-4">
			  <label class="form-label" for="name">Username</label>
            <input type="text" id="name" name="name" class="form-control form-control-lg" placeholder="Enter a valid username" />
            
          </div>

          <!-- Password input -->
          <div data-mdb-input-init class="form-outline mb-3">
			  <label class="form-label" for="txtPass">Password</label>
            <input type="password" id="txtPass" name="txtPass" value="123456" class="form-control form-control-lg" placeholder="Enter password" />
            
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
            <a href="../forgot_password.php" class="text-body">Forgot password?</a>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <input type="submit" value="Login" name="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="registration.php" class="link-danger">Register</a> or <a href="../portal.php" class="link-danger">return to login portal</a>.</p>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>
</body>
</html>