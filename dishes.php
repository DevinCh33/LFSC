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
</head>

<body class="home">
<?php
error_reporting(0); // hide undefined index errors
include_once 'product-action.php'; // including controller

if (empty($_SESSION["user_id"])) // if not logged in
{
	header("refresh:0;url=login.php"); // redirect to login.php page
}
?>
    <!--header starts-->
    <?php
    include("includes/header.php");
    ?>

    <div class="page-wrapper" style="padding-top: 5%;">
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
                $_GET['res_id'] = 48;
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
                                <p><?php echo $rows['address']; ?></p>
                                <ul class="nav nav-inline">
                                    <li class="nav-item"> <a class="nav-link active" href="#"><i class="fa fa-check"></i> Min $ 10,00</a> </li>
                                    <li class="nav-item"> <a class="nav-link" href="#"><i class="fa fa-motorcycle"></i> 30 min</a> </li>
                                    <li class="nav-item ratings">
                                        <a class="nav-link" href="#"> <span>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
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
                                <?php
                                    $item_total = 0;
                                    // fetch items defined in current session ID
                                    foreach ($_SESSION["cart_item"] as $item)  
                                    {
                                ?>				
                                									
                                <div class="title-row">
                                    <a href="dishes.php?res_id=<?php echo $item['owner'];?>"><?php echo $item["product_name"]; ?></a>
                                    <a href="dishes.php?res_id=<?php echo $_GET['res_id']; ?>&action=remove&id=<?php echo $item["product_id"]; ?>" >
                                        <i class="fa fa-trash pull-right"></i>
                                    </a>
                                </div>
                                
                                <div class="form-group row no-gutter">
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control b-r-0" value=<?php echo "Quantity ".$item["price"]; ?> readonly id="exampleSelect1">
                                            
                                    </div>
                                    <div class="col-xs-4">
                                        <input class="form-control" type="text" readonly value='<?php echo $item["quantity"]; ?>' id="example-number-input"> </div>
                                </div>
                                    
                            <?php // calculating current price into cart
                                $item_total += ($item["price"]*$item["quantity"]); 
                                }
                            ?>								  
                                </div>
                            </div>
                            <!-- end:Order row -->
                            
                            <div class="widget-body">
                                <div class="price-wrap text-xs-center">
                                    <p>TOTAL</p>
                                    <h3 class="value"><strong><?php echo "RM ".$item_total; ?></strong></h3>
                                    <p>Free Shipping</p>
                                    <a href="checkout.php?res_id=<?php echo $_GET['res_id'];?>&action=check"  class="btn theme-btn btn-lg">Checkout</a>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                    
                <!-- end:Widget menu -->
                <div class="menu-widget" id="2">
                    <div class="widget-heading">
                        <h3 class="widget-title text-dark">
                            POPULAR ORDERS Quality products! <a class="btn btn-link pull-right" data-toggle="collapse" href="#popular2" aria-expanded="true">
                            <i class="fa fa-angle-right pull-right"></i>
                            <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="collapse in" id="popular2">
                    <?php // display values and item of products
                        $stmt = $db->prepare("select * from product where owner = ".$_GET['res_id']);
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
                                    <form method="post" action='dishes.php?res_id=<?php echo $_GET['res_id'];?>&action=add&id=<?php echo $product['product_id']; ?>'>
                                        <div class="rest-logo pull-left">
                                            <a class="restaurant-logo pull-left" href="#"><?php echo '<img src="'.$product['product_image'].'" alt="Product logo">'; ?></a>
                                        </div>
                                        <!-- end:Logo -->
                                        <div class="rest-descr">
                                            <h6><?php echo $product['product_name']; ?></h6>
                                        </div>
                                        <!-- end:Description -->
                                
                                    <!-- end:col -->
                                        <div class="col-xs-12 col-sm-12 col-lg-4 pull-right item-cart-info"> 
                                            <span class="price pull-left" >RM <?php echo $product['price']; ?></span>
                                            <input class="b-r-0" type="text" name="quantity"  style="margin-left:30px;" value="1" size="2" />
                                            <input type="submit" class="btn theme-btn" style="margin-left:40px;" value="Add to cart" />
                                        </div>
                                    </form>
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
                <!-- end:Bar -->
            </div>
            <!-- end:row -->
        </div>
        <!-- end:Container -->

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
