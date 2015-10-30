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

if($processA == "process"){ // ประมวลผลรายการ

	$sql1 = "SELECT id,siteid FROM allschool WHERE id IN('720106','720155','720156','720110','230150','270182','270197','20046','2046919','640541','210786','210789','210791','210790','210808','210804','210806','210807','210805','210812','210814','210817','210813','210816','210820','210838','210839','210847','210815','210840','140334','140335','140340','680834','50659','50537','50719','450836','530916','530514','201356','201393','201432','201362','201455','700266','700271','700260','700261','700262','700263','700264','700265','700267','700268','700269','700270','700272','700273','700274','700275','700276','700277','700278','700279','700280','220622')";
	$result1 = mysql_db_query($dbnamemaster,$sql1);
	while($rs1 = mysql_fetch_assoc($result1)){
			$sql_update = "UPDATE  tbl_checklist_kp7 SET siteid='$rs1[siteid]' WHERE (profile_id='4' or profile_id='5')  AND schoolid='$rs1[id]'";
			echo "$sql_update<br>";
			mysql_db_query($dbname_temp,$sql_update);
			
	}//end while($rs1 = mysql_fetch_assoc($result1)){
		
		
		
	$xsql = "SELECT distinct idcard,siteid FROM tbl_checklist_kp7 WHERE profile_id >= '4'  AND schoolid IN('720106','720155','720156','720110','230150','270182','270197','20046','2046919','640541','210786','210789','210791','210790','210808','210804','210806','210807','210805','210812','210814','210817','210813','210816','210820','210838','210839','210847','210815','210840','140334','140335','140340','680834','50659','50537','50719','450836','530916','530514','201356','201393','201432','201362','201455','700266','700271','700260','700261','700262','700263','700264','700265','700267','700268','700269','700270','700272','700273','700274','700275','700276','700277','700278','700279','700280','220622')";
	$xresult = mysql_db_query($dbname_temp,$xsql);
	while($xrs = mysql_fetch_assoc($xresult)){
			$xsql_up = "UPDATE monitor_keyin SET siteid='$xrs[siteid]' WHERE idcard='$xrs[idcard]'";
			//echo "$sql_up<br>";
			mysql_db_query($dbcallcenter_entry,$xsql_up);
			$xsql_up1 = "UPDATE tbl_assign_key SET siteid='$xrs[siteid]' WHERE idcard='$xrs[idcard]' AND profile_id >= '4'";
			//echo $sql_up1."<br>";
			mysql_db_query($dbcallcenter_entry,$xsql_up1);
	}//end while($rs = mysql_db_query($result)){

	
	$sql = "SELECT distinct idcard,siteid FROM tbl_checklist_kp7 WHERE profile_id >= '4'  AND schoolid IN('720106','720155','720156','720110','230150','270182','270197','20046','2046919','640541','210786','210789','210791','210790','210808','210804','210806','210807','210805','210812','210814','210817','210813','210816','210820','210838','210839','210847','210815','210840','140334','140335','140340','680834','50659','50537','50719','450836','530916','530514','201356','201393','201432','201362','201455','700266','700271','700260','700261','700262','700263','700264','700265','700267','700268','700269','700270','700272','700273','700274','700275','700276','700277','700278','700279','700280','220622') ";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){	
		$sql1 = "SELECT * FROM tbl_checklist_assign_detail WHERE idcard='$rs[idcard]' and  profile_id >= '4' AND siteid='$rs[siteid]' ";
		$result1 = mysql_db_query($dbname_temp,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		if($rs1[ticketid] != ""){
			$sql_up1 = "UPDATE tbl_checklist_assign SET siteid='$rs[siteid]' WHERE ticketid='$rs1[ticketid]'";
			//echo $sql_up1."<br>";
			mysql_db_query($dbname_temp,$sql_up1);	
		}//end if($rs1[ticketid] != ""){
			$sql_up2 = "UPDATE tbl_checklist_assign_detail SET siteid='$rs[siteid]' WHERE idcard='$rs[idcard]' AND profile_id >= '4'";
			//echo $sql_up2."<br>";
			mysql_db_query($dbname_temp,$sql_up2);
			$sql_up3 = "UPDATE tbl_checklist_assign_log SET siteid='$rs[siteid]' WHERE idcard='$rs[idcard]'";
			//echo $sql_up3."<br>";
			mysql_db_query($dbname_temp,$sql_up3);
			$sql_up4 = "UPDATE tbl_checklist_assign_log_activity SET siteid='$rs[siteid]' WHERE idcard='$rs[idcard]'";
			//echo $sql_up4."<br>";
			mysql_db_query($dbname_temp,$sql_up4);
	
	}//end while($rs = mysql_fetch_assoc($result)){	

		
/*echo "<script>alert('ปรับโครงสร้างข้อมูลเรียบร้อยแล้ว'); location.href='?action=';</script>";	exit();*/
		
}

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
<a href="?processA=process">ประมวลผล</a>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>