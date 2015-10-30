<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		ÃĞººÊè§§Ò¹
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM

include "epm.inc.php";
include("function_assign.php");

$cdate = date("Y-m-d"); // ÇÑ¹·Õè»Ñ¨¨ØºÑ¹
$sql = "SELECT staffid FROM keystaff WHERE retire_date <> '0000-00-00' and retire_date <= '$cdate' AND status_permit='YES'";
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
	$sql_update = "UPDATE keystaff SET status_permit='NO' WHERE staffid='$rs[staffid]'";
	mysql_db_query($dbnameuse,$sql_update);
		
}//end while($rs = mysql_fetch_assoc($result)){


?>