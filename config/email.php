<?php
use PHPMailer\PHPMailer\PHPMailer;

$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Host = 'smtp.gmail.com';
$mail->Username = 'gjunyu99@gmail.com';
$mail->Password = 'vdkx mcja yusp rwsr';
$mail->Port = 587;

// Recipients
$mail->setFrom('no-reply@example.com', 'LFSC System');
