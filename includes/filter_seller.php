<div class="col-xs-12 col-sm-5 col-md-5 col-lg-3">
    <div class="widget clearfix">
        <!-- Widget heading -->
        <div class="widget-heading">
            <h3 class="widget-title text-dark">
                Seller Types
            </h3>
            <div class="clearfix"></div>
        </div>

        <div class="widget-body">
            <ul class="tags">
            <?php
            // Include the database connection
            include("config/connect.php");

            // Check if a category is clicked
            if (isset($_GET['category'])) {
                $category_id = $_GET['category'];
                // Query to fetch categories with associated restaurants
                $query = "SELECT c.categories_id, c.categories_name 
                          FROM categories c
                          INNER JOIN products p ON c.categories_id = p.category_id
                          INNER JOIN restaurant r ON p.restaurant_id = r.rs_id
                          WHERE c.categories_status = 1 AND c.categories_id = $category_id
                          GROUP BY c.categories_id, c.categories_name";
            } else {
                // Query to fetch all restaurants
                $query = "SELECT r.rs_id, r.rs_name 
                          FROM restaurant r";
            }

            $result = mysqli_query($db, $query);

            // Check if there are any categories or restaurants
            if (mysqli_num_rows($result) > 0) {
                // Loop through categories or restaurants and display them as links
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<li><a href="merchants.php?category=' . $row["categories_id"] . '" class="tag">' .
                        $row["categories_name"] . '</a></li>';
                }
            } else {
                echo '<li>No categories found.</li>';
            }
            ?>
            </ul>
        </div>
    </div>
    <!-- end:Widget -->
</div>
