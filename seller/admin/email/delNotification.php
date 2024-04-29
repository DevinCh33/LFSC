    <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendDelete($userEmail, $proID, $proName, $delReason)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'gjunyu99@gmail.com';
        $mail->Password = 'vdkx mcja yusp rwsr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('no-reply@example.com', 'LFSC System');
        $mail->addAddress($userEmail);     // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Validate Your Email Address';

        $mail->Body = <<<EMAILBODY
		<html>
		<head>
		  <title>Email Verification</title>
		</head>
		<body>
		  <div style="font-family: Arial, sans-serif; color: #333;">
			<h2>Delete Notification</h2>
			<p>Your Product {$proID}, {$proName} deleted due to {$delReason}</p>
			<span>Thank you for your understanding! </span><br>
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