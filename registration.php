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
   <title>Registration</title>
   <!-- Bootstrap core CSS -->
   <link href="css/bootstrap.min.css" rel="stylesheet">
   <link href="css/font-awesome.min.css" rel="stylesheet">
   <link href="css/animsition.min.css" rel="stylesheet">
   <link href="css/animate.css" rel="stylesheet">
   <link rel="icon" type="image/png" sizes="16x16" href="landing/logo.png">
   <!-- Custom styles for this template -->
   <link href="css/style.css" rel="stylesheet">
</head>

<body>
<?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
include("connection/connect.php"); // connection to database

if(isset($_POST['submit'] )) // if submit button was pressed
{
   if(empty($_POST['username']) || // fetching and find if its empty
      empty($_POST['firstname']) ||  
      empty($_POST['lastname']) || 
      empty($_POST['email']) ||  
      empty($_POST['phone']) ||
      empty($_POST['password']) ||
      empty($_POST['cpassword']))
   {
      $message = "All fields must are required to be filled!";
   }

	else
	{
		//cheching username & email if already present
      $check_username = mysqli_query($db, "SELECT username FROM users where username = '".$_POST['username']."' ");
      $check_email = mysqli_query($db, "SELECT email FROM users where email = '".$_POST['email']."' ");

      if($_POST['password'] != $_POST['cpassword']) // matching passwords
      {  
         $message = "Passwords do not match!";
      }

      elseif(strlen($_POST['password']) < 6)  // cal password length
      {
         $message = "Passwords must be longer than 6 characters!";
      }

      elseif(strlen($_POST['phone']) < 10)  // cal phone length
      {
         $message = "Invalid phone number!";
      }

      elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // validate email address
      {
         $message = "Invalid email address, please type a valid email!";
      }

      elseif(mysqli_num_rows($check_username) > 0)  // check username
      {
         $message = 'Username already exists!';
      }

      elseif(mysqli_num_rows($check_email) > 0) // check email
      {
         $message = 'Email already exists!';
      }

      else
      {
	      //inserting values into db
         $mql = "INSERT INTO users(username,f_name,l_name,fullName,email,phone,password,address) VALUES('".$_POST['username']."','".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['firstname']." ".$_POST['lastname']."','".$_POST['email']."','".$_POST['phone']."','".password_hash($_POST['password'], PASSWORD_BCRYPT)."','".$_POST['address']."')";
         mysqli_query($db, $mql);
		
         $success = "Account created successfully! <p>You will be redirected in <span id='counter'>5</span> second(s).</p>
                     <script type='text/javascript'>
                        function countdown() {
                           var i = document.getElementById('counter');
                           if (parseInt(i.innerHTML)<=0) {
                              location.href = 'login.php';
                           }
                           i.innerHTML = parseInt(i.innerHTML)-1;
                        }
                        setInterval(function(){ countdown(); },1000);
                     </script>'";

		   header("refresh:5;url=login.php"); // redirected once account created
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
                                 <input class="form-control" type="text" name="username" value="<?php if(isset($_POST['username'])) { echo htmlentities ($_POST['username']); }?>" id="example-text-input" placeholder="Username"> 
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputEmail1">First Name</label>
                                 <input class="form-control" type="text" name="firstname" value="<?php if(isset($_POST['firstname'])) { echo htmlentities ($_POST['firstname']); }?>" id="example-text-input" placeholder="First Name"> 
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputEmail1">Last Name</label>
                                 <input class="form-control" type="text" name="lastname" value="<?php if(isset($_POST['lastname'])) { echo htmlentities ($_POST['lastname']); }?>" id="example-text-input-2" placeholder="Last Name"> 
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputEmail1">Email address</label>
                                 <input type="text" class="form-control" name="email" value="<?php if(isset($_POST['email'])) { echo htmlentities ($_POST['email']); }?>" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputEmail1">Mobile number</label>
                                 <input class="form-control" type="text" name="phone" value="<?php if(isset($_POST['phone'])) { echo htmlentities ($_POST['phone']); }?>" id="example-tel-input-3" placeholder="Mobile Number">  
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputPassword1">Password</label>
                                 <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password"> <small class="form-text text-muted">We'll never ask you for your password elsewhere except here.</small>
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputPassword1">Repeat password</label>
                                 <input type="password" class="form-control" name="cpassword" id="exampleInputPassword2" placeholder="Password"> <small class="form-text text-muted">We'll never ask you for your password elsewhere except here.</small>
                              </div>
                              <div class="form-group col-sm-12">
                                 <label for="exampleTextarea">Delivery Address</label>
                                 <textarea class="form-control" id="exampleTextarea" placeholder="Delivery Address" name="address" value="<?php if(isset($_POST['address'])) { echo htmlentities ($_POST['address']); }?>" rows="3"></textarea>
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
    
   <!-- Bootstrap core JavaScript
   ================================================== -->
   <script src="js/jquery.min.js"></script>
   <script src="js/tether.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/animsition.min.js"></script>
   <script src="js/bootstrap-slider.min.js"></script>
   <script src="js/jquery.isotope.min.js"></script>
   <script src="js/headroom.js"></script>
   <script src="js/foodpicky.min.js"></script>
   <script src="js/cart.js"></script>
</body>
</html>
