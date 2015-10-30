<?

//echo  "old_pwd : ".$_POST['old_pwd'];
//echo  "<br>new_pwd1 : ".$_POST['new_pwd1'];
//echo  "<br>new_pwd2 : ".$_POST['new_pwd2'];

session_start();
header("Last-Modified: ".gmdate( "D, d M Y H:i:s")."GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("content-type: application/x-javascript; charset=TIS-620");

include("epm.inc.php");
include("function.php");

$pwd_old	= post_decode($_POST["old_pwd"]); 
$pwd_new	= post_decode($_POST["new_pwd1"]); 
$org_id 		= intval($_SESSION[session_dev_id]);
$id 			= $_SESSION[session_staffid];

$sql			= " select * from $epm_staff  where password = '$pwd_old' and staffid='$id'; ";

$result		= mysql_query($sql)or die("Query line " . __LINE__ . "<hr>".mysql_error());
$row			= mysql_num_rows($result);
if($row >= 1){

	$sql		= " update $epm_staff set password = '".$pwd_new	."',flag_change_password='0'  where staffid='$id'; ";
	$update	= mysql_query($sql)or die("Query line " . __LINE__ . "<hr>".mysql_error());
	$sql_up = "INSERT INTO log_change_password SET staffid='$id',change_date='".date("Y-m-d")."',oldpassword='$pwd_old',newpassword='$pwd_new'";
	mysql_query($sql_up);
	echo "<div align=\"center\"><img src=\"images/approve.gif\" width=\"18\" height=\"18\" align=\"absmiddle\" />&nbsp;";
	echo "<font color='blue'>ทำการเปลี่ยน รหัสผ่านเรียบร้อยแล้ว</font></div>";		
		
} else {
	echo "<div align=\"center\"><font color='red'>รหัสผ่านของท่านไม่ถูกต้อง</font></div>";		
}
?>