<?
##START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_absent";
$module_code 		= "absent"; 
$process_id			= "absent";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
//include("session.inc.php");
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();

$sql 		= " select * from `general` where name_th like '%¹Øª¹Ò®%'; ";
$result	= mysql_query($sql)or die("Query line " . __LINE__ . " error<hr>".mysql_error());
while($rs = mysql_fetch_assoc($result)){
	
	echo $rs[id]." ".$rs[unit]." ".$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]." ".$rs[idcard]."<br>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Untitled Document</title>
</head>
<body>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
