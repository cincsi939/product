<?
require_once("../../../config/conndb_nonsession.inc.php");
require_once("../function_assign_edit.php");

$d_week = 6; // �ӹǹ�ѹ����ѻ����
$d_numkey = 30; // �ӹǹ�ش�����������ѹ

$limit_defilt = " LIMIT 50";

### icon �ʴ�ʶҹС�ûԴ�Դ�����ҹ
$arrimg = array("0"=>" <img src=\"../../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border='0' title='�Դ�����ҹ'>","1"=>"<img src=\"../../../images_sys/approve20.png\" width=\"16\" height=\"16\" border='0' title='�Դ�����ҹ'>");

$arrimg_app = array("0"=>" <img src=\"../../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border='0' title='��ҧ���Թ���'>","1"=>"<img src=\"../../../images_sys/approve20.png\" width=\"16\" height=\"16\" border='0' title='���Թ�����������'>");

##### �ѹ �. �֧ �.
$arrday = array("0"=>"�ҷԵ��","1"=>"�ѹ���","2"=>"�ѧ���","3"=>"�ظ","4"=>"����ʺ��","5"=>"�ء��","6"=>"�����");

$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$shortmonth = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");
$arrsex = array("M"=>"���","F"=>"˭ԧ");

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
		return $t." �.";
}//end 

### �ʴ��ѹ���㹿����
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
	
	
function GetStaffProfile($profile_edit_id){
	global $dbnameuse;
		$sql_edit = "SELECT * FROM tbl_assign_edit_staffkey WHERE profile_edit_id='$profile_edit_id'";
		$result_edit = mysql_db_query($dbnameuse,$sql_edit) or die(mysql_error()."$sql_edit<br>LINE::".__LINE__);
		while($rse = mysql_fetch_assoc($result_edit)){
			$arrstaff[$rse[staffid]] = $rse[staffid];	
		}
	return $arrstaff;
}//end function GetStaffProfile($profile_edit_id){
	
##### �ʴ��ӹǹ��¡�÷���ͺ��������Ǣͧ��ѡ�ҹ�����
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

#### ��Ǩ�ͺ㺧ҹ�����������
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

##########  fucntion ��Ǩ�ͺ㺧ҹ��͹�ӡ��ź
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

### �ʴ��ӹǹ�������¡��
function CountGroupEdit($period_master_id){
	global $dbnameuse;
	$sql = "SELECT COUNT(period_master_id) AS num1  FROM tbl_assign_edit_period_detail WHERE period_master_id='$period_master_id' GROUP BY period_master_id";	
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}// end function CountGroupEdit(){
	

	
#### �ʴ��ӹǹ��������������䢡Ѻprofile
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

####  �ʴ����͡������¡����ѡ
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

	
### ��Ǩ�ͺ�����ҹ�ͧ profile
function CountPeriodProfile($period_id){
	global $dbnameuse;
	$sql = "SELECT COUNT(profile_edit_id) AS num1 FROM tbl_assign_edit_profile WHERE period_id='$period_id'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
		
}//end function CountPeriodProfile(){
	
	
#### �Ѻ�ӹǹ��ѡ�ҹ���ӧҹ����� profile
function CountStaffProfile($profile_edit_id){
	global $dbnameuse;
	$sql = "SELECT COUNT(staffid) AS num1 FROM  tbl_assign_edit_staffkey WHERE profile_edit_id='$profile_edit_id'";	
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}

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
	
	
#########  function �Ѻ�ӹǹ�ؤ�ҡ÷���ҧ���Թ��÷�����
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

############  �� log 㹡��ź�ؤ�ҡ��㺧ҹ
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

##########################################  funciton ��Ǩ�ͺ����ͧ����繢���������繺Ѩ�غѹ ##################
function UpdateReqProblemType(){
	global $dbnamemaster,$dbnameuse;
	$sql = "SELECT
t1.runid,
t1.req_person_id
FROM
req_temp_wrongdata as t1
Inner Join req_problem as t2 ON t1.req_person_id = t2.req_person_id
where t1.problem_type='1' and t2.problem_type='2'";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$sql1 = "UPDATE req_temp_wrongdata SET problem_type='2' WHERE  req_person_id='$rs[req_person_id]'";
		//echo $sql1."<br>";
		mysql_db_query($dbnamemaster,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
		
		$sql2 = "DELETE FROM tbl_assign_edit_log_detail WHERE req_person_id='$rs[req_person_id]'";
		//echo "$sql2<br><hr>";
		mysql_db_query($dbnameuse,$sql2) or die(mysql_error()."$sql2<br>LINE__".__LINE__);		
	}//end while($rs = mysql_fetch_assoc($result)){
}//end function UpdateReqProblemType(){
	
	
########################  FUNCTION ��Ǩ�ͺ 㺧ҹ����ͺ���������������Ť���ͧ #####################
function UpdateAssignEditKey(){
	global $dbnameuse;
	$sql = "SELECT
t1.runid,
t1.idcard,
t1.siteid,
t1.ticketid
FROM
tbl_assign_edit_log as t1
Left Join tbl_assign_edit_log_detail as t2  ON t1.runid = t2.log_id
WHERE
t2.log_id IS NULL ";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>__LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$sql_del = "DELETE  FROM tbl_assign_edit_log WHERE runid='$rs[runid]' AND idcard='$rs[idcard]' AND siteid='$rs[siteid]' AND ticketid='$rs[ticketid]'";
		mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."<br>$sql_del<br>LINE__".__LINE__);
		
		$sql_del1 = "DELETE FROM tbl_assign_edit_key WHERE ticketid='$rs[ticketid]' AND siteid='$rs[siteid]' AND idcard='$rs[idcard]' ";
		mysql_db_query($dbnameuse,$sql_del1) or die(mysql_error()."<br>$sql_del1<br>LINE__".__LINE__);
	}//end while($rs = mysql_fetch_assoc($result)){
}// end function UpdateAssignEditKey(){
	
	
############ �ӡ��ź㺧ҹ�óշ��㺧ҹ�������բ����š�ä��� #################

function DelTicketNull(){
	global $dbnameuse;
	$sql = "SELECT t1.ticketid FROM tbl_assign_edit_sub as t1
Left Join tbl_assign_edit_key as t2 ON t1.ticketid = t2.ticketid
where t2.ticketid IS NULL";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$sql_del = "DELETE FROM tbl_assign_edit_sub WHERE ticketid='$rs[ticketid]'";
		mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE__".__LINE__);
	}
}//end function DelTicketNull(){



#########################  update�����ŷ��������繻Ѩ�غѹ����繾����Դ ###############################
function UpdateReqWrong(){
	global $dbnamemaster,$dbnameuse;
	$sql = "SELECT
t1.runid,
t1.req_person_id
FROM
req_temp_wrongdata as t1
Inner Join req_problem as t2 ON t1.req_person_id = t2.req_person_id
where t1.problem_type='2' and t2.problem_type='1'";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		$sql1 = "UPDATE req_temp_wrongdata SET problem_type='1' WHERE  req_person_id='$rs[req_person_id]'";
		mysql_db_query($dbnamemaster,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
	}//end while($rs = mysql_fetch_assoc($result)){
}//end function UpdateReqWrong(){
	
##########################################  ��Ѻ��ا�����Ť���ͧ ######################################
function ProcessReq(){
	global $dbnamemaster,$dbnameuse;
	UpdateReqProblemType();# ��Ѻ�����Ť���ͧ����繢���������繻Ѩ�غѹ�������� callcenter ��Ѻ
	UpdateAssignEditKey();# ��Ѻ �����š���ͺ���§ҹ
	DelTicketNull();# ź㺧ҹ�������բ�����
	UpdateReqWrong();// ��Ѻ����ͧ������������繻Ѩ�غѹ����繾����Դ
	
}//end function ProcessReq(){
?>