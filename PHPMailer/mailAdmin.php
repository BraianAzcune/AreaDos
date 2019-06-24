<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

class mailAdmin
{
 
    
    function enviar($email,$asunto,$mensaje)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 4;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Helo = "www.asd.com.es";
            //$mail->Host       = "smtp.office365.com";  // Specify main and backup SMTP servers
            $mail->Host       = "smtp.gmail.com";

            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'kyozen91@gmail.com';                     // SMTP username
            $mail->Password   = '12deagosto';                               // SMTP password

            //para hotmail y outlook, solo pudo probarse 1 vez por que el acceso para enviar a traves de cuentas hotmail y outlook necesita ciertos permisos de cuentas "premium" que tienen las de office365 y no las gratuitas.

            //$mail->Username   = 'soloproject@outlook.com';                
            //$mail->Password   = 'camila999';


            $mail->SMTPSecure = 'tls';                   // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = 587;                     // TCP port to connect to

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            //Recipients
            $mail->setFrom('kyozen91@gmail.com', 'AreaDos');
            //$mail->setFrom('soloproject@outlook.com', 'Mailer');  //si se envia por hotmail/outlook usar esta
            $mail->addAddress($email, 'user');                      // Add a recipient
            // Content
            $mail->isHTML(true);                                    // Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;
           

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}

// Instantiation and passing `true` enables exceptions
?>