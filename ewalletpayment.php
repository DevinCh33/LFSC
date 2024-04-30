<?php
include("config/connect.php");
session_start();
error_reporting(0);

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$paymentAmount = 0;

if ($order_id > 0) {

    $query = "SELECT total_amount FROM orders WHERE order_id = '$order_id'";
    $result = mysqli_query($db, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $paymentAmount = $row['total_amount'];
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['receipt-upload'])) {
    $uploadDir = 'receipts/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileName = basename($_FILES['receipt-upload']['name']);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array(strtolower($fileType), $allowTypes)) {
        if (move_uploaded_file($_FILES['receipt-upload']['tmp_name'], $targetFilePath)) {
            $query = "INSERT INTO payment_receipts (order_id, receipt_path, status) VALUES ('$order_id', '$fileName', 0)";
            if (mysqli_query($db, $query)) {
                echo "<script>alert('Receipt uploaded successfully.'); window.location.href='market.php';</script>";
                unset($_SESSION["cart"]); 
                exit;
            } else {
                echo "<script>alert('Receipt upload failed, please try again.');</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
    } else {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG, & GIF files are allowed.');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>eWallet Payment Confirmation</title>
    <link rel="stylesheet" href="landing/style.css" />
    <script>
        function changeQR(codeId) {
            document.querySelectorAll('.qr-codes img').forEach(function (img) {
                img.style.display = 'none';
            });
            document.getElementById(codeId).style.display = 'block';
        }
    </script>
</head>

<body>
    <div class="payment-confirmation-container">
        <div class="confirmation-message">
            <img src="landing/tick.png" alt="Confirmation Tick" class="confirmation-tick" />
            <h1>Thank You! Your order is confirmed.</h1>
            <p>Your order has been successfully placed. Thank you for shopping with us online!</p>
        </div>
        <div class="payment-details">
            <h2>Payment Due</h2>
            <p class="payment-amount">RM <?php echo htmlspecialchars($paymentAmount); ?></p>
        </div>
        <div class="payment-information">
            <h2>Payment Information</h2>
            <div class="payment-methods">
                <button onclick="changeQR('duitnow-qr')">DuitNow QR</button>
                <button onclick="changeQR('touchngo-qr')">Touch n Go</button>
                <button onclick="changeQR('grabpay-qr')">GrabPay</button>
                <button onclick="changeQR('boost-qr')">Boost</button>
            </div>
            <div class="qr-codes">
                <img id="duitnow-qr" src="landing/qrcode.jpg" alt="DuitNow QR Code" style="display:none;" />
                <img id="touchngo-qr" src="landing/qrcode.jpg" " alt="Touch n Go QR Code" style="display:none;" />
                <img id="grabpay-qr" src="landing/grabqr.jpg" alt="GrabPay QR Code" style="display:none;" />
                <img id="boost-qr" src="landing/boostqr.jpg" alt="Boost QR Code" style="display:none;" />
            </div>
            <p>Scan QR code and make payment.</p>
        </div>
        <div class="confirm-payment">
            <h2>Confirm Payment</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="receipt-upload">Upload the payment receipt here</label>
                <input type="file" id="receipt-upload" name="receipt-upload" required />
                <input type="submit" value="Submit" />
            </form>
        </div>
    </div>
</body>
</html>
