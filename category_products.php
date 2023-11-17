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
    <?php
    include("includes/header.php");
    ?>

    <!-- banner part starts -->
    <section class="hero">
        <div class="hero-inner">
            <h1>Order Delivery & Take-Out </h1>
            <h5 class="font-white space-xs">Find merchants, specials, and coupons for free</h5>
            <!--<a href="category_products.php?categories_id=4" class="btn btn-info" role="button">All</a>-->
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
                                <div class="product content" data-product-id="'.$r['product_id'].'" data-product-owner="'.$r['owner'].'">
                                    <div class="price-btn-block">
                                        <a href="dishes.php?res_id='.$r['owner'].'"> <h5>'.$r['product_name'].'</h5></a>
                                        <div class="product-name"> Stock: '. (int) $r['quantity'].'</div>
                                        <span class="price">RM '.$r['price'].'</span> 
                                        <button class="btn theme-btn-dash pull-right addToCart">Order Now</button>
                                    </div>
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
                <!--<h2>Little Farmer's Featured Products</h2>
                <p class="lead">Fresh and pesticide free!</p>-->
            </div>

            <div class="row">
            <?php
            // fetching records from table and filter using html data-filter tag
            if (isset($_GET['categories_id'])) 
            {
                $id = $_GET['categories_id'];
            }

            else
            {
                $id = 0;
            }

            // fetch records from database to display popular first 12 products from database
            $ress = mysqli_query($db, "SELECT * FROM product WHERE categories_id = {$id}");

            while ($r = mysqli_fetch_array($ress)) 
            {
                echo '<div class="col-xs-12 col-sm-6 col-md-4 food-item">
                        <div class="food-item-wrap">
                            <div class="figure-wrap bg-image" data-image-src="' . $r['product_image'] . '">
                            </div>
                            <div class="product content" data-product-id="'.$r['product_id'].'" data-product-owner="'.$r['owner'].'">
                                <div class="price-btn-block">
                                    <a href="dishes.php?res_id='.$r['owner'].'"> <h5>'.$r['product_name'].'</h5></a>
                                    <div class="product-name"> Stock: '.(int) $r['quantity'].'</div>
                                    <span class="price">RM '.$r['price'].'</span> 
                                    <button class="btn theme-btn-dash pull-right addToCart">Order Now</button>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            ?>  
        </div>
    </section>
    <!-- Popular block ends -->
  
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
