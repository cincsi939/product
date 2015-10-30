<?
session_start();
set_time_limit(0);
include ("../../../../config/conndb_nonsession.inc.php")  ;
include('function_checkdata.inc.php') ;

//$limit1 = " LIMIT 1000";

	function Check_kp7_key($idcard,$profile_id){
		global $dbname_temp;
		$sql = "SELECT count(idcard) as num1 FROM `tbl_checklist_kp7` where idcard='$idcard' and profile_id='$profile_id' and (comment_absent LIKE '%ไม่พบข้อมูลวันลา%'  or comment_salary LIKE '%ไม่พบข้อมูลเงินเดือน%' )";
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
	}// end function Check_kp7_key($idcard,$profile_id){
	
	function CheckKeyUpdate($idcard,$siteid,$staffid){
	global $dbnameuse;
	$dbsite = STR_PREFIX_DB.$siteid;
	$sql = "SELECT staff_login,max(updatetime) as maxtime FROM log_update WHERE username='$idcard' AND staff_login='$staffid'  ";
	$result = mysql_db_query($dbsite,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);

	$sql1 = "SELECT staff_login,max(updatetime) as maxtime1 FROM log_update WHERE username='$idcard' AND staff_login NOT LIKE 'cmss%' AND staff_login NOT LIKE '%$staffid%' AND staff_login <> '' AND action <>'login' and action <> ''  and updatetime > '$rs[maxtime]' ";
	$result1 = mysql_db_query($dbsite,$sql1) or die(mysql_error()."$sql1<br>LINE::".__LINE__);
	$rs1 = mysql_fetch_assoc($result1);
	
	

	$arr['staff_key'] = $rs[staff_login];
	$arr['time_key'] = $rs[maxtime];
	$arr['staff_edit'] = $rs1[staff_login];
	$arr['time_edit'] = $rs1[maxtime1];
	return $arr;
}//end function CheckKeyUpdate(){

	$sql = "SELECT distinct t1.idcard,t1.siteid,t2.staffid,t1.profile_id FROM tbl_assign_key as t1 Inner Join tbl_assign_sub as t2 ON t1.ticketid=t2.ticketid Inner Join  ".DB_MASTER.".view_general as t3 ON t1.idcard=t3.CZ_ID and t1.siteid=t3.siteid  WHERE t1.approve='2' and t1.profile_id >= '1'  ORDER BY t1.profile_id  DESC $limit1";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		
				$dbsite = STR_PREFIX_DB.$rs[siteid];
				$date_profile =  DateProfile($rs[idcard],$rs[siteid],$rs[profile_id]);// วันที่จัดทำข้อมูล
				$arrdata = ProcessQCData($rs[siteid],$rs[idcard],$rs[profile_id]);
				if(count($arrdata) < 1){
					$case_id = "0";	
					$arrnum[$rs[siteid]]['C'] = $arrnum[$rs[siteid]]['C']+1;
				}else{
					$arr = CheckKeyUpdate($rs[idcard],$rs[siteid],$rs[staffid]);
					if($arr['staff_edit'] != ""){
						$arrnum[$rs[siteid]]['N'] = $arrnum[$rs[siteid]]['N']+1;
						$case_id = "2";	
					}else{
						if(Check_kp7_key($rs[idcard],$rs[profile_id]) > 0){
							$case_id = "1";
							$arrnum[$rs[siteid]]['Y1'] = $arrnum[$rs[siteid]]['Y1']+1;
						}else{
							$case_id = "3";
							$arrnum[$rs[siteid]]['Y2'] = $arrnum[$rs[siteid]]['Y2']+1;
						}// end if(Check_kp7_key($rs[idcard],$rs[profile_id]) > 0){
					}// end if($arr['staff_edit'] != ""){
						
				}// end if(count($arrdata) < 1){
				$arrnum[$rs[siteid]]['all'] = $arrnum[$rs[siteid]]['all']+1;	
		
		$sql_insert1 = "REPLACE INTO temp_approve_kp7_detail SET idcard='$rs[idcard]',siteid='$rs[siteid]',timekey='".$arr['time_key']."',staffkey='".$arr['staff_key']."',timeedit='".$arr['time_edit']."',staffedit='".$arr['staff_edit']."',case_id='$case_id' ";
		mysql_db_query($dbnameuse,$sql_insert1) or die(mysql_error()."$sql_insert1<br>LINE::".__LINE__) ;
		
		
		
		$arrdata = "";
	}// end while($rs = mysql_fetch_assoc($result)){
		
		

		
##########  เก็บข้อมูล
if(count($arrnum) > 0){
		foreach($arrnum as $key => $val){
			$numN = $val['N'];
			$numY1 = $val['Y1'];
			$numY2 = $val['Y2'];
			$numAll = $val['all'];
			$numC = $val['C'];
			$sql_insert = "REPLACE INTO temp_approve_kp7 SET siteid='$key',approve_all='$numAll',approve_complete='$numC',approve_case1='$numY1',approve_case2='$numN',approve_case3='$numY2' ";
			mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE::".__LINE__);
				
		}
}// end if(count($arrnum) > 0){


echo "ok";

?>
