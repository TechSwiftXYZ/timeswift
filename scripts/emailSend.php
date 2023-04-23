<?php
// Start with PHPMailer class
use PHPMailer\PHPMailer\PHPMailer;
require_once '/home/faderr/vendor/autoload.php';
$userName = $_POST['name'];
$userEmail = $_POST['email'];
$messageSubject = $_POST['subject'];
$message = $_POST['message'];
// create a new object
$mail = new PHPMailer();
// configure an SMTP
$mail->isSMTP();
$mail->Host = 'smtp.porkbun.com';
$mail->SMTPAuth = true;
$mail->Username = 'contact@techswift.xyz';
$mail->Password = 'mail_password_redacted_for_security';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->setFrom('contact@techswift.xyz', 'TechSwift Contact Form');
$mail->addAddress('contact@techswift.xyz', 'TechSwift');
$mail->Subject = "New Support Request: ".$messageSubject;
$mail->Body = "User's name: " . $userName . "User's email address: " . $userEmail . "\nMessage:\n" . $message;

// send the message
if(!$mail->send()){
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}