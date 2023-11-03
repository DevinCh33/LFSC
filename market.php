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
    <title>Marketplace</title>
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
                <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/food-picky-logo.png" alt=""> </a>
                <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
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

    <!-- banner part starts -->
    <section class="hero">
        <div class="hero-inner">
            <h1>Order Delivery & Take-Out </h1>
            <h5 class="font-white space-xs">Find merchants, specials, and coupons for free</h5>
            <a href="login.php" class="btn btn-info" role="button">All</a>
            <a href="login.php" class="btn btn-outline-info" role="button">Salad</a>
            <a href="#link" class="btn btn-outline-info" role="button">Herbs</a>
            <a href="#link" class="btn btn-outline-info" role="button">Baby Green</a>
            <a href="#link" class="btn btn-outline-info" role="button">Microgreen</a>
            <a href="#link" class="btn btn-outline-info" role="button">Edible Flower</a>
            <a href="#link" class="btn btn-outline-info" role="button">Retail Pack</a>
            <a href="#link" class="btn btn-outline-info" role="button">Organic</a>
            <a href="#link" class="btn btn-outline-info" role="button">Pesticide Free</a>
            <a href="#link" class="btn btn-outline-info" role="button">End Product</a>
            <a href="#link" class="btn btn-outline-info" role="button">Services</a>
            <div class="banner-form">
                <form class="form-inline" method="get">
                    <div class="form-group" style="margin-top:50px;">
                        <label class="sr-only" for="exampleInputAmount">Search product....</label>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" id="exampleInputAmount" name="search" value="<?php if(isset($_GET['search'])) { echo htmlentities ($_GET['search']); }?>" placeholder="Search product...">
                            <input type="submit" class="btn theme-btn btn-lg" value="Search">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end:Hero inner -->

    <!-- Search part starts-->
    </section>
    <?php
    if (isset($_GET['search']))
    {
    echo '<section class="popular">
            <div class="container">
                <div class="title text-xs-center m-b-30">
                    <h2>Search Results</h2>
                </div>
                <div class="row">';
 
                // fetch records from database to display first 12 products searched from the database
                $query_res = mysqli_query($db,"select * from dishes WHERE title LIKE '%".$_GET['search']."%' LIMIT 12"); 
                
                while($r=mysqli_fetch_array($query_res))
                {   
                    echo '<div class="col-xs-12 col-sm-6 col-md-4 food-item">
                            <div class="food-item-wrap">
                                <div class="figure-wrap bg-image" data-image-src="seller/Res_img/dishes/'.$r['img'].'">
                                    <div class="distance"><i class="fa fa-pin"></i>1240m</div>
                                    <div class="rating pull-left"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </div>
                                    <div class="review pull-right"><a href="#">198 reviews</a> </div>
                                </div>
                                <div class="content">
                                    <h5><a href="dishes.php?res_id='.$r['rs_id'].'">'.$r['title'].'</a></h5>
                                    <div class="product-name">'.$r['slogan'].'</div>
                                    <div class="price-btn-block"> <span class="price">$'.$r['price'].'</span> <a href="dishes.php?res_id='.$r['rs_id'].'" class="btn theme-btn-dash pull-right">Order Now</a> </div>
                                </div>
                            </div>
                    </div>';              
                    }
        echo   '</div>
            </div>
        </section>';
    }
    ?> 
    <!-- Search part ends-->

    <!-- Popular block starts -->
    <section class="popular">
        <div class="container">
            <div class="title text-xs-center m-b-30">
                <h2>Little Farmer's Featured Products</h2>
                <p class="lead">Fresh and pesticide free!</p>
            </div>
            <div class="row">
                <?php 
                // fetch records from database to display popular first 12 products from database
                $query_res= mysqli_query($db,"select * from dishes LIMIT 12"); 
                
                while($r=mysqli_fetch_array($query_res))
                {   
                    echo '  <div class="col-xs-12 col-sm-6 col-md-4 food-item">
                            <div class="food-item-wrap">
                                <div class="figure-wrap bg-image" data-image-src="seller/Res_img/dishes/'.$r['img'].'">
                                    <div class="distance"><i class="fa fa-pin"></i>1240m</div>
                                    <div class="rating pull-left"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </div>
                                    <div class="review pull-right"><a href="#">198 reviews</a> </div>
                                </div>
                                <div class="content">
                                    <h5><a href="dishes.php?res_id='.$r['rs_id'].'">'.$r['title'].'</a></h5>
                                    <div class="product-name">'.$r['slogan'].'</div>
                                    <div class="price-btn-block"> <span class="price">$'.$r['price'].'</span> <a href="dishes.php?res_id='.$r['rs_id'].'" class="btn theme-btn-dash pull-right">Order Now</a> </div>
                                </div>
                                
                            </div>
                    </div>';              
                }
                ?>
            </div>
        </div>
    </section>
    <!-- Popular block ends -->
    <!-- Featured Merchants starts -->
    <section class="featured-restaurants">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="title-block pull-left">
                        <h4>Featured Merchants</h4> </div>
                </div>
                <div class="col-sm-8">
                    <!-- Merchants filter nav starts -->
                    <div class="restaurants-filter pull-right">
                        <nav class="primary pull-left">
                            <ul>
                                <li><a href="#" class="selected" data-filter="*">all</a> </li>
                                <?php 
                                    // display categories here
                                    $res = mysqli_query($db,"select * from res_category");

                                    while($row=mysqli_fetch_array($res))
                                    {
                                        echo '<li><a href="#" data-filter=".'.$row['c_name'].'"> '.$row['c_name'].'</a> </li>';
                                    }
                                ?>
                                
                            </ul>
                        </nav>
                    </div>
                    <!-- Merchants filter nav ends -->
                </div>
            </div>
            <!-- Merchants listing starts -->
            <div class="row">
                <div class="restaurant-listing">
                    <?php  //fetching records from table and filter using html data-filter tag
                        $ress= mysqli_query($db,"select * from restaurant");

                        while($rows=mysqli_fetch_array($ress))
                        {
                                // fetch records from res_category table according to catgory ID
                                $query= mysqli_query($db,"select * from res_category where c_id='".$rows['c_id']."' ");
                                    $rowss=mysqli_fetch_array($query);

                                    echo ' <div class="col-xs-12 col-sm-12 col-md-6 single-restaurant all '.$rowss['c_name'].'">
                                    <div class="restaurant-wrap">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-3 col-md-12 col-lg-3 text-xs-center">
                                                <a class="restaurant-logo" href="dishes.php?res_id='.$rows['rs_id'].'" > <img src="seller/Res_img/'.$rows['image'].'" alt="Merchant logo"> </a>
                                            </div>
                                            <!--end:col -->
                                            <div class="col-xs-12 col-sm-9 col-md-12 col-lg-9">
                                                <h5><a href="dishes.php?res_id='.$rows['rs_id'].'" >'.$rows['title'].'</a></h5> <span>'.$rows['address'].'</span>
                                                <div class="bottom-part">
                                                    <div class="cost"><i class="fa fa-check"></i> Min $ 10,00</div>
                                                    <div class="mins"><i class="fa fa-motorcycle"></i> 30 min</div>
                                                    <div class="ratings"> <span>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o"></i>
                                                        </span> (122) </div>
                                                </div>
                                            </div>
                                            <!-- end:col -->
                                        </div>
                                        <!-- end:row -->
                                    </div>
                                    <!--end:Merchant wrap -->
                                </div>';
                        }
                    ?>
                </div>
            </div>
            <!-- Merchants listing ends -->
            
        </div>
    </section>
    <!-- Featured Merchants ends -->
    <section class="app-section">
        <div class="app-wrap">
            <div class="container">
                <div class="row text-img-block text-xs-left">
                    <div class="container">
                        <div class="col-xs-12 col-sm-5 right-image text-center">
                            <figure> <img src="images/app.png" alt="Right Image" class="img-fluid"> </figure>
                        </div>
                        <div class="col-xs-12 col-sm-7 left-text">
                            <h3>The Best Food Delivery App</h3>
                            <p>Now you can make food happen pretty much wherever you are thanks to the free easy-to-use Food Delivery &amp; Takeout App.</p>
                            <div class="social-btns">
                                <a href="#" class="app-btn apple-button clearfix">
                                    <div class="pull-left"><i class="fa fa-apple"></i> </div>
                                    <div class="pull-right"> <span class="text">Available on the</span> <span class="text-2">App Store</span> </div>
                                </a>
                                <a href="#" class="app-btn android-button clearfix">
                                    <div class="pull-left"><i class="fa fa-android"></i> </div>
                                    <div class="pull-right"> <span class="text">Available on the</span> <span class="text-2">Play store</span> </div>
                                </a>
                            </div>
                        </div>
                    </div>
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
                    <a href="#"> <img src="images/food-picky-logo.png" alt="Footer logo"> </a> <span>Order Delivery &amp; Take-Out </span> </div>
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
                        <li><a href="#">Choose merchant</a> </li>
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
            <div class="bottom-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 payment-options color-gray">
                        <h5>Payment Options</h5>
                        <ul>
                            <li>
                                <a href="#"> <img src="images/paypal.png" alt="Paypal"> </a>
                            </li>
                            <li>
                                <a href="#"> <img src="images/mastercard.png" alt="Mastercard"> </a>
                            </li>
                            <li>
                                <a href="#"> <img src="images/maestro.png" alt="Maestro"> </a>
                            </li>
                            <li>
                                <a href="#"> <img src="images/stripe.png" alt="Stripe"> </a>
                            </li>
                            <li>
                                <a href="#"> <img src="images/bitcoin.png" alt="Bitcoin"> </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-4 address color-gray">
                        <h5>Address</h5>
                        <p>Concept design of oline food order and deliveye,planned as restaurant directory</p>
                        <h5>Phone: <a href="tel:+080000012222">080 000012 222</a></h5> </div>
                    <div class="col-xs-12 col-sm-5 additional-info color-gray">
                        <h5>Addition informations</h5>
                        <p>Join the thousands of other restaurants who benefit from having their menus on TakeOff</p>
                    </div>
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
</body>
</html>
