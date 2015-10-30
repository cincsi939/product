<? 
set_time_limit(0);
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "search_person"; 
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
include("checklist.inc.php");
$time_start = getmicrotime();


$db_temp = "temp_pobec_import";

	$siteid = '5301';
	$strSQL="
		SELECT
			log_copy_kp7file.runid,
			log_copy_kp7file.siteid,
			log_copy_kp7file.status_copy_file,
			log_copy_kp7file.date_copy,
			log_copy_kp7file.idcard
		FROM
			log_copy_kp7file
		WHERE
			log_copy_kp7file.siteid = '$siteid'  and  log_copy_kp7file.status_copy_file='1'
		GROUP BY
			log_copy_kp7file.idcard
		";
		echo "<pre>$strSQL</pre>";
		
	$Result_POBECNAME = mysql_db_query($dbname_temp,$strSQL)or die(mysql_error());
	$i=0; $e=0;
	while( $Rs_pobec = mysql_fetch_array($Result_POBECNAME) ) {
			$strSQL="
			UPDATE `tbl_checklist_kp7` SET tbl_checklist_kp7.page_upload = tbl_checklist_kp7.page_num WHERE tbl_checklist_kp7.idcard= '".$Rs_pobec[idcard]."' limit 1
			";
			echo "$all >".$Rs_pobec[status_copy_file]."<br>";
			if($Rs_pobec[status_copy_file] == "1" ){
				if($debug=="on"){ $result=mysql_db_query( $dbname_temp , $strSQL )or die(mysql_error());		} 
				$i++;		
				echo $strSQL."<br>";
			}else{
				$e++;
			}
			$all++;
	}	
		echo "$siteid : ทั้งหมด : $all ได้ $i  ไม่ได้ $e <br>";			
?>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>