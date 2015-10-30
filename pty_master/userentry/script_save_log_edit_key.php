<?
//include ("../../config/conndb_nonsession.inc.php")  ;
//$limit = " LIMIT 100";
include("epm.inc.php");
$sql = "SELECT
tbl_assign_edit_key.ticketid,
tbl_assign_edit_key.idcard,
tbl_assign_edit_key.siteid,
tbl_assign_edit_key.userkey_wait_approve,
date(tbl_assign_edit_key.update_time) AS date1,
tbl_assign_edit_sub.staffid,
tbl_assign_edit_key.update_time,
date(tbl_assign_edit_key.time_approvekey) as datekey
FROM
tbl_assign_edit_key
Inner Join tbl_assign_edit_sub ON tbl_assign_edit_key.ticketid = tbl_assign_edit_sub.ticketid
where 
userkey_wait_approve='1'  $limit";
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
while($rs = mysql_fetch_assoc($result)){
	$sql_insert1 = "REPLACE INTO temp_log_key_edit SET idcard='$rs[idcard]',siteid='$rs[siteid]',staffid='$rs[staffid]' ";
	mysql_db_query($dbnameuse,$sql_insert1) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	
	$dbsite = STR_PREFIX_DB.$rs[siteid];
	if($rs[datekey] != ""){
			$datekey = $rs[datekey];
	}else{
			$datekey = $rs[date1];
	}
	
	$sql_max = "SELECT max(updatetime) as maxt,min(updatetime) as mint FROM `log_update` WHERE `username` LIKE '$rs[idcard]' AND `staff_login` LIKE '$rs[staffid]' and updatetime LIKE '".date('Y-m')."%'  ";
	$result_max = mysql_db_query($dbsite,$sql_max) or die(mysql_error()."$sql_max<br>>LINE::".__LINE__);
	$rsm = mysql_fetch_assoc($result_max);
	if($rsm[mint] != "0000-00-00 00:00:00" and  $rsm[mint]  != ""   and $rsm[maxt] != "0000-00-00 00:00:00" and $rsm[maxt] != ""){
		//echo "$rs[idcard] :: <br>";
		$arrt1 =  GetDiffTime($rsm[mint],$rsm[maxt]);
		
	}//end 	if($rsm[mint] != "0000-00-00 00:00:00"  and $rsm[maxt] != "0000-00-00 00:00:00"){
	$sql_update = "UPDATE tbl_assign_edit_key SET time_start_key='$rsm[mint]',time_end_key='$rsm[maxt]',time_edit='".$arrt1['all']."',time_approvekey='$rsm[maxt]' WHERE ticketid='$rs[ticketid]' and idcard='$rs[idcard]'";
	mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."$sql_update<br>LINE::".__LINE__);	
	$xidcard = $rs[idcard];
	$xstaffid = $rs[staffid];
	
	$sql_log = "SELECT
menu_id,
COUNT(username) as num1
FROM `log_update`
WHERE `username` LIKE '$rs[idcard]'
AND updatetime like '$datekey%' AND staff_login='$rs[staffid]' and updatetime LIKE '".date('Y-m')."%'
group by menu_id";


//echo $sql_log."<br>$dbsite<br>";
	$result_log = mysql_db_query($dbsite,$sql_log) or die(mysql_error()."$sql_log<br>LINE::".__LINE__);
	while($rsl = mysql_fetch_assoc($result_log)){
		//echo "$rsl[num1]<br>";
		$sql_max1 = "SELECT max(updatetime) as maxt,min(updatetime) as mint FROM `log_update` WHERE `username` LIKE '$xidcard' AND `staff_login` LIKE '$xstaffid' and menu_id='$rsl[menu_id]'  and updatetime LIKE '".date('Y-m')."%'  ";
				//echo $sql_max1;die;	
		$result_max1 = mysql_db_query($dbsite,$sql_max1) or die(mysql_error()."$sql_max1<br>LINE::".__LINE__);
		$rsm1 = mysql_fetch_assoc($result_max1);
		if($rsm1[mint] != "0000-00-00 00:00:00" and  $rsm1[mint]  != ""   and $rsm1[maxt] != "0000-00-00 00:00:00" and $rsm1[maxt] != ""){
			
			$arrt =  GetDiffTime($rsm1[mint],$rsm1[maxt]);
		}
	
		$sql_insert2 = "REPLACE INTO temp_log_key_edit_detail SET menu_id='$rsl[menu_id]',idcard='$rs[idcard]',siteid='$rs[siteid]',keypoint='$rsl[num1]',start_time='$rsm1[mint]',edit_time='$rsm1[maxt]',timeedit='".$arrt['all']."' ";
		//echo $sql_insert2."<br>";
		mysql_db_query($dbnameuse,$sql_insert2) or die(mysql_error()."$sql_insert2<br>LINE::".__LINE__);
	}// end while($rsl = mysql_fetch_assoc($result_log)){
		
}//end while($rs = mysql_fetch_assoc($result)){

echo "OK";		

		


?>