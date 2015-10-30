<?
######  function CheckKeyApprove
$idsub = 2;// รหัสของ subcrontact

// 30/09/2013 แก้ไขให้เข้าได้ตลอดเวลา
$con_hour = "09"; // ชั่วโมงเลิกงาน
$con_minute = "00"; // นาทีเลิกงาน
$con_hour1 = "09";

function CheckKp7List($idcard,$siteid){
	global $dbname_temp;
	$year1 = (date("Y")+543)."-09-30";
	$dbsite = STR_PREFIX_DB.$siteid;
	$sql_general = "SELECT COUNT(idcard) AS num1  FROM general WHERE idcard='$idcard' and   (TIMESTAMPDIFF(MONTH,begindate,'$year1')/12) > 5 GROUP BY idcard";
	$result_general = mysql_db_query($dbsite,$sql_general) or die(mysql_error()."$sql_general<br>LINE::".__LINE__);
	$rsg = mysql_fetch_assoc($result_general);
	
	$sql = "SELECT idcard, siteid, graduate_status as graduate, 	salary_status as salary, absent_status as hr_absent 	FROM  tbl_checklist_kp7
	WHERE idcard='$idcard' AND siteid='$siteid' AND status_check_file='YES' GROUP BY idcard ORDER BY profile_id DESC LIMIT 1";	
	//echo $sql."<br>";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
		if($rs[graduate] == "1"){
			$arr['graduate'] = "id";
		}	
		if($rs[salary] == "1"){
			$arr['salary'] = "id";	
		}
/*	if($rsg[num1] > 0){
		if($rs[hr_absent] == "1"){
			$arr['hr_absent'] = "id";	
		}//end if($rs[hr_absent] == "1"){
	}//end if($rsg[num1] > 0){
*/		
		//echo "<pre>";
		//print_r($arr);
	return $arr;

}//end function CheckKp7List($idcard,$siteid){

function CheckDataKeyFull($idcard,$siteid){
	$dbsite = STR_PREFIX_DB.$siteid;
	$arr_tbl = CheckKp7List($idcard,$siteid);
	//echo "<pre>";
	//print_r($arr_tbl);
	if(count($arr_tbl) > 0){
		foreach($arr_tbl as $key => $val){
			$sql = "SELECT  COUNT($val) AS num1 FROM $key WHERE $val='$idcard' GROUP BY  $val";	
			//echo $sql."<br>";
			$result = mysql_db_query($dbsite,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
			$rs = mysql_fetch_assoc($result);
			//echo "$rs[num1] ::  $key<br>";
			if($rs[num1] < 1 and $key == "graduate"){
				$arr['graduate'] = "ยังไม่ได้คีย์ข้อมูลการศึกษา";
			}else if($rs[num1] < 1 and $key == "salary"){
				$arr['salary'] = "ยังไม่ได้คีย์ข้อมูลเงินเดือน";
			}else if($rs[num1] < 1 and $key == "hr_absent" ){
				$arr['hr_absent'] = "ยังไม่ได้คีย์ข้อมูลวันลา";
			}
		}//end foreach($arr_tbl as $key => $val){
	}//end if(count($arr_tbl) > 0){
	return $arr;
}//end function CheckGraduate($idcard,$siteid){
	
function CheckUnlock_keykp7($idcard,$siteid,$profile_id){
	global $dbnameuse;
	$sql = "SELECT COUNT(idcard) AS num1 FROM tbl_assign_key WHERE idcard='$idcard' AND siteid='$siteid' AND profile_id='$profile_id' and unlock_idcardkey='1' ";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function CheckUnlock_keykp7($idcard,$siteid,$profile_id){
	
###### funciton ตรวจสอบ idcard ที่อยู่ในใบงานแต่ยังไม่เคย login เข้าไปคีย์ข้อมูล

function AssignIdcardNoKey($staffid){
	global $dbnameuse;
	$sql = "SELECT t1.ticketid, t1.staffid, t2.ticketid, t2.idcard, t2.fullname, t2.siteid  FROM tbl_assign_sub AS t1 Inner Join tbl_assign_key as t2 ON t1.ticketid = t2.ticketid Left Join monitor_keyin as t3 ON t2.idcard = t3.idcard AND t2.siteid = t3.siteid AND t1.staffid = t3.staffid WHERE t1.staffid='$staffid' AND t3.idcard IS NULL
	ORDER BY t2.userkey_wait_approve ASC,t1.ticketid DESC,t2.idcard ASC	";	
	//echo $sql."<br>";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs= mysql_fetch_assoc($result)){

			$arr[$rs[idcard]] = $rs[idcard];
	}//end 	while($rs= mysql_fetch_assoc($result)){
		return $arr;
}// end function AssignIdcardNoKey($staffid){
	
function CheckKeyLastApprove($staffid){
	global $dbnameuse,$dbnamemaster;
	$yymm = date("Y-m");
	$xbasedate = strtotime("$yymm");
	$xmonth = strtotime("$yymm -1 month",$xbasedate);
	$month_before = date("Y-m",$xmonth);// เดือนก่อนหน้านี้	
	
	$sql = "SELECT
t1.ticketid,
t2.idcard,
t2.siteid,
t2.fullname,
t2.userkey_wait_approve,t2.profile_id
FROM
tbl_assign_sub AS t1
Inner Join tbl_assign_key as t2 ON t1.ticketid = t2.ticketid
Inner Join monitor_keyin as t3 ON t2.idcard = t3.idcard AND t2.siteid = t3.siteid AND t1.staffid = t3.staffid
WHERE t1.staffid='$staffid' and (t3.timeupdate LIKE '$yymm%' or t3.timeupdate LIKE '$month_before%' )
order by t3.timeupdate desc Limit 1";	
//echo $sql."<br>";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	//echo $rs[userkey_wait_approve] ."<br>";
	if($rs[userkey_wait_approve] == "0"){
			$msg = "ยังไม่ได้รับรองการคีย์ข้อมูล ก.พ.7  ";
	}else if($rs[userkey_wait_approve] == "1"){
			//echo " xxx <pre>";
			if(CheckUnlock_keykp7($rs[idcard],$rs[siteid],$rs[profile_id]) > 0){
				$msg = "";
			}else{
				$arrch = CheckDataKeyFull($rs[idcard],$rs[siteid]);	 // ตรวจสอบการคีย์ข้อมูล
					//print_r($arrch);
				if(count($arrch) > 0){
						foreach($arrch as $key => $val){
								if($msg > "") $msg .= " || ";
								$msg .= " $val ";
						}//end foreach($arrch as $key => $val){
				}else{
						$msg = "";
						
				}//end 	if(count($arrch) > 0){
		}// end if(CheckUnlock_keykp7($idcard,$siteid,$profile_id) > 0){
	} // end if($rs[userkey_wait_approve] == "0"){
		
	if($msg != ""){
		$sql_person = "SELECT t1.prename_th, t1.name_th, t1.surname_th, t1.position_now, t2.secname, t1.schoolname FROM view_general as t1 Inner Join eduarea as t2  ON t1.siteid = t2.secid 
		WHERE t1.CZ_ID='$rs[idcard]'";	
		$result_person = mysql_db_query($dbnamemaster,$sql_person) or die(mysql_error()."$sql_person<br>LINE::".__LINE__);
		$rsp = mysql_fetch_assoc($result_person);
		return "ข้อมูลของ $rsp[prename_th]$rsp[name_th] $rsp[surname_th] เลขบัตรประชาชน $rs[idcard]  ตำแหน่ง $rsp[position_now] สังกัด ".str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rsp[secname])." / ".$rsp[schoolname]." <br>รหัสใบงาน $rs[ticketid] ".$msg;
	}else{
		return "";	
	}
}// end function CheckKeyLastApprove($staffid){
	
	##############  function block การคีย์งาน sub ในเวลางาน ###############
	function CheckBlockKeySub(){
		global $idsub,$con_hour,$con_minute,$con_hour1;
		$hour = date("H");
		$minute = date("i");
		if($_SESSION['session_sapphire'] == "$idsub"){
			if( ($hour == $con_hour and $minute > $con_minute ) or ($hour > $con_hour or $hour < $con_hour1)){
				$result_key = 1;
			}else{
				$result_key = 0;	
			}// end if(($hour == $con_hour and $minute > $con_minute ) or ($hour > $con_hour)){
		}else{
				$result_key = 1;	
		}//end if($_SESSION['session_sapphire'] == "$idsub"){	
		return $result_key;
	}//end function CheckBlockKeySub(){

?>