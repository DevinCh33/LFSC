<?php
// Include necessary PHP code to establish database connection
include 'connect.php';

// Fetch data from the database
$query = "SELECT c.categories_name, COALESCE(SUM(oi.quantity), 0) AS total_quantity
          FROM categories c
          LEFT JOIN product p ON c.categories_id = p.categories_id
          LEFT JOIN tblprice tp ON p.product_id = tp.productID
          LEFT JOIN order_item oi ON tp.priceNo = oi.priceID
          GROUP BY c.categories_name";
$result = $db->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[$row['categories_name']] = $row['total_quantity'];
}
$result->free_result();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Best-Selling Categories Pie Chart</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Best-Selling Categories Pie Chart</h1>
<div class="sidebar close">
        <?php include "sidebar.php"; ?>
    </div>
    <section class="home-section" style="margin:auto;padding:30px 300px 30px 200px;width:1000px; ">
        <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Reports</span>
        </div>
        <div style="margin:auto; width: 500px; height: 500px;"> <!-- Adjust dimensions as needed -->
            <canvas id="myPieChart"></canvas>
        </div>

        <script>
            // Data for the pie chart
            var data = <?php echo json_encode($data); ?>;

            // Extract labels and data values
            var labels = Object.keys(data);
            var quantities = Object.values(data);

            // Colors for the pie chart slices
            var colors = ['#ff9999', '#66b3ff', '#99ff99', '#ffcc99']; // Add more colors if needed

            // Create pie chart
            var ctx = document.getElementById('myPieChart').getContext('2d');
            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: quantities,
                        backgroundColor: colors
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Best-Selling Categories Pie Chart'
                        }
                    }
                }
            });
        </script>

        <h2>Data Summary</h2>

        <table>
            <tr>
                <th>Category</th>
                <th>Total Quantity</th>
            </tr>
            <?php foreach ($data as $category => $quantity) : ?>
            <tr>
                <td><?php echo $category; ?></td>
                <td><?php echo $quantity; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Data Analytics Report Summary -->
        <h2>Data Analytics Report Summary</h2>

        <?php
            $totalOrders = count($data);
            $totalAmount = array_sum(array_column($data, 'total_amount'));
            $averageAmount = $totalOrders > 0 ? $totalAmount / $totalOrders : 0;

            // Additional logic to analyze data and generate dynamic summary
            $summaryMessage = "No specific summary available.";

            if ($totalOrders > 0) {
                if ($averageQuantity > 0) {
                    $summaryMessage = "Based on the available data, the average quantity ordered across all categories is positive, indicating consistent demand for products.";
                } else {
                    $summaryMessage = "Although there are orders recorded, the average quantity ordered is either not available or calculated to be zero. Further analysis may be required to understand the trend.";
                }
            } else {
                $summaryMessage = "No orders data is available at the moment. This could be due to a lack of transactions during the reporting period.";
            }


            echo "<p>Total Orders: $totalOrders</p>";
            echo "<p>Total Amount: $totalAmount</p>";
            echo "<p>Average Amount: $averageAmount</p>";
            echo "<p>Summary: $summaryMessage</p>";
        ?>

        <!-- Trending -->
        <h2>Trending</h2>
        <?php
            // Initialize an array to store trending status for each category
            $trendingCategories = [];

            // Iterate through each category in the data
            foreach ($data as $category => $quantity) {
                // Check if the quantity sold for the category is higher than the average quantity per order
                if ($quantity > $averageQuantityPerOrder) {
                    // If the quantity sold is higher, the category is trending positively
                    $trending = "positively";
                } else {
                    // If the quantity sold is lower or equal to the average, the category is trending negatively
                    $trending = "negatively";
                }
                
                // Store the trending status for the category in the array
                $trendingCategories[$category] = $trending;
            }

            // Generate a detailed explanation of the trending status for each category
            $trendingExplanation = "Upon analyzing the sales data, we can observe the trending status for 
            each category based on the comparison with the average quantity per order. Categories with a higher 
            quantity sold than the average are considered to be trending positively, indicating a surge in demand 
            for products within those categories. On the other hand, categories with a quantity sold lower than or
             equal to the average are trending negatively, suggesting a decrease in customer interest or demand.";

            // Output the trending explanation
            echo "<p>$trendingExplanation</p>";

            // Display the trending status for each category
            echo "<h3>Trending Status for Each Category:</h3>";
            echo "<ul>";
            foreach ($trendingCategories as $category => $trending) {
                echo "<li>$category is trending $trending</li>";
            }
            echo "</ul>";

        ?>

        <!-- Explanation -->
        <h2>Explanation</h2>
        <?php
            // Determine the best-selling and poor-selling categories
            $bestSellCategory = array_keys($data, max($data))[0];
            $poorSellCategory = array_keys($data, min($data))[0];

            // Calculate the total number of categories, total orders, and average quantity per order
            $totalCategories = count($data);
            $totalOrders = array_sum($data);
            $averageQuantityPerOrder = $totalOrders > 0 ? array_sum($data) / $totalOrders : 0;

            // Generate explanation based on the best and poor selling categories
            if ($bestSellCategory !== $poorSellCategory) {
                $explanationMessage = "More items from the <strong> '$bestSellCategory'</strong> category were sold, showing strong demand.
                 However, sales for <strong>'$poorSellCategory'</strong> category items were lower, indicating less interest. This tells us 
                 that customers have different preferences. We offer a variety of <strong>$totalCategories</strong> categories, and with 
                 <strong>$totalOrders</strong> orders, it shows customers engage with our products. On average, each order includes
                 <strong>$averageQuantityPerOrder </strong>items.";
            } else {
                $explanationMessage = "Most sales were from the '$bestSellCategory' category, suggesting it's popular. 
                But, we need more data to understand why. Overall, customers are interested in our products. We had 
                $totalOrders orders, with an average of $averageQuantityPerOrder items per order.";
            }

            // Output the explanation message
            echo "<p>$explanationMessage</p>";
        ?>



    </section>
    
</body>
</html>
