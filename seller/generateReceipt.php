<?php
// Include database connection or any necessary files
include("./../connection/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date']) && isset($_POST['order_belong'])) {
    $selectedDate = $_POST['date'];
    $order_belong = $_POST['order_belong'];

    // Your SQL query to fetch data and generate receipt content based on order_belong
    $sql = "SELECT o.order_id, o.order_date, oi.quantity, oi.price, p.product_name
            FROM orders o
            INNER JOIN order_item oi ON o.order_id = oi.order_id
            INNER JOIN product p ON oi.product_id = p.product_id
            WHERE o.order_belong = '$order_belong' AND o.order_date LIKE '$selectedDate%' AND o.order_status = '3'";
    $query = $db->query($sql);

    if ($query->num_rows > 0) {
        $receiptNo = rand(10000, 99999); // Generating a random receipt number
        $receiptContent = "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: center;'>";
        $receiptContent .= "<p style='font-size: 14px; color: #555; font-weight: bold;'>LITTLE FARMER SDN.BHD.</p>";
        $receiptContent .= "<p style='font-size: 14px; color: #555;'>AB102 Ground Floor Parcel 2586-1-9 Lorong Persiaran Bandar Baru Batu Kawa 3D Batu Kawah New Township Jalan Batu Kawa 93250 Kuching Sarawak</p>";
        $receiptContent .= "<p style='font-size: 14px; color: #555;'>TEL: 010-217 0960</p>";
        $receiptContent .= "<h3 style='color: #333; border-bottom: 2px solid #333; padding-bottom: 10px; margin-top: 10px;'>RECEIPT</h3>";
        $receiptContent .= "<p style='font-size: 16px; color: #f00; margin-bottom: 10px;'><strong>RECEIPT NO. : LF$receiptNo</strong></p>";
        $receiptContent .= "<div style='display: flex; justify-content: space-between; align-items: center; margin: 10px 0;'>";
        $receiptContent .= "<p style='font-size: 14px; color: #555;'><strong>Date:</strong> " . date("Y-m-d H:i:s") . "</p>";
        $receiptContent .= "</div>";
        $receiptContent .= "<table style='width:100%; border-collapse: collapse; margin-top: 20px;'>";
        $receiptContent .= "<tr style='background-color: #f2f2f2;'><th style='padding: 10px;'>No</th><th style='padding: 10px;'>Order Date</th><th style='padding: 10px;'>Product Name</th><th style='padding: 10px;'>Quantity</th><th style='padding: 10px;'>Price</th></tr>";

        $totalAmount = 0;
        $totalItems = 0;
        $no = 1;

        while ($result = $query->fetch_assoc()) {
            $totalPrice = $result["quantity"] * $result["price"];
            $totalAmount += $totalPrice;
            $totalItems += $result["quantity"];

            $receiptContent .= "<tr><td style='padding: 10px;text-align: right;'>$no</td><td style='padding: 10px;text-align: right;'>".$result["order_date"]."</td><td style='padding: 10px;text-align: right;'>".$result["product_name"]."</td><td style='padding: 10px;text-align: right;'>".$result["quantity"]."</td><td style='padding: 10px; text-align: right;'>".number_format($result["price"], 2)."</td></tr>";

            ++$no;
        }

        $receiptContent .= "<tr style='background-color: #f2f2f2;'><td colspan='3' style='text-align: left; font-weight: bold; padding: 10px;'>Total Items: $totalItems</td><td colspan='2' style='text-align: right; font-weight: bold; padding: 10px;'>Total Price: RM " . number_format($totalAmount, 2) . "</td></tr>";

        $receiptContent .= "</table>";
        $receiptContent .= "<p style='font-size: 12px; margin-top: 20px;'>Thank you for shopping with us! We appreciate your business.</p>";
        $receiptContent .= "<button onclick='window.print()' style='display: block; margin: 20px auto; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;'>Print Receipt</button>";
        $receiptContent .= "</div>";

        echo $receiptContent;
    } else {
         // Display a styled message when no orders are found
         echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: center;'>";
         echo "<p style='font-size: 16px; color: #f00; font-weight: bold;'>No orders found for the selected date and seller.</p>";
         echo "</div>";
    }
} else {
    echo "Error: Invalid request method or missing parameters.";
}
?>
