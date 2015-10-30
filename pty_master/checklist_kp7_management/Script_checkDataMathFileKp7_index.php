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



include("../../config/conndb_nonsession.inc.php");
$pathfile = "../../../".PATH_KP7_FILE."/";

mysql_db_query($dbname_temp,"DELETE FROM edubkk_checklist_math_filekp7_file");
$sql = "SELECT CZ_ID as idcard,siteid FROM view_general ORDER BY siteid ASC  ";
$result = mysql_db_query($dbnamemaster,$sql);
$txt1 = "";
while($rs = mysql_fetch_assoc($result)){
	$filekp7 = $pathfile.$rs[siteid]."/".$rs[idcard].".pdf";
	
	
	if(!file_exists($filekp7)){
		$sql_insert = "REPLACE INTO edubkk_checklist_math_filekp7_file SET idcard='$rs[idcard]',siteid='$rs[siteid]' ";
			mysql_db_query($dbname_temp,$sql_insert);
			
	}
		
		
}//end while($rs = mysql_fetch_assoc($result)){




/*if($action == "process"){
		
}// end if($action == "process"){

echo "<a href='?action=process'>ประมวลผล</a>";*/
################  แสดงรายละเอียดจำนวนบุคลากร

?>