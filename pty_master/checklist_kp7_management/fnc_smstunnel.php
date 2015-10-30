<?php
	###################################################################
	## CMSS : SMS TUNNEL FUNCTION
	###################################################################
	## Version :			20100427.001 (Created/Modified; Date.RunNumber)
	## Created Date :	2010-04-27 14:34
	## Created By :		Mr.JESSADA RUEDEEKULRUNGROJ (AUSSY)
	## E-mail :				jessada@sapphire.co.th
	## Tel. :				086-1918665
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	
	
	/* Send SMS */
	function SendSMS ( $tel, $msg ) {
		$SendToTelNo = $tel;
		$SendMessage = $msg;
		
		if ( $SendToTelNo && $SendMessage ) {
			$RefNo = "1001"; //1001-9999
			$Sender = "Aussy";
			$Msn = $SendToTelNo; //for exemple 097694213 #
			$Msg = $SendMessage; #
			$MsgType = "T";
			$User = "sapphire";
			$Password = "es53y7h";
			
			$host = "www.sms.in.th";
			$method = "POST";
			$path = "/tunnel/sendsms.php";
			$data = 'RefNo='.$RefNo.'&Sender='.$Sender.'&Msn='.$Msn.'&Msg='.$Msg.'&MsgType='.$MsgType.'&User='.$User.'&Password='.$Password;
			
			$Result = sendRequest( $host, $method, $path, $data );
			
			return gwStatus($Result);
		}
	}
	
	/* SMS Server Connection */
	function sendRequest ( $host, $method, $path, $data ) {
		//$method = strtoupper($method);
		$fp = fsockopen($host, 80);
	
		fputs($fp, "$method $path HTTP/1.1\r\n");
		fputs($fp, "Host: $host\r\n");
		fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
		fputs($fp, "Content-length: " . strlen($data) . "\r\n");
		
		fputs($fp, "Connection: close\r\n\r\n");
		if ( $method == 'POST' ) {
			fputs($fp, $data);
		}
	
		while ( !feof($fp) ) {
			$result .= fgets($fp,128);
		}
		
		fclose($fp);
		return $result;
	}
	
	/* Get Sending Status */
	function gwStatus ( $raw_socket_return ) {
		$raw_socket_return = trim($raw_socket_return);
		$socket_status = "";
		$socket_return = explode("\n", $raw_socket_return);
		$count = count($socket_return);
		$iresult = $count-2;
		$socket_status = $socket_return[$iresult];
		return $socket_status;
	}
?>