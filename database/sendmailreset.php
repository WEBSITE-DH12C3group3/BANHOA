<?php
require '/xampp/htdocs/BANHOA/PHPMAILER/src/Exception.php';
require '/xampp/htdocs/BANHOA/PHPMAILER/src/PHPMailer.php';
require '/xampp/htdocs/BANHOA/PHPMAILER/src/SMTP.php';


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



class Mailer{
    public function sendMail($title, $content, $addressMail){
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            $mail->SMTPDebug = 0 ;                      //Enable verbose debug output
            $mail->isSMTP();  
            $mail->CharSet = 'utf-8';                                          //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'hoatuoieden@gmail.com';                     //SMTP username
            $mail->Password   = 'ebwiujughkzkvehu';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('hoatuoieden@gmail.com', 'Shop Hoa Tươi EDEN xin chào!');
            $mail->addAddress($addressMail);     //Add a recipient
    
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $title;
            $mail->Body    = $content;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}