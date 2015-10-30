<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");

$parth = "../../../".PATH_KP7_FILE."/";


$sql_site = "SELECT
keystaff.site_area as site
FROM `keystaff`
where site_area > 0
group by site_area";
$result_site = mysql_db_query($dbnameuse,$sql_site);
while($rss = mysql_fetch_assoc($result_site)){
		$arr_site[$rss[site]] = $rss[site];
}

$sql = "SELECT
t1.idcard,
t1.siteid,
t1.profile_id,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t1.begindate,
t1.sex,
t1.position_now,
t1.schoolid,
t1.status_replace,
t1.flag_kp7file,
t1.status_48area,
t1.flag_import
FROM
tbl_checklist_kp7_all_checklist_notin_cmss_checkimp AS t1
WHERE
(t1.status_replace='YES' and t1.status_48area='0' )  or  t1.status_48area='1' ";
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){

		$sql_log = "replace into tbl_checklist_kp7_1_delete  select * FROM tbl_checklist_kp7 where idcard='$rs[idcard]' and profile_id='".$rs[profile_id]."' and siteid='$rs[siteid]'";
		#echo $sql_log."<hr>";
		mysql_db_query($dbname_temp,$sql_log)or die(mysql_error()."$sql_log<br>LINE__".__LINE__);
		
		$sql_del = "DELETE FROM  tbl_checklist_kp7 WHERE idcard='$rs[idcard]' and profile_id='".$rs[profile_id]."' and siteid='$rs[siteid]'  ";
		#echo $sql_del."<hr>";
		mysql_db_query($dbname_temp,$sql_del) or die(mysql_error()."$sql_del<br>LINE__".__LINE__);
	
		
		
		
}



echo "Done....";

?>
