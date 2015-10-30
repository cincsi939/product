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
include("../../common/Script_CheckIdCard.php");
include("checklist2.inc.php");

$sql = "SELECT t1.idcard, t1.profile_id, t1.status_id_false,t1.siteid FROM tbl_checklist_kp7 as t1 where t1.status_id_false='1'";
$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
while($rs = mysql_fetch_assoc($result)){
	$status_id = Script_checkID($rs[idcard]);
	if($status_id == "1"){
			$sql_update = "UPDATE  tbl_checklist_kp7 SET status_id_false='0',idcard=trim(idcard) WHERE idcard='$rs[idcard]' AND  profile_id='$rs[profile_id]'";
			mysql_db_query($dbname_temp,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
			$sql_insert  = "INSERT INTO tbl_checklist_change_idcard_sys SET idcard='$rs[idcard]' ,profile_id='$rs[profile_id]',siteid='$rs[siteid]',timeupdate=NOW()";
			mysql_db_query($dbname_temp,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE__".__LINE__);
	} 
	
}//end while($rs1 = mysql_fetch_assoc($result1)){

echo "DONE......";

