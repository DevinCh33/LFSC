<?php
// updateOrderStatus.php

// Assuming you have the connection details in connect.php
require_once 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id']) && isset($_POST['orderStatus'])) {
    $order_id = mysqli_real_escape_string($db, $_POST['order_id']);
    $orderStatus = mysqli_real_escape_string($db, $_POST['orderStatus']);
    
    // SQL to update the order status
    $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
    
    // Prepare statement
    if($stmt = mysqli_prepare($db, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $orderStatus, $order_id);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            echo "Order status updated successfully.";
        } else{
            echo "Error updating record: " . mysqli_error($db);
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query: " . mysqli_error($db);
    }
    
    // Close connection
    mysqli_close($db);
} else {
    // Not a POST request, or missing order_id/orderStatus
    echo "Error: Invalid request.";
}
?>
