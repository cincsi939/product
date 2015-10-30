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
	
	function GetNumPointSalary($idcard,$staffid,$type=''){
		global $dbnameuse,$table_id;
		if($type==""){
			$contbl = " AND table_id='$table_id'";	
		}else{
			$contbl = "";	
		}
		$sql = "SELECT
sum(stat_user_keyperson_table.numpoint) as numpoint
FROM `stat_user_keyperson_table`
WHERE idcard='$idcard' and staffid='$staffid' $contbl";	
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."<hr>$sql</hr>".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[numpoint];
	}
	
	
		
		function CheckFillterData($siteid,$idcard,$staffid){
			$db_site = STR_PREFIX_DB.$siteid;
				$sql1 = "SELECT count(t1.id) as num
FROM
salary_log_after AS t1
Left Join salary AS t2 ON t1.runid = t2.runid AND t1.id = t2.id 
where t1.id='$idcard' and t1.staffid='$staffid' and t2.id IS NULL";
			$result1 = mysql_db_query($db_site,$sql1) or die(mysql_error()."".__LINE__);
			$rs1 = mysql_fetch_assoc($result1);	
			return $rs1[num];
		}
	
#$xlimit = " AND t1.secid='0137'  LIMIT  1";
#$xlimit1 = " AND t1.staff_login='10724' AND t1.username='3540400077876' ";
	if($action == "process"){
		
		
		
		$sql = "SELECT
t1.secid AS siteid,
if(t3.site_area > 0,1,0) AS ordersite
FROM
$dbnamemaster.eduarea AS t1
Inner Join $dbnameuse.site_process_casedata AS t2 ON t1.secid = t2.siteid
Left Join $dbnameuse.keystaff AS t3 ON t2.siteid = t3.site_area
WHERE
t2.status_process =  '0'
group by t1.secid
order by ordersite asc $xlimit ";
		$reuslt=  mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."<hr>$sql</hr>".__LINE__);
		while($rs = mysql_fetch_assoc($reuslt)){
					$db_site = STR_PREFIX_DB.$rs[siteid];
			mysql_db_query($dbnameuse,"DELETE FROM log_case_per_day WHERE siteid='$rs[siteid]'");
			mysql_db_query($dbnameuse,"DELETE FROM log_case_per_day_detail_before WHERE siteid='$rs[siteid]'");
			mysql_db_query($dbnameuse,"DELETE FROM log_case_per_day_detail_after WHERE siteid='$rs[siteid]'");
			
		
				$sql1 = "SELECT
count(t1.username) as num_delete,
t1.username as idcard,
t1.staff_login as staffid,
min(t1.updatetime) as key_start,
max(t1.updatetime) as key_end
FROM
$db_site.log_update AS t1
Inner Join $db_site.general AS t2 ON t1.username = t2.idcard
Inner Join ".DB_USERENTRY.".keystaff AS t3 ON t1.staff_login = t3.staffid
WHERE
t1.action =  'delete' AND
t1.subject =  'ข้อมูลเงินเดือน'  and date(t1.updatetime) >= '2012-02-02' $xlimit1
GROUP BY
t1.username,
t1.staff_login,
date(t1.updatetime)
HAVING
num_delete >  $num_del";
			$result1 = mysql_db_query($db_site,$sql1) or die(mysql_error()."<hr>$sql1</hr>".__LINE__);
			while($rs1 = mysql_fetch_assoc($result1)){
				$num_pointsalary = GetNumPointSalary($rs1[idcard],$rs1[staffid]);
				$num_pointall = GetNumPointSalary($rs1[idcard],$rs1[staffid],"all");
				
				$numdiff = CheckFillterData($rs[siteid],$rs1[idcard],$rs1[staffid]);
				
								
				#echo "$numpls => $percenpls >= $percen_config  |||  $numdate => $percendate >= $percen_config";
				
				if($numdiff > 0 and $num_pointall > 0){
					
					
				
				$sql_insert = "INSERT INTO log_case_per_day SET staffid='$rs1[staffid]',idcard='$rs1[idcard]',siteid='$rs[siteid]',num_delete='$rs1[num_delete]',key_start='$rs1[key_start]',key_end='$rs1[key_end]',num_point='$num_pointall',num_pointsalary='$num_pointsalary',timeupdate=NOW()";
				#echo $sql_insert."<hr>";
				mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."<hr>$sql_insert</hr>".__LINE__);
				
				}//end 	if($numdiff > 0){
					
			}//end while($rs1 = mysql_fetch_assoc($result1)){
				
				
			$sql_upsite = "UPDATE site_process_casedata  SET status_process='1' WHERE siteid='$rs[siteid]'";
			mysql_db_query($dbnameuse,$sql_upsite) or die(mysql_error()."$sql_upsite<br>".__LINE__);
			
		}// endwhile($rs = mysql_fetch_assoc($reuslt)){ 
			
	}// end 	if($action == "process"){
	
echo "Done....";
 ?>