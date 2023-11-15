<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   <meta name="description" content="">
   <meta name="author" content="">
   <link rel="icon" href="#">
   <title>Seller Registration</title>
   <!-- Bootstrap core CSS -->
   <link href="./../css/bootstrap.min.css" rel="stylesheet">
   <link href="./../css/font-awesome.min.css" rel="stylesheet">
   <link href="./../css/animsition.min.css" rel="stylesheet">
   <link href="./../css/animate.css" rel="stylesheet">
   <!-- Custom styles for this template -->
   <link href="./../css/style.css" rel="stylesheet">
</head>

<body>
<?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
include("./../connection/connect.php"); // connection to database

if(isset($_POST['submit'] )) // if submit button was pressed
{
   if(empty($_POST['cr_user']) ||
	   empty($_POST['cr_email'])|| 
	   empty($_POST['cr_pass']) ||  
	   empty($_POST['cr_cpass']))
	{
		$message = "All fields must are required to be filled!";
	}

	else
	{
		$check_username = mysqli_query($db, "SELECT username FROM admin where username = '".$_POST['cr_user']."' ");
		$check_email = mysqli_query($db, "SELECT email FROM admin where email = '".$_POST['cr_email']."' ");

		if($_POST['cr_pass'] != $_POST['cr_cpass'])
		{
			$message = "Passwords do not match!";
		}

      elseif(strlen($_POST['cr_pass']) < 6)  // cal password length
      {
         $message = "Passwords must be longer than 6 characters!";
      }
	
		elseif (!filter_var($_POST['cr_email'], FILTER_VALIDATE_EMAIL)) // Validate email address
		{
			$message = "Invalid email address please type a valid email!";
		}

		elseif(mysqli_num_rows($check_username) > 0)
		{
			$message = 'Username already exists!';
		}

		elseif(mysqli_num_rows($check_email) > 0)
		{
			$message = 'Email already exists!';
		}

		else
		{
			$mql = "INSERT INTO admin (username,password,email,code, u_role) VALUES ('".$_POST['cr_user']."','".password_hash($_POST['cr_pass'], PASSWORD_BCRYPT)."','".$_POST['cr_email']."','SUPP', 'SELLER')";
         mysqli_query($db, $mql);

         $success = "Account created successfully! <p>You will be redirected in <span id='counter'>5</span> second(s).</p>
                     <script type='text/javascript'>
                        function countdown() {
                           var i = document.getElementById('counter');
                           if (parseInt(i.innerHTML)<=0) {
                              location.href = 'index.php';
                           }
                           i.innerHTML = parseInt(i.innerHTML)-1;
                        }
                        setInterval(function(){ countdown(); },1000);
                     </script>'";

		   header("refresh:5;url=index.php"); // redirected once account created
		}
   }
}
?>
   <!--header starts-->
   <?php
   include("includes/header.php");
   ?>
   <div class="page-wrapper">
      <div class="breadcrumb">
         <div class="container">
            <ul>
               <li><a href="#" class="active">
                  <span style="color:red;"><?php echo $message; ?></span>
                  <span style="color:green;">
                     <?php echo $success; ?>
                  </span>
               </a></li>
            </ul>
         </div>
      </div>
      <section class="contact-page inner-page">
         <div class="container">
            <div class="row">
               <!-- REGISTER -->
               <div class="col-md-8">
                  <div class="widget">
                     <div class="widget-body">
                        <form action="" method="post">
                           <div class="row">
                              <div class="form-group col-sm-12">
                                 <label for="exampleInputEmail1">User-Name</label>
                                 <input class="form-control" type="text" name="cr_user" value="<?php if(isset($_POST['cr_user'])) { echo htmlentities ($_POST['cr_user']); }?>" id="example-text-input" placeholder="Username"> 
                              </div>
                              
                              <div class="form-group col-sm-12">
                                 <label for="exampleInputEmail1">Email address</label>
                                 <input type="text" class="form-control" name="cr_email" value="<?php if(isset($_POST['cr_email'])) { echo htmlentities ($_POST['cr_email']); }?>" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputPassword1">Password</label>
                                 <input type="password" class="form-control" name="cr_pass" id="exampleInputPassword1" placeholder="Password"> <small class="form-text text-muted">We'll never ask you for your password elsewhere except here.</small>
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputPassword1">Repeat password</label>
                                 <input type="password" class="form-control" name="cr_cpass" id="exampleInputPassword2" placeholder="Password"> <small class="form-text text-muted">We'll never ask you for your password elsewhere except here.</small>
                              </div>
                           </div>
                           
                           <div class="row">
                              <div class="col-sm-4">
                                 <p> <input type="submit" value="Register" name="submit" class="btn theme-btn"> </p>
                              </div>
                           </div>
                        </form>
                     </div>
                     <!-- end: Widget -->
                  </div>
                  <!-- /REGISTER -->
               </div>
            </div>
         </div>
      </section>
      
      <!-- start: FOOTER -->
      <?php
      include("includes/footer.php");
      ?>
      <!-- end:Footer -->
   </div>
   <!-- end:page wrapper -->
      
   <!-- Bootstrap core JavaScript
   ================================================== -->
   <script src="./../js/jquery.min.js"></script>
   <script src="./../js/tether.min.js"></script>
   <script src="./../js/bootstrap.min.js"></script>
   <script src="./../js/animsition.min.js"></script>
   <script src="./../js/bootstrap-slider.min.js"></script>
   <script src="./../js/jquery.isotope.min.js"></script>
   <script src="./../js/headroom.js"></script>
   <script src="./../js/foodpicky.min.js"></script>
</body>
</html>
