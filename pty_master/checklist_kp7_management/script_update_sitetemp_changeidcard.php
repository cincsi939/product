<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "checklistkp7"; 
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
include("../../common/common_competency.inc.php");
include("checklist2.inc.php");

if($action == "process"){
	$sql1 = "SELECT idcard,siteid  FROM `tbl_checklist_kp7` where siteid LIKE '0%' ";
	$result1 = mysql_db_query($dbname_temp,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
		$sql_up = "UPDATE temp_change_idcard SET siteid='$rs1[siteid]' WHERE status_process='1' AND new_idcard='$rs1[idcard]'";
		mysql_db_query($dbname_temp,$sql_up);
		//echo $sql_up."<br>";
			
	}//end while($rs1 = mysql_fetch_assoc($result1)){
		
}//end if($action == "process"){


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>script ปรับโครงสร้างหน่วยงานสังกัด สพม ในระบบ checklist</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>

<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>

</head>
<body>

<? echo "<a href='?action=process'>ประมวลผล</a>";?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>