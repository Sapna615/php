<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendConfirmationEmail($userEmail, $userName) {
    try {
        $mail = new PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        // $mail->Username = 'your-email@gmail.com'; // Replace with your email
        // $mail->Password = 'amishaathakur098@gmail.com'; // Replace with your email password
        $mail->Username='sapnarai2005@gmail.com'; // Replace with your email
        // $mail->Password = 'rvwi kopg yvwi zdgm'; // Replace with your email password
        $mail->Password = 'eahq zagr cwio yjij'; // Replace with your email password
        // $mail->Password = 'your-app-password'; // Replace with your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('noreply@travelease.com', 'TravelEase');
        $mail->addAddress($userEmail, $userName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Welcome to TravelEase - Registration Successful!";
        $mail->Body = "
        <html>
        <head>
            <title>Welcome to TravelEase</title>
        </head>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                <h2 style='color: #2c3e50;'>Welcome to TravelEase!</h2>
                <p>Dear $userName,</p>
                <p>Thank you for registering with TravelEase. Your account has been successfully created!</p>
                <p>You can now log in to your account and start exploring our services.</p>
                <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
                <p style='margin-top: 20px;'>Best regards,<br>The TravelEase Team</p>
            </div>
        </body>
        </html>";

        return $mail->send();
    } catch (Exception $e) {
        error_log("Email sending failed: {$mail->ErrorInfo}");
        return false;
    }
}
?>
