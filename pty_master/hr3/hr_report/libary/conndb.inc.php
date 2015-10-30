<?
session_start();

// SERVER ID 
$SERVER_ID=1; //man server www.pdc-obec.com
if ($ob_bypass ==""){  ob_start(); } 

if($_SESSION[secid]=="obec"){
	$dbname = "obec";
	$siteid = 0;
}else if($_SESSION[secid]==""){


	echo " <script language=\"JavaScript\">  alert(\" กรุณา loginเข้าสู่ระบบอีกครั้ง \") ; </script>  " ;   
	echo " <script language=\"JavaScript\"> top.location.replace('http://61.7.155.244/vc_cms2/login.php') </script>  " ;  

	die;
//	header("location: /vc_cms/");
//	exit;
}else{
	$dbname = "obec_".$_SESSION[secid];
	$siteid = $_SESSION[secid];
}
//data database
include("../../../../config/config_hr.inc.php");
?>