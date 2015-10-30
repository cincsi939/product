<?
session_start();
$ApplicationName	= "crontab";
$module_code 		= "crontab_key_req"; 
$process_id			= "update_key_req";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110503.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-05-03 15:00
	## Created By :		Mr.Suwat Khamtum
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110503.001 
	## Modified Detail :		corntab update ข้อมูลคำร้อง
	## Modified Date :		2011-05-03 15:00
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################



include "config_mgroup.php";
include("../../../common/common_competency.inc.php");
set_time_limit();
$time_start = getmicrotime();

### ประมวลผลจัดการข้อมูลคำร้องขอแก้ไขข้อมูล
ProcessReq();



$time_end = getmicrotime(); writetime2db($time_start,$time_end); 
echo "<h3>Done...</h3>";
  
?>