<?php
	function mail_daily_request($title_name,$email_to,$email_from,$msgtext,$title_msg1,$refid=''){
				global $PHP_SELF;
				//require_once "Mail.php";
				require_once("class.phpmailer.php");
				//echo $title_name.",".$email_to.",".$email_from.",".$msgtext;
				//$msg= "MIME-Version: 1.0\r\n";
				//$msg .= "Content-type: text/html; charset=tis-612\r\n"; 
				$msg .= "
					<head>
					<title> HTML content</title>
					</head>
					<body>".ereg_replace(chr(13),"<br>", $msgtext)."</body>
					</html>
				";
				$from = $email_from;
				$to = $email_to;

				$subject = iconv('TIS-620', 'UTF-8',$title_name);
				$msg = iconv('TIS-620', 'UTF-8',$msg);
				$title_msg = iconv('TIS-620','UTF-8',$title_msg1);

				//$subject = $title_name;
				$body = $msg;

				$host = "mail.sapphire.co.th"; 
				$username = "epm@sapphire.co.th";
				$password = "sapphire";
				$content=" text/html; charset=utf-8";

				###################### NEW MAILLER 5.1
				$mail = new PHPMailer();

				$mail->IsSMTP();                                      // set mailer to use SMTP

				$mail->CharSet ="utf-8";
				$mail->IsSMTP();
				$mail->Host ="mail.sapphire.co.th";
				$mail->Port=25;

				$mail->Username = $username;  // SMTP username
				$mail->Password = $password; // SMTP password

				$mail->From = "$from";
				$mail->FromName = "$title_msg";
				$mail->AddAddress("$to");
				$mail->AddReplyTo("$from");

				$mail->WordWrap = 50;                                 // set word wrap to 50 characters
				$mail->IsHTML(true);                                  // set email format to HTML

				$mail->Subject = "$subject";
				$mail->Body    = "$msg";
				//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
				//echo "$subject"."$msg";
				if(!$mail->Send()){
				   echo "Message could not be sent. <p>";
				   echo "Mailer Error: " . $mail->ErrorInfo;
				   exit;
				}
				###################### END MAILLER 5.1
			}

?>