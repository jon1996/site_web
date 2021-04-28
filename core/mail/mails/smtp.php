<?php
require_once("../../core/init.php");


    $emails="";
    $recipients=array("");
    $subject="";
    $messageBody="";

    // Getting request parameters
    if(isset($_POST['sendmail'])){

        $email=trim($_POST['emails']);

        $subject=trim($_POST['subject']);
        $messageBody=trim($_POST['message_body']);

    }







/**
 * This example shows making an SMTP connection with authentication.
 */

//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require '../src/PHPMailer.php';
require '../src/SMTP.php';


//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// SMTP::DEBUG_OFF = off (for production use)
// SMTP::DEBUG_CLIENT = client messages
// SMTP::DEBUG_SERVER = client and server messages
$mail->SMTPDebug = SMTP::DEBUG_SERVER;


//Whether to use SMTP authentication
// $mail->SMTPAuth = true;
// $mail->SMTPSecure = "ssl/tls";


//Set the hostname of the mail server
$mail->Host = 'mail.congojx.com';

//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 25;
//Username to use for SMTP authentication
// $mail->Username = 'pascal@congojx.com';
//Password to use for SMTP authentication
// $mail->Password = 'CongojxAdmin';
//Set who the message is to be sent from
$mail->setFrom('pascal@congojx.com', 'Congo JX - AMS');
//Set an alternative reply-to address
$mail->addReplyTo('pascal@congojx.com', 'Congo JX - AMS');
//Set who the message is to be sent to
$mail->AddCC(str_replace(",", "", $email), ""); 

//Set the subject line
$mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.php'), __DIR__);

// Send email
$mail->msgHTML($messageBody);
//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

// Setting the character encoding to UTF-8 to allow proper encoding and decoding of french characters
$mail->CharSet = 'UTF-8'; 

//send the message, check for errors

if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}


