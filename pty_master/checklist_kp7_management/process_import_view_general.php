<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");


$sql = "SELECT
t1.CZ_ID,
t1.siteid
FROM
view_general AS t1
left Join view_general_report AS t2 ON t1.CZ_ID = t2.CZ_ID AND t1.siteid = t2.siteid
where 
 t1.level_id <> '' and t1.position_now <> '' and t1.education <> '' and t1.salary <> '' and t1.schoolid <> '' and t1.sex <> '' and t1.sex <> '0' and t2.CZ_ID IS NULL and t1.user_approve <> '0'";
 $result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
 while($rs = mysql_fetch_assoc($result)){
	 $sql_insert = "REPLACE INTO view_general_report
	 SELECT * FROM view_general WHERE CZ_ID='$rs[CZ_ID]'";
	 mysql_db_query($dbnamemaster,$sql_insert) or die(mysql_error()."".__LINE__);
	 
	 $sql_log = "insert into log_import_view_general_report set idcard='$rs[CZ_ID]',siteid='$rs[siteid]'";
	 mysql_db_query($dbname_temp,$sql_log) or die(mysql_error()."$sql_log<br>LINE__".__LINE__);
			 
}

echo "Done...";
?>

