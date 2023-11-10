<!DOCTYPE html>
<html lang="en">

<?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
include("connection/connect.php"); // connection to database

if(empty($_SESSION['user_id']))  //if user is not logged in, redirect baack to login page
{
	header('location:login.php');
}

foreach ($_SESSION["cart_item"] as $item)
{
    $item_total += ($item["price"]*$item["quantity"]);

    if($_POST['submit'])
    {
        $SQL = "insert into users_orders(u_id,title,quantity,price) values('".$_SESSION["user_id"]."','".$item["title"]."','".$item["quantity"]."','".$item["price"]."')";
        mysqli_query($db,$SQL);
        
        $oldQuantity = mysqli_fetch_array(mysqli_query($db,"SELECT quantity from product WHERE product.product_name = '".$item["title"]."'"));
        $newQuantity = $oldQuantity["quantity"] - $item["quantity"];

        $SQL2 = "UPDATE product SET quantity = '".$newQuantity."' WHERE product_name = '".$item["title"]."'";
        mysqli_query($db,$SQL2);

        $success = "Thank you! Your order has been placed successfully!";
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Checkout</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="site-wrapper">
        <!--header starts-->
    <header id="header" class="header-scroll top-header headrom" >
        <!-- .navbar -->
        <nav class="navbar navbar-dark" >
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
        <div class="page-wrapper" style="padding-top: 5%;">
            <div class="top-links">
                <div class="container">
                    <ul class="row links"> 
                        <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose Merchant</a></li>
                        <li class="col-xs-12 col-sm-4 link-item "><span>2</span><a href="#">Pick Your favorite food</a></li>
                        <li class="col-xs-12 col-sm-4 link-item active" ><span>3</span><a href="checkout.php">Order and Pay online</a></li>
                    </ul>
                </div>
            </div>
			
            <div class="container">
                <span style="color:green;">
                        <?php echo $success; ?>
                </span>
            </div>
  
            <div class="container m-t-30">
			<form action="" method="post">
                <div class="widget clearfix">
                    <div class="widget-body">
                        <form method="post" action="#">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="cart-totals margin-b-20">
                                        <div class="cart-totals-title">
                                            <h4>Cart Summary</h4> </div>
                                        <div class="cart-totals-fields">
                                            <table class="table">
											<tbody>
                                                <tr>
                                                    <td>Cart Subtotal</td>
                                                    <td> <?php echo "$".$item_total; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping &amp; Handling</td>
                                                    <td>free shipping</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-color"><strong>Total</strong></td>
                                                    <td class="text-color"><strong> <?php echo "$".$item_total; ?></strong></td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--cart summary-->
                                    <div class="payment-option">
                                        <ul class=" list-unstyled">
                                            <li>
                                                <label class="custom-control custom-radio  m-b-20">
                                                    <input name="mod" id="radioStacked1" checked value="COD" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Payment on delivery</span>
                                                    <br> <span>Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</span> </label>
                                            </li>
                                            <li>
                                                <label class="custom-control custom-radio  m-b-10">
                                                    <input name="mod"  type="radio" value="paypal" disabled class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Paypal <img src="images/paypal.jpg" alt="" width="90"></span> </label>
                                            </li>
                                        </ul>
                                        <p class="text-xs-center"> <input type="submit" onclick="return confirm('Are you sure?');" name="submit"  class="btn btn-outline-success btn-block" value="Order now"> </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
			</form>
        </div>
          <!-- start: FOOTER -->
    <footer class="footer">
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
