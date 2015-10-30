<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "script_checkfile"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		ระบบตรวจสอบข้อมูลทะเบียนประวัติต้นฉบับ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
set_time_limit(0);

include ("../../common/common_competency.inc.php")  ;
include("checklist2.inc.php");
$time_start = getmicrotime();


	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../../common/style.css" type="text/css" rel="stylesheet" />
<title>เครื่องมือในการจัดการไฟล์ pdf</title>
</head>
<body bgcolor="#EFEFFF">
<?
$sql = "SELECT idcard,siteid FROM tbl_checklist_kp7 WHERE page_upload > '0'  and profile_id='1' ";
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
	$pathfile = "../../../checklist_kp7file/$rs[siteid]/$rs[idcard]".".pdf";
	
	if(!file_exists($pathfile)){
		$sql_up = "UPDATE  tbl_checklist_kp7 SET  page_upload=NULL WHERE idcard='$rs[idcard]'";	
		echo "$rs[siteid] :: ".$sql_up."<br>";
		//mysql_db_query($dbname_temp);
		echo "FALSE <br>";
	}
	
}//end 

?>

<a href="?action=process">ตรวจสอบข้อมูล</a>||
<a href="http://202.129.35.103/competency_master/application/hr3/hr_report/kp7103.php?xidcard=3501800010958&xsiteid=5001&tmpuser=16092494&tmppass=3501800010958">pdf</a>
</body>

</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
