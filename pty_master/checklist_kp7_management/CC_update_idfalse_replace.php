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

$sql = "SELECT
t2.idcard,
t2.siteid,
t2.profile_id,
t2.status_chang_idcard,
t2.prename_th,
t2.name_th,
t2.surname_th,
t2.status_IDCARD,
t2.status_IDCARD_REP
FROM
tbl_checklist_kp7 as t1
Inner Join tbl_checklist_kp7_false as t2 ON t1.idcard = t2.idcard AND t1.profile_id = t2.profile_id AND t1.siteid = t2.siteid
where t2.status_chang_idcard='NO' and t2.status_IDCARD='IDCARD_FAIL'";
$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
while($rs = mysql_fetch_assoc($result)){
	$sql_update = "UPDATE tbl_checklist_kp7_false SET status_chang_idcard='YES' WHERE  idcard='$rs[idcard]' and siteid='$rs[siteid]' and profile_id='$rs[profile_id]' ";	
	mysql_db_query($dbname_temp,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
}//end while($rs1 = mysql_fetch_assoc($result1)){

echo "DONE......";

