    <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendBan($userEmail)
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
        $mail->Subject = 'User Account Banned';

        $mail->Body = <<<EMAILBODY
		<html>
		<head>
		  <title>User Account Banned</title>
		</head>
		<body>
		  <div style="font-family: Arial, sans-serif; color: #333;">
			<h2>User Account Banned Notification</h2>
			<p>Your User Account Have Been Banned</p>
			<span>Please Contact Adminstration for more information!</span><br>
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

function sendRecovery($userEmail)
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
        $mail->Subject = 'User Account Recovery';

        $mail->Body = <<<EMAILBODY
		<html>
		<head>
		  <title>User Account Recovery</title>
		</head>
		<body>
		  <div style="font-family: Arial, sans-serif; color: #333;">
			<h2>User Account Recovery Notification</h2>
			<p>Your User Account Have Been Recovery</p>
			<span>Enjoy your buying journey!</span><br>
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