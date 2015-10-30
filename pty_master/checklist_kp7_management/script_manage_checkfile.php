<?
session_start();
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "script_import_pdf"; 
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

include("checklist2.inc.php");
$pathfile = "../../../".PATH_KP7_FILE."/";

$sql = "SELECT * FROM tbl_checklist_kp7 WHERE profile_id='4' AND page_upload > 0";
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
	$filec = $pathfile.$rs[siteid]."/$rs[idcard]".".pdf";
	if(!is_file($filec)){
		$sql_up = "REPLACE INTO 	temp_log_checkkp7file_lost SET idcard='$rs[idcard]',siteid='$rs[siteid]',profile_id='$rs[profile_id]'";
		mysql_db_query($dbname_temp,$sql_up);
	}

		
}


?>



