<?php
class clsMail 
{
var $to;
var $from;
var $cc;
var $bcc;
var $subject;
var $message;
var $contentType;

function clsMail() //init
{
$this->to = "";
$this->from = "";
$this->cc = "";
$this->bcc = "";
$this->subject = "";
$this->message = "";
$this->contentType = "html"; // text, html
}

function isemail($email)
{
// regx to test for valid e-mail adres
$regex = '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$';
if (eregi($regex, $email)) return true;
else return false;
}

function send()
{
// check if e-mail adresses are valid.

if (!clsMail::isemail($this->to)) echo 'Caution !!  Mail server can not sent email 1';
if (!clsMail::isemail($this->from)) echo 'Caution !!  Mail server can not sent email 2' ;
if (!clsMail::isemail($this->cc) && !$this->cc=="") echo 'Caution !!  Mail server can not sent email 3' ;
if (!clsMail::isemail($this->bcc) && !$this->bcc=="") echo 'Caution !!  Mail server can not sent email 3';


// To send HTML mail, you can set the Content-type header. html is the default
$headers  = "MIME-Version: 1.0\r\n";
if ($this->contentType=="html") {
	$headers .= "Content-type: text/html; charset=windows-874\r\n";
	$headers .= "<META content=\"text/html; charset=windows-874\" http-equiv=Content-Type>\r\n";
}else $headers .= "Content-type: text/plain; charset=us-ascii\r\n";

// additional headers  for From, Cc and Bcc
$headers .= "From: ".$this->from."\r\n";
if (!$this->cc=="")  $headers .= "Cc: ".$this->cc."\r\n";
if (!$this->bcc=="") $headers .= "Bcc: ".$this->bcc."\r\n";

// send the e-mail
return mail($this->to, $this->subject, $this->message, $headers);
}

}
/*
// example how te use the mail class
$mail = new clsMail();
$mail->to="pairoj@sapphire.co.th";
$mail->from="obec@domain.com";
$mail->subject="My Subject";
$mail->message="My Message";
echo $mail->send(); // returns true or false at failure
*/
?>