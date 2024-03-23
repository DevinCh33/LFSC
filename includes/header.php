<?php
include("../seller/connect.php");

if (isset($_POST['markRead']) && $_POST['markRead'] == 'true') {
    $query = "UPDATE orders SET is_seen = 1 WHERE is_seen = 0";
    $result = mysqli_query($db, $query);

    if ($result) {
        echo "Notifications marked as read successfully.";
    } else {

        echo "Error marking notifications as read: " . mysqli_error($db);
    }

    exit; 
}

$query = "SELECT o.order_id, o.order_status, r.title AS restaurant_title FROM orders o JOIN restaurant r ON o.order_belong = r.rs_id WHERE o.order_status IN (1, 2, 3) AND o.is_seen = 0";
$result = mysqli_query($db, $query);

$notifications = [];
while ($row = mysqli_fetch_assoc($result)) {
    switch ($row['order_status']) {
        case 1:
            $notifications[] = $row['restaurant_title'] . ": Seller is preparing your order (Order ID: " . $row['order_id'] . ")";
            break;
        case 2:
            $notifications[] = $row['restaurant_title'] . ": Seller is delivering your order (Order ID: " . $row['order_id'] . ")";
            break;
        case 3:
            $notifications[] = $row['restaurant_title'] . ": Order (Order ID: " . $row['order_id'] . ") delivered";
            break;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="landing/style.css" />
    <link rel="icon" type="image/png" sizes="16x16" href="./../landing/logo.png" />
    <title>Your Website Title</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

    <header>
        <img src="landing/logo.png" alt="logo" />

        <ul>
            <li>
                <div class="notification-container">
                    <img src="landing/notification.png" alt="Notifications" class="notification-icon <?php echo count($notifications) > 0 ? 'has-notifications' : ''; ?>" />
                    <div class="notification-dropdown">
                        <div class="notification-top-bar">
                            <span class="notification-title">Notifications (<?php echo count($notifications); ?>)</span>
                            <span id="markAllAsRead" class="mark-all-as-read">Mark all as read</span>
                        </div>
                        <div class="notification-content">
                            <?php if (count($notifications) > 0): ?>
                                <?php foreach ($notifications as $notification): ?>
                                    <div class="notification-item"><?php echo htmlspecialchars($notification); ?></div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="no-notifications">No new notifications</div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </li>
            <li <?php echo ($currentPage == 'home') ? 'class="active"' : ''; ?>><a href="index.php">Home</a></li>
            <li <?php echo ($currentPage == 'market') ? 'class="active"' : ''; ?>><a href="market.php">Market</a></li>
            <li <?php echo ($currentPage == 'merchants') ? 'class="active"' : ''; ?>><a href="restaurants.php">Merchants</a></li>
            <li <?php echo ($currentPage == 'products') ? 'class="active"' : ''; ?>><a href="dishes.php">Products / Cart</a></li>

            <li>
                <div class="my_account_dropdown">
                    <button class="dropbtn">My Account</button>
                    <div class="dropdown-content">
                        <a href="myaccount.php">My Account</a>
                        <a href="your_orders.php">Orders</a>
                        <?php if (isset($_SESSION['adm_id'])): ?>
                        <a href="seller/dashboard.php">Dashboard</a>
                        <?php endif; ?>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </li>

        </ul>
    </header>

    <script>
        $(document).ready(function() {
            $('#markAllAsRead').click(function() {
                $.ajax({
                    type: "POST",
                    url: "includes/header.php",
                    data: { markRead: 'true' },
                    success: function(response) {
                        console.log(response); 
                        $('.notification-icon').removeClass('has-notifications');
                        $('.notification-dropdown').html('<p>No new notifications</p>');
                    },
                    error: function(xhr, status, error) {
                        console.error("Error marking notifications as read:", status, error);
                    }
                });
            });
        });
    </script>




</body>
</html>
