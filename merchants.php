<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Merchants</title>
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

if (empty($_SESSION["user_id"])) // if not logged in
{
	header("refresh:0;url=login.php"); // redirect to login.php page
}
?>
    <!--header starts-->
    <?php
    $currentPage = 'merchants';
    include("includes/header.php");
    ?>
    
    <div class="page-wrapper" >
        <!-- top Links -->
        <div class="top-links">
            <div class="container">
                <ul class="row links">
                    <li class="col-xs-12 col-sm-4 link-item active"><span>1</span><a href="merchants.php">Choose Merchant</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Pick Your Products</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order and Pay Online</a></li>
                </ul>
            </div>
        </div>
        <!-- end:Top links -->
        <!-- start: Inner page hero -->
        <div class="inner-page-hero bg-image" data-image-src="images/img/main.jpeg">
            <div class="container"> </div>
            <!-- end:Container -->
        </div>

        <div class="banner-form" style = "text-align: center;margin-bottom:20px;">
            <form class="form-inline" method="get">
                <div class="form-group" style="margin-top:50px;">
                    <label class="sr-only" for="exampleInputAmount">Search merchant....</label>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg" id="exampleInputAmount" name="search" value="<?php if(isset($_GET['search'])) { echo htmlentities ($_GET['search']); }?>" placeholder="Search merchant..." style="width: 700px; margin: 0 auto; ">
                        <input type="submit" class="btn theme-btn btn-lg" value="Search" style="margin-right: 75px;">
                    </div>
                </div>
            </form>
        </div>
        <!-- Search part ends-->

        <!-- Results show -->
        <section class="restaurants-page" style="margin-left: 12vw;">
    <div class="container">
        <div class="row">
            <?php
            // include("includes/filter_seller.php");
            ?>    
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-9 mx-auto">
                <div class="bg-gray restaurant-entry">
                    <div class="row">
                        <?php 
                        if (isset($_GET['search'])) {
                            $searchTerm = addslashes($_GET['search']);
                            $query = "SELECT restaurant.*, admin.storeStatus FROM restaurant JOIN admin ON restaurant.rs_id = admin.store WHERE admin.storeStatus = 1 AND restaurant.title LIKE '%$searchTerm%' LIMIT 12";
                        }
                        elseif (isset($_GET['category'])) {
                            $query = "SELECT restaurant.*, admin.storeStatus FROM restaurant JOIN admin ON restaurant.rs_id = admin.store WHERE admin.storeStatus = 1 AND restaurant.c_id = ".addslashes($_GET['category']);
                        } else {
                            $query = "SELECT restaurant.*, admin.storeStatus FROM restaurant JOIN admin ON restaurant.rs_id = admin.store WHERE admin.storeStatus = 1";
                        }

                        $ress = mysqli_query($db, $query);

                        while($rows = mysqli_fetch_array($ress)) {
                            echo '<div class="col-sm-12 col-md-12 col-lg-8 text-xs-center text-sm-left">
                                <div class="entry-logo">
                                    <a class="img-fluid" href="products.php?res_id='.$rows['rs_id'].'" > <img src="seller/Res_img/'.$rows['image'].'" alt="Merchant logo"></a>
                                </div>
                                <!-- end:Logo -->
                                <div class="entry-dscr">
                                    <h5><a href="products.php?res_id='.$rows['rs_id'].'" >'.$rows['title'].'</a></h5>
                                    <span>'.substr($rows['description'], 0, 120);
                                    
                            if (strlen($rows['description']) > 120) {
                                echo '...';
                            }

                            echo '</span></br></br><span>'.$rows['address'].' <a href="#">...</a></span>
                                </div>
                                <!-- end:Entry description -->
                            </div>';

                            // Generate the rating block inside the loop
                            echo '<div class="col-sm-12 col-md-12 col-lg-4 text-xs-center">
                                    <div class="right-content bg-white">
                                        <div class="right-review">
                                            <div class="rating-block" data-resid="'.$rows['rs_id'].'" data-rating="'.$rating.'">';
                                            echo '<p class="average-rating">Rate Here: </p>';            
                            // Loop through 5 stars and generate each one dynamically
                            for ($i = 1; $i <= 5; $i++) {
                                // Check if the star should be active or inactive
                                $class = ($i <= 0) ? 'star-active' : 'star-inactive';
                                echo '<i class="fa fa-star '.$class.'"></i>';
                            }
                            
                            echo '</div>';
                     
                            // Fetch average rating from the database
                            $avgRatingQuery = "SELECT AVG(rating) AS average_rating FROM user_ratings WHERE res_id = ".$rows['rs_id'];
                            $avgRatingResult = mysqli_query($db, $avgRatingQuery);
                            $avgRatingRow = mysqli_fetch_assoc($avgRatingResult);
                            $averageRating = $avgRatingRow['average_rating'];
                        
                            echo '<p class="average-rating">Avg Rating: ' . number_format($averageRating, 1) . '</p>';
                            
                            echo '<a href="products.php?res_id='.$rows['rs_id'].'" class="btn theme-btn-dash">View Merchant</a>
                                </div>
                            </div>
                        </div>'; // End of rating block
                        }
                        ?>
                    </div>
                    <!--end:row -->
                </div>   
            </div>
        </div>
    </div>
</section>


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
    <script src="js/rating.js"></script>
</body>
</html>
