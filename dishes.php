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
    <title>Products</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="landing/logo.png">
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
    $currentPage = 'products';
    include("includes/header.php");
    ?>

     <div class="page-wrapper" > 
        <!-- top Links -->
        <div class="top-links">
            <div class="container">
                <ul class="row links">
                    <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose Merchant</a></li>
                    <li class="col-xs-12 col-sm-4 link-item active"><span>2</span><a href="dishes.php?res_id=<?php echo $_GET['res_id']; ?>">Pick Your Products</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order and Pay Online</a></li>
                </ul>
            </div>
        </div>
        <!-- end:Top links -->
        <!-- start: Inner page hero -->
        <?php
            if (!isset($_GET['res_id'])) // hardcoded
            {
                $_GET['res_id'] = 51;
            }

            $ress = mysqli_query($db,"select * from restaurant where rs_id='$_GET[res_id]'");
            $rows = mysqli_fetch_array($ress);                                
        ?>

        <section class="inner-page-hero bg-image" data-image-src="images/img/dish.jpeg">
            <div class="profile">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12  col-md-4 col-lg-4 profile-img">
                            <div class="image-wrap">
                                <figure><?php echo '<img src="seller/Res_img/'.$rows['image'].'" alt="Merchant logo">'; ?></figure>
                            </div>  
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 profile-desc">
                            <div class="pull-left right-text white-txt">
                                <h6><a href="#"><?php echo $rows['title']; ?></a></h6>
                                <p><?php echo $rows['description']; ?></p>
                                <p><?php echo $rows['address']; ?></p>
                                <ul class="nav nav-inline">
                                    <li class="nav-item ratings">
                                        <a class="nav-link" href="#"> <span>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                        <p>245 Review</p>
                                        </span> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end:Inner page hero -->

        <div class="breadcrumb">
            <div class="container">
                
            </div>
        </div>

        <div class="container m-t-30">
            <div class="row">
                <!-- Column for POPULAR ORDERS -->
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
                    <div class="menu-widget" id="2">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">
                                Product List <a class="btn btn-link pull-right" data-toggle="collapse" href="#popular2" aria-expanded="true">
                                <i class="fa fa-angle-right pull-right"></i>
                                <i class="fa fa-angle-down pull-right"></i>
                                </a>
                            </h3>
                            <div class="clearfix"></div>
                        </div>
                
                        <div class="collapse in" id="popular2">
                        <?php // display values and item of products
                            $stmt = $db->prepare("SELECT * FROM product, tblprice WHERE product.owner = ? AND product.status = 1 AND product.product_id = tblprice.productID");
                            $stmt->bind_param("i", $_GET['res_id']);
                            $stmt->execute();
                            $products = $stmt->get_result();
                            
                            if (!empty($products)) 
                            {
                                foreach($products as $product)
                                {           
                        ?>

                            <div class="food-item">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-8">
                                        <div class="rest-logo pull-left">
                                            <a class="restaurant-logo pull-left" href="#"><?php echo '<img src="'.$product['product_image'].'" alt="Product logo">'; ?></a>
                                        </div>
                                        <!-- end:Logo -->
                                
                                        <!-- end:col -->
                                        <div class="col-xs-12 col-sm-12 col-lg-4 pull-right item-cart-info product" data-product-id="<?php echo $product['product_id']; ?>" data-product-owner="<?php echo $product['owner']; ?>"> 
                                            <h6><?php echo $product['product_name']; ?></h6>

                                            <p><?php echo $product['descr'];  ?></p>

                                            <p style="color: green;">Stock Left: <?php echo (int)$product['quantity']; ?></p>

                                            <span class="price pull-left" >RM <?php echo $product['proPrice']; ?></span>
                                            <input type="number" name="quantity" style="margin-left: 1.8rem; margin-bottom: 1rem; max-width: 4rem;" value="1" min="1"/>
                                            <button class="btn theme-btn addsToCart">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- end:row -->
                            </div>
                            <!-- end:Item -->
                            
                            <?php
                                    }
                                }
                            ?>
                        </div>
                        <!-- end:Collapse -->
                    </div>
                    <!-- end:Widget menu -->
                </div>

                <!-- Column for Your Shopping Cart -->
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                    <div class="widget widget-cart">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">
                                Your Shopping Cart
                            </h3>
                            <div class="clearfix"></div>
                        </div>
                        <div class="order-row bg-white">
                            <div class="widget-body">	
                                <div id="cart">
                                    <p>Cart:</p>
                                    <ul id="cartItems"></ul>
                                </div>
                            </div>
                        </div>
                        <!-- end:Order row -->
                            
                        <div class="widget-body">
                            <div class="price-wrap text-xs-center">
                                <p>TOTAL</p>
                                <h3 id="cartTotal" class="value">RM 0.00</h3>
                                <p>Free Shipping</p>
                                <a href="checkout.php?res_id=<?php echo $_GET['res_id'];?>&action=check"  class="btn theme-btn btn-lg">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end:row -->
        </div>
        <!-- end:Container -->

        <div class="breadcrumb">
            <div class="container">
                
            </div>
        </div>
        
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
    <script src="js/rating1.js"></script>
</body>
</html>
