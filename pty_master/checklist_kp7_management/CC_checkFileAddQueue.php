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
$imgpdf = "<img src='../../images_sys/gnome-mime-application-pdf.png' alt='สำเนา ก.พ.7 ต้นฉบับ' width='16' height='16' border='0'>";



	$dbname_temp = DB_CHECKLIST;
	if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์
		
		$sql_profile = "SELECT * FROM tbl_checklist_profile WHERE status_active ='1' ORDER BY profile_date DESC LIMIT 0,1";
		$result_profile = @mysql_db_query($dbname_temp,$sql_profile);
		$rspro = @mysql_fetch_assoc($result_profile);
		$profile_id = $rspro[profile_id];
	}//end if($profile_id == ""){// กรณีไม่ได้เลือกรหัส โฟล์ไฟล์

include("function_check_xref.php");

function SaveLogUnlinkFile($idcard,$siteid,$file_script,$url_file,$profile_id){
	global $dbname_temp;
	$sql = "INSERT INTO tbl_log_unlinkfile SET idcard='$idcard',siteid='$siteid',file_script='$file_script',url_file='$url_file',profile_id='$profile_id',staff_id='".$_SESSION['session_staffid']."',timeupdate=NOW()";
	mysql_db_query($dbname_temp,$sql);	
}//end 


$time_start = getmicrotime();

//mail_daily_request($workname, $xemail , $email_sys ,$msgtext,"","5001");	
function ApproveScanFile($idcard,$approve="",$page_upload=""){
	
	global $dbname_temp,$profile_id;
	if($approve == ""){
		$approve = 1;	
	}
	$date_recive_true = date("Y-m-d");
	// date_recive_true='$date_recive_true'
	$sql_update = "UPDATE tbl_checklist_assign_detail SET approve='$approve',page_upload='$page_upload' WHERE idcard ='$idcard' AND profile_id='$profile_id'";
	@mysql_db_query($dbname_temp,$sql_update);
	$sql_c = "SELECT ticketid FROM tbl_checklist_assign_detail WHERE  idcard ='$idcard' AND profile_id='$profile_id'";
	$result_c = mysql_db_query($dbname_temp,$sql_c);
	$rsc = mysql_fetch_assoc($result_c);
	#############  ตรวจสอบว่าจำนวนบุคลากรในใบงานกับจำนวนที่รับรองไปแล้วเท่ากันรึเปล่า
	$sqlc1 = "SELECT COUNT(idcard) AS num1, sum(if(approve='1',1,0)) as napprove,sum(if(approve='2',1,0)) AS numedit FROM tbl_checklist_assign_detail WHERE ticketid='$rsc[ticketid]' GROUP BY ticketid";
	$resultc1 = mysql_db_query($dbname_temp,$sqlc1);
	$rsc1 = mysql_fetch_assoc($resultc1);
	if($rsc1[num1] == $rsc1[napprove]){
		$approve = 1;	
	}else if($rsc1[numedit] > 0){
		$approve	= 2;
	}else{
		$approve = 0;	
	}//end if($rsc1[num1] == $rsc1[napprove]){
	################## 
	$sql_up1 = "UPDATE tbl_checklist_assign SET approve='$approve',date_recive_true='$date_recive_true' WHERE ticketid='$rsc[ticketid]'";
	@mysql_db_query($dbname_temp,$sql_up1);
	
}//end function ApproveScanFile(){



	## function count จำนวนคน กับไฟล์ pdf
	function CountPersonPdf(){
		global $dbname_temp,$profile_id;	
		$sql = "SELECT 
		count(idcard) as NumPerson,
		sum(if(page_upload > 0,1,0)) as NumPdf,
		sum(if(page_upload > 0 and page_upload <> page_num,1,0)) as NumPageFail,
		Sum(if(status_numfile='1' and status_check_file='YES' and status_file='1' and (mainpage IS NULL  or mainpage='' or mainpage='1') and  status_id_false='0',1,0)) AS NumTrue,
		siteid
		FROM tbl_checklist_kp7 WHERE  profile_id='$profile_id' GROUP BY siteid";
		//echo $sql;
		$result = mysql_db_query($dbname_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]]['NumPdf'] = $rs[NumPdf];
		$arr[$rs[siteid]]['NumPerson'] = $rs[NumPerson];
		$arr[$rs[siteid]]['NumPageFail'] = $rs[NumPageFail];
		$arr[$rs[siteid]]['NumTrue'] = $rs[NumTrue];
		}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
	}
	
	###
	function AddLogPdf($get_idcard,$get_siteid,$get_action){
		global $dbname_temp;
		$sql = "INSERT INTO tbl_log_upload_pdf SET idcard='$get_idcard',siteid='$get_siteid',action='$get_action'";
		mysql_db_query($dbname_temp,$sql);
	}
	
	
	function AddRunQueueFile($siteid){
		global $dbname_temp;
		$sql = "REPLACE INTO log_run_queue_checkfile SET siteid='$siteid' ,timeupdate=NOW();";
		mysql_db_query($dbname_temp,$sql) or die(mysql_error()." LINE ::".__LINE__);
			
	}//end function AddRunQueueFile(){
		
	function AddFileError($idcard,$siteid,$status_error1,$status_error2,$status_error3,$num_page){
		global $dbname_temp;
		$sql = "INSERT INTO log_run_queue_checkfile_error SET idcard='$idcard',siteid='$siteid',status_error1='$status_error1',status_error2='$status_error2',status_error3='$status_error3',num_page='$num_page',timeupdate=NOW()";	
		mysql_db_query($dbname_temp,$sql) or die(mysql_error()." LINE ::".__LINE__);
	}


	function ReadFileFolderKp7($Dir_Part){ // $Dir_Part = ../../../".PATH_KP7_FILE."/fileall/		
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
	

	
	
	
	


	####  sript log pdf
	$pdf = ".pdf";
	$sql = "SELECT
t1.secid
FROM
$dbnamemaster.eduarea as t1
Left Join edubkk_checklist.log_run_queue_checkfile as t2 ON t1.secid = t2.siteid
WHERE
t1.secid NOT LIKE '99%' and 
t2.siteid IS NULL 
order by t1.secid ASC
 LIMIT 1
";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	$path_kp7 = "../../../".PATH_KP7_FILE."/$rs[secid]/";
	$file_pdf = ReadFileFolderKp7($path_kp7);
	AddRunQueueFile($rs[secid]);// เพิ่มเขตที่ทำการ check ไฟล์ ไปแล้ว
	 if(count($file_pdf) > 0){

			foreach($file_pdf as $k => $v){

			if($v != ""){

					
						$file_source =$path_kp7.$v.$pdf;
						//echo "<a href='$file_source'>$file_source</a><br>";
						
						$xError = CheckFilePDF($file_source);// ตรวจสอบไฟล์ เสีย
						$xEncrytp = CheckFileEncrypt($file_source); // ตรวจสอบไฟล์ที่มีปัญหาการเข้ารหัส
						$xPdfError = CheckFileError($file_source); // ตรวจสอบไฟล์มีปัญหา error รึเปล่า
						$xNumPage =  XCountPagePdf($file_source); // นับจำนวนแผ่น
						if($xError == "ok"){
								$status_error1 = 0;
						}else{
								$status_error1 = 1;
						}
						
						if($xEncrytp == "ok"){
								$status_error2 = 0;
						}else{
								$status_error2 = 1;	
						}
						
						if($xPdfError == "ok"){
								$status_error3 = 0;
						}else{
								$status_error3 = 1;	
						}
						
						### เก็บ log ผลการตรวจไฟล์
						AddFileError($v,$rs[secid],$status_error1,$status_error2,$status_error3,$xNumPage);
						
					unset($xError);
					unset($xEncrytp);
					unset($xPdfError);
					unset($xNumPage);
					//die;
			}// end if($v != ""){
			} //  end foreach($file_pdf as $k => $v){
			unset($file_pdf);
}//  if(count($file_pdf) > 0){
################  แสดงรายละเอียดจำนวนบุคลากร

?>