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
			$mql = "INSERT INTO admin (username,password,email,code) VALUES ('".$_POST['cr_user']."','".password_hash($_POST['cr_pass'], PASSWORD_BCRYPT)."','".$_POST['cr_email']."','SUPP')";
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
   <header id="header" class="header-scroll top-header headrom">
      <!-- .navbar -->
      <nav class="navbar navbar-dark">
         <div class="container">
            <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
            <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="./../images/food-picky-logo.png" alt=""> </a>
            <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
               <ul class="nav navbar-nav">
               <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                        
               <?php
               if(empty($_SESSION["adm_id"]))
               {
                  echo '<li class="nav-item"><a href="index.php" class="nav-link active">Login</a> </li>
                  <li class="nav-item"><a href="registration.php" class="nav-link active">Signup</a> </li>';
               }

               else
               { 
                  echo  '<li class="nav-item"><a href="dashboard.php" class="nav-link active">Dashboard</a> </li>';
                  echo  '<li class="nav-item"><a href="./../logout.php" class="nav-link active">Logout</a> </li>';
               }
               ?>
                  
               </ul>
            </div>
         </div>
      </nav>
      <!-- /.navbar -->
   </header>
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
      <footer class="footer">
         <div class="container">
            <!-- top footer statrs -->
            <div class="row top-footer">
               <div class="col-xs-12 col-sm-3 footer-logo-block color-gray">
                  <a href="#"> <img src="./../images/food-picky-logo.png" alt="Footer logo"> </a> <span>Order Delivery &amp; Take-Out </span> 
               </div>
               <div class="col-xs-12 col-sm-2 about color-gray">
                  <h5>About Us</h5>
                  <ul>
                     <li><a href="#">About us</a> </li>
                     <li><a href="#">History</a> </li>
                     <li><a href="#">Our Team</a> </li>
                     <li><a href="#">We are hiring</a> </li>
                  </ul>
               </div>
               <div class="col-xs-12 col-sm-2 how-it-works-links color-gray">
                  <h5>How it Works</h5>
                  <ul>
                     <li><a href="#">Enter your location</a> </li>
                     <li><a href="#">Choose restaurant</a> </li>
                     <li><a href="#">Choose meal</a> </li>
                     <li><a href="#">Pay via credit card</a> </li>
                     <li><a href="#">Wait for delivery</a> </li>
                  </ul>
               </div>
               <div class="col-xs-12 col-sm-2 pages color-gray">
                  <h5>Pages</h5>
                  <ul>
                     <li><a href="#">Search results page</a> </li>
                     <li><a href="#">User Sing Up Page</a> </li>
                     <li><a href="#">Pricing page</a> </li>
                     <li><a href="#">Make order</a> </li>
                     <li><a href="#">Add to cart</a> </li>
                  </ul>
               </div>
               <div class="col-xs-12 col-sm-3 popular-locations color-gray">
                  <h5>Popular locations</h5>
                  <ul>
                     <li><a href="#">Sarajevo</a> </li>
                     <li><a href="#">Split</a> </li>
                     <li><a href="#">Tuzla</a> </li>
                     <li><a href="#">Sibenik</a> </li>
                     <li><a href="#">Zagreb</a> </li>
                     <li><a href="#">Brcko</a> </li>
                     <li><a href="#">Beograd</a> </li>
                     <li><a href="#">New York</a> </li>
                     <li><a href="#">Gradacac</a> </li>
                     <li><a href="#">Los Angeles</a> </li>
                  </ul>
               </div>
            </div>
            <!-- top footer ends -->
            <!-- bottom footer statrs -->
            <div class="row bottom-footer">
               <div class="container">
                  <div class="row">
                     <div class="col-xs-12 col-sm-3 payment-options color-gray">
                        <h5>Payment Options</h5>
                        <ul>
                           <li>
                              <a href="#"> <img src="./../images/paypal.png" alt="Paypal"> </a>
                           </li>
                           <li>
                              <a href="#"> <img src="./../images/mastercard.png" alt="Mastercard"> </a>
                           </li>
                           <li>
                              <a href="#"> <img src="./../images/maestro.png" alt="Maestro"> </a>
                           </li>
                           <li>
                              <a href="#"> <img src="./../images/stripe.png" alt="Stripe"> </a>
                           </li>
                           <li>
                              <a href="#"> <img src="./../images/bitcoin.png" alt="Bitcoin"> </a>
                           </li>
                        </ul>
                     </div>
                     <div class="col-xs-12 col-sm-4 address color-gray">
                        <h5>Address</h5>
                        <p>Concept design of oline food order and deliveye,planned as restaurant directory</p>
                        <h5>Phone: <a href="tel:+080000012222">080 000012 222</a></h5>
                     </div>
                     <div class="col-xs-12 col-sm-5 additional-info color-gray">
                        <h5>Addition informations</h5>
                        <p>Join the thousands of other restaurants who benefit from having their menus on TakeOff</p>
                     </div>
                  </div>
               </div>
            </div>
            <!-- bottom footer ends -->
         </div>
      </footer>
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
