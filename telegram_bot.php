<?php
include 'connection/connect.php'; 

$content = file_get_contents("php://input");
$update = json_decode($content, true);

function sendMessage($chatId, $message)
{
    $token = "6861142064:AAGW10QBeruSdWOA5ZouHUMYyOp0kvQaUyY"; 
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&text=" . urlencode($message);
    file_get_contents($url);
}

if (isset($update["message"])) {
    $chatId = $update["message"]["chat"]["id"];
    $receivedMessage = strtolower($update["message"]["text"]);

    if ($receivedMessage === "/start") {
        sendMessage($chatId, "Welcome! Please enter your code:");
    } elseif ($receivedMessage === "/notifications_on") {
        $updateQuery = "UPDATE users SET notifications_enabled = 1 WHERE chat_id = ?";
        if ($stmt = $db->prepare($updateQuery)) {
            $stmt->bind_param("i", $chatId);
            $stmt->execute();
            sendMessage($chatId, "Notifications have been turned ON. You will now receive updates.");
        } else {
            sendMessage($chatId, "Error updating your preferences.");
        }
    } elseif ($receivedMessage === "/notifications_off") {
        $updateQuery = "UPDATE users SET notifications_enabled = 0 WHERE chat_id = ?";
        if ($stmt = $db->prepare($updateQuery)) {
            $stmt->bind_param("i", $chatId);
            $stmt->execute();
            sendMessage($chatId, "Notifications have been turned OFF. You will no longer receive updates.");
        } else {
            sendMessage($chatId, "Error updating your preferences.");
        }
    } elseif ($receivedMessage === "/help") {
        $helpMessage = "Here are some commands you can use:\n";
        $helpMessage .= "/notifications_on - Turn on order status notifications.\n";
        $helpMessage .= "/notifications_off - Turn off order status notifications.\n";
        sendMessage($chatId, $helpMessage);
    } else {
        // Check for verification code
        $stmt = $db->prepare("SELECT userId FROM tg_verification WHERE code = ? AND expiration > NOW() LIMIT 1");
        $stmt->bind_param("s", $receivedMessage);
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
}
?>
