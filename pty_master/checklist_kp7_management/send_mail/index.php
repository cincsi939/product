<?php

						include("func_send_mail.php");
						$msgtext	= "ตัวอย่าง";
						$workname="แจ้ง : คุณนาย " ;
						$email_sys = "system@sapphire.co.th";
						$staff_mail  = "suwat@sapphire.co.th";
						$id = "";

mail_daily_request($workname, $staff_mail , $email_sys ,$msgtext,$mail_daily_request,$id);	
									


	
?>