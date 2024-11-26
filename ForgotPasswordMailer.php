<?php
require 'vendor/autoload.php';
include('backend/class.php');
$db = new global_class();

date_default_timezone_set('Asia/Manila');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Sanitize user inputs
$userId = intval($_POST['userID']);
$Fullname = htmlspecialchars(trim($_POST['fullName']), ENT_QUOTES, 'UTF-8');
$Email = filter_var(trim($_POST['Email']), FILTER_VALIDATE_EMAIL);

// Generate a new password
$newpassword = $db->GenerateNewPassword($userId);

// Define the Mailer class
class Mailer extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function sendNewPassword($Email, $Fullname, $newpassword)
    {
        try {
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            // Fetch SMTP credentials securely
            $mail->Username = getenv('SMTP_USER'); // Use environment variables for security
            $mail->Password = getenv('SMTP_PASS'); 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Sender and recipient details
            $mail->setFrom('dummydummy1stapador@gmail.com', 'Adornsia'); // Update as needed
            $mail->addAddress($Email, $Fullname);
            $mail->addReplyTo('no-reply@adornsia.shop', 'No Reply');

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your New Password - Adornsia';

            // HTML email body
            $mail->Body = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                    .email-container { max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
                    .email-header { font-size: 24px; font-weight: bold; margin-bottom: 10px; color: #333; }
                    .email-body { margin: 20px 0; font-size: 16px; color: #555; }
                    .button { display: inline-block; background-color: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>Hello, $Fullname!</div>
                    <div class='email-body'>
                        <p>Your new password has been generated. Please log in to your account using the credentials below:</p>
                        <p><strong>Password:</strong> $newpassword</p>
                        <p>For security reasons, we recommend updating your password immediately after logging in.</p>
                        <a href='https://adornsia.shop/login.php' class='button'>Log In to Your Account</a>
                    </div>
                    <div class='email-footer'>If you did not request this email, please contact support immediately.</div>
                </div>
            </body>
            </html>";

            // Plain text body
            $mail->AltBody = "Hello $Fullname, your new password is: $newpassword.\nPlease log in at https://adornsia.shop/login.php and update it immediately.";

            // Send the email
            $mail->send();
            echo "200";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: " . $e->getMessage();
        }
    }
}

// Check if email and name are valid before proceeding
if ($Email && $Fullname && $newpassword) {
    // Create a Mailer object and send the email with the new password
    $mailer = new Mailer();
    $mailer->sendNewPassword($Email, $Fullname, $newpassword);
} else {
    echo "Invalid input. Please check the provided data.";
}
?>
