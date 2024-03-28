<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Combined Graphs</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        h1{
            text-decoration: underline;
            font-size: 30px;
        }
        table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 50px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4CAF50; /* Green */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
        .chart-container {
            width: 80%;
            height: 80%;
            margin: 5% auto 30% auto;
        }
    </style>
</head>
<body>
    <div class="sidebar close">
        <?php include "sidebar.php"; ?>
    </div>
    <section class="home-section">
        <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Reports</span>
        </div>
        <h1 style = "text-align:center;">Product Report</h1>
        <?php
        // Include necessary PHP code to establish database connection
        include 'connect.php';

        // Perform the SQL query to get the quantity of orders over time
        $sql_orders = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS order_month, SUM(quantity) AS total_quantity 
                    FROM order_item oi
                    JOIN orders o ON oi.order_id = o.order_id
                    GROUP BY DATE_FORMAT(order_date, '%Y-%m') 
                    ORDER BY order_date";

        $result_orders = mysqli_query($db, $sql_orders);

        // Fetch order data into an array
        $data_orders = array();
        while ($row_orders = mysqli_fetch_assoc($result_orders)) {
            $data_orders[] = $row_orders;
        }

        // Perform the SQL query to get the top 5 best-selling products
        $sql_best_sellers = "SELECT p.product_name, SUM(oi.quantity) AS total_quantity_sold
                            FROM order_item oi
                            INNER JOIN tblprice t ON oi.priceID = t.priceNo
                            INNER JOIN product p ON t.productID = p.product_id
                            GROUP BY p.product_name
                            ORDER BY total_quantity_sold DESC
                            LIMIT 5";

        $result_best_sellers = mysqli_query($db, $sql_best_sellers);

        // Display the chart container
        echo '<div class="chart-container">';
        echo '<h1>Quantity of Orders Over Time</h1>';
        echo '<canvas id="ordersChart" width="400" height="200"></canvas>';
        // Initialize variables to store best seller information
        $bestSellerMonth = "";
        $maxQuantity = 0;

        // Loop through the data to find the best seller
        foreach ($data as $item) {
            if ($item['total_quantity'] > $maxQuantity) {
                $maxQuantity = $item['total_quantity'];
                $bestSellerMonth = $item['order_month'];
            }
        }

        // Display message about the best seller
        if ($bestSellerMonth != "") {
            echo "<p><strong>The graph represents the quantity of orders over time,</strong> indicating the number of orders made each month. After analyzing the data, <strong>we identified the best-selling month as $bestSellerMonth,</strong> with a remarkable total quantity of <strong>$maxQuantity orders.</strong> This peak in sales highlights a period of high demand, demonstrating the popularity of our products during that time.</p>";
        } else {
            echo "<p><strong>The graph represents the quantity of orders over time,</strong> indicating the number of orders made each month. Unfortunately, <strong>we couldn't determine the best-selling month</strong> as there is no data available to provide insights into the most successful period. It's essential to continuously monitor and analyze sales trends to identify patterns and optimize our business strategies.</p>";
        }

        // Display the top 5 best-selling products
        echo '<h2>Top 5 Best-Selling Products</h2>';
        echo '<ol>';
        while ($row_best_seller = mysqli_fetch_assoc($result_best_sellers)) {
            $product_name = $row_best_seller['product_name'];
            $total_quantity_sold = $row_best_seller['total_quantity_sold'];
            echo "<li>$product_name - Total Quantity Sold: $total_quantity_sold</li>";
        }
        echo '</ol>';

        // Close the database connection
        mysqli_close($db);
        ?>

        <script>
            var data = <?php echo json_encode($data_orders); ?>;
            
            // Extract labels (order months) and quantity data
            var labels = data.map(item => item.order_month);
            var quantityData = data.map(item => item.total_quantity);

            var ctx = document.getElementById('ordersChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line', // Change type to line
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Quantity of Orders',
                        data: quantityData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>
        </div>


        <div class="chart-container" >
            <h1>Market Share Pie Chart</h1>
            <canvas id="marketShareChart" width="800" height="400"></canvas>

           <?php
                // Include necessary PHP code to establish database connection
                include 'connect.php';

                // Perform the SQL query to calculate total sales amount for each product
                $sql = "SELECT p.product_name, SUM(oi.quantity * tp.proPrice) AS total_sales
                        FROM order_item oi
                        JOIN tblprice tp ON oi.priceID = tp.priceNo
                        JOIN product p ON tp.productID = p.product_id
                        GROUP BY p.product_id";

                $result = mysqli_query($db, $sql);

                // Fetch data into an array
                $data = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }

                // Calculate total sales across all products
                $totalSales = array_sum(array_column($data, 'total_sales'));

                // Calculate market share for each product and generate explanation
                $graphExplanation = "<p><strong>Market Share Pie Chart Explanation:</strong></p>";
                $graphExplanation .= "<p>The Market Share Pie Chart illustrates the distribution of sales among different products based on the data obtained.</p>";
                $graphExplanation .= "<p>Here is the breakdown:</p>";

                foreach ($data as &$product) {
                    // Calculate market share percentage for each product
                    $product['market_share'] = ($product['total_sales'] / $totalSales) * 100;
                    $productName = $product['product_name'];
                    $totalSalesAmount = $product['total_sales'];
                    $marketSharePercentage = round($product['market_share'], 2);

                    // Add product-specific information to the explanation
                    $graphExplanation .= "<p><strong>$productName:</strong> Total Sales: $totalSalesAmount, Market Share: $marketSharePercentage%</p>";
                }

                // Add overall insights
                $graphExplanation .= "<p>This visualization helps in understanding the relative market share of each product in the sales landscape. Products with higher percentages indicate a larger share of total sales.</p>";

                // Close the database connection
                mysqli_close($db);

                // Output the graph explanation message
                echo $graphExplanation;
            ?>


            <script>
                var data = <?php echo json_encode($data); ?>;
                
                // Extract product names and market share percentages
                var productNames = data.map(item => item.product_name);
                var marketShareData = data.map(item => item.market_share);

                var ctx = document.getElementById('marketShareChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'pie', // Use pie chart for market share
                    data: {
                        labels: productNames,
                        datasets: [{
                            label: 'Market Share (%)',
                            data: marketShareData,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                                // Add more colors if needed
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                                // Add more colors if needed
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            </script>
        </div>

        <div class="chart-container" >
            <h1>Product Performance by Region Graph</h1>
            <canvas id="productPerformanceChart" width="800" height="400"></canvas>

            <?php
            // Include necessary PHP code to establish database connection
            include 'connect.php';

            // Perform the SQL query to calculate total sales amount for each region and product
            $sql = "SELECT p.product_name, c.categories_name, SUM(oi.quantity * tp.proPrice) AS total_sales
                    FROM order_item oi
                    JOIN tblprice tp ON oi.priceID = tp.priceNo
                    JOIN product p ON tp.productID = p.product_id
                    JOIN categories c ON p.categories_id = c.categories_id
                    GROUP BY p.product_id, c.categories_id";

            $result = mysqli_query($db, $sql);

            // Fetch data into an array
            $data = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            // Close the database connection
            mysqli_close($db);

          // Calculate total sales for each category
            $categorySales = array();
            foreach ($data as $item) {
                $category = $item['categories_name'];
                $sales = $item['total_sales'];
                if (!isset($categorySales[$category])) {
                    $categorySales[$category] = 0;
                }
                $categorySales[$category] += $sales;
            }

            // Find the most popular category
            $mostPopularCategory = '';
            $maxSales = 0;
            foreach ($categorySales as $category => $sales) {
                if ($sales > $maxSales) {
                    $mostPopularCategory = $category;
                    $maxSales = $sales;
                }
            }
            echo "<p>The graph illustrates product sales across various categories and regions. Each bar represents the total sales volume of a product category, providing insights into relative performance and identifying popular categories.</p>";

            // Output the message
            echo "<p>The most popular product category, <strong>$mostPopularCategory</strong>, leads with total sales reaching <strong>$maxSales</strong>. This insight assists in directing marketing strategies and optimizing inventory based on sales performance.</p>";

            ?>

            <script>
                    var data = <?php echo json_encode($data); ?>;
                    
                    // Extract product names, region names, and total sales data
                    var productNames = [];
                    var regionNames = [];
                    var salesData = [];

                    data.forEach(item => {
                        if (!productNames.includes(item.product_name)) {
                            productNames.push(item.product_name);
                        }
                        if (!regionNames.includes(item.categories_name)) {
                            regionNames.push(item.categories_name);
                        }
                    });

                    // Initialize sales data array
                    for (var i = 0; i < productNames.length; i++) {
                        salesData[i] = new Array(regionNames.length).fill(0);
                    }

                    // Populate sales data array
                    data.forEach(item => {
                        var productIndex = productNames.indexOf(item.product_name);
                        var regionIndex = regionNames.indexOf(item.categories_name);
                        salesData[productIndex][regionIndex] = item.total_sales;
                    });

                    var ctx = document.getElementById('productPerformanceChart').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: productNames,
                            datasets: regionNames.map((region, index) => {
                                return {
                                    label: region,
                                    data: salesData.map(product => product[index]),
                                    backgroundColor: 'rgba(' + (Math.random() * 255) + ', ' + (Math.random() * 255) + ', ' + (Math.random() * 255) + ', 0.5)',
                                    borderColor: 'rgba(' + (Math.random() * 255) + ', ' + (Math.random() * 255) + ', ' + (Math.random() * 255) + ', 1)',
                                    borderWidth: 1
                                };
                            })
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                </script>
        </div>

        <div class="chart-container" style="margin-top: 10%;">
        <h1>Sales Report</h1>
        <?php
// Include necessary PHP code to establish database connection
include 'connect.php';

// Default values
$search_value = "";
$search_type = "username";
$username_title = "Sales Report";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the search value and type from the form
    $search_value = $_POST["search_value"];
    $search_type = $_POST["search_type"];

    // Perform the SQL query based on search type
    if ($search_type == "username") {
        $sql = "SELECT oi.order_item_id, p.product_name, p.descr AS item_description, tp.proPrice AS price, oi.quantity,
                    (tp.proPrice * oi.quantity) AS amount
                FROM order_item oi
                INNER JOIN tblprice tp ON oi.priceID = tp.priceNo
                INNER JOIN product p ON tp.productID = p.product_id
                INNER JOIN orders o ON oi.order_id = o.order_id
                INNER JOIN users u ON o.user_id = u.u_id
                WHERE u.username LIKE '%$search_value%'";
        $username_title = "Sales Report of $search_value";
    } else {
        $sql = "SELECT oi.order_item_id, p.product_name, p.descr AS item_description, tp.proPrice AS price, oi.quantity,
                    (tp.proPrice * oi.quantity) AS amount
                FROM order_item oi
                INNER JOIN tblprice tp ON oi.priceID = tp.priceNo
                INNER JOIN product p ON tp.productID = p.product_id
                INNER JOIN orders o ON oi.order_id = o.order_id
                INNER JOIN users u ON o.user_id = u.u_id
                WHERE u.u_id = '$search_value'";
        $username_title = "Sales Report of User ID: $search_value";
    }
    
    // Execute the query
    $result = mysqli_query($db, $sql);
} else {
    // If form is not submitted, default to showing sales report for the top user with the highest spending amount
    $sql = "SELECT oi.order_item_id, p.product_name, p.descr AS item_description, tp.proPrice AS price, oi.quantity,
                (tp.proPrice * oi.quantity) AS amount
            FROM order_item oi
            INNER JOIN tblprice tp ON oi.priceID = tp.priceNo
            INNER JOIN product p ON tp.productID = p.product_id
            INNER JOIN orders o ON oi.order_id = o.order_id
            INNER JOIN users u ON o.user_id = u.u_id
            ORDER BY amount DESC
            LIMIT 1";

    // Execute the query
    $result = mysqli_query($db, $sql);

    // Check if the search value is empty
    if(empty($_POST['search_value'])) {
        $search_value = ""; // Set search value to empty
    }
}

// Initialize total sales amount
$total_sales = 0;

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    echo "<div class='chart-container' style='margin-top: 10%;'>";
    echo "<h2>$username_title</h2>";
    echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
    echo "<label for='search_value'>Search:</label>";
    echo "<input type='text' name='search_value' id='search_value' value='$search_value'>";
    echo "<select name='search_type' id='search_type'>";
    echo "<option value='username' " . ($search_type == 'username' ? 'selected' : '') . ">Username</option>";
    echo "<option value='u_id' " . ($search_type == 'u_id' ? 'selected' : '') . ">User ID</option>";
    echo "</select>";
    echo "<input type='submit' value='Search'>";
    echo "</form>";
    echo "<table border='1'>";
    echo "<tr><th>ITEM NO</th><th>ITEM NAME</th><th>ITEM DESCRIPTION</th><th>PRICE (RM)</th><th>QUANTITY</th><th>TOTAL (RM)</th></tr>";

    // Fetch and display each row of the result
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['order_item_id'] . "</td>";
        echo "<td>" . $row['product_name'] . "</td>";
        echo "<td>" . $row['item_description'] . "</td>";
        echo "<td>" . number_format($row['price'], 2) . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . number_format($row['amount'], 2) . "</td>";

        // Add amount to total sales
        $total_sales += $row['amount'];

        echo "</tr>";
    }

    // Add total sales row
    echo "<tr><td colspan='5' align='right'><strong>Total Sales:</strong></td><td>" . number_format($total_sales, 2) . "</td></tr>";

    echo "</table>";
    echo "</div>";
} else {
    echo "<div class='chart-container' style='margin-top: 10%;'>";
    echo "<h2>$username_title</h2>";
    echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
    echo "<label for='search_value'>Search:</label>";
    echo "<input type='text' name='search_value' id='search_value' value='$search_value'>";
    echo "<select name='search_type' id='search_type'>";
    echo "<option value='username' " . ($search_type == 'username' ? 'selected' : '') . ">Username</option>";
    echo "<option value='u_id' " . ($search_type == 'u_id' ? 'selected' : '') . ">User ID</option>";
    echo "</select>";
    echo "<input type='submit' value='Search'>";
    echo "</form>";
    echo "No sales data available.";
    echo "</div>";
}

// Close the database connection
mysqli_close($db);
?>


        <div class="chart-container" style="margin-top: 10%;">

            <!-- Data Analytics Report Summary -->
        <h1>Product Review Table</h1>
        
<!-- Display form to input rs_id -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="rs_id">Restaurant ID:</label>
    <input type="text" id="rs_id" name="rs_id">
    <input type="submit" value="Submit">
</form>

        <?php
// Include the connection file
include 'connect.php';

// Check if rs_id is provided in the form submission
if (isset($_POST['rs_id'])) {
    // Get the rs_id from the form
    $rs_id = $_POST['rs_id'];

    
    
    // SQL query to retrieve product report data for the provided rs_id
    $sql = "SELECT p.product_id AS 'No.', p.owner AS 'Restaurant ID', r.title AS 'Restaurant Title', CONCAT(p.product_name, ' (', tp.proWeight, ')') AS 'Product Name and Weight', p.descr AS 'Description', c.categories_name AS 'Category', p.quantity AS 'Quantity', p.product_date AS 'Product Date', p.lowStock AS 'Low Stock', FORMAT(tp.proPrice, 2) AS 'Price (RM)', oi.quantity AS 'Ordered Quantity'
            FROM product p
            JOIN categories c ON p.categories_id = c.categories_id
            JOIN tblprice tp ON p.product_id = tp.productID
            LEFT JOIN order_item oi ON tp.priceNo = oi.priceID
            LEFT JOIN restaurant r ON p.owner = r.rs_id
            WHERE r.rs_id = $rs_id";
} else {
    // No rs_id provided, retrieve the top restaurant
    $sql = "SELECT p.product_id AS 'No.', p.owner AS 'Restaurant ID', r.title AS 'Restaurant Title', CONCAT(p.product_name, ' (', tp.proWeight, ')') AS 'Product Name and Weight', p.descr AS 'Description', c.categories_name AS 'Category', p.quantity AS 'Quantity', p.product_date AS 'Product Date', p.lowStock AS 'Low Stock', FORMAT(tp.proPrice, 2) AS 'Price (RM)', oi.quantity AS 'Ordered Quantity'
            FROM product p
            JOIN categories c ON p.categories_id = c.categories_id
            JOIN tblprice tp ON p.product_id = tp.productID
            LEFT JOIN order_item oi ON tp.priceNo = oi.priceID
            LEFT JOIN restaurant r ON p.owner = r.rs_id
            ORDER BY r.rs_id ASC
            LIMIT 1";
}

// Execute the query
$result = $db->query($sql);

// Initialize counter
$counter = 1;

// Check if there are results
if ($result->num_rows > 0) {
    // Output table headers
    echo "<table>";
    echo "<tr><th>NO.</th><th>RESTAURANT TITLE</th><th>PRODUCT NAME AND WEIGHT</th><th>DESCRIPTION</th><th>CATEGORY</th><th>PRODUCT DATE</th><th>PRICE (RM)</th><th>ORDERED QUANTITY</th></tr>";
    
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $counter . "</td>";
        echo "<td>" . $row["Restaurant Title"] . "</td>";
        echo "<td>" . $row["Product Name and Weight"] . "</td>";
        echo "<td>" . $row["Description"] . "</td>";
        echo "<td>" . $row["Category"] . "</td>";
        echo "<td>" . $row["Product Date"] . "</td>";
        echo "<td>" . $row["Price (RM)"] . "</td>";
        echo "<td>" . $row["Ordered Quantity"] . "</td>";
        echo "</tr>";
        
        // Increment counter
        $counter++;
    }
    echo "</table>"; // Close the table
} else {
    // No results found
    echo "0 results";
}

// Close connection
$db->close(); // Use $db instead of $conn to close connection
?>


    

    </section>
</body>
</html>

