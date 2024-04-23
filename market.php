<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Marketplace</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="landing/logo.png">
    
    <style>
        .food-item-wrap {
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease-in-out;
        }

        .food-item-wrap:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="home">
<?php
session_start(); // temp session
error_reporting(0); // hide undefined index errors
include("config/connect.php"); // connection to database
include("config/recommend.php");

if (empty($_SESSION["user_id"])) // if not logged in
{
	header("refresh:0;url=login.php"); // redirect to login.php page
}
?>
    <!--header starts-->
    <?php
    $currentPage = 'market';
    include("includes/header.php");
    ?>

    <!-- banner part starts -->
    <section class="hero">
        <div class="hero-inner">
            <h1>Your One Stop Super Store!</h1></br>
            
            <div class="banner-form">
                <form class="form-inline" action="search.php" method="get">
                    <div class="form-group" style="margin-top:50px;">
                        <label class="sr-only" for="searchQuery">Search product...</label>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" id="searchQuery" name="query" placeholder="Search product...">
                            <input type="submit" class="btn theme-btn btn-lg" value="Search">
                        </div>
                    </div>
                </form>
            </div>
        </div> 
        <!--end:Hero inner -->

    <!-- Search part starts-->
    </section>

    <!-- Recommended products-->
    <section class="recommendations">
    <div class="container">
        <div class="title text-center mb-30">
            <h2>Recommended for You</h2>
            <p class="lead">Based on your recent orders:</p>
        </div>
        <div class="row">
            <?php
            // Four recommended products
            // Most recent order
            $query = "SELECT orders.order_id, orders.user_id, product.product_id, product.categories_id, 
                        product.owner, tblprice.proPrice FROM orders 
                        JOIN order_item ON orders.order_id = order_item.order_item_id 
                        JOIN tblprice ON order_item.priceID = tblprice.priceNo 
                        JOIN product ON tblprice.productID = product.product_id 
                        WHERE user_id = ".$_SESSION["user_id"]." ORDER BY orders.order_id DESC LIMIT 1;";

            $result = mysqli_query($db, $query);

            // Check if there are any products returned by the query
            if ($result && mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);

                $productQuery[0] = "SELECT * from product JOIN tblprice ON product.product_id = tblprice.productID
                                    WHERE product.product_id = ".$data['product_id'];

                // Recommendation from same category
                $productQuery[1] = "SELECT * from product JOIN tblprice ON product.product_id = tblprice.productID
                                    WHERE product.categories_id = ".$data['categories_id']." 
                                    ORDER BY RAND() LIMIT 1";

                // Recommendation from same merchant
                $productQuery[2] = "SELECT * from product JOIN tblprice ON product.product_id = tblprice.productID
                                    WHERE product.owner = ".$data['owner']." 
                                    ORDER BY RAND() LIMIT 1";

                 // Recommendation from similar price range (+- RM 10)
                $productQuery[3] = "SELECT * from product JOIN tblprice ON product.product_id = tblprice.productID
                                    WHERE tblprice.proPrice >= ".((float)$data['proPrice']-10)." 
                                    AND tblprice.proPrice <= ".((float)$data['proPrice']+10)."
                                    ORDER BY RAND() LIMIT 1";

                $recommended[0] = 0;

                for ($i = 0; $i < 8; $i += 2) {
                    $a = mysqli_fetch_assoc(mysqli_query($db, $productQuery[$i/2]));

                    // Check for duplicates
                    if (!in_array($a, $recommended)) {
                        $recommended[$i] = $a;
                        $recommended[$i+1] = $messageRec[$i/2];
                    }

                    // If duplicate, then suggest random product
                    else {
                        $productQuery[$i/2] = "SELECT * from product JOIN tblprice ON product.product_id = tblprice.productID
                                             WHERE tblprice.proDisc > 0
                                             ORDER BY RAND() LIMIT 1";

                        $messageRec[$i/2] = 0;

                        $i -= 2;

                        continue;
                    }
                }

                // Loop through each product and display the card
                for($i = 0; $i < 8; $i += 2) {
                    // Use htmlspecialchars to escape any special characters
                    $productName = htmlspecialchars($recommended[$i]['product_name']);
                    $productImage = htmlspecialchars($recommended[$i]['product_image']);
                    $priceId = $recommended[$i]['priceNo'];

                    // Convert quantity to an integer
                    $productQuantity = intval($recommended[$i]['quantity']);
                    $productWeight = intval($recommended[$i]['proWeight']);

                    $stmt = $db->prepare("SELECT price FROM custom_prices WHERE price_id = ? AND user_id = ?");
                    $stmt->bind_param("ii", $priceId, $_SESSION['user_id']);
                    $stmt->execute();
                    $custom = $stmt->get_result();

                    // Format price to ensure it has two decimal places
                    $productCustomPrice = number_format($custom->fetch_assoc()['price'], 2, '.', '');
                    $productPrice = number_format($recommended[$i]['proPrice'], 2, '.', '');
                    $productDiscount = number_format($recommended[$i]['proDisc']/100, 2, '.', '');
                    $productOwner = number_format($recommended[$i]['owner']);

                    echo '<div class="col-lg-3 col-md-4 col-sm-6 mb-4">';
                    echo '    <div class="card michaelProductCard" style="height: 100vh;">';
                    echo '        <img src="' . $productImage . '" alt="' . $productName . '" class="card-img-top">';
                    echo '        <div class="card-body" data-price-id="'.$priceId.'" data-product-owner="'.$productOwner.'">';
                    echo '            <a href="products.php?res_id='.$productOwner.'"><h5 class="card-title">' . $productName . ' (' . $productWeight . 'g)</h5></a>';
                    echo '            <p class="card-text">Stock: ' . $productQuantity . '</p>';

                    if ($productCustomPrice != 0) {
                    echo '            <span class="card-text">Price: RM ' . $productCustomPrice . '</span>';
                    }

                    else if ($productDiscount == 0) {
                    echo '            <span class="card-text">Price: RM ' . $productPrice . '</span>';
                    }
                    
                    else {
                    echo '            
                                      <p style="text-decoration: line-through; color: red;"> Price: RM ' . $productPrice . '</p>
                                      <p style="color: orange;">'. $productDiscount*100 .'% off</p>
                                      <span>Price: RM ' . number_format($productPrice*(1-$productDiscount), 2, '.', '') . '</span>';
                    }

                    if ($recommended[$i+1] == 0) {
                    echo '            <br/>';
                    }

                    else {
                    echo '            <p class="card-text" style="color: green;">'.$recommended[$i+1].'</p>';
                    }
                    
                    echo '            <button class="btn theme-btn-dash pull-right addmToCart">Order Now</button>';

                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';
                }
                
            } else {
                // No products found
                echo '<div class="col-12"><p>Purchase some products to unlock recommendations!</p></div>';
            }
            ?>
        </div>
    </div>
    </section>
    <!-- Recommended products ends-->

    <!-- Popular block starts -->
    <section class="popular">
        <div class="container">
            <div class="title text-xs-center m-b-30">
                <h2>Categories</h2>
                <p class="lead">Choose from our list of categories!</p>
                <?php
                include("includes/categories_bar.php");
                ?>
            </div>
            <div class="title text-xs-center m-b-30">
                <h2>Merchants</h2>
                <p class="lead">Get to know our trusted sellers!</p>
            </div>
            <div class="row">
                <?php 
                // fetch records from the database to display the first 6 products
                $query_res = mysqli_query($db, "select * from restaurant LIMIT 6"); 
                
                while ($r = mysqli_fetch_array($query_res)) {   
                    echo '<div class="col-xs-12 col-sm-6 col-md-4 food-item">
                            <div class="food-item-wrap">
                                <a href="products.php?res_id=' . $r['rs_id'] . '">
                                    <div class="figure-wrap bg-image" data-image-src="seller/Res_img/' . $r['image'] . '"></div>
                                    <div class="content">
                                        <h4 class="title"><strong>' . $r['title'] . '</strong></h4>
                                        <div class="seller-info text-xs-center">
                                            <div class="email" style="color: black;">' . $r['email'] . '</div></br>
                                            <div class="description" style="color: black;"><i>';

                                            $descriptionText = $r['description'];
                                            $words = explode(" ", $descriptionText);

                                            // Check if the number of words exceeds 12
                                            if (count($words) > 12) {
                                                // Join the first 12 words and append "..."
                                                $truncatedText = implode(" ", array_slice($words, 0, 12)) . "...";
                                                echo $truncatedText;
                                            } else {
                                                echo $descriptionText;
                                            }

                                            echo '</i></div></br>
                                            <div class="phone" style="color: black;"> Phone Number: ' . $r['phone'] . '</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>';
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
