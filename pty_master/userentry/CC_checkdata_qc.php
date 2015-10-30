<?
$ApplicationName	= "CC_CheckData";
$module_code 		= "CC_CheckData"; 
$process_id			= "CC_CheckData";
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
	## Modified Detail :		ระบบตรวจสอบรับรองความถูกต้องของข้อมูล
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
session_start();
set_time_limit(0);
$path_pdf = "../../../../../edubkk_kp7file/";


include ("../../../../config/conndb_nonsession.inc.php")  ;
include("../../../../common/common_competency.inc.php");
include('function_checkdata_cmss.inc.php') ;
$time_start = getmicrotime();
$report_id = "5"; // รหัสโพรไฟล์ 48 เขต ที่ใช้สำหรับการตรวจสอบข้อมูล
$profile_id = 1;
//$conv = " AND siteid='5001' ";
//$xlimit = " LIMIT 100";

$Hour_porcess = date("H"); // เวลาประมวลผล
if($Hour_porcess == "05"){
	$status_process = 1;
}else{
	$status_process = 0;
}//end if($Hour_porcess == "05" or $Hour_porcess == "06" or $Hour_porcess == "07"){
//$status_process = 1;


function ChecknumSalary($idcard,$siteid){
		$dbsite = STR_PREFIX_DB.$siteid;
		$sql = "SELECT COUNT(id) as numid FROM salary WHERE id='$idcard' GROUP BY id";
		$result = mysql_db_query($dbsite,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[numid];
}//end function ChecknumSalary($idcard,$siteid){


if($status_process == "1"){
$arrdata = array();

	$sql = "SELECT siteid FROM tbl_cmss_profile_new WHERE  report_id='$report_id' $conv";
	$result=  mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>___LINE___".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$xsiteid = $rs[siteid]; // 
		$dbsite = STR_PREFIX_DB.$xsiteid;
			$sql_view = "SELECT * FROM view_general_primarydata WHERE siteid='$rs[siteid]' $xlimit";	
			$result_view = mysql_db_query($dbnamemaster,$sql_view) or die(mysql_error()."$sql_view<br>LINE::".__LINE__);
			while($rsv = mysql_fetch_assoc($result_view)){
				$sql_maxprofile = "SELECT profile_id FROM 	tbl_checklist_kp7 WHERE idcard='$rsv[idcard]' AND siteid='$xsiteid' and page_num > 0 ORDER BY profile_id DESC LIMIT 1 ";
				$result_maxprofile = mysql_db_query($dbname_temp,$sql_maxprofile) or die(mysql_error()."$sql_maxprofile<br>LINE__".__LINE__);
				$rsp = mysql_fetch_assoc($result_maxprofile);
				$profile_id = $rsp[profile_id];
				
			
				$arrdata = ProcessQCData($xsiteid,$rsv[idcard],$profile_id);
				$num_error = count($arrdata);	
				if($num_error < 1){
					$status_checkdata = "1";	 
				}else if(ChecknumSalary($rsv[idcard],$xsiteid) < 1){
					$status_checkdata = "0";	 
				}else{
					$status_checkdata = "2";	
				}
				
				
				if($status_checkdata == "2"){
					 if(count($arrdata)> 0){
						 foreach($arrdata as $key => $val){	
							  $sql_error = "REPLACE INTO view_general_primary_checkdatadetail SET datecheck='".date("Y-m-d")."', idcard='$rsv[idcard]',siteid='$xsiteid',error_key='$key',error_msg='$val'";
							  mysql_db_query($dbnamemaster,$sql_error) or die(mysql_error()."$sql_error<br>LINE__".__LINE__);
						 }//end  foreach($arrdata as $key => $val){	
					 }//end if(count($arrdata)> 0){			
				}//end if($status_checkdata == "2"){
				
				#############   เก็บ  log การตรวจสอบข้อมูล
				$sql_rep = "REPLACE INTO view_general_primary_checkdata SET datecheck='".date("Y-m-d")."', idcard='$rsv[idcard]',siteid='$xsiteid',status_checkdata='$status_checkdata'";
				//echo $sql_rep."<br>";
				mysql_db_query($dbnamemaster,$sql_rep) or die(mysql_error()."$sql_rep<br>LINE__".__LINE__);
				
				$sql_update = "UPDATE view_general_primarydata SET status_checkdata='$status_checkdata'  WHERE idcard='$rsv[idcard]' AND siteid='$rsv[siteid]'";
			//	echo "$sql_update<br>";
				mysql_db_query($dbnamemaster,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
				
				unset($arr_val);
				unset($arrdata); 
				$num_error = 0;
				$status_checkdata = 0;
			}//end while($rsv = mysql_fetch_assoc($result_view)){
				
			mysql_free_result($result_view);
	}//end while($rs = mysql_fetch_assoc($result)){
			mysql_free_result($result);

}//end if($status_process == "1"){
	
echo "Done...$Hour_porcess";
#################   end ประมวลผลข้อมูล
?>


