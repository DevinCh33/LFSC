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
$query = "SELECT c_id, c_name FROM res_category";
$result = mysqli_query($db, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<li><a href="merchants.php?category='.$row["c_id"].'"class="tag">'.
    $row["c_name"].'</a></li>';
}
?>
            </ul>
        </div>
    </div>
    <!-- end:Widget -->
</div>
