<?
/*****************************************************************************
Function		: มอบหมายการคีย์ข้อมูล ก.พ.7 ให้กับผู้ใช้
Version			: 1.0
Last Modified	: 22/05/2552
Changes		:
*****************************************************************************/
include "epm.inc.php";
include("function_assign_group.php");
$sql = "SELECT
tbl_checklist_profile.profile_id
FROM `tbl_checklist_profile`
WHERE tbl_checklist_profile.status_active='1'
ORDER BY tbl_checklist_profile.profile_id DESC 
LIMIT 0,1";
$result = mysql_db_query($dbname_temp,$sql);
$rs = mysql_fetch_assoc($result);
$profile_id=$rs[profile_id];
#### checklist
$sql1 = "SELECT
tbl_checklist_kp7.siteid
FROM
tbl_checklist_kp7
where profile_id='$profile_id'
GROUP BY siteid";
$result1 = mysql_db_query($dbname_temp,$sql1);
while($rs1 = mysql_fetch_assoc($result1)){	
	SaveTempAssign($profile_id,$rs1[siteid]);
	ProcessGroupAge($rs1[siteid],$profile_id);
}//end while($rs1 = mysql_fetch_assoc($result1)){

#### ทำการล้างข้อมูล
$sql_clean = "update tbl_constan_assign_detail set flag_mark='0'";
mysql_db_query($dbnameuse,$sql_clean);

?>