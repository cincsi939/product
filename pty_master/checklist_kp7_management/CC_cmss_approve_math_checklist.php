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
mysql_db_query($dbnamemaster,"DELETE FROM view_general_approve_math_checklist");
$sql_checklist = "insert into view_general_approve_math_checklist(idcard,siteid)
SELECT
t1.CZ_ID,
t1.siteid
FROM
$dbnamemaster.view_general_report AS t1
Inner Join edubkk_checklist.tbl_checklist_kp7 AS t2 ON t1.CZ_ID = t2.idcard AND t1.siteid = t2.siteid
Inner Join edubkk_checklist.view_checklist_lastprofile AS t3 ON t2.siteid = t3.siteid AND t2.profile_id = t3.last_profile";	
mysql_db_query($dbnamemaster,$sql_checklist);



$sql_edu = "SELECT secid as siteid FROM eduarea WHERE secid NOT LIKE '99%'";
$result_edu = mysql_db_query($dbnamemaster,$sql_edu);
while($rse = mysql_fetch_assoc($result_edu)){
	mysql_db_query($dbnamemaster,"DELETE FROM view_general_approve_nomath_checklist WHERE siteid='$rse[siteid]' ");
	$sql_insert = "INSERT INTO view_general_approve_nomath_checklist(idcard,siteid)SELECT
t1.CZ_ID,
t1.siteid
FROM
view_general_report AS t1
WHERE
t1.siteid='$rse[siteid]'  and t1.CZ_ID NOT IN(select idcard from view_general_approve_math_checklist where siteid='$rse[siteid]' )";	
	mysql_db_query($dbnamemaster,$sql_insert) or die(mysql_error()."".__LINE__);
}//end while($rse = mysql_fetch_assoc($result_edu)){
	echo "DONE....";
############################ end ###########################
$time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>
