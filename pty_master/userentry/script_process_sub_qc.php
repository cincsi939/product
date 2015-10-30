<?
set_time_limit(0);
session_start();
include ("../../../../config/conndb_nonsession.inc.php")  ;
require_once("../../../../common/function_upload_kp7file_qc.php"); 
require_once("../../../checklist_kp7_management/function_check_xref.php");
include('function.inc_sub.php') ;

if($action == "process"){

$sql = "SELECT
keystaff.keyin_group,
validate_checkdata.idcard,
validate_checkdata.staffid,
validate_checkdata.timeupdate,
validate_checkdata.status_cal,
validate_checkdata.datecal,
validate_checkdata.num_point,
validate_checkdata.ticketid
FROM
validate_checkdata
Inner Join keystaff ON validate_checkdata.staffid = keystaff.staffid
where keystaff.keyin_group='8' and status_cal='0' and validate_checkdata.status_process_point='YES'
group by validate_checkdata.idcard
order by 
validate_checkdata.timeupdate desc";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			echo "$rs[idcard] :: $rs[staffid]<br>";
			CalSubtractQc($rs[idcard],$rs[staffid],$rs[ticketid]); // คำนวนคะแนนผลการ QC
	}//end while($rs = mysql_fetch_assoc($result)){
echo " Done....";		
	}//end if
		
?>
