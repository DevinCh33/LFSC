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

                $counts = [
                    1 => 0,
                    2 => 0
                ];

                while ($orderRow = $ordersResult->fetch_assoc()) {
                    if (array_key_exists($orderRow['order_status'], $counts)) {
                        $counts[$orderRow['order_status']] = $orderRow['count'];
                    }
                }

                $message = "Things you need to deal with:\n" .
                    "To-process packing: " . $counts[1] . "\n" .
                    "Processed Deliver: " . $counts[2];
                sendMessage($chatId, $message);
            } else {
                sendMessage($chatId, "Error querying order counts.");
            }
        } else {
            sendMessage($chatId, "No store found linked to this account.");
        }
        $storeStmt->close();
    } else {
        sendMessage($chatId, "Failed to prepare the store query.");
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
    } else if ($receivedMessage === "/delete") {
        if (unlinkTelegramAccount($chatId)) {
            sendMessage($chatId, "Your Telegram account has been successfully unlinked. You can now link a new account using a verification code from our website.");
        } else {
            sendMessage($chatId, "There was an error unlinking your account. Please try again.");
        }
    } else if ($receivedMessage === "/help") {
        $helpMessage = "Here are some functions you can use:";
        $keyboard = [
            "inline_keyboard" => [
                [
                    ["text" => "To Do List", "callback_data" => "todo_list"],
                    ["text" => "View Orders", "callback_data" => "view_orders"]
                ]
            ]
        ];
        sendMessage($chatId, $helpMessage, $keyboard);
    } else {
        bindTelegramAccount($chatId, $receivedMessage);
    }
}

if (isset($update["callback_query"])) {
    $callbackQuery = $update["callback_query"];
    $chatId = $callbackQuery["message"]["chat"]["id"];
    $callbackData = $callbackQuery["data"];

    if ($callbackData === "todo_list") {
        fetchOrderCounts($chatId);
    } elseif ($callbackData === "view_orders") {
        sendMessage($chatId, "Here are your orders.");
    } else {
        sendMessage($chatId, "Unknown command.");
    }
}

?>
