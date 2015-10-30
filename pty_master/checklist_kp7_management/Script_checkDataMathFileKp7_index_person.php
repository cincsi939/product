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
function xReadFileFolder($Dir_Part){
		$Dir=opendir($Dir_Part);
		while($File_Name=readdir($Dir)){
			if(($File_Name!= ".") && ($File_Name!= "..")){
				$Name .= "$File_Name";
			}
					
		}
		closedir($Dir);
		///ปิด Directory------------------------------	
		$File_Array=explode(".pdf",$Name);
		return $File_Array;
	}// end function ReadFileFolder($get_site=""){

function CheckPersonInDb($idcard,$siteid){
		global $dbnamemaster,$dbname_temp;
		$sql = "SELECT COUNT(CZ_ID) as numid FROM view_general WHERE CZ_ID='$idcard' AND siteid='$siteid' GROUP BY CZ_ID";
		$result = mysql_db_query($dbnamemaster,$sql);
		$rs= mysql_fetch_assoc($result);
		return intval($rs[numid]);
		
		
}// end function CheckPersonInDb($idcard){
	
	

mysql_db_query($dbname_temp,"DELETE FROM edubkk_checklist_math_filekp7_file_no_person");
$sql = "SELECT secid FROM eduarea WHERE secid NOT LIKE '99%'";
$result = mysql_db_query($dbnamemaster,$sql);
while($rs = mysql_fetch_assoc($result)){
	$pathfile1 = $pathfile.$rs[secid]."/";
	$arrfile = xReadFileFolder($pathfile1);
	
	if(count($arrfile) > 0){
		foreach($arrfile as $key => $val){
				if($val != "" and strlen($val) == "13"){
					
					$numid_person = intval(CheckPersonInDb($val,$rs[secid]));
					if($numid_person < 1){
							$sql_insert = "REPLACE INTO edubkk_checklist_math_filekp7_file_no_person SET idcard='$val',siteid='$rs[secid]' ";
			mysql_db_query($dbname_temp,$sql_insert);
					}
					
				}
		}//end foreach(){
		
	}//end if(count($arrfile) > 0){
	
	
	

		
}//end while($rs = mysql_fetch_assoc($result)){




/*if($action == "process"){
		
}// end if($action == "process"){

echo "<a href='?action=process'>ประมวลผล</a>";*/
################  แสดงรายละเอียดจำนวนบุคลากร

?>