<?
	session_start();
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
if($action == "process"){
		$sql = "SELECT * FROM `tbl_checklist_assign` where approve='0' and activity_id='1'";
		$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
				$sql1 = "SELECT COUNT(idcard) as numall ,SUM(if(status_sr_doc='2',1,0)) AS numapprove FROM tbl_checklist_assign_detail WHERE ticketid='$rs[ticketid]' ";	
				$result1 = mysql_db_query($dbname_temp,$sql1);
				$rs1 = mysql_fetch_assoc($result1);
				if($rs1[numall] == $rs1[numapprove]){
					$i++;
						$sql_up = "UPDATE tbl_checklist_assign SET approve='1' WHERE  ticketid='$rs[ticketid]' and activity_id='1' ";
						mysql_db_query($dbname_temp,$sql_up);
						echo $i." :: ".$sql_up."<br>";
				}
		}//end while($rs = mysql_fetch_assoc($result)){
}//end if($action == "process"){





echo "<a href='?action=process'>ประมวลผล</a>";

?>