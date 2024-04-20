<?php
include 'connect.php';

$content = file_get_contents("php://input");
$update = json_decode($content, true);

function sendMessage($chatId, $message)
{
    $token = "6871950229:AAGGsiFvspL7UdThz8DyupfCVcYFUAfIaxw"; // Replace with your actual bot token
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&text=" . urlencode($message);
    file_get_contents($url);
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
                    sendMessage($chatId, "Your Telegram account has been successfully linked. You can now access admin features.");
                } else {
                    sendMessage($chatId, "There was an error linking your account. Please try again.");
                }
                $updateStmt->close();
            } else {
                sendMessage($chatId, "Error preparing to link your account.");
            }
        } else {
            sendMessage($chatId, "The code is invalid or has expired. Please try again.");
        }
        $stmt->close();
    } else {
        sendMessage($chatId, "An error occurred preparing the database query. Please contact support.");
    }
}

if (isset($update["message"])) {
    $chatId = $update["message"]["chat"]["id"];
    $receivedMessage = trim($update["message"]["text"]);

    if (strtolower($receivedMessage) === "/start") {
        sendMessage($chatId, "Welcome to the LFSC seller bot. Please enter your OTP to link your Telegram account:");
    } else {
        bindTelegramAccount($chatId, $receivedMessage); // Handle the OTP verification
    }
}

?>
