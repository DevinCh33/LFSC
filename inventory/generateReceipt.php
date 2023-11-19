<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve start and end dates from the AJAX request
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];

    // Mock data for the report
    $reportData = [
        ['order_date' => '2023-01-01', 'product_name' => 'Product A', 'quantity' => 2, 'price' => 25.00],
        ['order_date' => '2023-01-02', 'product_name' => 'Product B', 'quantity' => 1, 'price' => 15.00],
    ];

    // Generate receipt content based on the report
    $receiptContent = "<div class='receipt-container'>";
    $receiptContent .= "<h2>Payment Receipt</h2>";
    $receiptContent .= "<p><strong>Date:</strong> " . date("Y-m-d H:i:s") . "</p>";
    $receiptContent .= "<p><strong>Period:</strong> $startDate to $endDate</p>";
    $receiptContent .= "<table class='table'>";
    $receiptContent .= "<thead><tr><th>Order Date</th><th>Product Name</th><th>Quantity</th><th>Price</th></tr></thead><tbody>";

    $totalAmount = 0;

    foreach ($reportData as $order) {
        $orderDate = $order["order_date"];
        $productName = $order["product_name"];
        $quantity = $order["quantity"];
        $price = $order["price"];
        $totalAmount += $price;

        // Add order details to the receipt
        $receiptContent .= "<tr>";
        $receiptContent .= "<td>$orderDate</td>";
        $receiptContent .= "<td>$productName</td>";
        $receiptContent .= "<td>$quantity</td>";
        $receiptContent .= "<td>$price</td>";
        $receiptContent .= "</tr>";
    }

    $receiptContent .= "</tbody></table>";
    $receiptContent .= "<p><strong>Total Amount:</strong> $totalAmount</p>";
    $receiptContent .= "<p>Thank you for your payment!</p>";
    $receiptContent .= "</div>";

    // Add styles to the PDF button
    echo '<a tabindex="0" aria-controls="example23" href="#" style="background-color: #3498db; color: #fff; margin-top:5%; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer; text-decoration: none; display: inline-block;"><span>PDF</span></a>';
          
    // Return the receipt content as HTML
    echo $receiptContent;
}
?>
