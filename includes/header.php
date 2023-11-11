<header>
    <link rel="stylesheet" type="text/css" href="landing/style.css">
    <img src="landing/logo.png" alt="logo">

    <?php
        echo '<li><a href="index.php">Little Farmer</a></li>';
        echo '<li><a href="market.php" class="active">Market</a></li>';
        echo '<li><a href="restaurants.php">Merchants</a></li>';
        echo '<li><a href="dishes.php">Product / Cart</a></li>';
        echo '<li><a href="your_orders.php">Orders</a></li>';
        
        if(isset($_SESSION['adm_id']))
        {
            echo '<li><a href="seller/dashboard.php">Dashboard</a></li>';
        }

        echo '<li><a href="logout.php">Logout</a></li>';
    ?>
</header>