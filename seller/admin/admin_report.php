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
            text-align: center;
            font-size: 20px;
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
            justify-content: center;
        }

        .export-button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            }

        /* The Modal (background) */
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        border: 1px solid #888;
        width: 80%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
        }

        /* Add Animation */
        @-webkit-keyframes animatetop {
        from {top:-300px; opacity:0} 
        to {top:0; opacity:1}
        }

        @keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
        }

        /* The Close Button */
        .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .close:hover,
        .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
        }

        .modal-header {
        padding: 2px 16px;
        background-color: #5cb85c;
        color: white;
        }

        .modal-body {padding: 30px;}

        .modal-footer {
        padding: 2px 16px;
        background-color: #5cb85c;
        color: white;
        }
    </style>
</head>
<body>
    	<input type="hidden" id="storeid" name="storeid" value="<?php echo $_SESSION['store'] ?>">

    <div class="sidebar close">
        <?php include "sidebar.php"; ?>
    </div>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text">Reports</span>
        </div>
        

            <h1 style = "text-decoration: underline;font-size: 30px;">Product Report</h1>
            <div class="chart-container">
        <h1>Sales Analysis</h1>
        <canvas id="ordersChart" width="400" height="200"></canvas>
        <div>

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

            // Perform the SQL query to get the total sales over time
            $sql_total_sales = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS order_month, SUM(p.proPrice * oi.quantity) AS total_sales
                                FROM order_item oi
                                INNER JOIN tblprice p ON oi.priceID = p.priceNo
                                INNER JOIN product pr ON p.productID = pr.product_id
                                INNER JOIN orders o ON oi.order_id = o.order_id
                                GROUP BY DATE_FORMAT(order_date, '%Y-%m') 
                                ORDER BY order_date";

            $result_total_sales = mysqli_query($db, $sql_total_sales);

            // Fetch total sales data into an array
            $data_total_sales = array();
            while ($row_sales = mysqli_fetch_assoc($result_total_sales)) {
                $data_total_sales[] = $row_sales;
            }

            // Close the database connection
            mysqli_close($db);
            // Explanation message to be displayed
            $explanation_message = "This chart represents the sales analysis over time. It shows the quantity of orders made each month, as well as the total sales generated.";

            // Print the explanation message within a <p> tag
            echo "<p>$explanation_message</p>";
        ?>

        <script>
            var dataOrders = <?php echo json_encode($data_orders); ?>;
            var dataTotalSales = <?php echo json_encode($data_total_sales); ?>;

            // Extract labels (order months), quantity data, and total sales data
            var labels = dataOrders.map(item => item.order_month);
            var quantityData = dataOrders.map(item => item.total_quantity);
            var totalSalesData = dataTotalSales.map(item => item.total_sales);

            var ctx = document.getElementById('ordersChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Quantity of Orders',
                        data: quantityData,
                        yAxisID: 'y', // Associate with the 'y' axis (left)
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Total Sales',
                        data: totalSalesData,
                        yAxisID: 'y1', // Associate with the 'y1' axis (right)
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Month',
                                color: 'black',
                                font: {
                                    family: 'Comic Sans MS',
                                    size: 20,
                                    weight: 'bold',
                                    lineHeight: 1.2,
                                },
                                padding: {top: 20, left: 0, right: 0, bottom: 0}
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Quantity',
                                color: 'black',
                                font: {
                                    family: 'Comic Sans MS',
                                    size: 20,
                                    weight: 'bold',
                                    lineHeight: 1.2,
                                },
                                padding: {top: 30, left: 0, right: 0, bottom: 50}
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Total Sales',
                                color: 'black',
                                font: {
                                    family: 'Comic Sans MS',
                                    size: 20,
                                    weight: 'bold',
                                    lineHeight: 1.2,
                                },
                                padding: {top: 30, left: 0, right: 0, bottom: 50}
                            },
                            grid: {
                                drawOnChartArea: false,
                            }
                        }
                    }
                }
            });

        </script>


            </div>


            <div class="chart-container">
                <h1>Market Share Pie Chart</h1>
                <canvas id="marketShareChart" width="800" height="400" style="margin-left: auto; margin-right: auto;"></canvas>

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

                    foreach ($data as &$product) {
                        // Calculate market share percentage for each product
                        $product['market_share'] = ($product['total_sales'] / $totalSales) * 100;
                        $productName = $product['product_name'];
                        $totalSalesAmount = $product['total_sales'];
                        $marketSharePercentage = round($product['market_share'], 2);

                    }

                
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

           
            <?php
                // Include necessary PHP code to establish database connection
                include 'connect.php';

                // Perform the SQL query to retrieve data for the bar chart
                $sql = "SELECT p.product_name, 
                            TIMESTAMPDIFF(YEAR, u.dob, CURDATE()) AS customer_age,
                            COUNT(*) AS order_count
                        FROM order_item oi
                        JOIN orders o ON oi.order_id = o.order_id
                        JOIN users u ON o.user_id = u.u_id
                        JOIN tblprice tp ON oi.priceID = tp.priceNo
                        JOIN product p ON tp.productID = p.product_id
                        GROUP BY p.product_id, customer_age
                        ORDER BY p.product_id, customer_age";

                $result = mysqli_query($db, $sql);

                // Fetch data into an array for the bar chart
                $data = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }

                // Calculate total order count for each age group
                $ageGroupCounts = array();
                foreach ($data as $item) {
                    $age = $item['customer_age'];
                    $orderCount = $item['order_count'];
                    if (!isset($ageGroupCounts[$age])) {
                        $ageGroupCounts[$age] = 0;
                    }
                    $ageGroupCounts[$age] += $orderCount;
                }

                // Determine the age group with the most orders
                $mostOrderAgeGroup = array_keys($ageGroupCounts, max($ageGroupCounts))[0];

                // Find the product that contributed the most to the order count in the age group with the most orders
                $mostOrderedProduct = '';
                $maxOrderCount = 0;
                foreach ($data as $item) {
                    if ($item['customer_age'] == $mostOrderAgeGroup && $item['order_count'] > $maxOrderCount) {
                        $mostOrderedProduct = $item['product_name'];
                        $maxOrderCount = $item['order_count'];
                    }
                }

                // Close the database connection
                mysqli_close($db);
                ?>

                <div class="chart-container">
                    <h1>Total Number of Orders by Age Group</h1>
                    <canvas id="orderAgeGraph" width="800" height="400"></canvas>
                    <p>This bar chart visualizes <strong>the distribution of orders</strong> across<strong> different age groups for each product</strong>. Each bar represents the number of orders placed for a specific product within a particular age group. The x-axis displays the number of orders, while the y-axis represents the products. The color of each bar distinguishes different age groups.</p>
                    <p>The age group with the most orders is <strong><?php echo $mostOrderAgeGroup; ?></strong>, with the most ordered product being <strong><?php echo $mostOrderedProduct; ?></strong></p>


                    <script>
                        var data = <?php echo json_encode($data); ?>;
                        
                        // Extract product names and order counts by age group
                        var productNames = [...new Set(data.map(item => item.product_name))];
                        var ageGroups = [...new Set(data.map(item => item.customer_age))];
                        var chartData = ageGroups.map((age, index) => ({
                            label: "Age " + age,
                            data: productNames.map(product => {
                                var order = data.find(item => item.customer_age === age && item.product_name === product);
                                return order ? order.order_count : 0;
                            }),
                            backgroundColor: getRandomColor(), // Random color for each age group
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 1
                        }));

                        function getRandomColor() {
                            var letters = '0123456789ABCDEF';
                            var color = '#';
                            for (var i = 0; i < 6; i++) {
                                color += letters[Math.floor(Math.random() * 16)];
                            }
                            return color;
                        }

                        var ctx = document.getElementById('orderAgeGraph').getContext('2d');
                        var chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: productNames,
                                datasets: chartData
                            },
                            options: {
                                responsive: true,
                                indexAxis: 'y',
                                scales: {
                                    x: {
                                        stacked: true,
                                        title: {
                                            display: true,
                                            text: 'Number of Orders',
                                            color: 'black',
                                            font: {
                                                family: 'Comic Sans MS',
                                                size: 20,
                                                weight: 'bold',
                                                lineHeight: 1.2,
                                            },
                                            padding: {top: 20, left: 0, right: 0, bottom: 0}
                                        }
                                    },
                                    y: {
                                        stacked: true,
                                        title: {
                                            display: true,
                                            text: 'Product Ordered',
                                            color: 'black',
                                            font: {
                                                family: 'Comic Sans MS',
                                                size: 20,
                                                weight: 'bold',
                                                lineHeight: 1.2,
                                            },
                                            padding: {top: 20, left: 0, right: 0, bottom: 0}
                                        }
                                    }
                                }
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
                echo "<p style='padding-bottom: 15%;'>The most popular product category, <strong>$mostPopularCategory</strong>, leads with total sales reaching <strong>RM" . number_format($maxSales, 2) . "</strong>. This insight assists in directing marketing strategies and optimizing inventory based on sales performance.</p>";

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
                            responsive: true,
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Product Names',
                                        color: 'black',
                                        font: {
                                            family: 'Comic Sans MS',
                                            size: 20,
                                            weight: 'bold',
                                            lineHeight: 1.2,
                                        },
                                        padding: {top: 20, left: 0, right: 0, bottom: 0}
                                    }
                                },
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Total Sales',
                                        color: 'black',
                                        font: {
                                            family: 'Comic Sans MS',
                                            size: 20,
                                            weight: 'bold',
                                            lineHeight: 1.2,
                                        },
                                        padding: {top: 30, left: 0, right: 0, bottom: 50}
                                    }
                                }
                            }
                        }

                        });
                    </script>
            </div>


        </section>
</body>
</html>
<script src="scripts.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>