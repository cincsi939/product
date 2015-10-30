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
die;
$dbname_edubkk_userentry = "edubkk_userentry";
$sql = "SELECT
assign_keyin_out.ticketid,
assign_keyin_out.idcard,
assign_keyin_out.staffid
FROM `assign_keyin_out` where ticketid IN('TK-255401310913130124789','TK-255401310915140124567','TK-255401310916220125789','TK-255401310933150135789')";
$result = mysql_db_query($dbname_edubkk_userentry,$sql);
while($rs = mysql_fetch_assoc($result)){
	
	//INSERT INTO tbl_assign_key(ticketid,idcard,siteid,fullname,profile_id)VALUES('$TicketId','$v','$xsiteid[$k]','$name[$k]','$profile_id')
	$sql1 = "SELECT * FROM  tbl_assign_key WHERE ticketid='$rs[ticketid]' GROUP BY profile_id";
	$result1 = mysql_db_query($dbname_edubkk_userentry,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	
	$sql_checklist = "SELECT * FROM tbl_checklist_kp7 WHERE idcard='$rs[idcard]' AND profile_id='$rs1[profile_id]'";
	$resultc =mysql_db_query("edubkk_checklist",$sql_checklist);
	$rsc = mysql_fetch_assoc($resultc);
	
	$sql_insert = "INSERT INTO tbl_assign_key(ticketid,idcard,siteid,fullname,profile_id)VALUES('$rs[ticketid]','$rs[idcard]','$rsc[siteid]','$rsc[prename_th]$rsc[name_th] $rsc[surname_th]','$rsc[profile_id]')";
	mysql_db_query($dbname_edubkk_userentry,$sql_insert);
	$sql_insert1 = "INSERT INTO tbl_checklist_assign_detail(ticketid,idcard,siteid,prename_th,name_th,surname_th,profile_id,activity_id)VALUES('$rs[ticketid]','$rs[idcard]','$rsc[siteid]','$rsc[prename_th]','$rsc[name_th]','$rsc[surname_th]','$rsc[profile_id]','3')";
	//mysql_db_query("edubkk_checklist",$sql_insert1);
	echo "$sql_insert<br>";
	echo "$sql_insert1<hr>";
	
	$sql_up1 = "UPDATE  assign_keyin_out SET  flag_restore='1' WHERE ticketid='$rs[ticketid]' AND  idcard='$rs[idcard]' AND staffid='$rs[staffid]'";
	mysql_db_query($dbname_edubkk_userentry,$sql_up1);
		
}// end while($rs = mysql_fetch_assoc($result)){

?>