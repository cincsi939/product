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
include ("../../common/common_competency.inc.php")  ;
include("../../common/function_add_queue_kp7.php");
//include("checklist.inc.php");

$path_pdf = "../../../kp7file_original/";
$kp7_original = "../../../kp7file_original/";
$xkp7path = "../../../".PATH_KP7_FILE."/";
$imgpdf = "<img src='../../images_sys/gnome-mime-application-pdf.png' alt='สำเนา ก.พ.7 ต้นฉบับ' width='16' height='16' border='0'>";


$sql = "SELECT secid FROM eduarea WHERE secid NOT LIKE '99%'";
$result = mysql_db_query($dbnamemaster,$sql);
while($rs = mysql_fetch_assoc($result)){
		$kp7path = $xkp7path.$rs[secid]."/";
		$objScan = scandir("$kp7path");
		foreach ($objScan as $value) {
			$exp = explode(".",$value);
			if($exp[1] == "pdf"){
					echo "folder : $value => ";
					$filename =$kp7path.$value;
					$num_bytes = filesize($filename);
					$num_kb = $num_bytes/1024;
					$num_mb = $num_kb/1024;
					$num_gb = $num_mb/1024;
					echo "ขนาดไฟล์ :: ".filesize($filename)." Bytes<br>";
					$sql_replace = "REPLACE INTO view_kp7file_size SET idcard='".$exp[0]."',siteid='$rs[secid]',filename='$value',num_bytes='$num_bytes',num_mb='$num_mb',num_gb='$num_gb',num_kb='$num_kb'";
					mysql_db_query($dbnamemaster,$sql_replace) or die(mysql_error()."".__LINE__);
			}
		
		}
		unset($objScan);
}//end while($rs = mysql_fetch_assoc($result)){





?>