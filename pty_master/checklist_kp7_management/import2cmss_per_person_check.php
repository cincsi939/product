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
t2.profile_id,
t1.siteid,
t1.prename_th,
t1.name_th,
t1.surname_th,
t1.birthday,
t2.begindate,
t2.position_now,
t2.schoolid,
t2.sex
FROM
tbl_checklist_kp7_all_checklist_notin_cmss AS t1
Inner Join tbl_checklist_kp7 AS t2 ON t1.idcard = t2.idcard AND t1.siteid = t2.siteid
Inner Join view_checklist_lastprofile as t3 ON t2.profile_id = t3.last_profile AND t2.siteid = t3.siteid
where t2.status_numfile='1' and t2.status_file='1' and t2.status_check_file='YES' and t2.status_id_false='0' and status_retire='0'

";
$result = mysql_db_query($dbname_temp,$sql);
while($rs = mysql_fetch_assoc($result)){
		
		$sql1 = "SELECT
count(t1.CZ_ID) as num1
FROM
edubkk_master.view_general AS t1
Inner Join callcenter_entry.keystaff AS t2 ON t1.siteid = t2.site_area
where 
t1.CZ_ID='$rs[idcard]'
group by t1.CZ_ID";
		$result1 = mysql_db_query($dbnamemaster,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
		$rs1 = mysql_fetch_assoc($result1);
		
		if($rs1[num1] > 0){
				$status_replace = "YES";
		}else{
				$status_replace= "NO";	
		}
		
		
		$kp7file = $parth."$rs[siteid]"."/".$rs[idcard].".pdf";
		if(is_file($kp7file)){
				$flag_kp7file = 1;
		}else{
				$flag_kp7file = 0;	
		}//end if(is_file($kp7file)){
			
		if (array_key_exists($rs[siteid], $arr_site)) {
			$status_48area = 1;
		}else{
			$status_48area = 0;	
		}
			
		
		
		$sql_replace = "REPLACE INTO tbl_checklist_kp7_all_checklist_notin_cmss_checkimp SET  profile_id='$rs[profile_id]',idcard='$rs[idcard]',siteid='$rs[siteid]',prename_th='$rs[prename_th]',name_th='$rs[name_th]',surname_th='$rs[surname_th]',birthday='$rs[birthday]',begindate='$rs[begindate]',sex='$rs[sex]',position_now='$rs[position_now]',schoolid='$rs[schoolid]',status_replace='$status_replace',flag_kp7file='$flag_kp7file',status_48area='$status_48area'";
		
		mysql_db_query($dbname_temp,$sql_replace) or die(mysql_error()."".__LINE__);
		
		
		
		
}



echo "Done....";

?>
