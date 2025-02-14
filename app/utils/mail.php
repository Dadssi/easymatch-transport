<?php
// Include PHPMailer classes (adjust the paths according to your project structure)
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {

    public function notify($to, $subject, $message) {
       
        $mail = new PHPMailer(true);

        try {
           
            $mail->isSMTP();
            $mail->Host       = 'smtp.example.com';         // Replace with your SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'your_email@example.com';     // Replace with your SMTP username
            $mail->Password   = 'your_password';              // Replace with your SMTP password
            $mail->SMTPSecure = 'tls';                        // Use 'ssl' if required
            $mail->Port       = 587;                          // Adjust port if needed

            
            $mail->setFrom('your_email@example.com', 'Your Name'); // Replace with your sender info
            $mail->addAddress($to); // Add a recipient

            
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message);

            
            $mail->send();
            return true;
        } catch (Exception $e) {
            
            return false;
        }
    }
}
?>
