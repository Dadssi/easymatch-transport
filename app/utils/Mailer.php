<?php

require_once 'src/Exception.php';
require_once 'src/PHPMailer.php';
require_once 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    public function notify($to, $subject, $message) {
        $mail = new PHPMailer(true);

        try {
            
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';        
            $mail->SMTPAuth   = true;
            $mail->Username   = 'osama2code79@gmail.com';   
            $mail->Password   = 'xnbq cqcr albs hpmw';         
            $mail->SMTPSecure = 'tls';                    
            $mail->Port       = 587;                     

            
            $mail->setFrom('osama2code79@gmail.com', 'Oussama Benoujja'); 
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
