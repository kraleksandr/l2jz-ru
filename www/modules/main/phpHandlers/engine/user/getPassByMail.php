<?php
if(!defined('L2JZ'))exit;
require "engine/php/class.phpmailer.php";
if($sql->getCount("SELECT login FROM accounts WHERE login='$login' AND email='$email'","LS")!=1){
	setErrorCode("wrongLoginOrEmail");
}

$password = rand(1000000,9999999);
$password = md5($password.microtime());
$password = substr($password,0,15);
	
$mail = new PHPMailer();

$mail->IsMail();
$mail->FromName = "L2JZSystem";
$mail->AddAddress($email,$login); 
$mail->Subject  =  "Lost Password.";
$mail->Body     =  <<<HERE
The user account $login has this email associated with it.
A web user from has just requested that a new password be sent.

Your New Password is: $password

If you didn`t ask for this, don`t worry.
You are seeing this message, not them. If this was an error just login with your
new password and then change your password to what you would like it to be.
HERE;

if(!$mail->Send())setErrorCode("errorSendingMail");

$password = base64_encode(pack("H*",sha1(utf8_encode($password))));
$sql->query("UPDATE accounts SET password='$password' WHERE login='$login'","LS");
?>