<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("../../common/common_competency.inc.php");

if($_GET['action'] == "process"){
	$sql = "SELECT
t2.idcard,t2.profile_id,t2.siteid,t2.prename_th,t2.name_th,t2.surname_th
FROM
tbl_checklist_kp7  as t2
where t2.status_file='1'  and (t2.status_check_file='NO' or t2.status_check_file IS NULL)";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$sql_update = "UPDATE tbl_checklist_kp7 SET status_check_file='YES' WHERE idcard='$rs[idcard]' AND siteid='$rs[siteid]' AND profile_id='$rs[profile_id]' ";
			//echo $sql_update."<hr>";
			mysql_db_query($dbname_temp,$sql_update) or die(mysql_error()."$sql_update<br>__LINE__".__LINE__);
	}//end while($rs = mysql_fetch_assoc($result)){
		echo "<h1>Done...</h1>";
}//end if($_GET['action'] == "process"){
?>
