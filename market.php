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
    <section class="hero" style = "background-color: #36454f;">
        <div class="hero-inner">
            <h1>Order Delivery & Take-Out </h1></br>
            <!--<a href="category_products.php?categories_id=4" class="btn btn-info" role="button">Artificial</a>-->
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
                                        <div class="product-name"> Stock: '.$r['quantity'].'</div>
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

    <!-- Micheal Special Section-->
    <section class="littleFarmer">
    <div class="container">
        <div class="title text-center mb-30">
            <h2>Little Farmer's Specials Section</h2>
            <p class="lead">Something about Little Farmer</p>
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
                <h2>Little Farmer's Merchants</h2>
                <p class="lead">Get to know our trusted seller!</p>
            </div>
            <div class="row">
                <?php 
                // fetch records from database to display popular first 12 products from database
                $query_res = mysqli_query($db,"select * from restaurant LIMIT 6"); 
                
                while($r=mysqli_fetch_array($query_res))
                {   

                    echo '  <div class="col-xs-12 col-sm-6 col-md-4 food-item">
                                <div class="food-item-wrap">
                                    <a href="dishes.php?res_id='.$r['rs_id'].'"  " ><div class="figure-wrap bg-image" data-image-src= "seller/Res_img/'.$r['image'].'"></div>
                                    <div class="content">
                                        <h4>'.$r['title'].'</h4>
                                        <div class="product-name"> '.$r['email'].'</div>
                                        <div class="product-name"> Phone Number: '.$r['phone'].'</div>
                                    </div></a> 
                                </div>
                            </div>';   

                    // echo '  <div class="col-xs-12 col-sm-6 col-md-4 food-item">
                    //             <div class="food-item-wrap">
                    //                 <div class="figure-wrap bg-image" data-image-src="'.$r['product_image'].'">
                    //                 </div>
                    //                 <div class="content">
                    //                     <h5>'.$r['product_name'].'</a></h5>
                    //                     <div class="product-name"> Stock: '.(int)$r['quantity'].'</div>
                    //                     <div class="price-btn-block"> <span class="price">RM '.$r['price'].'</span> <div productId="'.$r['product_id'].'" id="addOneToCart" class="btn theme-btn-dash pull-right">Order Now</div> </div>
                    //                 </div>
                    //             </div>
                    //         </div>';   
                }
                ?>
            </div>
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
