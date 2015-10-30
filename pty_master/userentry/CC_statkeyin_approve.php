<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "CrontabCalStatkeyinApprove";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Suwat
#DateCreate::17/11/2010
#LastUpdate::17/11/2010
#DatabaseTable::log_stat_keyinapprove, log_stat_keyinapprove_detail
#END
#########################################################
//session_start();
//die;
			set_time_limit(0);
			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			$dbnameuse = $db_name;
			$time_start = getmicrotime();
			$datekey = date("Y-m-d");
			
				$xbasedate = strtotime("$datekey");
				 $xdate = strtotime("-1 day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป		
				 //$xsdate = "2010-11-15";
			######### start script

		$sql = "SELECT
distinct tbl_assign_key.idcard,
tbl_assign_key.siteid,
tbl_assign_key.approve,
tbl_assign_key.profile_id,
date(tbl_assign_key.update_time) AS datek,
monitor_keyin.staffid,
monitor_keyin.timeupdate_user
FROM
tbl_assign_key
Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
where status_keydata='1' and  date(update_time) = '$xsdate' and tbl_assign_key.profile_id >= 4";
$result = mysql_db_query($dbnameuse,$sql);
while($rs = mysql_fetch_assoc($result)){
	
	if($rs[approve] == "2"){
			$status_approve = 1;
	}else{
			$status_approve = 0;	
	}// end if($rs[approve] == "2"){
	
	$sql1 = "SELECT *  FROM log_stat_keyinapprove_detail WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]' ";
	$result1 = mysql_db_query($dbnameuse,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	if($rs1[idcard] != ""){
			if($rs1[status_approve] == "0"){
				$sql_up = "UPDATE log_stat_keyinapprove_detail SET datekeyin='$rs[datek]', status_approve='$status_approve'  WHERE idcard='$rs[idcard]' AND profile_id='$rs[profile_id]' and datekeyin='$rs1[datekeyin]' and siteid='$rs1[siteid]'";
				mysql_db_query($dbnameuse,$sql_up);
			}//end if($rs1[status_approve] == "0"){
	}else{
			$sql_up = "INSERT INTO  log_stat_keyinapprove_detail SET datekeyin='$rs[datek]', siteid='$rs[siteid]', idcard='$rs[idcard]',staffid='$rs[staffid]',status_approve='$status_approve',timeupdate=NOW(),profile_id='$rs[profile_id]'";
			mysql_db_query($dbnameuse,$sql_up);
	}//end if($rs1[idcard] != ""){
		//echo $sql_up."<br>";
}// end while($rs = mysql_db_query($result)){
//echo $sql;

############  เริ่มเก็บจำนวนการนับรายการ
$sql_sts = "SELECT 
SUM(if(status_approve=1,1,0)) AS numkey_approve,
SUM(if(status_approve=0,1,0)) as numkey,
datekeyin,profile_id
FROM log_stat_keyinapprove_detail WHERE datekeyin = '$xsdate'
GROUP BY datekeyin";
$result_sts = mysql_db_query($dbnameuse,$sql_sts);
while($rss = mysql_fetch_assoc($result_sts)){
	$sql_replace = "REPLACE INTO log_stat_keyinapprove SET datekeyin='$rss[datekeyin]',numkey='$rss[numkey]',numkey_approve='$rss[numkey_approve]',timeupdate=NOW(),profile_id='$rss[profile_id]'";
	mysql_db_query($dbnameuse,$sql_replace);
		
}//end while($rss = mysql_fetch_assoc($result_sts)){

			
#########  end script
$time_end = getmicrotime();
echo "<br>เวลาในการประมวลผล :".($time_end - $time_start);echo " Sec.";
 writetime2db($time_start,$time_end);

 ?>