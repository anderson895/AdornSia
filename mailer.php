<?php
require 'vendor/autoload.php';
include('backend/class.php');
$db = new global_class();

date_default_timezone_set('Asia/Manila');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// $userId = $_POST["userId"];
$userId = $_POST['user_id']; 

// Get the verification key
$verificationKey = $db->update_verificationKey($userId);

class Mailer extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    public function sendVerificationEmail($userId, $verificationKey)
    {
        try {
            // Prepare statement to fetch account details
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE user_id = ?");
            
            // Check if the prepare statement failed
            if ($stmt === false) {
                throw new Exception('Prepare statement failed: ' . $this->conn->error);
            }

            $stmt->bind_param("i", $userId); // Assuming user_id is an integer
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if any account is found
            if ($result->num_rows == 0) {
                echo "Error: Account not found.";
                exit;
            }

            // Fetch account details
            $account_row = $result->fetch_assoc();
            $Email = $account_row["Email"];
            $Fullname = $account_row["Fullname"];

            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'angeladeniseflores199@gmail.com'; 
            $mail->Password = 'rpbm yjls katl wcrt'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender and recipient details
            $mail->setFrom('adornsia@gmail.com', 'Adornsia');
            $mail->addAddress($Email, $Fullname); // Use $Email and $Fullname
            $mail->addReplyTo('no-reply@yourdomain.com', 'No Reply'); // Correcting the reply-to email

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Adorn Sia';

            // Corrected the HTML body with proper PHP variable concatenation
            $mail->Body = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <script src='https://cdn.tailwindcss.com'></script> <!-- Include Tailwind CSS -->
            </head>
            <body class='bg-white font-sans'>
                <div class='w-full bg-gray-200 py-8'>
                    <div class='max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg'>
                        <h1 class='text-2xl font-semibold mb-4'>Hello, $Fullname</h1>
                        <hr class='mb-4'>
                        <p class='text-gray-700 mb-4'>Please use this link to verify your account:</p>
                        <p class='text-gray-700 mb-6'>This link will expire in 5 minutes.</p>
                        
                        <a href='http://localhost/Client/Adorn_sia/verification.php?userId=$userId&verificationKey=$verificationKey' class='inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300'>
                            Verify your account
                        </a>
                    </div>
                </div>
            </body>
            </html>";

            // Plain text body for non-HTML mail clients
            $mail->AltBody = "Hello $Fullname, please use the link below to verify your account. The link will expire in 5 minutes.\n\n";
            $mail->AltBody .= "Verification link: verification.php?userId=$userId&verificationKey=$verificationKey";

            // Send the email
            if ($mail->send()) {
                echo "OTPSentSuccessfully";
            } else {
                echo "Mailer Error: {$mail->ErrorInfo}";
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
        }
    }
}

// Create Mailer object and send the email with the verificationKey
$mailer = new Mailer();
$mailer->sendVerificationEmail($userId, $verificationKey);
?>
