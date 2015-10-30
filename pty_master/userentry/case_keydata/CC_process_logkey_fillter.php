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
	
	
	function FillterDataCaseKeyPls($idcard,$siteid,$staffid){
		$db_site = STR_PREFIX_DB.$siteid;
		$sql = "SELECT count(id) as num,noorder FROM `salary_log_after` where id='$idcard' and staffid='$staffid' group by noorder order by num desc LIMIT 1";
		$result = mysql_db_query($db_site,$sql) or die(mysql_error()."".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[num];
	}// end 	function FillterDataCaseKeyPls($idcard,$siteid,$staffid){
	
	
		function FillterDataCaseKeyDate($idcard,$siteid,$staffid){
		$db_site = STR_PREFIX_DB.$siteid;
		$sql = "SELECT count(id) as num,year(date) FROM `salary_log_after` where id='$idcard' and staffid='$staffid' group by year(date) order by num desc LIMIT 1";
		$result = mysql_db_query($db_site,$sql) or die(mysql_error()."".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[num];
	}// end 	function FillterDataCaseKeyDate($idcard,$siteid,$staffid){
	
#$xlimit = " AND t1.secid='0137'  LIMIT  1";
#$xlimit1 = " AND t1.staff_login='10724' AND t1.username='3540400077876' ";
	if($action == "process"){
		
		$sql = "SELECT
log_case.runid,
log_case.staffid,
log_case.idcard,
log_case.siteid,
log_case.num_delete
FROM `log_case` 
where process_data='0'
order by 
log_case.siteid asc
";	
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				$db_site = STR_PREFIX_DB.$rs[siteid];
				$sql1 = "SELECT count(t1.id) as num
FROM
salary_log_after AS t1
Left Join salary AS t2 ON t1.runid = t2.runid AND t1.id = t2.id 
where t1.id='$rs[idcard]' and t1.staffid='$rs[staffid]' and t2.id IS NULL";
			$result1 = mysql_db_query($db_site,$sql1) or die(mysql_error()."".__LINE__);
			$rs1 = mysql_fetch_assoc($result1);
			if($rs1[num] > 0){
					$flag_data = "1";
			}else{
					$flag_data = "0";	
			}
			$sql_up = "UPDATE log_case SET flag_data='$flag_data',process_data='1'  WHERE runid='$rs[runid]'";
			mysql_db_query($dbnameuse,$sql_up) or die(mysql_error()."".__LINE__);
				
		}//end while($rs = mysql_fetch_assoc($result)){
	}// end 	if($action == "process"){
	
echo "Done....";
 ?>