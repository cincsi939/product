<?
include ("../../config/conndb_nonsession.inc.php")  ;

//$limit1 = " LIMIT 1000";
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
		$arr = CheckKeyUpdate($rs[idcard],$rs[siteid],$rs[staffid]);
		if($arr['staff_edit'] != ""){
			$arrnum[$rs[siteid]]['N'] = $arrnum[$rs[siteid]]['N']+1;
		}else{
			$arrnum[$rs[siteid]]['Y'] = $arrnum[$rs[siteid]]['Y']+1;	
		}
		$arrnum[$rs[siteid]]['all'] = $arrnum[$rs[siteid]]['all']+1;	
		
		$sql_insert1 = "REPLACE INTO temp_approve_kp7_detail SET idcard='$rs[idcard]',siteid='$rs[siteid]',timekey='".$arr['time_key']."',staffkey='".$arr['staff_key']."',timeedit='".$arr['time_edit']."',staffedit='".$arr['staff_edit']."' ";
		mysql_db_query($dbnameuse,$sql_insert1) or die(mysql_error()."$sql_insert1<br>LINE::".__LINE__) ;
		
	}// end while($rs = mysql_fetch_assoc($result)){
		
		

		
##########  เก็บข้อมูล
if(count($arrnum) > 0){
		foreach($arrnum as $key => $val){
			$numN = $val['N'];
			$numY = $val['Y'];
			$numAll = $val['all'];
			$sql_insert = "REPLACE INTO temp_approve_kp7 SET siteid='$key',approve_all='$numAll',approve_pass='$numY',approve_edit='$numN'";
			mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE::".__LINE__);
				
		}
}// end if(count($arrnum) > 0){


echo "OK";



?>