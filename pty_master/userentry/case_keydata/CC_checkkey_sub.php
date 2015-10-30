<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "CrontabCalScore";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Suwat
#DateCreate::29/07/2011
#LastUpdate::29/07/2011
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();
//die;

	require_once("../../../config/conndb_nonsession.inc.php");
	$num_del = 5; // จำนวนที่มีการลบที่จะทำการตรวจสอบ
	$table_id = 17;// รหัสตาราง salary
	$percen_config = 50;
	
			$datec = date("Y-m-d");
					
				 $xbasedate = strtotime("$datec");
				 $xdate = strtotime("-1 day",$xbasedate);
				 $before_date = date("Y-m-d",$xdate); // วันก่อนหน้า
				 
				#echo $before_date;die;
				
				
mysql_db_query($dbnameuse,"DELETE FROM log_case_delete_sub");
	
	
$sql = "SELECT
t1.idcard,
t1.profile_id,
t1.fullname,
t1.siteid,
t3.prename,
t3.staffname,
t3.staffsurname
FROM
tbl_assign_key AS t1
Inner Join tbl_assign_sub AS t2 ON t1.ticketid = t2.ticketid
Inner Join keystaff AS t3 ON t2.staffid = t3.staffid
WHERE
t3.sapphireoffice =  '2'";
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
while($rs = mysql_fetch_assoc($result)){
		$sqlc = "SELECT
tbl_assign_log.ticketid,
tbl_assign_log.idcard,
tbl_assign_log.profile_id,
tbl_assign_log.siteid,
tbl_assign_log.action,
tbl_assign_log.subject,
tbl_assign_log.staffid,
tbl_assign_log.fullname
FROM `tbl_assign_log` where idcard ='$rs[idcard]' and action='delete'";
		$resutlc = mysql_db_query($dbnameuse,$sqlc) or die(mysql_error()."".__LINE__);
		$rsc = mysql_fetch_assoc($resutlc);
		
		if($rsc[idcard] != ""){
		$sqlint = "insert into log_case_delete_sub set ticketid='$rsc[ticketid]',staffid='$rsc[staffid]',idcard='$rsc[idcard]',siteid='$rsc[siteid]',action='$rsc[action]'";
		mysql_db_query($dbnameuse,$sqlint) or die(mysql_error()."".__LINE__);
		}//end 

}//end while($rs = mysql_fetch_assoc($result)){
			

	
echo "Done....";
 ?>