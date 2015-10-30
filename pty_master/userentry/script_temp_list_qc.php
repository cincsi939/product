<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		รายงานการบันทึกข้อมูล
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
include "epm.inc.php";
	
$sql = "SELECT
distinct validate_checkdata.idcard,
validate_checkdata.staffid_check,
validate_checkdata.date_check,
validate_checkdata.datetime_check,
validate_checkdata.timeupdate
FROM `validate_checkdata`
WHERE datetime_check > '' and staffid_check > 0 and datetime_check Like  '2011-05-19%'
order by staffid_check asc ,datetime_check asc";
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
while($rs = mysql_fetch_assoc($result)){
	$sql1 = "SELECT * FROM validate_checkdata WHERE  datetime_check > '' and staffid_check='$rs[staffid_check]' and datetime_check Like  '2011-05-19%' AND datetime_check < '$rs[datetime_check]' ORDER BY  datetime_check DESC LIMIT 1 ";
	$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE::".__LINE__);
	$rs1 = mysql_fetch_assoc($result1);
	if($rs1[datetime_check] != ""){
		$arr_t = GetDiffTime($rs1[datetime_check],$rs[datetime_check]);
			$secs = $arr_t['all'];
			//echo "$rs[idcard] :: $rs1[datetime_check] :: $rs[datetime_check]<pre>";
			//print_r($arr_t);
			$sql_in = "REPLACE INTO temp_avg_listqc SET staffid='$rs[staffid_check]',idcard='$rs[idcard]',t_start='$rs1[datetime_check]',t_end='$rs[datetime_check]',num_time='$secs'";
			//echo $sql_in."<br>";
			mysql_db_query($dbnameuse,$sql_in) or die(mysql_error()."$sql<br>$sql_in".__LINE__);
			$secs = 0;
			unset($arr_t);
	}//end if($rs1[datetime_check] != ""){
		
}// end while($rs = mysql_fetch_assoc($result)){


?>
