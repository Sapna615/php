<?php
$to = "your-email@example.com"; // Replace with your email
$subject = "Test Email from XAMPP";
$message = "This is a test email from XAMPP PHP mail() function";
$headers = "From: webmaster@localhost";

if(mail($to, $subject, $message, $headers)) {
    echo "Test email sent successfully";
} else {
    echo "Failed to send test email";
    echo "<br>Last error: " . error_get_last()['message'];
}
?>