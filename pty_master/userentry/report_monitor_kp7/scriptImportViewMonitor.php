<?php
header('Content-type: text/html; charset=utf-8');
###################################################################
## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
###################################################################
## Version :		20120106.001 (Created/Modified; Date.RunNumber)
## Created Date :		2012-01-07
## Created By :		Mr. Nattaphon Mahawan
## E-mail :			nattaphon@sapphire.co.th
## Tel. :
## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
###################################################################
session_start();
set_time_limit(0);
include("main.php");
require_once("../../../config/conndb_nonsession.inc.php");
$xsiteid=$_GET['xsiteid'];
if($xsiteid!=''){
	$w="WHERE siteid='{$xsiteid}' ";
	$w2=" WHERE tbl_checklist_kp7.siteid='{$xsiteid}' ";
}
mysql_db_query($dbnamemaster, "DELETE FROM $tblMonitorKey $w " )or die(mysql_error);
echo "START=>กรุณารอจนประมวลผลเสร็จสิ้น";
$strSql=" SELECT tbl_checklist_kp7.idcard AS idcard, 
	tbl_checklist_kp7.siteid AS siteid, 
	tbl_checklist_kp7.profile_id AS profile_id, 
	if(tbl_checklist_kp7.status_numfile='1' AND tbl_checklist_kp7.status_file='1' AND tbl_checklist_kp7.status_check_file='YES','1','0') AS status_doc, 
	if(tbl_checklist_kp7.page_upload>0 ,'1','0') AS status_kp7file, 
	if(".DB_USERENTRY.".tbl_assign_key.idcard IS NOT NULL, if(COUNT(".DB_USERENTRY.".tbl_assign_key.idcard)='1' AND tbl_checklist_kp7.profile_id=".DB_USERENTRY.".tbl_assign_key.profile_id,'kp7_new','kp7_update'), 'kp7_new') AS status_dockey, 
	if(".DB_USERENTRY.".tbl_assign_key.idcard IS NULL, '0', '1') AS status_assign, 
	if(".DB_USERENTRY.".tbl_assign_key.approve='2', '1', '0') AS status_approve   
FROM tbl_checklist_kp7 INNER JOIN view_checklist_lastprofile ON tbl_checklist_kp7.siteid = view_checklist_lastprofile.siteid AND tbl_checklist_kp7.profile_id = view_checklist_lastprofile.last_profile
	 LEFT JOIN ".DB_USERENTRY.".tbl_assign_key ON tbl_checklist_kp7.idcard = ".DB_USERENTRY.".tbl_assign_key.idcard 
	  {$w2} 
	 GROUP BY tbl_checklist_kp7.idcard ";
$result=mysql_db_query($dbTempCheckData, $strSql)or die(mysql_error);
while($ass=mysql_fetch_assoc($result)){
	$sqlInsert="INSERT INTO {$tblMonitorKey} SET 
	idcard='{$ass[idcard]}', 
	siteid='{$ass[siteid]}', 
	profile_id='{$ass[profile_id]}', 
	status_doc='{$ass[status_doc]}', 
	status_kp7file='{$ass[status_kp7file]}', 
	status_dockey='{$ass[status_dockey]}', 
	status_assign='{$ass[status_assign]}', 
	status_approve='{$ass[status_approve]}', 
	timeupdate=NOW() ";
	$res=mysql_db_query($dbnamemaster, $sqlInsert)or die(mysql_error);
	$i+=mysql_affected_rows();
}
echo "<br>DONE {$i} RECORD=>ประมวลผลเสร็จสิ้น";