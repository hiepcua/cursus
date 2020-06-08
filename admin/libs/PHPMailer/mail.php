<?php
include "src/PHPMailer.php";
include "src/Exception.php";
include "src/OAuth.php";
include "src/POP3.php";
include "src/SMTP.php";
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($title, $content, $sendTo) {
	try {
		$mail = new PHPMailer(true);       
		$mail->CharSet  = 'UTF-8';
		//Server settings
		//$mail->SMTPDebug = 2;                               // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  					  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'ecohub.5gmedia@gmail.com';             // SMTP username
		$mail->Password = 'ecohub@123';                   // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
	 
		//Recipients
		$mail->setFrom('ecohub.5gmedia@gmail.com', 'EcoHub system');	
		$mail->addReplyTo('ecohub.5gmedia@gmail.com', 'EcoHub system');	
		$mail->addAddress($sendTo);
		//Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $title;
		$mail->Body    = $content;
		//$mail->SMTPDebug = 3;
		$mail->send();
		//echo 'Message has been sent';
	} catch (Exception $e) {
		echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}
}
?>