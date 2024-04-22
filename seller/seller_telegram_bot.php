<?php
include 'connect.php';

$content = file_get_contents("php://input");
$update = json_decode($content, true);

function sendMessage($chatId, $message, $keyboard = null)
{
    $token = "6871950229:AAGGsiFvspL7UdThz8DyupfCVcYFUAfIaxw"; // Replace 'YOUR_BOT_TOKEN' with your actual bot token
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&text=" . urlencode($message);
    if ($keyboard) {
        $url .= "&reply_markup=" . urlencode(json_encode($keyboard));
    }
    file_get_contents($url);
}

function isAccountLinked($chatId)
{
    global $db;
    $query = "SELECT chat_id FROM admin WHERE chat_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $chatId);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

function unlinkTelegramAccount($chatId)
{
    global $db;
    $query = "UPDATE admin SET chat_id = NULL WHERE chat_id = ?";
    $stmt = $db->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $chatId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    } else {
        return false;
    }
}

function bindTelegramAccount($chatId, $code)
{
    global $db;
    $stmt = $db->prepare("SELECT adm_id FROM seller_tg_verification WHERE code = ? AND expiration > NOW() LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $admId = $row['adm_id'];
            $updateQuery = "UPDATE admin SET chat_id = ? WHERE adm_id = ?";
            if ($updateStmt = $db->prepare($updateQuery)) {
                $updateStmt->bind_param("ii", $chatId, $admId);
                $updateStmt->execute();
                if ($updateStmt->affected_rows > 0) {
                    sendMessage($chatId, "Your Telegram account has been successfully linked.\nHit /help to find out more about how to use me to my full potential.");
                } else {
                    sendMessage($chatId, "There was an error linking your account. Please try again.");
                }
                $updateStmt->close();
            } else {
                sendMessage($chatId, "Error preparing to link your account.");
            }
        } else {
            sendMessage($chatId, "The code is invalid or has expired. Please try again or use /help for more commands.");
        }
        $stmt->close();
    } else {
        sendMessage($chatId, "An error occurred preparing the database query. Please contact support.");
    }
}

function fetchOrderCounts($chatId)
{
    global $db;
    $storeQuery = "SELECT store FROM admin WHERE chat_id = ?";
    $storeStmt = $db->prepare($storeQuery);
    if ($storeStmt) {
        $storeStmt->bind_param("i", $chatId);
        $storeStmt->execute();
        $storeResult = $storeStmt->get_result();
        if ($row = $storeResult->fetch_assoc()) {
            $storeId = $row['store'];
            $ordersQuery = "SELECT order_status, COUNT(*) as count FROM orders WHERE order_belong = ? GROUP BY order_status";
            $ordersStmt = $db->prepare($ordersQuery);
            if ($ordersStmt) {
                $ordersStmt->bind_param("i", $storeId);
                $ordersStmt->execute();
                $ordersResult = $ordersStmt->get_result();
                $counts = [1 => 0, 2 => 0]; // Adjust according to your order_status IDs
                while ($orderRow = $ordersResult->fetch_assoc()) {
                    if (array_key_exists($orderRow['order_status'], $counts)) {
                        $counts[$orderRow['order_status']] = $orderRow['count'];
                    }
                }
                $message = "Things you need to deal with:\n" .
                    "To-process packing: " . $counts[1] . "\n" .
                    "Processed Deliver: " . $counts[2];
                $keyboard = [
                    "inline_keyboard" => [
                        [["text" => "View Orders", "callback_data" => "view_orders"]]
                    ]
                ];
                sendMessage($chatId, $message, $keyboard);
            } else {
                sendMessage($chatId, "Error querying order counts.");
            }
            $ordersStmt->close();
        } else {
            sendMessage($chatId, "No store found linked to this account.");
        }
        $storeStmt->close();
    } else {
        sendMessage($chatId, "Failed to prepare the store query.");
    }
}

function displayOrders($chatId)
{
    global $db;
    $query = "SELECT order_id, order_status FROM orders WHERE order_belong = (SELECT store FROM admin WHERE chat_id = ?)";
    $stmt = $db->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $chatId);
        $stmt->execute();
        $result = $stmt->get_result();
        $message = "Here are your orders:\n";
        while ($row = $result->fetch_assoc()) {
            $message .= "/order_" . $row['order_id'] . " - Status: " . $row['order_status'] . "\n";
        }
        if ($result->num_rows == 0) {
            $message = "No orders found.";
        }
        $stmt->close();
    } else {
        $message = "Failed to query orders.";
    }
    sendMessage($chatId, $message);
}

function displayOrderDetails($chatId, $orderId)
{
    global $db;
    // Query to get the order date from the orders table
    $orderQuery = "SELECT order_date FROM orders WHERE order_id = ?";
    $orderStmt = $db->prepare($orderQuery);
    if ($orderStmt) {
        $orderStmt->bind_param("i", $orderId);
        $orderStmt->execute();
        $orderResult = $orderStmt->get_result();
        if ($orderRow = $orderResult->fetch_assoc()) {
            $orderDate = $orderRow['order_date'];

            // Query to fetch product details for each product in the order
            $itemQuery = "SELECT p.product_name, tp.proWeight, oi.quantity FROM order_item oi
                          JOIN tblprice tp ON oi.priceID = tp.priceNo
                          JOIN product p ON tp.productID = p.product_id
                          WHERE oi.order_id = ?";
            $itemStmt = $db->prepare($itemQuery);
            if ($itemStmt) {
                $itemStmt->bind_param("i", $orderId);
                $itemStmt->execute();
                $itemResult = $itemStmt->get_result();

                $productsDetails = "";
                $index = 1;
                while ($itemRow = $itemResult->fetch_assoc()) {
                    $productsDetails .= $index . ") " . $itemRow['product_name'] . " (" . $itemRow['proWeight'] . "g) x " . $itemRow['quantity'] . "\n";
                    $index++;
                }
                if ($productsDetails === "") {
                    $productsDetails = "No products found.";
                }
                $itemStmt->close();

                $keyboard = [
                    "inline_keyboard" => [
                        [["text" => "Customer Details", "callback_data" => "customer_details_$orderId"]],
                        [["text" => "Order Status Update", "callback_data" => "update_status_$orderId"]],
                        [["text" => "Back to Order List", "callback_data" => "view_orders"]]
                    ]
                ];

                $message = "Order ID $orderId\n" .
                    "Order Date: " . $orderDate . "\n" .
                    "Products Bought:\n" . $productsDetails;

                sendMessage($chatId, $message, $keyboard);
            } else {
                $message = "Failed to query product details.";
                sendMessage($chatId, $message);
            }
        } else {
            $message = "Order not found.";
            sendMessage($chatId, $message);
        }
        $orderStmt->close();
    } else {
        $message = "Failed to query order details.";
        sendMessage($chatId, $message);
    }
}

function displayCustomerDetails($chatId, $orderId)
{
    global $db;
    // First, get the user_id from the orders table
    $orderQuery = "SELECT user_id FROM orders WHERE order_id = ?";
    $orderStmt = $db->prepare($orderQuery);
    if ($orderStmt) {
        $orderStmt->bind_param("i", $orderId);
        $orderStmt->execute();
        $orderResult = $orderStmt->get_result();
        if ($orderRow = $orderResult->fetch_assoc()) {
            $userId = $orderRow['user_id'];

            // Now, get the user details from the users table
            $userQuery = "SELECT fullName, phone, address FROM users WHERE u_id = ?";
            $userStmt = $db->prepare($userQuery);
            if ($userStmt) {
                $userStmt->bind_param("i", $userId);
                $userStmt->execute();
                $userResult = $userStmt->get_result();
                if ($userRow = $userResult->fetch_assoc()) {
                    $message = "Name: " . $userRow['fullName'] . "\n" .
                        "Phone Number: " . $userRow['phone'] . "\n" .
                        "Address: " . $userRow['address'];
                } else {
                    $message = "Customer details not found.";
                }
                $userStmt->close();
            } else {
                $message = "Failed to query customer details.";
            }
        } else {
            $message = "Order not found or missing customer info.";
        }
        $orderStmt->close();
    } else {
        $message = "Failed to query order.";
    }
    sendMessage($chatId, $message);
}

function displayOrderStatusUpdateOptions($chatId, $orderId)
{
    global $db;
    $query = "SELECT order_status FROM orders WHERE order_id = ?";
    $stmt = $db->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $currentStatus = $row['order_status'];

            // Determine the current status text
            switch ($currentStatus) {
                case 1:
                    $statusText = "Processing";
                    break;
                case 2:
                    $statusText = "Delivering";
                    break;
                case 3:
                    $statusText = "Delivered";
                    break;
                default:
                    $statusText = "Unknown Status"; // Handle unexpected status
            }

            // Inline keyboard options for order statuses
            $keyboard = [
                'inline_keyboard' => [
                    [['text' => 'Processing', 'callback_data' => 'set_status_' . $orderId . '_1']],
                    [['text' => 'Delivering', 'callback_data' => 'set_status_' . $orderId . '_2']],
                    [['text' => 'Delivered', 'callback_data' => 'set_status_' . $orderId . '_3']]
                ]
            ];
            $message = "Current Status: " . $statusText . "\nChoose new status:";
            sendMessage($chatId, $message, $keyboard);
        } else {
            sendMessage($chatId, "Order not found.");
        }
        $stmt->close();
    } else {
        sendMessage($chatId, "Failed to prepare query for fetching order status.");
    }
}


function updateOrderStatus($chatId, $orderId, $newStatus)
{
    global $db;
    $stmt = $db->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $stmt->bind_param("ii", $newStatus, $orderId);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        sendMessage($chatId, "Order status updated successfully.");
    } else {
        sendMessage($chatId, "Failed to update order status.");
    }
    $stmt->close();
}

if (isset($update["message"])) {
    $chatId = $update["message"]["chat"]["id"];
    $receivedMessage = trim(strtolower($update["message"]["text"]));
    if ($receivedMessage === "/start") {
        if (isAccountLinked($chatId)) {
            sendMessage($chatId, "Account already linked. If you wish to relink, please use /delete to unlink and then /start again.");
        } else {
            sendMessage($chatId, "Welcome to the LFSC Seller bot. Please enter your OTP to link your Telegram account:");
        }
    } elseif ($receivedMessage === "/delete") {
        if (unlinkTelegramAccount($chatId)) {
            sendMessage($chatId, "Your Telegram account has been successfully unlinked. You can now link a new account using a verification code from our website.");
        } else {
            sendMessage($chatId, "There was an error unlinking your account. Please try again.");
        }
    } elseif ($receivedMessage === "/help") {
        $helpMessage = "Click below to view your to-do list:";
        $keyboard = [
            "inline_keyboard" => [
                [["text" => "To Do List", "callback_data" => "todo_list"]]
            ]
        ];
        sendMessage($chatId, $helpMessage, $keyboard);
    } elseif (preg_match('/^\/order_(\d+)$/', $receivedMessage, $matches)) {
        $orderId = $matches[1];
        displayOrderDetails($chatId, $orderId);
    } else {
        bindTelegramAccount($chatId, $receivedMessage);
    }
}

if (isset($update["callback_query"])) {
    $callbackQuery = $update["callback_query"];
    $chatId = $callbackQuery["message"]["chat"]["id"];
    $callbackData = $callbackQuery["data"];

    if (strpos($callbackData, "customer_details_") === 0) {
        $orderId = substr($callbackData, strlen("customer_details_"));
        displayCustomerDetails($chatId, $orderId);
    } elseif (strpos($callbackData, "set_status_") === 0) {
        if (preg_match('/^set_status_(\d+)_(\d+)$/', $callbackData, $matches)) {
            $orderId = $matches[1];
            $newStatus = $matches[2];
            updateOrderStatus($chatId, $orderId, $newStatus);
        }
    } elseif (strpos($callbackData, "update_status_") === 0) {
        $orderId = substr($callbackData, strlen("update_status_"));
        displayOrderStatusUpdateOptions($chatId, $orderId);
    } elseif ($callbackData === "view_orders") {
        displayOrders($chatId);
    } elseif ($callbackData === "todo_list") {
        fetchOrderCounts($chatId);
    } else {
        sendMessage($chatId, "Unknown command.");
    }
}



?>