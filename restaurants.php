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
    <title>Merchants</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="home">
<?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
include("connection/connect.php"); // connection to database

if (empty($_SESSION["user_id"])) // if not logged in
{
	header("refresh:0;url=login.php"); // redirect to login.php page
}
?>
    <!--header starts-->
    <header id="header" class="header-scroll top-header headrom">
        <!-- .navbar -->
        <nav class="navbar navbar-dark">
            <div class="container">
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
    
    <div class="page-wrapper"  style="padding-top: 5%;" >
        <!-- top Links -->
        <div class="top-links">
            <div class="container">
                <ul class="row links">
                    <li class="col-xs-12 col-sm-4 link-item active"><span>1</span><a href="restaurants.php">Pick Your Merchant</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Choose Your Product</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order and Pay Online</a></li>
                </ul>
            </div>
        </div>
        <!-- end:Top links -->
        <!-- start: Inner page hero -->
        <div class="inner-page-hero bg-image" data-image-src="images/img/res.jpeg">
            <div class="container"> </div>
            <!-- end:Container -->
        </div>


        <div class="result-show">
            <div class="container">
                <div class="row">
                    
                </div>
            </div>
        </div>
        <!-- //results show -->
        <section class="restaurants-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3">
                        <div class="widget clearfix">
                            <!-- /widget heading -->
                            <div class="widget-heading">
                                <h3 class="widget-title text-dark">
                                Seller Types
                            </h3>
                                <div class="clearfix"></div>
                            </div>
                            <div class="widget-body">
                                <ul class="tags">
                                    <li> <a href="restaurants.php?c_id=5" class="tag">
                                Fresh
                                </a> </li>
                                    <li> <a href="restaurants.php?c_id=6" class="tag">
                                Frozen
                                </a> </li>
                                    <li> <a href="restaurants.php?c_id=7" class="tag">
                                Dried
                                </a> </li>
                                    <li> <a href="restaurants.php?c_id=8" class="tag">
                                Canned 
                                </a> </li>
                                    <li> <a href="restaurants.php?c_id=9" class="tag">
                                Other
                                </a> </li>

                                </ul>
                            </div>
                        </div>
                        <!-- end:Widget -->
                    </div>
                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-9">
                        <div class="bg-gray restaurant-entry">
                            <div class="row">
                            <?php 
                                if (isset($_GET['c_id']))
                                {
                                    $query = "select * from restaurant where c_id = ".$_GET['c_id'];
                                }

                                else
                                {
                                    $query = "select * from restaurant";
                                }

                                $ress = mysqli_query($db, $query);
                                
                                while($rows=mysqli_fetch_array($ress))
                                {
                                    echo' <div class="col-sm-12 col-md-12 col-lg-8 text-xs-center text-sm-left">
                                        <div class="entry-logo">
                                            <a class="img-fluid" href="dishes.php?res_id='.$rows['rs_id'].'" > <img src="seller/Res_img/'.$rows['image'].'" alt=Merchant logo"></a>
                                        </div>
                                        <!-- end:Logo -->
                                        <div class="entry-dscr">
                                            <h5><a href="dishes.php?res_id='.$rows['rs_id'].'" >'.$rows['title'].'</a></h5> <span>'.$rows['address'].' <a href="#">...</a></span>
                                            <ul class="list-inline">
                                                <li class="list-inline-item"><i class="fa fa-check"></i> Min $ 10,00</li>
                                                <li class="list-inline-item"><i class="fa fa-motorcycle"></i> 30 min</li>
                                            </ul>
                                        </div>
                                        <!-- end:Entry description -->
                                    </div>
                                    
                                        <div class="col-sm-12 col-md-12 col-lg-4 text-xs-center">
                                            <div class="right-content bg-white">
                                                <div class="right-review">
                                                    <div class="rating-block"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </div>
                                                    <p> 245 Reviews</p> <a href="dishes.php?res_id='.$rows['rs_id'].'" class="btn theme-btn-dash">View Menu</a> </div>
                                            </div>
                                            <!-- end:right info -->
                                        </div>';
                                }
                            ?>                 
                            </div>
                            <!--end:row -->
                        </div>   
                    </div>
                </div>
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
