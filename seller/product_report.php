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
                            WHERE pr.owner = '".$_SESSION['store']."'
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
        echo "<p style='padding-bottom: 15%;'>$explanation_message</p>";
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


        <div class="chart-container" >
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
                        WHERE p.owner = '".$_SESSION['store']."'
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
                $graphExplanation .= "<p style='padding-bottom: 15%;'>The Market Share Pie Chart illustrates the distribution of sales among different products based on the data obtained.</p>";

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
                    WHERE p.owner = '".$_SESSION['store']."'
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
