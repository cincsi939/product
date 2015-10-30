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

$sql = "SELECT DISTINCT
tbl_checklist_log.idcard,
if(tbl_checklist_log.user_update <> '',tbl_checklist_log.user_update,tbl_checklist_log.user_save) as staffid,
tbl_checklist_log.profile_id,
date(tbl_checklist_log.time_update) as time_update
FROM
tbl_checklist_log
Inner Join tbl_checklist_kp7 ON tbl_checklist_log.idcard = tbl_checklist_kp7.idcard AND tbl_checklist_log.profile_id = tbl_checklist_kp7.profile_id
WHERE
tbl_checklist_log.action_data LIKE  '%excel%' AND
tbl_checklist_kp7.page_num >  '0'
and  staff_upload_pic  IS NULL
and  tbl_checklist_log.profile_id ='4'
order by tbl_checklist_log.time_update ";
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
		$sql_up = "update tbl_checklist_kp7 set staff_upload_pic='$rs[staffid]',date_upload_pic='$rs[$time_update]' WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]'";
		mysql_db_query($dbname_temp,$sql_up);
}




$sql1 = "SELECT DISTINCT
tbl_checklist_log.idcard,
if(tbl_checklist_log.user_update <> '',tbl_checklist_log.user_update,tbl_checklist_log.user_save) as staffid,
tbl_checklist_log.profile_id,
date(tbl_checklist_log.time_update) as time_update
FROM
tbl_checklist_log
Inner Join tbl_checklist_kp7 ON tbl_checklist_log.idcard = tbl_checklist_kp7.idcard AND tbl_checklist_log.profile_id = tbl_checklist_kp7.profile_id
WHERE
tbl_checklist_log.action_data LIKE  '%excel%' AND
tbl_checklist_kp7.page_num >  '0'
and  staff_upload_pic  IS NULL
and  tbl_checklist_log.profile_id ='4'
order by tbl_checklist_log.time_update ";
$result1 = mysql_db_query($dbname_temp,$sql1);
while($rs1 = mysql_fetch_assoc($result1)){
		$sql_up1 = "update tbl_checklist_kp7 set staff_upload_pic='$rs1[staffid]',date_upload_pic='$rs1[$time_update]' WHERE idcard='$rs1[idcard]' AND profile_id='$rs1[profile_id]'";
		mysql_db_query($dbname_temp,$sql_up1);
}

?>