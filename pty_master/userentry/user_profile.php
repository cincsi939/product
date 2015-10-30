<?
session_start();
header("Last-Modified: ".gmdate( "D, d M Y H:i:s")."GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("content-type: application/x-javascript; charset=TIS-620");

include("epm.inc.php");
include("function.php");
$prename 			= post_decode($_POST['prename']);
$staffname 		= post_decode($_POST['staffname']);
$staffsurname	= post_decode($_POST['staffsurname']);
$engprename		= post_decode($_POST['engprename']);
$engname			= post_decode($_POST['engname']);
$engsurname		= post_decode($_POST['engsurname']);
$email				= post_decode($_POST['email']);
$sex					= post_decode($_POST['sex']);
$title					= post_decode($_POST['title']);
$telno				= post_decode($_POST['telno']);
$address			= post_decode($_POST['address']);
$comment 		= post_decode($_POST['comment']);
$org_id 				= intval($_SESSION[session_dev_id]);
$id 					= $_SESSION[session_staffid];

$username = $engname.'.'.substr($engsurname,0,3);
$sql = " update $epm_staff set prename='$prename',staffname='$staffname',staffsurname='$staffsurname',  ";
$sql = $sql." engprename='$engprename',engname='$engname',engsurname='$engsurname', email='$email', comment='$comment', ";
$sql = $sql." sex='$sex',title='$title', telno='$telno',address='$address',username='$username' where staffid = '$id'; ";

$result		= mysql_query($sql)or die("Query line " . __LINE__ . "<hr>".mysql_error());
echo "<div align=\"center\"><img src=\"images/approve.gif\" width=\"18\" height=\"18\" align=\"absmiddle\" />&nbsp;";
echo "<font color='blue'>ข้อมูลของท่านได้รับการปรับปรุงแล้ว</font></div>";	
echo "<div align=\"left\"><table><tr><td width=140><font color='#FF0033'><b>รหัสผู้ใช้คือ</b></font></td><td> <font color='#FF0033'><b>$username</b></font></td></tr></div>";	
?>