    <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendSuccess($userEmail)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        include("../../../config/email.php");
        $mail->addAddress($userEmail);     // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Store Validation';

        $mail->Body = <<<EMAILBODY
		<html>
		<head>
		  <title>Email Verification</title>
		</head>
		<body>
		  <div style="font-family: Arial, sans-serif; color: #333;">
			<h2>Validated Success Notification</h2>
			<p>Your Store Have Been Approved!</p>
			<span>Enjoy your selling journey</span><br>
			<p>Best Regards,<br>LFSC System Team</p>
		  </div>
		</body>
		</html>
		EMAILBODY;

        $mail->send();
        return true;
    } catch (Exception $e) {

        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;

        return false;
    }
}

function sendFail($userEmail, $reason)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        include("../../../config/email.php");
        $mail->addAddress($userEmail);     // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Store Validation';

        $mail->Body = <<<EMAILBODY
		<html>
		<head>
		  <title>Store Verification</title>
		</head>
		<body>
		  <div style="font-family: Arial, sans-serif; color: #333;">
			<h2>Validate Fails Notification</h2>
			<h3>Your Validation Request Fail!</h3>
			<p>Reason: $reason</p>
			<span>Please Resubmit Again</span><br>
			<p>Best Regards,<br>LFSC System Team</p>
		  </div>
		</body>
		</html>
		EMAILBODY;

        $mail->send();
        return true;
    } catch (Exception $e) {

        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;

        return false;
    }
}
?>