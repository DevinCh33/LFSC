<?php
include 'config/connect.php';

$content = file_get_contents("php://input");
$update = json_decode($content, true);

function sendMessage($chatId, $message, $keyboard = null)
{
    $token = "6857843252:AAHa267pqAKyWAimgH52Vi4NYOt1FdsMu0A"; // Ensure to replace with your actual bot token
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&text=" . urlencode($message);
    if ($keyboard) {
        $url .= "&reply_markup=" . urlencode(json_encode($keyboard));
    }
    file_get_contents($url);
}

function sendInlineKeyboard($chatId, $message, $keyboard)
{
    sendMessage($chatId, $message, $keyboard);
}

function updateNotificationsStatus($chatId, $status)
{
    global $db;
    $updateQuery = "UPDATE users SET notifications_enabled = ? WHERE chat_id = ?";
    if ($stmt = $db->prepare($updateQuery)) {
        $stmt->bind_param("ii", $status, $chatId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    } else {
        return false;
    }
}

function getUserDetails($chatId)
{
    global $db;
    $query = "SELECT username, fullName, email, phone, address FROM users WHERE chat_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $chatId);
    $stmt->execute();
    $stmt->bind_result($username, $fullName, $email, $phone, $address);
    $stmt->fetch();
    $stmt->close();

    return [
        "Username: " . $username,
        "Full Name: " . $fullName,
        "Email: " . $email,
        "Phone: " . $phone,
        "Address: " . $address
    ];
}


function getActiveOrders($chatId)
{
    global $db;
    $query = "SELECT order_id, order_date, order_status FROM orders WHERE user_id = (SELECT u_id FROM users WHERE chat_id = ?) AND order_status IN (1, 2)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $chatId);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $row['status_text'] = ($row['order_status'] == 1) ? "Packing" : "Delivering";
        $orders[] = $row;
    }
    return $orders;
}

function isAccountLinked($chatId)
{
    global $db;
    $query = "SELECT chat_id FROM users WHERE chat_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $chatId);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

function unlinkTelegramAccount($chatId)
{
    global $db;
    $query = "UPDATE users SET chat_id = NULL WHERE chat_id = ?";
    $stmt = $db->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $chatId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    } else {
        return false; // Return false if the statement preparation fails
    }
}

function bindTelegramAccount($chatId, $code)
{
    global $db;
    $stmt = $db->prepare("SELECT userId FROM tg_verification WHERE code = ? AND expiration > NOW() LIMIT 1");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $userId = $row['userId'];
        $updateQuery = "UPDATE users SET chat_id = ? WHERE u_id = ?";
        if ($updateStmt = $db->prepare($updateQuery)) {
            $updateStmt->bind_param("ii", $chatId, $userId);
            $updateStmt->execute();
            if ($updateStmt->affected_rows > 0) {
                sendMessage($chatId, "Your Telegram account has been successfully linked.\nHit /help to find out more about how to use me to my full potential.");
            } else {
                sendMessage($chatId, "There was an error linking your account. Please try again.");
            }
        } else {
            sendMessage($chatId, "Error preparing to link your account.");
        }
    } else {
        sendMessage($chatId, "The code is invalid or has expired. Please try again or use /help for more commands.");
    }
}

function getToReceiveOrders($chatId)
{
    global $db;
    $query = "SELECT order_id, last_updated FROM orders WHERE user_id = (SELECT u_id FROM users WHERE chat_id = ?) AND order_status = 3";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $chatId);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = "/order_" . $row['order_id'] . " - Delivered: " . $row['last_updated'];
    }
    $stmt->close();
    return $orders;
}

function updateOrderStatus($orderId, $newStatus)
{
    global $db;
    $query = "UPDATE orders SET order_status = ? WHERE order_id = ?";
    if ($stmt = $db->prepare($query)) {
        $stmt->bind_param("ii", $newStatus, $orderId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    } else {
        return false;
    }
}

function isOrderBelongsToUser($chatId, $orderId)
{
    global $db;
    $query = "SELECT order_id FROM orders WHERE order_id = ? AND user_id = (SELECT u_id FROM users WHERE chat_id = ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $orderId, $chatId);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}


if (isset($update["message"])) {
    $chatId = $update["message"]["chat"]["id"];
    $receivedMessage = strtolower($update["message"]["text"]);

    if ($receivedMessage === "/start") {
        if (isAccountLinked($chatId)) {
            sendMessage($chatId, "Account already linked. If you wish to relink, please use /delete to unlink and then /start again.");
        } else {
            sendMessage($chatId, "Welcome to the LFSC Buyer bot. Please enter your OTP to link your Telegram account:");
        }
    } elseif ($receivedMessage === "/delete") {
        if (unlinkTelegramAccount($chatId)) {
            sendMessage($chatId, "Your Telegram account has been successfully unlinked. You can now link a new account using a verification code from our website.");
        } else {
            sendMessage($chatId, "There was an error unlinking your account. Please try again.");
        }
    } elseif (preg_match('/^\/order_(\d+)$/', $receivedMessage, $matches)) {
        $orderId = $matches[1]; // Capture the numeric part of the order ID
        if (isOrderBelongsToUser($chatId, $orderId)) {
            $confirmMessage = "Do you confirm that you received the order?";
            $keyboard = [
                'inline_keyboard' => [
                    [
                        ['text' => 'Yes', 'callback_data' => 'confirm_order_' . $orderId . '_yes'],
                        ['text' => 'No', 'callback_data' => 'confirm_order_' . $orderId . '_no']
                    ]
                ]
            ];
            sendInlineKeyboard($chatId, $confirmMessage, $keyboard);
        } else {
            sendMessage($chatId, "Order not found or does not belong to you.");
        }
    } elseif ($receivedMessage === "/help") {
        $helpMessage = "Here are some functions you can use:";
        $keyboard = [
            "inline_keyboard" => [
                [
                    ["text" => "Details", "callback_data" => "details"]
                ],
                [
                    ["text" => "Orders", "callback_data" => "orders"]
                ],
                [
                    ["text" => "Notifications", "callback_data" => "notifications"]
                ]
            ]
        ];
        sendInlineKeyboard($chatId, $helpMessage, $keyboard);
    } else {
        bindTelegramAccount($chatId, $receivedMessage); // Handling verification code
    }
} elseif (isset($update["callback_query"])) {
    $callbackQuery = $update["callback_query"];
    $chatId = $callbackQuery["message"]["chat"]["id"];
    $data = $callbackQuery["data"];


    if (preg_match('/^confirm_order_(\d+)_yes$/', $data, $matches)) {
        $orderId = $matches[1];
        if (updateOrderStatus($orderId, 4)) {
            $confirmationMessage = "Thank you for confirming your order. We're pleased to have completed your order successfully.";
            sendMessage($chatId, $confirmationMessage);
        } else {
            $errorMessage = "There was an issue updating the status of order #$orderId. Please contact support for further assistance.";
            sendMessage($chatId, $errorMessage);
        }
    } elseif (preg_match('/^confirm_order_(\d+)_no$/', $data, $matches)) {
        $notificationMessage = "Please notify us upon its arrival, or reach out if there are any issues with the delivery. We appreciate your patience and are here to assist you.";
        sendMessage($chatId, $notificationMessage);
    } elseif ($data === "details") {
        $details = getUserDetails($chatId);
        $detailsMessage = "Your details:\n" . implode("\n", $details);
        sendMessage($chatId, $detailsMessage);
    } elseif ($data === "orders") {
        $message = "Please select the type of orders you would like to view:";
        $ordersKeyboard = [
            "inline_keyboard" => [
                [["text" => "Active Orders", "callback_data" => "active_orders"]],
                [["text" => "To-Receive Orders", "callback_data" => "to_receive_orders"]]
            ]
        ];
        sendInlineKeyboard($chatId, $message, $ordersKeyboard);
    } elseif ($data === "active_orders") {
        $orders = getActiveOrders($chatId);
        if (!empty($orders)) {
            $ordersMessage = "Here are your active orders:\n";
            foreach ($orders as $order) {
                $ordersMessage .= "Order ID: " . $order['order_id'] . "\n";
                $ordersMessage .= "Order Date: " . $order['order_date'] . "\n";
                $ordersMessage .= "Order Status: " . $order['status_text'] . "\n\n";
            }
        } else {
            $ordersMessage = "You have no active orders.";
        }
        sendMessage($chatId, $ordersMessage);
    } elseif ($data === "to_receive_orders") {
        $orders = getToReceiveOrders($chatId);
        if (!empty($orders)) {
            $ordersMessage = "Below are your orders and their delivery times:\n" . implode("\n", $orders);
        } else {
            $ordersMessage = "You have no orders to receive.";
        }
        sendMessage($chatId, $ordersMessage);
    } elseif ($data === "notifications") {
        $message = "Choose an option for notifications:";
        $notificationsKeyboard = [
            "inline_keyboard" => [
                [
                    ["text" => "On", "callback_data" => "notifications_on"],
                    ["text" => "Off", "callback_data" => "notifications_off"]
                ]
            ]
        ];
        sendInlineKeyboard($chatId, $message, $notificationsKeyboard);
    } elseif ($data === "notifications_on") {
        if (updateNotificationsStatus($chatId, 1)) {
            sendMessage($chatId, "Notifications have been turned ON. You will now receive updates.");
        } else {
            sendMessage($chatId, "Notifications were already ON.");
        }
    } elseif ($data === "notifications_off") {
        if (updateNotificationsStatus($chatId, 0)) {
            sendMessage($chatId, "Notifications have been turned OFF. You will no longer receive updates.");
        } else {
            sendMessage($chatId, "Notifications were already OFF.");
        }
    }
}
?>
