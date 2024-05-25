<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
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
                    <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="merchants.php">Choose Merchant</a></li>
                    <li class="col-xs-12 col-sm-4 link-item active"><span>2</span><a href="products.php?merchant=<?php echo $_GET['merchant']; ?>">Pick Your Products</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Order and Pay Online</a></li>
                </ul>
            </div>
        </div>
        <!-- end:Top links -->

        <?php
            $ress = mysqli_query($db,"select * from restaurant where rs_id='$_GET[merchant]'");
            $rows = mysqli_fetch_array($ress);                                
        ?>

        <section class="inner-page-hero bg-image" data-image-src="images/img/dish.jpeg">
            <div class="profile">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12  col-md-4 col-lg-4 profile-img">
                            <div class="image-wrap">
                                <figure><?php echo '<img src="seller/'.$rows['image'].'" alt="Merchant logo">'; ?></figure>
                            </div>  
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 profile-desc">
                            <div class="pull-left right-text white-txt">
                                <h6><a href="#"><?php echo $rows['title']; ?></a></h6>
                                <p><?php echo $rows['description']; ?></p>
                                <p><?php echo $rows['address']; ?></p>
                                <div class="featured-restaurants">
                                    <div class="nav-item ratings">
                                        <span>
                                        <?php
                                        // Fetch average rating from the database
                                        $ratingQuery = "SELECT AVG(rating) AS average_rating, COUNT(rating) AS rating_count FROM user_ratings WHERE res_id = ".$_GET['merchant'];
                                        $ratingResult = mysqli_query($db, $ratingQuery);
                                        $ratingRow = mysqli_fetch_assoc($ratingResult);

                                        // Loop through 5 stars and generate each one dynamically
                                        for ($i = 1; $i <= number_format($ratingRow['average_rating']); $i++) {
                                            // Check if the star should be active or inactive
                                            echo '<i class="fa fa-star active"></i>';
                                        }
                                        ?>

                                        <p><?php echo $ratingRow['rating_count'];?> Reviews</p>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!-- Section for viewing comments start -->
<hr class="mb-1">
        <h2>All Comments</h2>
        <hr class="mb-1"> <!-- Add a horizontal rule for visual separation -->

    <?php
    session_start();
    include("config/connect.php");

    if (empty($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }

    $res_id = $_GET['merchant'];
    $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'desc';
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $commentsPerPage = isset($_GET['per_page']) ? $_GET['per_page'] : 5;
    $offset = ($currentPage - 1) * $commentsPerPage;

    $totalCountQuery = "SELECT COUNT(*) AS total FROM user_comments WHERE res_id = $res_id";
    $totalCountResult = mysqli_query($db, $totalCountQuery);
    $totalCountRow = mysqli_fetch_assoc($totalCountResult);
    $totalComments = $totalCountRow['total'];
    $totalPages = ceil($totalComments / $commentsPerPage);

    $query = "SELECT * FROM user_comments WHERE res_id = $res_id ORDER BY created_at $sortOrder LIMIT $offset, $commentsPerPage";
    $result = mysqli_query($db, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($db));
    }

    $commentsForPage = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>



    <div class="sorting-options">
        <form action="" method="GET">
            <input type="hidden" name="merchant" value="<?php echo $res_id; ?>">
            <label for="sort">Sort By:</label>
            <select id="sort" name="sort" onchange="this.form.submit()">
                <option value="desc" <?php echo ($sortOrder == 'desc' ? 'selected' : ''); ?>>Oldest First</option>
                <option value="asc" <?php echo ($sortOrder == 'asc' ? 'selected' : ''); ?>>Newest First</option>
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Posted on</th>
                </tr>
            </thead>
            <tbody>
                <?php
                function generateRandomName() {
                    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $length = rand(5, 8);
                    $name = '';
                    for ($i = 0; $i < $length; $i++) {
                        $name .= $characters[rand(0, strlen($characters) - 1)];
                    }
                    return substr_replace($name, '****', -4);
                }

                $generatedNames = array();
                foreach ($commentsForPage as $row) {
                    if (!isset($generatedNames[$row['user_id']])) {
                        $generatedNames[$row['user_id']] = generateRandomName();
                    }
                    echo '<tr>';
                    echo '<td>' . $generatedNames[$row['user_id']] . '</td>';
                    echo '<td>' . $row['created_at'] . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="3">' . $row['comment'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <?php
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i > 1) {
                echo ', ';
            }
            echo '<a href="all_comments.php?merchant=' . $res_id . '&per_page=' . $commentsPerPage . '&page=' . $i . '&sort=' . $sortOrder . '">' . $i . '</a>';
        }
        ?>
    </div>
          
    <!-- start: FOOTER -->
    <?php
    include("includes/footer_seller.php");
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
    <script src="js/rating_product.js"></script>
    <script src="js/rating.js"></script>
    <script src="js/comment.js"></script>
    <script src="js/allcomments.js"></script>
</body>
</html>
