<?php
include("connection/connect.php"); // connection to database
if (isset($_GET['res_id']))
{
    $d_id = $_GET['res_id'];
}

else
{
    $d_id = 51; // hardcoded
}

$query = "SELECT * from restaurant where rs_id = ".$d_id;
$result = mysqli_query($db, $query); // executing
$row = mysqli_fetch_assoc($result);
?>
<footer class="footer">
    <div class="container">
        <!-- top footer statrs -->
        <div class="row top-footer">
            <div class="col-xs-12 col-sm-3 footer-logo-block color-gray">
                <img class="img-rounded" width="225" height="225" src="seller/Res_img/<?php echo $row['image'];?>" alt="seller logo">
            </div>
            
            <div class="col-xs-12 col-sm-2 pages color-gray">
                <h5>Pages</h5>
                <ul>
                    <li><a href="index.php">Little Farmer</a> </li>
                    <li><a href="market.php">Market</a> </li>
                    <li><a href="merchants.php">Merchants</a> </li>
                    <li><a href="products.php?res_id=<?php echo $d_id;?>">Products / Cart</a> </li>
                    <li><a href="your_orders.php">Orders</a> </li>
                </ul>
            </div>

            <div class="col-xs-12 col-sm-2 how-it-works-links color-gray">
                <?php
                if (isset($row['o_days']))
                {
                echo '<h5>Operating Hours</h5>';
                $openings = $row['o_days'];
                    
                if (isset($row['o_hr']) && $row['c_hr'])
                {
                    $openings=$openings.": ".$row['o_hr']." - ".$row['c_hr'];
                }

                echo '<p>'.$openings.'</p>';
                }
                ?>
            </div>
            
            <div class="col-xs-12 col-sm-3 popular-locations color-gray">
                <?php
                if (isset($row['url']))
                {
                echo '<h5>Website</h5>';
                echo '<p>'.$row['url'].'</p>';
                }
                ?>
            </div>

            <div class="col-xs-12 col-sm-2 WhatsApp color-gray">
                <?php
                if (isset($row['phone']))
                {
                echo '<h5>Contact</h5>';
                echo '<p>WhatsApp:<a href="https://api.whatsapp.com/send?phone='.$row['phone'].'"><br/>'.$row['phone'].'</a></p>';
                }
                ?>
            </div>
        </div>
        <!-- top footer ends -->
        <!-- bottom footer statrs -->
        <div class="bottom-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-6 address color-gray">
                    <?php
                    if (isset($row['address']))
                    {
                    echo '<h5>Address</h5>';
                    echo '<p>'.$row['address'].'</p></div>';
                    }
                    ?>
            </div>
        </div>
        <!-- bottom footer ends -->
    </div>
</footer>
