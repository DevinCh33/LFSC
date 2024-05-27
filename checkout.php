<!DOCTYPE html>
<html lang="en">

<?php
include("config/connect.php");

if (empty($_SESSION['user_id'])) {
    header('location:login.php');
} else {
    if ($_POST['submit']) {
        $today = date("Y/m/d");
        $groupedProducts = [];
        $user = "SELECT * FROM users WHERE u_id = '" . $_SESSION['user_id'] . "'";
        $user1 = $db->query($user);
        $user2 = $user1->fetch_array();

        foreach ($_SESSION["cart"] as $product) {
            $ownerId = $product['owner'];
            $groupedProducts[$ownerId][] = $product;
        }

        $times = 0;
        foreach ($groupedProducts as $ownerId => $products) {
            $totalPrice = 0;
            $payment_type = 1; 
            if ($_POST['mod'] == 'ewallet') {
                $payment_type = 2;
            } else if ($_POST['mod'] == 'paypal') {
                $payment_type = 3;
            }

            $sql = "INSERT INTO orders (order_date, client_name, client_contact, sub_total, total_amount, paid, due, payment_type, order_status, user_id, order_belong) 
                    VALUES ('$today', '" . $user2['fullName'] . "', '" . $user2['phone'] . "', 0, 0, 0, 0, $payment_type, 1, " . $_SESSION['user_id'] . ", $ownerId)";

            if ($db->query($sql) === true) {
                $order_id = $db->insert_id;
                $orderStatus = true;
                foreach ($products as $item) {
                    $item_total = ($item["price"] * $item["quantity"]);
                    $totalPrice += $item_total;
                    $updateProductQuantitySql = "SELECT tblprice.proQuant FROM tblprice WHERE tblprice.priceNo = " . $item['price_id'];
                    $updateProductQuantityData = $db->query($updateProductQuantitySql);
                    while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
                        $updateQuantity = $updateProductQuantityResult[0] - $item['quantity'];
                        $db->query("UPDATE tblprice SET proQuant = '" . $updateQuantity . "' WHERE priceNo = '" . $item['price_id'] . "'");
                        $db->query("INSERT INTO order_item (order_id, priceID, quantity) VALUES ('$order_id', '" . $item['price_id'] . "', '" . $item['quantity'] . "')");
                    }
                    $times++;
                }
                $db->query("UPDATE orders SET sub_total = '$totalPrice', due= '$totalPrice', total_amount = '$totalPrice' WHERE order_id = '$order_id'");

                if ($payment_type == 2) {
                    header("Location: ewalletpayment.php?order_id=$order_id");
                    exit;
                }
            }
        }
        if ($times == count($_SESSION["cart"])) {
            echo "<script>alert('Thank you! Your order has been placed successfully!'); window.location.href='market.php';</script>";
            unset($_SESSION["cart"]);
        }
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Checkout</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="landing/logo.png">
</head>

<body>
    <div class="site-wrapper">
        <!--header starts-->
        <?php
        include("includes/header.php");
        ?>

        <div class="page-wrapper" style="padding-top: 5%;">
            <div class="top-links">
                <div class="container">
                    <ul class="row links"> 
                        <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="merchants.php">Choose Merchant</a></li>
                        <li class="col-xs-12 col-sm-4 link-item "><span>2</span><a href="#">Pick Your Products</a></li>
                        <li class="col-xs-12 col-sm-4 link-item active" ><span>3</span><a href="checkout.php">Order and Pay online</a></li>
                    </ul>
                </div>
            </div>
  
            <div class="container m-t-30">
			<form action="" method="post">
                <div class="widget clearfix">
                    <div class="widget-body">
                        <form method="post" action="#">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="cart-totals margin-b-20">
                                        <div class="cart-totals-title">
                                            <h4>Cart Summary</h4> </div>
                                        <div class="cart-totals-fields">
                                            <table class="table">
											<tbody>
                                                <tr>
                                                    <td>Cart Subtotal</td>
                                                    <td class="cartTotal text-color">RM 0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping &amp; Handling</td>
                                                    <td>Shipping Included</td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--cart summary-->
                                    <div class="payment-option">
                                        <ul class=" list-unstyled">
                                            <li>
                                                <label class="custom-control custom-radio  m-b-20">
                                                    <input name="mod" id="radioStacked1" checked value="COD" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Cash on Delivery</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="custom-control custom-radio  m-b-20">
                                                    <input name="mod" id="radioStacked1" value="ewallet" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">E-wallet</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="custom-control custom-radio  m-b-10">
                                                    <input name="mod"  type="radio" value="paypal" disabled class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Paypal <img src="images/paypal.jpg" alt="" width="90"></span> </label>
                                            </li>
                                        </ul>
                                        <p class="text-xs-center"> <input id="confirmOrder" type="submit" onclick="return confirm('Are you sure?');" name="submit"  class="btn btn-outline-success btn-block" value="Order Now"> </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
			</form>
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
    <script src="js/spay.js"></script>
</body>
</html>
