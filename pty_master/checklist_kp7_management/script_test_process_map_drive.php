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
$dbname_temp = DB_CHECKLIST;
$path_upload = "../../../checklist_kp7file/$xsiteid/";
$path_uploadall = "../../../checklist_kp7file/fileall/";
$path_kp7upload = "../../../".PATH_KP7_FILE."/$xsiteid/";
$kp7upload = "../../../".PATH_KP7_FILE."/";

function XReadFileFolder($Dir_Part){		
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
#############  end #########################################  นับไฟล์ในโฟล์เดอร์
$kp75001 = $kp7upload."5001/";
$arr_file = XReadFileFolder($kp75001);
foreach($arr_file as $key => $val){
	$spos1 = strpos($val,"a");
	
		if(!($spos1 === false)){
			$sourcefile = $kp75001.$val.".pdf";
			$destfile = $kp75001."x".$val.".pdf";
			echo $destfile."<br>";
			copy($sourcefile,$destfile);
			chmod($destfile,0777);
		}
		
}//end foreach($arr_file as $key => $val){



?>