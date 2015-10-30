<?
session_start();
set_time_limit(0);
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
include("../../common/Script_CheckIdCard.php");
include("../../common/function_getsite_continue.php");
include("checklist2.inc.php");

$sql = "SELECT
t1.secid,
t1.secname,
t2.config_profile
FROM
edubkk_master.eduarea AS t1
Left Join edubkk_checklist.view_checklist_lastprofile as t2 ON t1.secid =t2.siteid
WHERE
t1.secid NOT LIKE  '99%' and t2.config_profile='0'
ORDER BY
t1.secid ASC
";
$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
while($rs = mysql_fetch_assoc($result)){
		$sql_maxprofile = "SELECT MAX(profile_id) as last_profile FROM tbl_checklist_kp7 WHERE siteid='$rs[secid]' GROUP BY siteid";
		$result_maxp = mysql_db_query($dbname_temp,$sql_maxprofile)or die(mysql_error()."$sql_beforeprofile<br>LINE__".__LINE__);
		$rsp = mysql_fetch_assoc($result_maxp);
		
		$sql_beforeprofile = "SELECT MAX(profile_id) as last_profile FROM tbl_checklist_kp7 WHERE siteid='$rs[secid]' AND profile_id <> '$rsp[last_profile]' GROUP BY siteid";
		$result_maxpb = mysql_db_query($dbname_temp,$sql_beforeprofile) or die(mysql_error()."$sql_beforeprofile<br>LINE__".__LINE__);
		$rsp1 = mysql_fetch_assoc($result_maxpb);
		
		$sql_rep = "REPLACE INTO view_checklist_lastprofile SET siteid='$rs[secid]',last_profile='$rsp[last_profile]',before_profile='$rsp1[last_profile]',timeupdate=NOW()";
		mysql_db_query($dbname_temp,$sql_rep) or die(mysql_error()."$sql_rep".__LINE__);
}//end while($rs = mysql_fetch_assoc($result)){
	

	$sql_update1 = "UPDATE view_checklist_lastprofile SET before_profile='0' WHERE siteid IN(".GetSiteContinue().")";
	//echo $sql_update1."<br>";
	mysql_db_query($dbname_temp,$sql_update1) or die(mysql_error()."".__LINE__);

echo "DONE......";

