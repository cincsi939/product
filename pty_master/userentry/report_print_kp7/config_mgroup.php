<?
require_once("../../../config/conndb_nonsession.inc.php");

$d_week = 6; // จำนวนวันต่อสัปดาห์
$d_numkey = 30; // จำนวนชุดที่คีย์ได้ต่อวัน

$limit_defilt = " LIMIT 50";

### icon แสดงสถานะการปิดเปิดการใช้งาน
$arrimg = array("0"=>" <img src=\"../../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border='0' title='ปิดการใช้งาน'>","1"=>"<img src=\"../../../images_sys/approve20.png\" width=\"16\" height=\"16\" border='0' title='เปิดการใช้งาน'>");

$arrimg_app = array("0"=>" <img src=\"../../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border='0' title='ค้างดำเนินการ'>","1"=>"<img src=\"../../../images_sys/approve20.png\" width=\"16\" height=\"16\" border='0' title='ดำเนินการแล้วเสร็จ'>");

##### วัน จ. ถึง อ.
$arrday = array("0"=>"อาทิตย์","1"=>"จันทร์","2"=>"อังคาร","3"=>"พุธ","4"=>"พฤหัสบดี","5"=>"ศุกร์","6"=>"เสาร์");

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$arrsex = array("M"=>"ชาย","F"=>"หญิง");

	function ShowThaiDate($temp){
				global $monthname;
				$x = explode("-",$temp);
				$m1 = $monthname[intval($x[1])];
				$y1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $y1 ";
				return $xrs;
	}



function GetThaiDateS($d){
global $shortmonth;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $shortmonth[intval($d1[1])] . " " . (intval($d1[0]) + 543);
}// end function GetThaiDateS($d){
	
function GetTimeS($t){
		if(!$t) return "";
		if($t == "00:00:00") return "";
		return $t." น.";
}//end 

### แสดงวันที่ในฟอร์ม
function GetDateFrom($temp_date){
	if($temp_date != "0000-00-00" and $temp_date != ""){
		$arr = explode("-",$temp_date);
		$result = $arr[2]."/".$arr[1]."/".($arr[0]+543);
	}else{
		$result = "";
	}
return $result;
}// end function GetDateFrom($temp_date){
	
function GetDateDB($temp_date){
	if($temp_date != "00/00/0000" and $temp_date != ""){
		$arr = explode("/",$temp_date);
		$result = ($arr[2]-543)."/".$arr[1]."/".($arr[0]);
	}else{
		$result = "";
	}
return $result;
}// end function GetDateFrom($temp_date){
	
	
function GetStaffProfile($staffqc){
	global $dbnameuse;
		$sql_edit = "SELECT * FROM keystaff_qc_math_key WHERE staffqc='$staffqc'";
		$result_edit = mysql_db_query($dbnameuse,$sql_edit) or die(mysql_error()."$sql_edit<br>LINE::".__LINE__);
		while($rse = mysql_fetch_assoc($result_edit)){
			$arrstaff[$rse[staffkey]] = $rse[staffkey];	
		}
	return $arrstaff;
}//end function GetStaffProfile($profile_edit_id){
	
##### แสดงจำนวนรายการที่มอบหมายไปแล้วของพนักงานคนนั้น
function CountStaffAssign($staffid){
	global $dbnameuse;
	$sql = "SELECT
count(t2.idcard) as num1
FROM
tbl_assign_edit_sub as t1
Inner Join tbl_assign_edit_key as t2  ON t1.ticketid = t2.ticketid
where t1.staffid='$staffid' and t2.approve <> '2'
GROUP BY t1.staffid";	
//echo $sql;die;
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}// end function CountStaffAssign($staffid){
	
function CountTicketDetail($ticketid,$xtype=""){
	global $dbnameuse;
	if($xtype == ""){
			$conv = " AND userkey_wait_approve='1'";
	}else{
			$conv = " AND userkey_wait_approve <>'1'";	
	}
	$sql = "SELECT count(idcard) as num1 FROM tbl_assign_edit_key WHERE ticketid='$ticketid'  $conv ";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}

#### ตรวจสอบใบงานที่คีย์ไปแล้ว
function CheckEditKey($ticketid){
	global $dbnameuse;
	$sql = "SELECT * FROM tbl_assign_edit_key WHERE ticketid='$ticketid'";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		if($rs[userkey_wait_approve] == "1" or $rs[approve] == "2"){
				$flag_key = 1;
		}else{
				$flag_key = 0;	
		}
		$arr[$rs[idcard]] = $flag_key;
	}// end while($rs = mysql_fetch_assoc($result)){
	
	return $arr;
}// end function CheckEditKey($ticketid){

##########  fucntion ตรวจสอบใบงานก่อนทำการลบ
function CountTicketKey($ticketid){
	global $dbnameuse;
	$sql = "SELECT COUNT(idcard) AS num1 FROM tbl_assign_edit_key WHERE ticketid='$ticketid'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
		
}// end function CountTicketKey(){
	
function CountTicketStaff($staffid){
	global $dbnameuse;
	$sql = "SELECT COUNT(ticketid) AS num1 FROM tbl_assign_edit_sub WHERE staffid='$staffid'  GROUP BY staffid";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}

### แสดงจำนวนกลุ่มรายการ
function CountGroupEdit($period_master_id){
	global $dbnameuse;
	$sql = "SELECT COUNT(period_master_id) AS num1  FROM tbl_assign_edit_period_detail WHERE period_master_id='$period_master_id' GROUP BY period_master_id";	
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}// end function CountGroupEdit(){
	

	
#### แสดงจำนวนการใช้กลุ่มการแก้ไขกับprofile
function CountEditProfile($period_id){
	global $dbnameuse;
	$sql = "SELECT COUNT(profile_edit_id) AS num1 FROM tbl_assign_edit_profile WHERE period_id='$period_id'";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}// end function CountEditProfile($period_id){


function GetNameEditProfile($profile_edit_id){
	global $dbnameuse;
	$sql = "SELECT * FROM tbl_assign_edit_profile WHERE profile_edit_id='$profile_edit_id'";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[profile_edit_name];
}// end function GetNameEditProfile($period_id){

####  แสดงชื่อกลุ่มรายการหลัก
function GetGroupPeriodName($period_master_id){
		global $dbnameuse;
		$sql = "SELECT * FROM tbl_assign_edit_period WHERE period_master_id='$period_master_id'";
		$result  = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[periodname];
}//end function GetGroupPeriodName(){
	
function GetGroupPeriodNameDetail($period_id){
		global $dbnameuse;
		$sql = "SELECT * FROM tbl_assign_edit_period_detail WHERE period_id='$period_id'";
		$result  = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[periodname];
}//end function GetGroupPeriodName(){

	
### ตรวจสอบการใช้งานของ profile
function CountPeriodProfile($period_id){
	global $dbnameuse;
	$sql = "SELECT COUNT(profile_edit_id) AS num1 FROM tbl_assign_edit_profile WHERE period_id='$period_id'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
		
}//end function CountPeriodProfile(){
	
	
#### นับจำนวนพนักงานที่ทำงานอยู่ใน profile
function CountStaffProfile(){
	global $dbnameuse;
	$sql = "SELECT
t1.staffqc,
COUNT(t1.staffkey) AS num1
FROM  keystaff_qc_math_key AS t1 
GROUP BY t1.staffqc";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffqc]] = $rs[num1];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}// end function CountStaffProfile(){

function GetGroupName(){
	global $dbnameuse;
	$sql = "SELECT * FROM keystaff_group  ";	
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[groupkey_id]] = $rs[groupname];
	}
	return $arr;
}
function GetStaffName($staffid){
	global $dbnameuse;
	$sql = "SELECT * FROM keystaff WHERE staffid='$staffid'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return "$rs[prename]$rs[staffname] $rs[staffsurname]";
}// end function GetStaffName($staffid){
	
	
#########  function นับจำนวนบุคลากรที่ค้างดำเนินการทั้งหมด
function CountReqAll(){
	global $dbnamemaster;
	$sql = "SELECT
COUNT(distinct t2.idcard) as numdif,
t3.siteid
FROM
req_temp_wrongdata as t1
Inner Join req_problem_person as t2 ON t1.req_person_id = t2.req_person_id
Inner Join view_general as t3 ON t2.idcard = t3.CZ_ID
WHERE
t1.problem_type =  '1' AND t1.status_assign =  '0' AND t1.status_req_approve='1' AND t1.status_permit='NO'  AND t1.status_assign='0'
GROUP BY
t3.idcard";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<BR>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[siteid]] = $rs[numdif];		
	}
	return $arr;
}//end function CountReqAll(){
	
##############################
function GetArea($siteid){
	global $dbnamemaster;
	$sql = "SELECT secname FROM eduarea WHERE secid='$siteid'";	
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[secname];
}

function GetSchool($id){
	global $dbnamemaster;
	$sql = "SELECT office FROM allschool WHERE id='$id'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[office];
}

############  เก็บ log ในการลบบุคลากรในใบงาน
function SaveLogDelete($ticketid,$idcard,$siteid){
	global $dbnameuse;
	$sql = "INSERT INTO tbl_assign_edit_log_delete SET ticketid='$ticketid',idcard='$idcard',siteid='$siteid',staffdel='".$_SESSION['session_staffid']."',timeupdate=NOW()";	
	mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
}
function get_real_ip()
{
	$ip = false;
	if(!empty($_SERVER['HTTP_CLIENT_IP']))	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
		if($ip){
			array_unshift($ips, $ip);
			$ip = false;
		}
	for($i = 0; $i < count($ips); $i++){
		if(!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])){
			if(version_compare(phpversion(), "5.0.0", ">=")){
				if(ip2long($ips[$i]) != false){
					$ip = $ips[$i];
					break;
				}
			} else {
				if(ip2long($ips[$i]) != - 1){
					$ip = $ips[$i];
					break;
				}
			}
		}
	}
}
return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

############### แสดงอัตราส่วนการบันทึกข้อมูล ################
function GetRatio(){
	global $dbnameuse;
	$sql = "SELECT t1.ratio_id, t1.ratio_name FROM  keystaff_ratio AS t1";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[ratio_id]] = $rs[ratio_name];
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr;
}//end function GetRatio(){


?>