<?

//echo "CLOSE";die;
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
$siteid = "9501";


$sql = "SELECT
pobec_01.idcard,
pobec_01.date_bt,
pobec_01.date_bet,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now
FROM
tbl_checklist_kp7
Inner Join pobec_01 ON tbl_checklist_kp7.idcard = pobec_01.idcard
WHERE
tbl_checklist_kp7.birthday =  '0000-00-00' or tbl_checklist_kp7.birthday ='' or  tbl_checklist_kp7.birthday IS NULL or 
tbl_checklist_kp7.begindate =  '0000-00-00' or tbl_checklist_kp7.begindate ='' or tbl_checklist_kp7.begindate  IS NULL
order by date_bt desc
";

$result = mysql_db_query($dbname_temp,$sql);
$i=0;
while($rs = mysql_fetch_assoc($result)){
$i++;
	if($rs[date_bt] != ""){
		$arrd = explode("/",$rs[date_bt]);
		$birthday = $arrd[2]."-".sprintf("%02d",$arrd[1])."-".sprintf("%02d",$arrd[0]);
	}else{
		$birthday = "";		
	}
	
	if($rs[date_bet] != ""){
		$arrd1  =  explode("/",$rs[date_bet]);
		$begindate = $arrd1[2]."-".sprintf("%02d",$arrd1[1])."-".sprintf("%02d",$arrd1[0]);
	}else{
		$begindate = "";	
	}
	if($birthday != ""){
			$conu .= " ,birthday='$birthday'";
	}
	if($begindate != ""){
			$conu .= " ,begindate='$begindate'";
	}
	
	if($conu != ""){
		$sqlup = "UPDATE  tbl_checklist_kp7 SET siteid='$siteid' $conu  WHERE siteid = '$siteid'  and idcard='$rs[idcard]'";
		mysql_db_query($dbname_temp,$sqlup) or die(mysql_error()."$sqlup<br>LINE::".__LINE__);
		echo $i." :: ".$sqlup."<br>";	
	}//end if($conu != ""){
	
	

	$conu = "";	
}//end while($rs = mysql_fetch_assoc($result)){




?>