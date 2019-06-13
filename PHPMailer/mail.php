<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

//-----elementos del usuario------------------
$nombre=$_POST["nombre"];
$apellido=$_POST["apellido"];
$contacto=$_POST["contacto"];
$email=$_POST["email"];
$contraseña=$_POST["contraseña"];




// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'kyozen91@gmail.com';                     // SMTP username
    $mail->Password   = '12deagosto';                               // SMTP password
    //$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 25;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('kyozen91@gmail.com', 'Area Dos');
    $mail->addAddress($email, $nombre.' '.$apellido);     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Registro completo en Area Dos';
    $mail->Body    = 'para ingresar utilice la aplicacion e ingrese con el usuario y contraseña asignado<br> Usuario: <b>'.$email.'</b><br> Contraseña: '.$contraseña.'<br> Disfrute de nuestra calité de servicios ';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

print("<script>window.location='../admin.php';</script>");

?>