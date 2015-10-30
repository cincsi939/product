<?
session_start();
set_time_limit(0);
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


include("../../common/common_competency.inc.php");
include("../../common/function_getsite_continue.php");
include("checklist2.inc.php");
$file_name = basename($_SERVER['PHP_SELF']);
$time_start = getmicrotime();
############################  start ###########################
mysql_db_query($dbname_temp,"DELETE FROM view_check_notin_cmss");
$sql_checklist = "INSERT INTO view_check_notin_cmss(idcard,siteid)

SELECT
distinct t2.idcard,
t2.siteid
FROM
edubkk_checklist.view_checklist_lastprofile AS t1
Inner Join edubkk_checklist.tbl_checklist_kp7 AS t2 ON t1.last_profile = t2.profile_id AND t1.siteid = t2.siteid
left Join $dbnamemaster.view_general_report AS t3 ON t2.idcard = t3.CZ_ID AND t2.siteid = t3.siteid  
where  t3.CZ_ID IS NULL ; ";	
mysql_db_query($dbname_temp,$sql_checklist);


	echo "DONE....";
############################ end ###########################
$time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
