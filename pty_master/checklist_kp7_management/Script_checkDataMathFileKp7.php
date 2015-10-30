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
include("function_check_xref.php");

$sql = "SELECT CZ_ID as idcard,siteid FROM view_general ORDER BY siteid ASC  ";
$result = mysql_db_query($dbnamemaster,$sql);
$txt1 = "";
while($rs = mysql_fetch_assoc($result)){
	$filekp7 = $pathfile.$rs[siteid]."/".$rs[idcard].".pdf";
	
	

	if(file_exists($filekp7)){
		$sizefile = filesize($filekp7);	
		if($sizefile < 1){ // ขนานไฟล์ เป็น 0
			$txt1 .= " ,sizefile_error='1'";	
		}
		
						$xError = CheckFilePDF($filekp7);// ตรวจสอบไฟล์ เสีย
						$xEncrytp = CheckFileEncrypt($filekp7); // ตรวจสอบไฟล์ที่มีปัญหาการเข้ารหัส
						$xPdfError = CheckFileError($filekp7); // ตรวจสอบไฟล์มีปัญหา xrefer
						if($xError != "ok"){
								$txt1 .= ",status_error1='1' ";
						}
						
						if($xEncrytp != "ok"){
								$txt1 .= ",status_error2='1' ";
						}
						
						if($xPdfError != "ok"){
								$txt1 .= ",status_error3='1' ";
						}
		
		
	}
	
	if(!file_exists($filekp7)){
			$flagid = 1;
	}else{
			$flagid = 0;	
	}
	
	
	if($flagid == "1" or $txt1 != ""){
			$sql_insert = "REPLACE INTO edubkk_checklist_math_filekp7 SET idcard='$rs[idcard]',siteid='$rs[siteid]' $txt1";
			//echo "$sql_insert<br>";
			mysql_db_query($dbname_temp,$sql_insert);
	}
		
		
		
	$txt1 = "";
}//end while($rs = mysql_fetch_assoc($result)){




/*if($action == "process"){
		
}// end if($action == "process"){

echo "<a href='?action=process'>ประมวลผล</a>";*/
################  แสดงรายละเอียดจำนวนบุคลากร

?>