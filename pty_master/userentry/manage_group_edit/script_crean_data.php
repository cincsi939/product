<?
session_start();
$ApplicationName	= "profile_group_edit";
$module_code 		= "profile_group_edit"; 
$process_id			= "profile_group_edit";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110503.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-05-03 15:00
	## Created By :		Mr.Suwat Khamtum
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110503.001 
	## Modified Detail :		ระบบบริหารจัดการกลุ่มการแก้ไขข้อมูล
	## Modified Date :		2011-05-03 15:00
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################



include "config_mgroup.php";
include("../../../common/common_competency.inc.php");


if($aciton == "process"){
		$sql = "SELECT
tbl_assign_edit_key.idcard,
tbl_assign_edit_sub.staffid,
tbl_assign_edit_key.userkey_wait_approve,
tbl_assign_edit_sub.ticketid
FROM
tbl_assign_edit_sub
Inner Join tbl_assign_edit_key ON tbl_assign_edit_sub.ticketid = tbl_assign_edit_key.ticketid
WHERE
tbl_assign_edit_sub.staffid NOT IN('10562','10928','11082','11132','11133','11328','11329','11349','11782') and userkey_wait_approve='0' ";
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
while($rs = mysql_fetch_assoc($result)){
	$sql1 = "SELECT
tbl_assign_edit_log_detail.req_person_id
FROM
tbl_assign_edit_log
Inner Join tbl_assign_edit_log_detail ON tbl_assign_edit_log.runid = tbl_assign_edit_log_detail.log_id
where idcard='$rs[idcard]' and ticketid='$rs[ticketid]' group by req_person_id";
	$result1 = mysql_db_query($dbnameuse,$sql1)or die(mysql_error()."$sql1<br>LINE::".__LINE__);
	while($rs1 = mysql_fetch_assoc($result1)){
			$sql_up = "UPDATE req_temp_wrongdata  SET status_assign='0',status_key_approve='0' WHERE req_person_id='$rs1[req_person_id]'";
			//echo $sql_up."<br>";
			mysql_db_query($dbnamemaster,$sql_up) or die(mysql_error()."$sql_up<br>LINE::".__LINE__);
	}
		$sql_del = "DELETE FROM tbl_assign_edit_key WHERE idcard='$rs[idcard]' AND ticketid='$rs[ticketid]' ";
		//echo $sql_del."<br>";
	mysql_db_query($dbnameuse,$sql_del);
		$sql_delsub = "DELETE FROM tbl_assign_edit_sub WHERE ticketid='$rs[ticketid]' AND staffid='$rs[staffid]'";
		//echo $sql_delsub."<br>";
	@mysql_db_query($dbnameuse,$sql_delsub);
}


echo "OK";
}

?>
