<?php
	###################################################################
	## REPORT: ASSIGN KEY
	###################################################################
	## Version :			20110111.001 (Created/Modified; Date.RunNumber)
	## Created Date :	2011-01-11 11:30
	## Created By :		Mr.KIDSANA PANYA(JENG)
	## E-mail :				kidsana@sapphire.co.th
	## Tel. :				-
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
session_start();
include("../../config/conndb_nonsession.inc.php");
include ("../../common/common_competency.inc.php");
$dbname_edubkk_userentry = "edubkk_userentry";
die;
$sql = "SELECT * FROM `assign_keyin_out`";
$result = mysql_db_query($dbname_edubkk_userentry,$sql);
while($rs = mysql_fetch_assoc($result)){
						$sql_del2 = "DELETE FROM tbl_checklist_assign_detail WHERE ticketid='".$rs['ticketid']."' AND idcard='".$rs[idcard]."' "; 
						echo $sql_del2."<br>";
						 mysql_db_query("edubkk_checklist",$sql_del2);
		
}

?>