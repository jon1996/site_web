<?php

require_once("contents/userMailContent.php");

    $emails="";
    $name="";
    $phone="";
    $message="";
    $recipients=array("");
    $subject="NEW CONTACT";
    $messageBody="";

    // Getting request parameters
    if(isset($_POST['sendmail'])){

        $email=trim($_POST['email']);
        $phone=trim($_POST['phone']);
        $name=trim($_POST['name']);
        $message=trim($_POST['message']);


        // Inserting values in the email body
      $messageBody=$user_contact_email;

      $messageBody=str_replace("{name}", $name, $messageBody);
      $messageBody=str_replace("{email}", $email, $messageBody);
      $messageBody=str_replace("{phone}", $phone, $messageBody);
      $messageBody=str_replace("{message}", $message, $messageBody);

    }
    

/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;

require '../src/PHPMailer.php';
require '../src/SMTP.php';
//require '../src/Exception.php';
$mail = new PHPMailer(TRUE);

try {
   
   
   /* SMTP parameters. */
   $mail->isSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->SMTPAuth = true;
   $mail->SMTPSecure = 'tls';
   $mail->Username = 'jonathanpascal5@gmail.com';
   $mail->Password = 'JonathanpascalBahavu';
   $mail->Port = 587;
   

   $mail->setFrom('jonathanpascal5@gmail.com', 'Congo JX - AMS');

   // Adding recepients
   $mail->addAddress("lucienmeru@gmail.com", ""); 
    

   $mail->Subject = $subject;
   
  
   $mail->msgHTML($messageBody);

   /* Disable some SSL checks. */
   $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      )
   );
   
   /* Finally send the mail. */
   $mail->send();
   echo 'Message sent!';

}
catch (Exception $e)
{
   echo $e->getMessage();
}
catch (\Exception $e)
{
   echo $e->getMessage();
}