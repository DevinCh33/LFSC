<header>
    <link rel="stylesheet" type="text/css" href="landing/style.css">
    <img src="landing/logo.png" alt="logo">
    <link rel="icon" type="image/png" sizes="16x16" href="./../landing/logo.png">

    <ul>
        <li <?php echo ($currentPage == 'home') ? 'class="active"' : ''; ?>>
            <a href="index.php">Little Farmer</a>
        </li>
        <li <?php echo ($currentPage == 'market') ? 'class="active"' : ''; ?>>
            <a href="market.php">Market</a>
        </li>
        <li <?php echo ($currentPage == 'merchants') ? 'class="active"' : ''; ?>>
            <a href="restaurants.php">Merchants</a>
        </li>
        <li <?php echo ($currentPage == 'products') ? 'class="active"' : ''; ?>>
            <a href="dishes.php">Product / Cart</a>
        </li>
        <li <?php echo ($currentPage == 'orders') ? 'class="active"' : ''; ?>>
            <a href="your_orders.php">Orders</a>
        </li>

        <?php
        if (isset($_SESSION['adm_id'])) {
            echo '<li><a href="seller/dashboard.php">Dashboard</a></li>';
        }

        echo '<li><a href="logout.php">Logout</a></li>';
        ?>
    </ul>
</header>
