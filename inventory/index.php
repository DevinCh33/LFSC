<?php
include("./../connection/connect.php"); // connection to database
session_start();

if(isset($_SESSION['adm_id'])) {
	header('location:'.$inv_url.'dashboard.php');		
}

$errors = array();

if($_POST)
{		
	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) || empty($password))
	{
		if($username == "") {
			$errors[] = "Username is required";
		} 

		if($password == "") {
			$errors[] = "Password is required";
		}
	} 
	
	else 
	{
		$sql = "SELECT adm_id, code, password FROM admin WHERE username = '$username'";
		$result = $db->query($sql);
		$row = mysqli_fetch_array($result);
		
		if(password_verify($password, $row['password']))
		{
			$_SESSION["adm_id"] = $row['adm_id'];
			$_SESSION["adm_co"] = $row['code'];
			header('location:'.$inv_url.'dashboard.php');
		}

		else
		{	
			$errors[] = "Incorrect username / password combination!";
		} 
	}	
} // if $_POST
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stock Management System</title>

	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme-->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-theme.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

	<!-- custom css -->
	<link rel="stylesheet" href="custom/css/custom.css">

	<!-- jquery -->
	<script src="assets/jquery/jquery.min.js"></script>
	<!-- jquery ui -->  
	<link rel="stylesheet" href="assets/jquery-ui/jquery-ui.min.css">
	<script src="assets/jquery-ui/jquery-ui.min.js"></script>

  	<!-- bootstrap js -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
		<div class="row vertical">
			<div class="col-md-5 col-md-offset-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Please Sign in</h3>
					</div>
					<div class="panel-body">

						<div class="messages">
							<?php 
							if($errors) 
							{
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-warning" role="alert">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
									}
							}
							?>
						</div>

						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
							<fieldset>
							  <div class="form-group">
									<label for="username" class="col-sm-2 control-label">Username</label>
									<div class="col-sm-10">
									  <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" />
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">Password</label>
									<div class="col-sm-10">
									  <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" />
									</div>
								</div>								
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
									  <button type="submit" class="btn btn-default"> <i class="glyphicon glyphicon-log-in"></i> Sign in</button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
					<!-- panel-body -->
				</div>
				<!-- /panel -->
			</div>
			<!-- /col-md-4 -->
		</div>
		<!-- /row -->
	</div>
	<!-- container -->	
</body>
</html>
