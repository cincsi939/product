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
include("checklist2.inc.php");

function GetColumnTbl($tbl_name){
	global $dbname_temp;
	$inField = "";
	$sql = "show columns from $tbl_name";	
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			if($inField > "") $inField .= ",";
			$inField .= "$rs[Field]";
	}
	return $inField;
}// end function GetColumnTbl($tbl_name){


$sql = "SELECT * FROM tbl_checklist_site_delete WHERE status_process='0' ";
$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
while($rs = mysql_fetch_assoc($result)){
	$sql_temp = " REPLACE INTO tbl_checklist_site_delete_detail (".GetColumnTbl("tbl_checklist_site_delete_detail").") 
	SELECT ".GetColumnTbl("tbl_checklist_kp7")." FROM tbl_checklist_kp7 WHERE siteid='$rs[siteid]' and profile_id='$rs[profile_id]'";	
	//echo $sql_temp."<br>";
	$result_temp = mysql_db_query($dbname_temp,$sql_temp) or die(mysql_error()."$sql_temp<br>LINE__".__LINE__);
	if($result_temp){
			$sql_delete = "DELETE FROM  tbl_checklist_kp7 WHERE siteid='$rs[siteid]' AND profile_id='$rs[profile_id]' ";
			//echo $sql_delete."<br>";
			mysql_db_query($dbname_temp,$sql_delete) or die(mysql_error()."$sql_delete<br>LINE__".__LINE__);
			$sql_update = "UPDATE tbl_checklist_site_delete SET status_process='1' WHERE siteid='$rs[siteid]' AND profile_id='$rs[profile_id]' ";
			//echo $sql_update."<br>";
			mysql_db_query($dbname_temp,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
	}// end if($result_temp){
	#mysql_db_query($dbname_temp,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
}//end while($rs1 = mysql_fetch_assoc($result1)){

echo "DONE......";

