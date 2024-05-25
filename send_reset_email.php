<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendResetEmail($userEmail, $token)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        include("config/email.php");
        $mail->addAddress($userEmail);     // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Confirm Your Email Address';

        $mail->Body = <<<EMAILBODY
<html>
<head>
  <title>Password Reset Request</title>
</head>
<body>
  <div style="font-family: Arial, sans-serif; color: #333;">
    <h2>Password Reset Request</h2>
    <p>You have requested to reset your password on our website. Please click the link below to reset your password:</p>
    <p><a href="http://localhost/LFSC/reset_password.php?token={$token}" style="background-color: #0046be; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Reset Password</a></p>
    <p>If you did not request this, please ignore this email and your password will remain unchanged.</p>
  </div>
</body>
</html>
EMAILBODY;
        $mail->AltBody = 'You have requested to reset your password. Please use the following link to reset your password: http://localhost/LFSC/reset_password.php?token=' . $token;

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        return false;
    }
}
?>
