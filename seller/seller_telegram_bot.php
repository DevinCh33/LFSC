<?php
include 'connect.php';
require_once '../telegram_notification.php';

$content = file_get_contents("php://input");
$update = json_decode($content, true);

function sendMessage($chatId, $message, $keyboard = null)
{
    $token = "6871950229:AAGGsiFvspL7UdThz8DyupfCVcYFUAfIaxw";
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

            $ordersQuery = "SELECT o.order_status, pr.status, COUNT(*) as count FROM orders o
                            LEFT JOIN payment_receipts pr ON o.order_id = pr.order_id
                            WHERE o.order_belong = ? AND ((o.order_status = 1 AND pr.status = 0) OR
                                                          (o.order_status = 1 AND pr.status = 1) OR
                                                          (o.order_status = 2 AND pr.status = 1))
                            GROUP BY o.order_status, pr.status";
            $ordersStmt = $db->prepare($ordersQuery);
            if ($ordersStmt) {
                $ordersStmt->bind_param("i", $storeId);
                $ordersStmt->execute();
                $ordersResult = $ordersStmt->get_result();
                $counts = ['Pending Payment Verification' => 0, 'To-process packing' => 0, 'Processed Deliver' => 0];
                while ($orderRow = $ordersResult->fetch_assoc()) {
                    if ($orderRow['order_status'] == 1 && $orderRow['status'] == 0) {
                        $counts['Pending Payment Verification'] += $orderRow['count'];
                    }
                    if ($orderRow['order_status'] == 1 && $orderRow['status'] == 1) {
                        $counts['To-process packing'] += $orderRow['count'];
                    }
                    if ($orderRow['order_status'] == 2 && $orderRow['status'] == 1) {
                        $counts['Processed Deliver'] += $orderRow['count'];
                    }
                }
                $message = "Things you need to deal with:\n" .
                    "Pending Payment Verification: " . $counts['Pending Payment Verification'] . "\n" .
                    "To-process packing: " . $counts['To-process packing'] . "\n" .
                    "Processed Deliver: " . $counts['Processed Deliver'];
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
    // Query only orders with order_status 1 and 2 and specific status conditions
    $query = "SELECT o.order_id, o.order_status, pr.status FROM orders o
              LEFT JOIN payment_receipts pr ON o.order_id = pr.order_id
              WHERE o.order_belong = (SELECT store FROM admin WHERE chat_id = ?) AND
                    ((o.order_status = 1 AND (pr.status = 0 OR pr.status = 1)) OR
                     (o.order_status = 2 AND pr.status = 1))";
    $stmt = $db->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $chatId);
        $stmt->execute();
        $result = $stmt->get_result();
        $message = "Here are your orders:\n";
        while ($row = $result->fetch_assoc()) {
            switch ($row['order_status']) {
                case 1:
                    if ($row['status'] == 0) {
                        $message .= "/order_" . $row['order_id'] . " - Pending Payment Verification\n";
                    } elseif ($row['status'] == 1) {
                        $message .= "/order_" . $row['order_id'] . " - To-process packing\n";
                    }
                    break;
                case 2:
                    if ($row['status'] == 1) {
                        $message .= "/order_" . $row['order_id'] . " - Delivering\n";
                    }
                    break;
            }
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
    $storeCheckQuery = "SELECT store FROM admin WHERE chat_id = ?";
    $storeCheckStmt = $db->prepare($storeCheckQuery);
    if ($storeCheckStmt) {
        $storeCheckStmt->bind_param("i", $chatId);
        $storeCheckStmt->execute();
        $storeResult = $storeCheckStmt->get_result();
        if ($storeRow = $storeResult->fetch_assoc()) {
            $storeId = $storeRow['store'];

            $orderQuery = "SELECT order_date, total_amount FROM orders WHERE order_id = ? AND order_belong = ?";
            $orderStmt = $db->prepare($orderQuery);
            if ($orderStmt) {
                $orderStmt->bind_param("ii", $orderId, $storeId);
                $orderStmt->execute();
                $orderResult = $orderStmt->get_result();
                if ($orderRow = $orderResult->fetch_assoc()) {
                    $orderDate = $orderRow['order_date'];
                    $totalAmount = $orderRow['total_amount'];

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
                        $itemStmt->close();

                        $receiptQuery = "SELECT status FROM payment_receipts WHERE order_id = ?";
                        $receiptStmt = $db->prepare($receiptQuery);
                        $receiptStmt->bind_param("i", $orderId);
                        $receiptStmt->execute();
                        $receiptResult = $receiptStmt->get_result();
                        $receiptRow = $receiptResult->fetch_assoc();

                        $keyboard = ["inline_keyboard" => []];

                        if ($receiptRow && $receiptRow['status'] == 0) {
                            $keyboard['inline_keyboard'][] = [["text" => "Verify Payment", "callback_data" => "verify_payment_$orderId"]];
                        } else if ($receiptRow && $receiptRow['status'] == 1) {
                            $keyboard['inline_keyboard'][] = [["text" => "Customer Details", "callback_data" => "customer_details_$orderId"]];
                            $keyboard['inline_keyboard'][] = [["text" => "Order Status Update", "callback_data" => "update_status_$orderId"]];
                        }
                        $keyboard['inline_keyboard'][] = [["text" => "Back to Order List", "callback_data" => "view_orders"]];

                        $message = "Order ID $orderId\n" .
                            "Order Date: " . $orderDate . "\n" .
                            "Products Bought:\n" . $productsDetails .
                            "Total Price: RM" . $totalAmount;

                        sendMessage($chatId, $message, $keyboard);
                    } else {
                        $message = "Failed to query product details.";
                        sendMessage($chatId, $message);
                    }
                } else {
                    $message = "Order not found or does not belong to your store.";
                    sendMessage($chatId, $message);
                }
                $orderStmt->close();
            } else {
                $message = "Failed to query order details.";
                sendMessage($chatId, $message);
            }
        } else {
            sendMessage($chatId, "No store found linked to this account.");
        }
        $storeCheckStmt->close();
    } else {
        sendMessage($chatId, "Failed to prepare the store query.");
    }
}


function displayCustomerDetails($chatId, $orderId)
{
    global $db;
    $orderQuery = "SELECT user_id FROM orders WHERE order_id = ?";
    $orderStmt = $db->prepare($orderQuery);
    if ($orderStmt) {
        $orderStmt->bind_param("i", $orderId);
        $orderStmt->execute();
        $orderResult = $orderStmt->get_result();
        if ($orderRow = $orderResult->fetch_assoc()) {
            $userId = $orderRow['user_id'];

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
                    $statusText = "Unknown Status";
            }

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

        $query = "SELECT o.user_id, r.title AS restaurant_title FROM orders o JOIN restaurant r ON o.order_belong = r.rs_id WHERE o.order_id = ?";
        if ($detailStmt = $db->prepare($query)) {
            $detailStmt->bind_param("i", $orderId);
            $detailStmt->execute();
            $result = $detailStmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $userId = $row['user_id'];
                $restaurantTitle = $row['restaurant_title'];

                $chatIdQuery = "SELECT chat_id FROM users WHERE u_id = ?";
                if ($chatIdStmt = $db->prepare($chatIdQuery)) {
                    $chatIdStmt->bind_param("i", $userId);
                    $chatIdStmt->execute();
                    $chatIdResult = $chatIdStmt->get_result();
                    if ($chatRow = $chatIdResult->fetch_assoc()) {
                        $buyerChatId = $chatRow['chat_id'];
                        $message = "";
                        switch ($newStatus) {
                            case 1:
                                $message = $restaurantTitle . ": Seller is preparing your order (Order ID: " . $orderId . ").";
                                break;
                            case 2:
                                $message = $restaurantTitle . ": Seller is delivering your order (Order ID: " . $orderId . ").";
                                break;
                            case 3:
                                $message = $restaurantTitle . ": Order (Order ID: " . $orderId . ") completed.";
                                break;
                        }

                        if (!empty($message)) {
                            sendTelegramNotification($buyerChatId, $message);
                        }
                    }
                }
            }
        }
    } else {
        sendMessage($chatId, "Failed to update order status.");
    }
    $stmt->close();
}

function verifyPayment($chatId, $orderId)
{
    global $db;
    $orderQuery = "SELECT order_date, total_amount FROM orders WHERE order_id = ?";
    $orderStmt = $db->prepare($orderQuery);
    if ($orderStmt) {
        $orderStmt->bind_param("i", $orderId);
        $orderStmt->execute();
        $orderResult = $orderStmt->get_result();
        if ($orderRow = $orderResult->fetch_assoc()) {
            $orderDate = $orderRow['order_date'];
            $totalAmount = $orderRow['total_amount'];

            $itemQuery = "SELECT p.product_name, tp.proWeight, oi.quantity FROM order_item oi
                          JOIN tblprice tp ON oi.priceID = tp.priceNo
                          JOIN product p ON tp.productID = p.product_id
                          WHERE oi.order_id = ?";
            $itemStmt = $db->prepare($itemQuery);
            $itemStmt->bind_param("i", $orderId);
            $itemStmt->execute();
            $itemResult = $itemStmt->get_result();

            $productsDetails = "";
            $index = 1;
            while ($itemRow = $itemResult->fetch_assoc()) {
                $productsDetails .= $index . ") " . $itemRow['product_name'] . " (" . $itemRow['proWeight'] . "g) x " . $itemRow['quantity'] . "\n";
                $index++;
            }
            $itemStmt->close();

            $receiptQuery = "SELECT receipt_path FROM payment_receipts WHERE order_id = ?";
            $receiptStmt = $db->prepare($receiptQuery);
            $receiptStmt->bind_param("i", $orderId);
            $receiptStmt->execute();
            $receiptResult = $receiptStmt->get_result();
            $receiptRow = $receiptResult->fetch_assoc();

            $messageDetails = "Order ID $orderId\nOrder Date: $orderDate\nProducts Bought:\n$productsDetailsTotal Price: RM$totalAmount\nPlease confirm the receipt details are correct before proceeding.";

            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['text' => 'Paid', 'callback_data' => 'confirm_payment_' . $orderId . '_yes'],
                        ['text' => 'Not paid yet', 'callback_data' => 'confirm_payment_' . $orderId . '_no']
                    ]
                ]
            ];

            if ($receiptRow && $receiptRow['receipt_path']) {
                $photoUrl = "https://2ccc-115-132-25-116.ngrok-free.app/LFSC/receipts/" . rawurlencode($receiptRow['receipt_path']);
                sendPhoto($chatId, $photoUrl, $messageDetails, $keyboard);
            } else {
                sendMessage($chatId, $messageDetails, $keyboard);
            }
        } else {
            sendMessage($chatId, "Order details not found.");
        }
        $orderStmt->close();
    } else {
        sendMessage($chatId, "Failed to retrieve order details.");
    }
}




function sendPhoto($chatId, $photoUrl, $caption, $keyboard = null)
{
    global $db;
    $token = "6871950229:AAGGsiFvspL7UdThz8DyupfCVcYFUAfIaxw";
    $url = "https://api.telegram.org/bot$token/sendPhoto";

    $post_fields = [
        'chat_id' => $chatId,
        'photo' => $photoUrl,
        'caption' => $caption,
        'parse_mode' => 'Markdown'
    ];

    if ($keyboard) {
        $post_fields['reply_markup'] = json_encode($keyboard);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    $output = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        sendMessage($chatId, "Failed to send image: " . $error_msg);
    }
    curl_close($ch);
}


function confirmPayment($chatId, $orderId, $status)
{
    global $db;
    $query = "UPDATE payment_receipts SET status = ? WHERE order_id = ?";
    $stmt = $db->prepare($query);
    if ($stmt) {
        $stmt->bind_param("ii", $status, $orderId);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            sendMessage($chatId, "Payment status has been updated successfully.");
        } else {
            sendMessage($chatId, "Failed to update payment status.");
        }
        $stmt->close();
    } else {
        sendMessage($chatId, "Error preparing to update payment status.");
    }
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

    if (preg_match('/^verify_payment_(\d+)$/', $callbackData, $matches)) {
        $orderId = $matches[1];
        verifyPayment($chatId, $orderId);
    } elseif (preg_match('/^confirm_payment_(\d+)_yes$/', $callbackData, $matches)) {
        $orderId = $matches[1];
        confirmPayment($chatId, $orderId, 1);
    } elseif (preg_match('/^confirm_payment_(\d+)_no$/', $callbackData, $matches)) {
        $orderId = $matches[1];
        confirmPayment($chatId, $orderId, 0);
    } elseif (strpos($callbackData, "customer_details_") === 0) {
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
