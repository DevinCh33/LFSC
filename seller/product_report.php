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
            width: 600px;
            height: 600px;
            margin: 50px auto 50px auto;
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
        <div class="chart-container">
            <h1>Quantity of Orders Over Time</h1>
            <canvas id="ordersChart" width="400" height="200"></canvas>

            <?php
            // Include necessary PHP code to establish database connection
            include 'connect.php';

            // Perform the SQL query to get the quantity of orders over time
            $sql = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS order_month, SUM(quantity) AS total_quantity 
                    FROM order_item oi
                    JOIN orders o ON oi.order_id = o.order_id
                    GROUP BY DATE_FORMAT(order_date, '%Y-%m') 
                    ORDER BY order_date";

            $result = mysqli_query($db, $sql);

            // Fetch data into an array
            $data = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            // Close the database connection
            mysqli_close($db);

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

            ?>

            <script>
                var data = <?php echo json_encode($data); ?>;
                
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

        <div class="chart-container" style="margin-bottom: 10%;">
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

        <div class="chart-container" style="margin-top: 30%;">
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

            <!-- Data Analytics Report Summary -->
        <h2>Product Review Table</h2>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Review Table</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>
<body>
    <?php
        // Include the connection file
        include 'connect.php';

        // SQL query to retrieve product report data
        $sql = "SELECT p.product_id AS 'No.', p.owner AS 'Restaurant ID', r.title AS 'Restaurant Title', CONCAT(p.product_name, ' (', tp.proWeight, ')') AS 'Product Name and Weight', p.descr AS 'Description', c.categories_name AS 'Category', p.quantity AS 'Quantity', p.product_date AS 'Product Date', p.lowStock AS 'Low Stock', FORMAT(tp.proPrice, 2) AS 'Price (RM)', oi.quantity AS 'Ordered Quantity'
                FROM product p
                JOIN categories c ON p.categories_id = c.categories_id
                JOIN tblprice tp ON p.product_id = tp.productID
                LEFT JOIN order_item oi ON tp.priceNo = oi.priceID
                LEFT JOIN restaurant r ON p.owner = r.rs_id";

        $result = $db->query($sql); // Use $db instead of $conn to execute queries

        // Initialize counter
        $counter = 1;

        // Check if there are results
        if ($result->num_rows > 0) {
            // Output table headers
            echo "<table>";
            echo "<tr><th>No.</th><th>Restaurant Title</th><th>Product Name and Weight</th><th>Description</th><th>Category</th><th>Product Date</th><th>Price (RM)</th><th>Ordered Quantity</th></tr>";
            
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
            echo "0 results";
        }

        // Close connection
        $db->close(); // Use $db instead of $conn to close connection
    ?>
</body>
</html>



    </div> 

    

    </section>
</body>
</html>

