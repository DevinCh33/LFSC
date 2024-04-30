<?php
include('connect.php');
session_start();
if (empty($_SESSION['adm_id'])) {
    header('location:login.php');
    exit;
}

$otpMessage = "";

if (isset($_POST['bindTelegram'])) {
    // Generate a unique OTP
    $otp = bin2hex(random_bytes(4));
    $expiration = new DateTime('+15 minutes');
    $admId = $_SESSION['adm_id'];

    // Insert OTP into the seller_tg_verification table
    $query = "INSERT INTO seller_tg_verification (adm_id, code, expiration) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iss", $admId, $otp, $expiration->format('Y-m-d H:i:s'));
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $otpMessage = "Please send the following code to our Telegram bot <a href='https://t.me/lfsc_seller_bot' target='_blank'>@lfsc_seller_bot</a>: <strong>$otp</strong>";
        } else {
            $otpMessage = "An error occurred. Please try again or contact support.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $otpMessage = "An error occurred preparing the database. Please try again or contact support.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Bind to Telegram</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="form-container">
        <?php if ($otpMessage == ""): ?>
            <form method="POST">
                <button type="submit" name="bindTelegram">Bind Telegram</button>
            </form>
        <?php else: ?>
            <div class="otp-message">
                <?php echo $otpMessage; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>