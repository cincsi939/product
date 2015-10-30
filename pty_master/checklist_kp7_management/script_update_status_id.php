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


include("../../config/conndb_nonsession.inc.php");
include("../../common/common_competency.inc.php");
include("checklist2.inc.php");

	$sql_checklist  = "SELECT idcard FROM tbl_checklist_kp7 WHERE profile_id='4' AND status_id_false='1' ";
	$result_checklist = mysql_db_query($dbname_temp,$sql_checklist);
	$numrow = mysql_num_rows($result_checklist);
	$i=0;
	while($rsc = mysql_fetch_assoc($result_checklist)){
			if(Check_IDCard($rsc[idcard])){
				$i++;
				$sql_up = "UPDATE tbl_checklist_kp7 SET status_id_false='0' WHERE idcard='$rsc[idcard]' AND profile_id='4' ";	
				mysql_db_query($dbname_temp,$sql_up);
				echo $i." :: ".$sql_up."<br>";
			}
	}
	
	echo "ทั้งหมด  $numrow  :: แก้ไข  : $i  รายการ";

?>