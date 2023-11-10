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
   if(empty($_POST['firstname']) ||  // fetching and find if its empty
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
         $mql = "INSERT INTO users(username,f_name,l_name,email,phone,password,address) VALUES('".$_POST['username']."','".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['email']."','".$_POST['phone']."','".password_hash($_POST['password'], PASSWORD_BCRYPT)."','".$_POST['address']."')";
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
  <header id="header" class="header-scroll top-header headrom" >
        <!-- .navbar -->
        <nav class="navbar navbar-dark">
            <div class="container" >
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> <img class="img-rounded" style = "height:50px;width:50px;" src="landing/logo.png" alt="logo"> </a>
                <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav" style = "font-size:22px;">
                        <li class="nav-item"> <a class="nav-link active" href="market.php">Home <span class="sr-only">(current)</span></a> </li>
                        
                        <?php
                            echo '<li class="nav-item"><a href="index.php" class="nav-link active">Little Farmer</a> </li>';
                            echo '<li class="nav-item"><a href="restaurants.php" class="nav-link active">Merchants</a> </li>';
                            echo '<li class="nav-item"><a href="dishes.php" class="nav-link active">Product</a> </li>';
                            echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">Cart</a> </li>';
                            
                            if(isset($_SESSION['adm_co']))
                            {
                                echo '<li class="nav-item"><a href="seller/dashboard.php" class="nav-link active">Dashboard</a> </li>';
                            }

                            echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
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
                                 <label for="exampleInputEmail1">Phone number</label>
                                 <input class="form-control" type="text" name="phone" value="<?php if(isset($_POST['phone'])) { echo htmlentities ($_POST['phone']); }?>" id="example-tel-input-3" placeholder="Phone">  
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
                                 <textarea class="form-control" id="exampleTextarea"  name="address" value="<?php if(isset($_POST['address'])) { echo htmlentities ($_POST['address']); }?>" rows="3"></textarea>
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
               <!-- WHY? -->
               <div class="col-md-4">
                  <h4>Registration is fast, easy, and free.</h4>
                  <p>Once you're registered, you can:</p>
                  <hr>
                  <img src="http://placehold.it/400x300" alt="" class="img-fluid">
                  <p></p>
                  <div class="panel">
                     <div class="panel-heading">
                        <h4 class="panel-title"><a data-parent="#accordion" data-toggle="collapse" class="panel-toggle collapsed" href="#faq1" aria-expanded="false"><i class="ti-info-alt" aria-hidden="true"></i>Can I viverra sit amet quam eget lacinia?</a></h4>
                     </div>
                     <div class="panel-collapse collapse" id="faq1" aria-expanded="false" role="article" style="height: 0px;">
                        <div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam rutrum ut erat a ultricies. Phasellus non auctor nisi, id aliquet lectus. Vestibulum libero eros, aliquet at tempus ut, scelerisque sit amet nunc. Vivamus id porta neque, in pulvinar ipsum. Vestibulum sit amet quam sem. Pellentesque accumsan consequat venenatis. Pellentesque sit amet justo dictum, interdum odio non, dictum nisi. Fusce sit amet turpis eget nibh elementum sagittis. Nunc consequat lacinia purus, in consequat neque consequat id. </div>
                     </div>
                  </div>
                  <!-- end:panel -->
                  <div class="panel">
                     <div class="panel-heading">
                        <h4 class="panel-title"><a data-parent="#accordion" data-toggle="collapse" class="panel-toggle" href="#faq2" aria-expanded="true"><i class="ti-info-alt" aria-hidden="true"></i>Can I viverra sit amet quam eget lacinia?</a></h4>
                     </div>
                     <div class="panel-collapse collapse" id="faq2" aria-expanded="true" role="article">
                        <div class="panel-body"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam rutrum ut erat a ultricies. Phasellus non auctor nisi, id aliquet lectus. Vestibulum libero eros, aliquet at tempus ut, scelerisque sit amet nunc. Vivamus id porta neque, in pulvinar ipsum. Vestibulum sit amet quam sem. Pellentesque accumsan consequat venenatis. Pellentesque sit amet justo dictum, interdum odio non, dictum nisi. Fusce sit amet turpis eget nibh elementum sagittis. Nunc consequat lacinia purus, in consequat neque consequat id. </div>
                     </div>
                  </div>
                  <!-- end:Panel -->
                  <h4 class="m-t-20">Contact Customer Support</h4>
                  <p> If you're looking for more help or have a question to ask, please </p>
                  <p> <a href="contact.html" class="btn theme-btn m-t-15">Contact Us</a> </p>
               </div>
               <!-- /WHY? -->
            </div>
         </div>
      </section>
       <!-- start: FOOTER -->
       <footer class="footer" style = "margin-top:10%;">
        <div class="container">
            <!-- top footer statrs -->
            <div class="row top-footer">
                <div class="col-xs-12 col-sm-3 footer-logo-block color-gray">
                    <a href="#"> <img class="img-rounded" style = "margin-bottom:50px;" src="landing/logo.png" alt="logo"> </a> </div>
               
                <div class="col-xs-12 col-sm-2 pages color-gray">
                    <h5>Pages</h5>
                    <ul>
                        <li><a href="market.php">Home</a> </li>
                        <li><a href="index.php">Little Farmer</a> </li>
                        <li><a href="restaurants.php">Merchants</a> </li>
                        <li><a href="dishes.php">Product</a> </li>
                        <li><a href="your_orders.php">Cart</a> </li>
                    </ul>
                </div>

                <div class="col-xs-12 col-sm-2 how-it-works-links color-gray">
                    <h5>Operating Hours</h5>
                    <p>Mon - Fri: 8am - 8pm</p>
                    <p>Saturday: 9am - 7pm</p>
                    <p>Sunday: 9am - 8pm</p>
                </div>
                
                <div class="col-xs-12 col-sm-3 popular-locations color-gray">
                    <h5>Delivery Hours</h5>
                    <p>Mon - Fri: 8am - 8pm</p>
                    <p>Saturday: 9am - 7pm</p>
                    <p>Sunday: 9am - 8pm</p>
                </div>

                <div class="col-xs-12 col-sm-2 WhatsApp color-gray">
                    <h5>Contact</h5>
                    <p>WhatsApp:<a href="https://api.whatsapp.com/send?phone=60102170960">   +60102170960</a></p> 
                </div>
            </div>
            <!-- top footer ends -->
            <!-- bottom footer statrs -->
            <div class="bottom-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 address color-gray">
                        <h5>Address</h5>
                        <p>AB102 Ground Floor Parcel 2586-1-9 Lorong Persiaran Bandar Baru Batu Kawa 3D Batu Kawah New Township Jalan Batu Kawa 93250 Kuching Sarawak</p></div>
                        <!-- <h5>WhatsApp:</h5> <a href="https://api.whatsapp.com/send?phone=60102170960">   +60102170960</a> -->
                </div>
            </div>
            <!-- bottom footer ends -->
        </div>
    </footer>
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