<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Marketplace</title>
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
    include("config/connect.php"); // connection to database
    include("config/search.php");
    
    if (empty($_SESSION["user_id"])) // if not logged in
    {
        header("refresh:0;url=login.php"); // redirect to login.php page
    }

    // Header starts
    $currentPage = 'market';
    include("includes/header.php");
    ?>

    <div>
        <!-- Search bar -->
        <div class="banner-form">
            <form class="form-inline" method="get">
                <div class="form-group" style="margin-top:50px;">
                    <label class="sr-only" for="searchQuery">Search product...</label>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg" id="searchQuery" name="query" value="<?php if(isset($_GET['query'])) { echo htmlentities ($_GET['query']); }?>" placeholder="Search product...">
                        <input type="submit" class="btn theme-btn btn-lg" value="Search">
                    </div>
                </div>
            </form>
        </div>

        <!-- Category Links -->
        <?php
        include("includes/categories_bar.php");
        ?>
        <br/>
    </div>

    <?php
    echo '<section class="popular">
            <div class="container">
                <div class="title text-xs-center m-b-30">
                    <h2>Search Results</h2>
                </div>
                <div class="row">';
 
                $resultsObtained = false;

                if (isset($_GET['query']))
                {
                    // fetch records from database to display first 12 products searched from the database
                    $query = mysqli_query($db,"SELECT * from product JOIN tblprice ON product.product_id = tblprice.productID WHERE product_name LIKE '%".addslashes($_GET['query'])."%' LIMIT ".$max); 
                }

                else if (isset($_GET['category']))
                {
                    // fetch records from database to display first 12 products searched from the database
                    $query = mysqli_query($db,"SELECT * from product JOIN tblprice ON product.product_id = tblprice.productID WHERE categories_id = ".addslashes($_GET['category'])." LIMIT ".$max);
                }
                
                while($product=mysqli_fetch_array($query))
                {   
                    $resultsObtained = true;

                    echo '<div class="col-xs-12 col-sm-6 col-md-4 food-item">
                            <div class="food-item-wrap">
                                <div class="figure-wrap bg-image search-product" data-image-src="'.$product['product_image'].'">
                                </div>
                                <div class="product content" >
                                    <div class="price-btn-block" data-price-id="'.$product['priceNo'].'" data-product-owner="'.$product['owner'].'">
                                        <a href="products.php?merchant='.$product['owner'].'"> <h5>'.$product['product_name'].' ('.$product['proWeight'].'g)</h5></a>
                                        <div>'.$product['descr'].'</div>                       
                                        <div class="product-name" style="color: green;">Number Left: '. (int) $product['proQuant'].'</div>';

                                        $stmt = $db->prepare("SELECT price FROM custom_prices WHERE price_id = ? AND user_id = ?");
                                        $stmt->bind_param("ii", $product['priceNo'], $_SESSION['user_id']);
                                        $stmt->execute();
                                        $custom = $stmt->get_result();
                                        $customPrice = number_format($custom->fetch_assoc()['price'], 2, '.', '');

                                        if ($customPrice != 0) {
                                        echo '            <span class="price">RM ' . $customPrice . '</span>';
                                        }
                    
                                        else if ($product['proDisc'] == 0) {
                                        echo '            <span class="price">RM ' . number_format($product['proPrice'], 2) . '</span>';
                                        }
                                        
                                        else {
                                        echo '            <a style="text-decoration: line-through; color: red;">RM ' . number_format($product['proPrice'], 2, '.', '') . '</a>
                                                          <a style="color: orange;">'. $product['proDisc'] .'% off</a>
                                                          <span class="price">RM ' . number_format($product['proPrice']*(1-$product['proDisc']/100), 2, '.', '') . '</span>';
                                        }
                                        
                                        echo '
                                        <br/><button class="btn theme-btn-dash pull-right addToCart">Order Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>';              
                }

                if (!$resultsObtained)
                {
                    echo '<p class="no-recommendations">No results found.</p>';
                }
                
        echo   '</div>
            </div>
        </section>';
    ?>
    <!-- Search part ends-->
  
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
