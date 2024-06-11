<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->Username = '----';
    $mail->Password = '----';
    $mail->SMTPSecure = '-----';
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('-----', 'Test Email');
    $mail->addAddress('-----', 'Recipient Name');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body = "This is a test email.";

    $mail->send();
    echo 'Test email has been sent';
} catch (Exception $e) {
    echo "Test email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
