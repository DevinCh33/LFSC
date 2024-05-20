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
        #suggestionList {
            display: none;
            list-style-type: none;
            padding: 0;
        }
        #suggestionList li {
            background-color: #fff;
            padding: 10px;
            padding-left: 30px;
            cursor: pointer;
            text-align: left;
        }
        #suggestionList li:hover {
            background-color: #f0f0f0;
        }
    </style>

    <script>
        function showSuggestions() {
            fetch('./config/recommend.json').then((response) => {
                response.json().then((config) => {
                    var suggestions = config.suggestions;
                    console.log(suggestions)
                    var input = document.getElementById('searchQuery').value;
                    var suggestionList = document.getElementById('suggestionList');

                    // Clear previous suggestions
                    suggestionList.innerHTML = '';

                    // Filter suggestions based on input
                    var filteredSuggestions = suggestions.filter(function(suggestion) {
                        return suggestion.toLowerCase().startsWith(input.toLowerCase());
                    });

                    // Display suggestions
                    if (filteredSuggestions.length > 0) {
                        filteredSuggestions.forEach(function(suggestion) {
                            var li = document.createElement('li');
                            li.textContent = suggestion;
                            li.addEventListener('click',  function() {
                                useSuggestion(suggestion)
                            });
                            suggestionList.appendChild(li);
                        });
                        suggestionList.style.display = 'block';
                    } else {
                        suggestionList.style.display = 'none';
                    }
                })
            })
        }
        function useSuggestion(search) {
            document.getElementById('searchQuery').value = search;
        }
    </script>
</head>

<body class="home">
<?php
include("config/connect.php"); // connection to database
include("config/recommend.php");
include("includes/checks.php");

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
                            <input type="text" class="form-control form-control-lg" id="searchQuery" name="query" placeholder="Search product..." oninput="showSuggestions()" onclick="showSuggestions()" style="width: 550px;">
                            <input type="submit" class="btn theme-btn btn-lg" value="Search">
                        </div>
                        <ul id="suggestionList"></ul>
                    </div>
                </form>
            </div>
        </div> 
        <!--end:Hero inner -->
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
                      JOIN order_item ON orders.order_id = order_item.order_id 
                      JOIN tblprice ON order_item.priceID = tblprice.priceNo 
                      JOIN product ON tblprice.productID = product.product_id 
                      WHERE user_id = ".$_SESSION["user_id"]." AND tblprice.proQuant > 0 AND product.status = 1 ORDER BY orders.order_id DESC LIMIT 1;";

            $result = mysqli_query($db, $query);

            // Check if there are any products returned by the query
            if ($result && mysqli_num_rows($result) > 0) {
                $data = mysqli_fetch_assoc($result);
                $duplicates = new DuplicateCheck();

                $productQuery[0] = "SELECT * from product JOIN tblprice ON product.product_id = tblprice.productID
                                    WHERE product.product_id = ".$data['product_id'];

                // Recommendation from same category
                $productQuery[1] = "SELECT * from product JOIN tblprice ON product.product_id = tblprice.productID
                                    WHERE product.categories_id = ".$data['categories_id']."
                                    AND tblprice.proQuant > 0 AND product.status = 1";

                // Recommendation from same merchant
                $productQuery[2] = "SELECT * from product JOIN tblprice ON product.product_id = tblprice.productID
                                    WHERE product.owner = ".$data['owner']."
                                    AND tblprice.proQuant > 0 AND product.status = 1";

                // Recommendation from similar price range (+- $priceRange as defined in config/recommend.php)
                $productQuery[3] = "SELECT * from product JOIN tblprice ON product.product_id = tblprice.productID
                                    WHERE tblprice.proPrice >= ".((float)$data['proPrice']-$priceRange)." 
                                    AND tblprice.proPrice <= ".((float)$data['proPrice']+$priceRange)." 
                                    AND tblprice.proQuant > 0 AND product.status = 1";

                $recommended[0] = 0;

                for ($i = 0; $i < 8; $i += 2) {
    	            if ($i == 0)
                    {
                        $result = mysqli_query($db, $productQuery[$i/2]);
                    }

                    else
                    {
                        $query = $productQuery[$i/2]." 
                        AND priceNo NOT IN ".$duplicates->List()." 
                        ORDER BY RAND() LIMIT 1";

                        $result = mysqli_query($db, $query);
                    }
                    
                    $result = mysqli_fetch_assoc($result);

                    if ($result != null)
                    {
                        $duplicates->Add($result['priceNo']);
                        $recommended[$i] = $result;
                        $recommended[$i+1] = $messageRec[$i/2];
                    }

                    else
                    {
                        $query = "SELECT * from product JOIN tblprice ON product.product_id = tblprice.productID
                        WHERE tblprice.proDisc > 0 
                        AND tblprice.proQuant > 0 AND product.status = 1 
                        AND priceNo NOT IN ".$duplicates->List()." 
                        ORDER BY RAND() LIMIT 1";

                        $result = mysqli_fetch_assoc(mysqli_query($db, $query));

                        $duplicates->Add($result['priceNo']);
                        $recommended[$i] = $result;
                        $recommended[$i+1] = 0;
                    }
                }

                // Loop through each product and display the card
                for($i = 0; $i < 8; $i += 2) {
                    // Use htmlspecialchars to escape any special characters
                    $productName = htmlspecialchars($recommended[$i]['product_name']);
                    $productImage = htmlspecialchars($recommended[$i]['product_image']);
                    $priceId = $recommended[$i]['priceNo'];

                    // Convert quantity to an integer
                    $productQuantity = intval($recommended[$i]['proQuant']);
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
                    echo '    <div class="card michaelProductCard">';
                    echo '        <img src="' . $productImage . '" alt="' . $productName . '" class="card-img-top">';
                    echo '        <div class="card-body" data-price-id="'.$priceId.'" data-product-owner="'.$productOwner.'">';
                    echo '            <a><h5 class="card-title">' . $productName . ' (' . $productWeight . 'g)</h5></a>';
                    echo '            <p class="card-text">Number Left: ' . $productQuantity . '</p>';

                    if ($productCustomPrice != 0) {
                    echo '            <span class="card-text">Price: RM ' . $productCustomPrice . '</span>';
                    }

                    else if ($productDiscount == 0) {
                    echo '            <span class="card-text">Price: RM ' . $productPrice . '</span>';
                    }
                    
                    else {
                    echo '            
                                      <p class="price-line-through">RM ' . $productPrice . '</p>
                                      <p class="price-discount">'. $productDiscount*100 .'% off</p>
                                      <br/><span>Price: RM ' . number_format($productPrice*(1-$productDiscount), 2, '.', '') . '</span>';
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
                echo '<div class="col-12 no-recommendations"><p>Start searching and purchase more products to unlock recommendations!</p></div>';
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
                if ($recommendMerchantsBasedOnRating) {
                    // Fetch the 6 highest rating merchants
                    $query_res = mysqli_query($db, "SELECT restaurant.*, admin.storeStatus FROM restaurant JOIN admin ON restaurant.rs_id = admin.store JOIN user_ratings ON restaurant.rs_id = user_ratings.res_id WHERE admin.storeStatus = 1 GROUP BY restaurant.rs_id ORDER BY AVG(user_ratings.rating) DESC LIMIT 6");
                }

                else
                {
                    // Fetch records from the database to display the first 6 merchants
                    $query_res = mysqli_query($db, "SELECT restaurant.*, admin.storeStatus FROM restaurant JOIN admin ON restaurant.rs_id = admin.store WHERE admin.storeStatus = 1 LIMIT 6");
                }
                 
                while ($r = mysqli_fetch_array($query_res)) {   
                    echo '<div class="col-xs-12 col-sm-6 col-md-4 food-item">
                            <div class="food-item-wrap">
                                <a href="products.php?res_id=' . $r['rs_id'] . '">
                                    <div class="figure-wrap bg-image" data-image-src="seller/Res_img/' . $r['image'] . '"></div>
                                    <div class="content">
                                        <h4 class="title text-description-bigger"><strong>' . $r['title'] . '</strong></h4>
                                        <div class="seller-info text-xs-center">
                                            <div class="email text-description" style="color: black;">' . $r['email'] . '</div></br>
                                            <div class="description text-description" style="color: black;"><i>';

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
                                            <div class="phone" style="color: black;">Phone Number: ' . $r['phone'] . '</div>
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
