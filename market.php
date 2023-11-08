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

    <!-- banner part starts -->
    <section class="hero" style = "background-color: #36454f;">
        <div class="hero-inner">
            <h1>Order Delivery & Take-Out </h1></br>
            <a href="category_products.php?categories_id=4" class="btn btn-info" role="button">All</a>
            <a href="category_products.php?categories_id=5" class="btn btn-outline-info" role="button">Leafy Green</a>
            <a href="category_products.php?categories_id=6" class="btn btn-outline-info" role="button">Root Vegetables</a>
            <a href="category_products.php?categories_id=7" class="btn btn-outline-info" role="button">Pome Fruits</a>
            <a href="category_products.php?categories_id=8" class="btn btn-outline-info" role="button">Other</a>
            <!--<a href="login.php" class="btn btn-info" role="button">All</a>
            <a href="login.php" class="btn btn-outline-info" role="button">Salad</a>
            <a href="#link" class="btn btn-outline-info" role="button">Herbs</a>
            <a href="#link" class="btn btn-outline-info" role="button">Baby Green</a>
            <a href="#link" class="btn btn-outline-info" role="button">Microgreen</a>
            <a href="#link" class="btn btn-outline-info" role="button">Edible Flower</a>
            <a href="#link" class="btn btn-outline-info" role="button">Retail Pack</a>
            <a href="#link" class="btn btn-outline-info" role="button">Organic</a>
            <a href="#link" class="btn btn-outline-info" role="button">Pesticide Free</a>
            <a href="#link" class="btn btn-outline-info" role="button">End Product</a>
            <a href="#link" class="btn btn-outline-info" role="button">Services</a> -->
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
                $query_res = mysqli_query($db,"select * from product WHERE product_name LIKE '%".$_GET['search']."%' LIMIT 12"); 
                
                while($r=mysqli_fetch_array($query_res))
                {   
                    echo '<div class="col-xs-12 col-sm-6 col-md-4 food-item">
                            <div class="food-item-wrap">
                                <div class="figure-wrap bg-image" data-image-src="'.$r['product_image'].'">
                                    <div class="distance"><i class="fa fa-pin"></i>1240m</div>
                                    <div class="rating pull-left"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </div>
                                    <div class="review pull-right"><a href="#">198 reviews</a> </div>
                                </div>
                                <div class="content">
                                    <h5>'.$r['product_name'].'</a></h5>
                                    <div class="product-name"> Stock: '.$r['quantity'].'</div>
                                    <div class="price-btn-block"> <span class="price">$'.$r['price'].'</span> <div productId="'.$r['product_id'].'" id="addOneToCart" class="btn theme-btn-dash pull-right">Order Now</div> </div>
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

    <!-- Micheal Special Section-->
    <section class="littleFarmer">
    <div class="container">
        <div class="title text-center mb-30">
            <h2>Little Farmer's Specials Section</h2>
            <p class="lead">Somethinng about Little Farmer</p>
        </div>
        <div class="row">
            <?php
            // Query a maximum of 8 products from the "Little Farmer" where owner is "13"
            $littleFarmerProductsQuery = "SELECT * FROM product WHERE owner = '50' AND active = 1 LIMIT 4";
            $result = mysqli_query($db, $littleFarmerProductsQuery);

            // Check if there are any products returned by the query
            if ($result && mysqli_num_rows($result) > 0) {
                // Loop through each product and display the card
                while ($product = mysqli_fetch_assoc($result)) {
                    // Use htmlspecialchars to escape any special characters
                    $productName = htmlspecialchars($product['product_name']);
                    $productImage = htmlspecialchars($product['product_image']);
                    // Convert quantity to an integer
                    $productQuantity = intval($product['quantity']);
                    // Format price to ensure it has two decimal places
                    $productPrice = number_format($product['price'], 2);

                    echo '<div class="col-lg-3 col-md-4 col-sm-6 mb-4">';
                    echo '    <div class="card michealProductCard">';
                    echo '        <img src="' . $productImage . '" alt="' . $productName . '" class="card-img-top">';
                    echo '        <div class="card-body">';
                    echo '            <h5 class="card-title">' . $productName . '</h5>';
                    echo '            <p class="card-text">Quantity: ' . $productQuantity . '</p>';
                    echo '            <p class="card-text">Price: RM ' . $productPrice . '</p>';
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';
                }
            } else {
                // No products found
                echo '<div class="col-12"><p>No products found in Little Farmer\'s Specials.</p></div>';
            }
            ?>
        </div>
    </div>
    </section>


    <!-- Micheal Special section ends-->

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
                $query_res = mysqli_query($db,"select * from product LIMIT 12"); 
                
                while($r=mysqli_fetch_array($query_res))
                {   
                    echo '  <div class="col-xs-12 col-sm-6 col-md-4 food-item">
                                <div class="food-item-wrap">
                                    <div class="figure-wrap bg-image" data-image-src="'.$r['product_image'].'">
                                    </div>
                                    <div class="content">
                                        <h5>'.$r['product_name'].'</a></h5>
                                        <div class="product-name"> Stock: '.(int)$r['quantity'].'</div>
                                        <div class="price-btn-block"> <span class="price">RM '.$r['price'].'</span> <div productId="'.$r['product_id'].'" id="addOneToCart" class="btn theme-btn-dash pull-right">Order Now</div> </div>
                                    </div>
                                </div>
                            </div>';   
                }
                ?>
            </div>
        </div>
    </section>
    <!-- Popular block ends -->
  
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
