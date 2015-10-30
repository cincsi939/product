<?
session_start();
$nochecklogin=true;
include("checklist.inc.php");
//8=login fail, 9 = login , 10 = logout
addLog(10,"Logout จาก username  $_SESSION[session_depusername]");

$_SESSION[session_dev_id] = "";
$_SESSION[session_depusername] = "";
$_SESSION[session_depname] = "";
$_SESSION[session_fullname] = "";
$_SESSION[session_privilege] = "";
$_SESSION[session_lastlogin]="";
$_SESSION[session_username]="";

header("Location: index.php");
exit;

?>
