<?
	session_start();
	include("../../../config/db.inc.php");
		$_SESSION[isprivilage] = "none";
		$_SESSION[islogin] = 0;
		
		if($_SESSION[session_staffid] != ""){ // กรณี login เป็น dataentry
		session_destroy();
		echo "<meta http-equiv='refresh' content='1;url=../../userentry/index.php'>" ;
		exit;
		}else{
		//session_destroy();
		echo "<meta http-equiv='refresh' content='1;url=http://www.cmss-otcsc.com'>" ;
		exit;
		}


?>