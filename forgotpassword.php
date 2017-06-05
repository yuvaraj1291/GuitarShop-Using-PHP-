<?php

require('./model/database.php');
require_once('./PHPMailer/PHPMailerAutoload.php');

global $db;

$address = filter_input(INPUT_GET, 'email');

$mail             = new PHPMailer();

$mail->IsSMTP(); 
#$mail->Host       = "mail.yourdomain.com"; 
$mail->SMTPDebug  = 3;                     
$mail->SMTPAuth   = true;                  
$mail->SMTPSecure = "ssl";                 
$mail->Host       = "smtp.gmail.com";      
$mail->Port       = 465;                   
$mail->Username   = "yuvaraj1291@gmail.com";  
$mail->Password   = "iluvindia";            

$mail->SetFrom('user@gmail.com', 'Test');

$query = 'SELECT email,pass FROM user
              WHERE email = :email';
$statement = $db->prepare($query);
$statement->bindValue(":email", $address);
$statement->execute();
$user = $statement->fetch();

$statement->closeCursor();

$mail->Subject    = "Password Information!";

$mail->MsgHTML('Your passwrod is ' . $user["pass"]);

$mail->AddAddress($address, "Test");

if(!$mail->Send()) {	
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
	echo "MAIL SENT";
	ob_end_clean();
}
include 'index.php';
?>