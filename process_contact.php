<?php
require_once 'config/db_connect.php';
require_once 'send_confirmation_email.php';

// Include PHPMailer files
require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'] ?? '';
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    try {
        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO contact_submissions (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $subject, $message]);

        // Send confirmation email using PHPMailer
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; // Replace with your Gmail address
            // $mail->Username = 'sapnarai2005@gmail.com';
            $mail->Password = 'your-app-password'; // Replace with your Gmail app password
            // $mail->Password = 'eahq zagr cwio yjij';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('noreply@travelease.com', 'TravelEase');
            $mail->addAddress($email, $name);
            $mail->addReplyTo('support@travelease.com', 'TravelEase Support');
            // $mail->addReplyTo('sapnarai2005@gmail.com', 'TravelEase Support');

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Thank you for contacting TravelEase";
            $mail->Body = "
            <html>
            <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                    <h2 style='color: #2c3e50;'>Thank You for Contacting Us!</h2>
                    <p>Dear $name,</p>
                    <p>Thank you for reaching out to TravelEase. We have received your message and will get back to you shortly.</p>
                    <div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                        <h3 style='color: #2c3e50; margin-top: 0;'>Your Message Details:</h3>
                        <p><strong>Subject:</strong> $subject</p>
                        <p><strong>Message:</strong><br>$message</p>
                    </div>
                    <p>Best regards,<br>The TravelEase Team</p>
                </div>
            </body>
            </html>";

            $mail->send();

            // Send notification to admin
            $mail->clearAddresses();
            $mail->addAddress('admin@travelease.com', 'TravelEase Admin');
            $mail->Subject = "New Contact Form Submission";
            $mail->Body = "
            <html>
            <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                    <h2 style='color: #2c3e50;'>New Contact Form Submission</h2>
                    <div style='background: #f8f9fa; padding: 15px; border-radius: 5px;'>
                        <p><strong>Name:</strong> $name</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>Phone:</strong> $phone</p>
                        <p><strong>Subject:</strong> $subject</p>
                        <p><strong>Message:</strong><br>$message</p>
                    </div>
                </div>
            </body>
            </html>";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email sending failed: {$mail->ErrorInfo}");
            // Continue with the process even if email fails
        }

        // Redirect with success message
        header("Location: contact.php?status=success");
        exit();

    } catch (PDOException $e) {
        header("Location: contact.php?status=error");
        exit();
    }
} else {
    header("Location: contact.php");
    exit();
}
?>
