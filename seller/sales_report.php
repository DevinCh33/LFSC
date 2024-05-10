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
    <div class="sidebar close">
        <?php include "sidebar.php"; ?>
    </div>
    <section class="home-section">
        <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Sales Report</span>
        </div>
      
        <div class="chart-container" style="margin-top: 10%;">
    <?php
    // Start the session
    session_start();

    // Include necessary PHP code to establish database connection
    include 'connect.php';

    // Default values for date range
    $start_date = "";
    $end_date = "";

    // Check if session variables for date range are set
    if(isset($_SESSION["start_date"]) || isset($_SESSION["end_date"])) {
        // Use session values if available
        $start_date = $_SESSION["start_date"];
        $end_date = $_SESSION["end_date"];
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the start date and end date from the form
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];

        // Store the search parameters in session variables
        $_SESSION["start_date"] = $start_date;
        $_SESSION["end_date"] = $end_date;

        // Perform the SQL query based on date range
        if (!empty($start_date) && !empty($end_date)) {
            // Both start date and end date are selected
            $sql = "SELECT oi.order_item_id AS item_no, u.username, o.order_date, CONCAT(p.product_name, ' (', tp.proWeight, ')') AS 'Product Name and Weight', p.descr AS item_description, tp.proPrice AS price, oi.quantity,
                        (tp.proPrice * oi.quantity) AS amount, p.product_image, r.title AS owner, uc.comment
                    FROM order_item oi
                    INNER JOIN tblprice tp ON oi.priceID = tp.priceNo
                    INNER JOIN product p ON tp.productID = p.product_id
                    INNER JOIN orders o ON oi.order_id = o.order_id
                    INNER JOIN users u ON o.user_id = u.u_id
                    LEFT JOIN restaurant r ON p.owner = r.rs_id
                    LEFT JOIN user_comments uc ON u.u_id = uc.user_id
                    WHERE o.order_date BETWEEN '$start_date' AND '$end_date' AND p.owner = '". $_SESSION['store'] . "'
                    ORDER BY item_no ASC";
        } elseif (!empty($start_date)) {
            // Only start date is selected
            $sql = "SELECT oi.order_item_id AS item_no, u.username, o.order_date, CONCAT(p.product_name, ' (', tp.proWeight, ')') AS 'Product Name and Weight', p.descr AS item_description, tp.proPrice AS price, oi.quantity,
                        (tp.proPrice * oi.quantity) AS amount, p.product_image, r.title AS owner, uc.comment
                    FROM order_item oi
                    INNER JOIN tblprice tp ON oi.priceID = tp.priceNo
                    INNER JOIN product p ON tp.productID = p.product_id
                    INNER JOIN orders o ON oi.order_id = o.order_id
                    INNER JOIN users u ON o.user_id = u.u_id
                    LEFT JOIN restaurant r ON p.owner = r.rs_id
                    LEFT JOIN user_comments uc ON u.u_id = uc.user_id
                    WHERE o.order_date >= '$start_date' AND p.owner = '". $_SESSION['store'] . "'
                    ORDER BY item_no ASC";
        } elseif (!empty($end_date)) {
            // Only end date is selected
            $sql = "SELECT oi.order_item_id AS item_no, u.username, o.order_date, CONCAT(p.product_name, ' (', tp.proWeight, ')') AS 'Product Name and Weight', p.descr AS item_description, tp.proPrice AS price, oi.quantity,
                        (tp.proPrice * oi.quantity) AS amount, p.product_image, r.title AS owner, uc.comment
                    FROM order_item oi
                    INNER JOIN tblprice tp ON oi.priceID = tp.priceNo
                    INNER JOIN product p ON tp.productID = p.product_id
                    INNER JOIN orders o ON oi.order_id = o.order_id
                    INNER JOIN users u ON o.user_id = u.u_id
                    LEFT JOIN restaurant r ON p.owner = r.rs_id
                    LEFT JOIN user_comments uc ON u.u_id = uc.user_id
                    WHERE o.order_date <= '$end_date' AND p.owner = '". $_SESSION['store'] . "'
                    ORDER BY item_no ASC";
        } else {
            // Neither start date nor end date is selected
            $sql = "SELECT oi.order_item_id AS item_no, u.username, o.order_date, CONCAT(p.product_name, ' (', tp.proWeight, ')') AS 'Product Name and Weight', p.descr AS item_description, tp.proPrice AS price, oi.quantity,
                        (tp.proPrice * oi.quantity) AS amount, p.product_image, r.title AS owner, uc.comment
                    FROM order_item oi
                    INNER JOIN tblprice tp ON oi.priceID = tp.priceNo
                    INNER JOIN product p ON tp.productID = p.product_id
                    INNER JOIN orders o ON oi.order_id = o.order_id
                    INNER JOIN users u ON o.user_id = u.u_id
                    LEFT JOIN restaurant r ON p.owner = r.rs_id
                    LEFT JOIN user_comments uc ON u.u_id = uc.user_id
                    WHERE p.owner = '". $_SESSION['store'] . "'
                    ORDER BY item_no ASC";
        }
        // Execute the query
        $result = mysqli_query($db, $sql);
    }

    // Initialize total sales amount
    $total_sales = 0;

    // Check if there are any results
    if (isset($result) && mysqli_num_rows($result) > 0) {
        echo "<div class='chart-container' style='margin-top: 10%;'>";
        echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
        echo "<label for='start_date'>Start Date:</label>";
        echo "<input type='date' name='start_date' id='start_date' value='$start_date'>";
        echo "<label for='end_date'>End Date:</label>";
        echo "<input type='date' name='end_date' id='end_date' value='$end_date'>";
        echo "<input type='submit' value='Search' name='search_sales'>";
        echo "<button type='submit' formaction='export_sales_to_excel.php' class='export-button'>Excel</button>"; // Add Export to Excel button with class
        echo "</form>";
        echo "<table border='1'>";
        echo "<tr><th>ITEM NO</th><th>PRODUCT NAME AND WEIGHT</th><th>PRICE (RM)</th><th>QUANTITY</th><th>TOTAL (RM)</th><th>DATE</th><th>DETAILS</th></tr>";

        // Initialize item number counter
        $item_no = 1;

        // Fetch and display each row of the result
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $item_no . "</td>";
            echo "<td>" . $row['Product Name and Weight'] . "</td>";
            echo "<td>" . number_format($row['price'], 2) . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . number_format($row['amount'], 2) . "</td>";
            echo "<td>" . $row['order_date'] . "</td>";
            echo "<td><button onclick='showDetails(\"" . $row['username'] . "\", \"" . $row['Product Name and Weight'] . "\", \"" . $row['item_description'] . "\", \"" . $row['product_image'] . "\", \"" . $row['order_date'] . "\", \"" . $row['owner'] . "\", \"" . $row['comment'] . "\", " . $row['price'] . ")'>Details</button></td>";

            // Add amount to total sales
            $total_sales += $row['amount'];

            // Increment item number
            $item_no++;

            echo "</tr>";
        }

        // Add total sales row
        echo "<tr><td colspan='5' align='right'><strong>Total Sales:</strong></td><td colspan='3'><strong>RM " . number_format($total_sales, 2) . "</strong></td></tr>";

        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='chart-container' style='margin-top: 10%;'>";
        echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
        echo "<label for='start_date'>Start Date:</label>";
        echo "<input type='date' name='start_date' id='start_date' value='$start_date'>";
        echo "<label for='end_date'>End Date:</label>";
        echo "<input type='date' name='end_date' id='end_date' value='$end_date'>";
        echo "<input type='submit' value='Search' name='search_sales'>";
        echo "</form>";
        echo "No sales data available.";
        echo "</div>";
    }

    // Close the database connection
    mysqli_close($db);
?>

    <script>
        function showDetails(username, productName, description, image, date, owner, comment, price) {
            // Get the modal
            var modal = document.getElementById("myModal");

            // Get the modal content
            var modalContent = document.getElementById("modal-content");

            // Set the details in the modal
            modalContent.innerHTML = `
                <div class="modal-header">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Details</h2>
                </div>
                <div class="modal-body">
                    <p><strong>User Name:</strong> ${username}</p>
                    <p><strong>Product Name:</strong> ${productName}</p>
                    <p><strong>Description:</strong> ${description}</p>
                    <p><strong>Date:</strong> ${date}</p>
                    <p><strong>Owner:</strong> ${owner}</p>
                    <p><strong>Comment:</strong> ${comment}</p>
                    <p><strong>Price:</strong> RM ${price.toFixed(2)}</p>
                    <img src="${image}" alt="Product Image" style="max-width: 200px; max-height: 200px;">
                </div>
            `;

            // Display the modal
            modal.style.display = "block";
        }

        function closeModal() {
            // Get the modal
            var modal = document.getElementById("myModal");

            // Hide the modal
            modal.style.display = "none";
        }
    </script>

    <!-- The Modal -->
    <div id="myModal" class="modal" >
        <!-- Modal content -->
        <div class="modal-content" id="modal-content" ></div>
    </div>
</div>



    </section>
</body>
</html>
<script src="scripts.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
