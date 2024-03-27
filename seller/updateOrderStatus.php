<?php

require_once 'connect.php';
require_once '../telegram_notification.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id']) && isset($_POST['orderStatus'])) {
    $order_id = mysqli_real_escape_string($db, $_POST['order_id']);
    $orderStatus = mysqli_real_escape_string($db, $_POST['orderStatus']);
    echo "Current order status: $orderStatus";

    $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";

    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $orderStatus, $order_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Order status updated successfully.";

            // After updating the order status, fetch the user_id associated with the order
            $query = "SELECT user_id FROM orders WHERE order_id = $order_id";
            $result = mysqli_query($db, $query);
            if ($row = mysqli_fetch_assoc($result)) {
                $userId = $row['user_id'];

                // Fetch chat_id and notifications_enabled status using user_id
                $chatIdQuery = "SELECT chat_id, notifications_enabled FROM users WHERE u_id = $userId LIMIT 1";
                $chatIdResult = mysqli_query($db, $chatIdQuery);
                if ($chatRow = mysqli_fetch_assoc($chatIdResult)) {
                    $chatId = $chatRow['chat_id'];
                    $notificationsEnabled = $chatRow['notifications_enabled'];

                    // Construct the message based on order status
                    $message = "";
                    switch ($orderStatus) {
                        case 1:
                            $message = "Seller is preparing your order.";
                            break;
                        case 2:
                            $message = "Seller is delivering your order.";
                            break;
                        case 3:
                            $message = "Order completed.";
                            break;
                    }

                    // Check if notifications are enabled for the user
                    if ($notificationsEnabled == 1 && !empty($message)) {
                        sendTelegramNotification($chatId, $message);
                    } else {
                        // If notifications are disabled, you can perform some other action or simply do nothing
                        echo "Notifications are disabled for user with chat ID: $chatId.";
                    }
                }
            }
        } else {
            echo "Error updating record: " . mysqli_error($db);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query: " . mysqli_error($db);
    }

    mysqli_close($db);
} else {
    echo "Error: Invalid request.";
}

?>
