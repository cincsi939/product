<?
session_start();
header("Expires: Mon, 26 April 2003 09:09:09 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("cache-Control: no-store, no-cache, must-revalidate"); 
header("cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache"); 

include("../../config/conndb_nonsession.inc");
$dbcallcenter_entry ="callcenter_entry"  ;
$dbnamemaster="edubkk_master";
$dbsystem = "competency_system";
$dbname_temp = "edubkk_checklist";
$config_yy = "52";

//system data base
$sysdbname =""  ;
$aplicationpath="competency_master";
//gov data
$gov_name = ""    ;
$ministry_name = "";
$gov_name_en = ""    ;
$connect_status =   ""   ;
$mainwebsite = "http://www.cmss-otcsc.com"  ;
$admin_email    = "";  
$servergraph = "202.129.35.106";
$masterserverip = "";
$policyFile="";

$dbtemp_pobec = "temp_pobec_import_checklist";
$dbtemp_check = "edubkk_checklist";
$db_temp_pobec = "temp_pobec_import_checklist";
//if($_SESSION['session_username'] == ""){
//	echo "<h3>�Ҵ��õԴ��͡Ѻ server �ҹ�Թ仡�س� login �������к�����</h3>";
//	header("Location: login.php");
//	die;
//}

$ipsource = "localhost";
$ipdest ="localhost";
$arr_approve = array("0"=>"���Ѻ�ͧ","1"=>"�Ѻ�ͧ������","2"=>"�����");

//$config_date = "01/10/".(date("Y")+543);
$config_date = "01/10/2552";
$xyear = (date("Y")+543)."-09-30";
$epm_staff = "keystaff";
$epm_groupmember = "epm_groupmember";
$officetable = "epm_main_menu";


$isLocked = 0;

$max_graphitem = 5;
$graph_path = "http://$servergraph/graphservice/graphservice.php";
$gstyle="srd_sf_014";
$gtype="pie";
$g_ydata = "";
$g_xdata = "";


$headcolor="#3355FF";
$bodycolor="#A3B2CC";
$nextyearcolor="#003333";

$monthname = array( "","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹", "�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
$shortmonth = array( "","�.�.","�.�.","��.�.","��.�.","�.�.","��.�.", "�.�.","�.�.","�.�.","�.�.","�.�.","�.�.");

$ThaiWeekDay = array("Monday"=>"�ѹ���","Tuesday"=>"�ѧ���","Wednesday"=>"�ظ", "Thursday"=>"����ʺ��","Friday"=>"�ء��","Saturday"=>"�����","Sunday"=>"�ҷԵ��");


$ticketYY = (date("Y")+543)."".(date("md"))."".(date("His"));
function ran_digi($num_require=7) {
	$alphanumeric = array(0,1,2,3,4,5,6,7,8,9);
	$rand_key = array_rand($alphanumeric , $num_require);
	for($i=0;$i<sizeof($rand_key);$i++) $randomstring .= $alphanumeric[$rand_key[$i]];
	return $randomstring;
}


function sw_date_show($temp_date){
	if($temp_date != ""){
		$arr = explode("-",$temp_date);
		$xdate = $arr[2]."/".$arr[1]."/".$arr[0];
	}
	return $xdate;
}

######  funcntion 㹡�� genisylࢵ��鹷�����֡��
function GenidcardSys($get_siteid,$str_digi){
		return $get_siteid."".ran_digi($str_digi);
}//end function GenidcardSys($get_siteid,$str_digi){

function sw_date_indb($temp_date){
	if($temp_date != ""){
		$arr = explode("/",$temp_date);
		if($arr[2] > 2500){
			$result = ($arr[2]-543)."-".$arr[1]."-".$arr[0];
		}else{
			$result = ($arr[2])."-".$arr[1]."-".$arr[0];
		}
	}else{
		$result = "0000-00-00";
	}
return $result;
}
##  end function function sw_date($temp_date,$type){
	
## �ѧ���蹵�Ǩ�ͺ��úѹ�֡�����ū��
function check_assign_replace($idcard,$ticketid){
global $dbname_temp,$profile_id;
	$sql = "SELECT count(idcard) as num1 FROM tbl_checklist_assign_detail WHERE idcard='$idcard' AND profile_id='$profile_id' GROUP BY idcard  ";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	
	return $rs[num1];

}## end �ѧ���蹵�Ǩ�ͺ��úѹ�֡�����ū��	
	


function show_user($get_staffid){
		global $dbcallcenter_entry;
		$sql = "SELECT * FROM  keystaff WHERE staffid='$get_staffid'";
		$result = mysql_db_query($dbcallcenter_entry,$sql);
		$rs = mysql_fetch_assoc($result);
		return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
}//end function show_user(){

function CheckLockArea($get_site,$profile_id){
	global $dbname_temp;
	if($profile_id == ""){// �ó���������͡���� ������
	$profile_id = LastProfile();
}//end if($profile_id == ""){// �ó���������͡���� ������
	$sql_count = "SELECT COUNT(siteid) AS num_site FROM tbl_status_lock_site WHERE siteid='$get_site' AND profile_id='$profile_id'";
	$result_count = mysql_db_query($dbname_temp,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
	return $rs_c[num_site];
}

function get_dateThai($get_date,$xtype=""){
	global $shortmonth;
		if($get_date != "" and get_date != "0000-00-00 00:00:00"){
			$arrd = explode(" ",$get_date);
			$arrd1 = explode("-",$arrd[0]);
			if($xtype != ""){
				$xdate = intval($arrd1[2])." ".$shortmonth[intval($arrd1[1])]." ".($arrd1[0]+543);
			}else{
				$xdate = intval($arrd1[2])." ".$shortmonth[intval($arrd1[1])]." ".($arrd1[0]+543)."<br> ���� $arrd[1] �.";
			}
			
		}else{
			$xdate = "����к�";
		}
	return $xdate;
}//end function get_dateThai(){

### �ѧ��Ѫ�� ����¹�ҡ �.�. �� �.�.
	function sw_dateE($get_date){
		$arr1 = explode("/",$get_date);
		return ($arr1[2]-543)."-".$arr1[1]."-".$arr1[0];
	}

### �ѧ��Ѫ�� ����¹�ٻẺ��èѴ�红�����
	function SwDateT($get_date){
		$arr1 = explode("/",$get_date);
		return ($arr1[2])."-".$arr1[1]."-".$arr1[0];
	}
### function FROM show
function DateFrom($d){
	$arr = explode("-",$d);
	return $arr[2]."/".$arr[1]."/".($arr[0]+543);
	
}//end function DateFrom(){
	
	
function sw_date_intxtbox($temp_date){
	if($temp_date != "0000-00-00"){
		$arr = explode("-",$temp_date);
		$result = $arr[2]."/".$arr[1]."/".($arr[0]+543);
	}else{
		$result = "";
	}
return $result;
}
##  end function function sw_date($temp_date,$type){


function addLog($action,$detail){
//action 8=login fail, 9 = login , 10 = logout
	$ip = get_real_ip();
	$sql = "insert into log_update(logtime,staffid,act,detail,pcomplete,bpercent,ip) values(now(),'$_SESSION[session_staffid]','$action','$detail','$pcomplete','$bpercent','$ip');"; 
	$result = mysql_db_query("edubkk_checklist",$sql);
}




function person_not_assign($xidcard,$xsiteid,$ticketid){ // �ѧ���蹵�Ǩ�ͺ�óպؤ�ҡö١ assing ¡��鹵���ͧ
global $dbname_temp,$profile_id;
	$sql_p = "SELECT COUNT(idcard) AS num1 FROM tbl_checklist_assign_detail WHERE  idcard = '$xidcard'  AND siteid='$xsiteid' AND profile_id='$profile_id' GROUP BY idcard ";
	$result_p = @mysql_db_query($dbname_temp,$sql_p);
	$rs_p = @mysql_fetch_assoc($result_p);
	return $rs_p[num1];
}// end function person_not_assign(){

## ��Ǩ�ͺ�ͧ����ͧ
function person_select_assign($xidcard,$xsiteid,$ticketid){
global $dbname_temp,$profile_id;
	$sql_p = "SELECT COUNT(idcard) AS num1 FROM tbl_checklist_assign_detail  WHERE ticketid = '$ticketid' AND siteid='$xsiteid' AND idcard = '$xidcard' AND profile_id = '$profile_id' GROUP BY idcard ";
	$result_p = @mysql_db_query($dbname_temp,$sql_p);
	$rs_p = @mysql_fetch_assoc($result_p);
	return $rs_p[num1];

}// function person_select_assign($xidcard,$xsiteid){

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


##########  log ��� assgin �ҹ�᡹
function SaveLogAssign($idcard,$siteid,$ticketid,$action,$comment=""){
		global $dbtemp_check;
			$ip = get_real_ip();
		$sql_insert = "INSERT INTO tbl_checklist_assign_log SET ticketid='$ticketid',idcard='$idcard',siteid='$siteid',staffid='".$_SESSION[session_staffid]."',user_ip='$ip',action='$action',comment='$comment',timeupdate=NOW()";
		mysql_db_query($dbtemp_check,$sql_insert);
}//end function SaveLogAssign($idcard,$siteid,$action,$comment=""){


### ��Ǩ�ͺ�Ţ�ѵ�
function Check_IDCard($StrID){
	if(is_numeric($StrID)){
		if(strlen($StrID)==13){
		$id=str_split($StrID); 
		$sum=0;    
		for($i=0; $i < 12; $i++){
			 $sum += floatval($id[$i])*(13-$i); 
		}   
		if((11-$sum%11)%10!=floatval($id[12])){
			 return false;
		}else{
			 return true; 
		}
	}else{
		return false;
	}   
	}else{
		return false;		
	}
} //end function Check_IDCard($StrID){


###  

function count_person_pobec($get_secid){
global $dbtemp_pobec;
	$tbl_pobec = "pobec_$get_secid";
	$sql_count = "select count(IDCODE) as num_id 	from $tbl_pobec WHERE IDCODE <> '' AND IDCODE IS NOT NULL";
	$result_count = @mysql_db_query($dbtemp_pobec,$sql_count);
	$rs_c = @mysql_fetch_assoc($result_count);
	return $rs_c[num_id];
}
function check_imp_kp7($get_secid,$profile_id=""){
	$db_call = "edubkk_checklist";
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
	$sql_1 = "select count(idcard) as num1 from tbl_checklist_kp7 where siteid='$get_secid' AND profile_id='$profile_id'";
	$result1 = mysql_db_query($db_call,$sql_1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[num1];
}
###########  ����Ң����� pobec ����к ��Ǩ�ͺ�����١��ͧ�ͧ�͡���
### �Ҥӹ�˹�Ҫ���
function get_prename($get_precode){
	global $dbtemp_pobec;
	$sql_p = "SELECT PRE_NAME FROM  prencode WHERE SUR_CODE='$get_precode'";
	$result_p = mysql_db_query($dbtemp_pobec,$sql_p);
	$rs_p = mysql_fetch_assoc($result_p);
	return $rs_p[PRE_NAME];
}// end function get_prename($get_precode){

## �ҵ��˹�
function get_position($get_postcode){
	global $dbtemp_pobec;
	$sql_post = "SELECT
edubkk_master.hr_addposition_now.`position`
FROM
temp_pobec_import_checklist.postcode
Inner Join edubkk_master.hr_addposition_now ON temp_pobec_import_checklist.postcode.pid = edubkk_master.hr_addposition_now.pid
WHERE
temp_pobec_import_checklist.postcode.POST_CODE =  '$get_postcode'";
	$result_post = mysql_db_query($dbtemp_pobec,$sql_post);
	$rs_post = mysql_fetch_assoc($result_post);
	return $rs_post[position];
}//END function get_position($get_postcode){

function get_school($get_icode,$get_siteid){
	global $dbnamemaster;
	$sql_school = "SELECT id, office FROM allschool WHERE i_code='$get_icode' AND siteid='$get_siteid'";
	$result_school = mysql_db_query($dbnamemaster,$sql_school);
	$rs_school = mysql_fetch_assoc($result_school);
	$arr_school['id'] = $rs_school[id];
	$arr_school['schoolname'] = $rs_school[office];
	return $arr_school;
}

###  �ʴ������ç���¹�¤��Ҩҡ����˹��§ҹ
function GetSchoolByName($get_school,$get_siteid){
global $dbnamemaster;
	$sql_s ="SELECT id FROM allschool WHERE office='$get_school' AND siteid='$get_siteid'";
	$result_s = mysql_db_query($dbnamemaster,$sql_s);
	$rs_s = mysql_fetch_assoc($result_s);
	return $rs_s[id];
}//end function GetSchoolByName(){
	
	
function GetBirthDay($get_site,$get_idcard){
		$db_site = "cmss_$get_site";
		$sql = "SELECT birthday,begindate FROM general WHERE idcard='$get_idcard'";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		$arr['birthday'] = $rs[birthday];
		$arr['begindate'] = $rs[begindate];
		return $arr;
	}//end function GetBirthDay(){
		
###  �ѧ�����ʴ���Ǵ�ѭ��
function show_problem(){
	global $dbtemp_check;
	$sql = "SELECT * FROM tbl_problem ORDER BY problem_id ASC";
	$result = mysql_db_query($dbtemp_check,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$result_id[$rs[problem_id]] = $rs[problem];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $result_id;
}//end function show_problem(){
###  ��Ǩ�ͺ�Ţ�ѵ�仫�ӡѺ�����
function check_idreplace($get_secid,$get_idcard,$get_name,$get_surname,$get_birthday){
	global $dbnamemaster;
	$sql_r = "SELECT CZ_ID,siteid,name_th,surname_th,birthday FROM view_general WHERE CZ_ID='$get_idcard'";
	$result_r = mysql_db_query($dbnamemaster,$sql_r);
	$rs_r = mysql_fetch_assoc($result_r);
	if($rs_r[CZ_ID] != ""){
	
	if($get_secid != $rs_r[siteid]){ // �ó�����ࢵ���ǡѹ
	
			if(($rs_r[birthday] == $get_birthday and $rs_r[name_th] == $get_name and $rs_r[surname_th] == $get_surname)){
				$error_msg['siteid'] = $rs_r[siteid];
				$error_msg['msg'] = "IDCARD_REP";
			}else{
				$error_msg['siteid'] = $rs_r[siteid];
				$error_msg['msg'] = "IDCARD_REP_NO_PERSON";
			}
	}/*else{
	//echo "$rs_r[birthday] == $get_birthday and $rs_r[name_th] == $get_name and $rs_r[surname_th] == $get_surname";
		if(($rs_r[birthday] == $get_birthday and $rs_r[name_th] == $get_name and $rs_r[surname_th] == $get_surname)){
			$error_msg['siteid'] = "";
			$error_msg['msg'] = "";
		}else{
			$error_msg['siteid'] = $rs_r[siteid];
			$error_msg['msg'] = "IDCARD_REP_NO_PERSON";
		}
		
	}*///end 	if($get_secid == $rs_r[siteid]){
	}//end if($rs_r[CZ_ID] != ""){
	return $error_msg;
}// end function check_replace(){
	###  function ��Ǩ�ͺ ������� cmss ��������ѧ
	function UpdateDataCmss($get_siteid,$get_idcard,$get_schoolid){
		$db_site = "cmss_$get_siteid";
		$sql = "SELECT COUNT(idcard) as numid FROM general WHERE idcard='$get_idcard'";
		$result = mysql_db_query($db_site,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[numid] > 0){
				$sql_update = "UPDATE general SET schoolid='$get_schoolid' WHERE idcard='$get_idcard'";
				mysql_db_query($db_site,$sql_update);
		}
	}// end function UpdateDataCmss($get_siteid,$get_idcard){

	
	function insert_log_import($get_siteid,$get_idcard,$get_action="",$get_type="",$staff_id="",$get_schoolid="",$get_siteid_old="",$get_schoolid_old="",$profile_id=""){
//action 8=login fail, 9 = login , 10 = logout

	$ip = get_real_ip();
	if($staff_id != ""){
		$staff_id = $staff_id;
	}else{
		$staff_id = $_SESSION[session_staffid];
	}
	
			if($profile_id == ""){
				$profile_id =  LastProfile();
		}

	
	if($get_type != ""){
	$sql = "insert into tbl_checklist_log(idcard,siteid,user_update,ip_server,action_data,time_update,type_action,schoolid,siteid_old,schoolid_old,user_save,profile_id) values($get_idcard,'$get_siteid','$staff_id','$ip','$get_action',now(),'1','$get_schoolid','$get_siteid_old','$get_schoolid_old','".$_SESSION[session_staffid]."','$profile_id');"; 
	}else{
		$sql = "insert into tbl_checklist_log(idcard,siteid,user_update,ip_server,action_data,time_update,type_action,user_save,profile_id) values($get_idcard,'$get_siteid','$staff_id','$ip','$get_action',now(),'0','".$_SESSION[session_staffid]."','$profile_id');"; 
	}

	$result = mysql_db_query("edubkk_checklist",$sql);
}


#######  �ѧ���蹵�Ǩ�ͺ���Ң����ū�ӡѹ� ���ҧ checklist
	function CheckIdReplaceChecklist($get_secid,$get_idcard,$profile_id=""){
		global $dbtemp_check;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
		$sql_r1 = "SELECT count(idcard) as num_id,siteid FROM tbl_checklist_kp7 WHERE idcard='$get_idcard' and siteid <> '$get_secid' and profile_id='$profile_id' group by idcard";
		$result_r1 = mysql_db_query($dbtemp_check,$sql_r1);
		$rs_r1 = mysql_fetch_assoc($result_r1);
			if($rs_r1[num_id] > 0){ // �ó������ʫ��ѡѺࢵ���� �� list
				$error_msg['siteid'] = $rs_r1[siteid];
				$error_msg['msg'] = "REP_CHECKLISTSITE";
			}else{
				$error_msg['siteid'] = "";
				$error_msg['msg'] = "";
			}//end if($rs_r1[num_id] > 0){
		return $error_msg;
	}//end function CheckIdReplaceChecklist(){
###  end  �ѧ���蹵�Ǩ�ͺ���Ң����ū�ӡѹ� ���ҧ checklist

#####  function ��Ǩ�ͺ�ó��Ţ�ѵüԴ� pobec �������� cmss ����㹹��Ţ�ѵù����������
	function CheckIdCmss($get_siteid,$get_name,$get_surname,$get_birthday){
		global $dbnamemaster;
		$sql_cmss = "SELECT CZ_ID,siteid FROM view_general WHERE name_th='$get_name' AND surname_th='$get_surname' AND birthday='$get_birthday'";
		$result_cmss = @mysql_db_query($dbnamemaster,$sql_cmss);
		$rs_cmss = @mysql_fetch_assoc($result_cmss);
		if($rs_cmss[CZ_ID] != ""){ //�ó��դ������к�����ա��������� �Ţ�ѵ÷��١��ͧ����
				if($rs_cmss[siteid] != $get_siteid){ // �ʴ���Ң����������仫�ӡѺࢵ���
					$result_msg['siteid'] = $rs_cmss[siteid];
					$result_msg['msg'] = "REPLACE";
					$result_msg['id'] = $rs_cmss[CZ_ID];
				}else{
					$result_msg['siteid'] = "";
					$result_msg['msg'] = "";
					$result_msg['id'] = $rs_cmss[CZ_ID];
				}//end if($rs_cmss[siteid] != $get_siteid){ 
			}//end if($rs_cmss[CZ_ID] != ""){

		return $result_msg;
	}//end function CheckIdCmss(){

## end  function ��Ǩ�ͺ�ó��Ţ�ѵüԴ� pobec �������� cmss ����㹹��Ţ�ѵù����������
###  �Ѻ�ӹǹ���������� list ��
	function count_imp_checklist($get_secid,$get_type="",$profile_id=""){
		global $dbtemp_check;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
		
		if($get_type == "F"){
			$sql = "SELECT COUNT(idcard) AS numIMP FROM tbl_checklist_kp7_false WHERE siteid='$get_secid' AND status_IDCARD='IDCARD_FAIL' AND  status_chang_idcard='NO' and profile_id='$profile_id'";
		}else if($get_type == "FR"){
			$sql = "SELECT COUNT(idcard) AS numIMP FROM tbl_checklist_kp7_false WHERE  profile_id='$profile_id' and siteid='$get_secid' AND (status_IDCARD_REP='IDCARD_REP' OR status_IDCARD_REP='IDCARD_REP_NO_PERSON' OR status_IDCARD_REP='REP_CHECKLISTSITE') and (status_id_replace='0')";
		}else if($get_type == "R"){ // ���³�����Ҫ���
			$sql = "SELECT COUNT(idcard) as numIMP FROM tbl_checklist_kp7_false WHERE siteid='$get_secid' AND status_retire='1' and profile_id='$profile_id'";
		}else{
			$sql = "SELECT COUNT(idcard) AS numIMP FROM tbl_checklist_kp7 WHERE siteid='$get_secid' AND profile_id='$profile_id'";
		}
			$result = mysql_db_query($dbtemp_check,$sql);
			$rs = mysql_fetch_assoc($result);

	return $rs[numIMP];
	}// end function count_imp_checklist($get_secid){
		
	###  �Ѻ�ӹǹ���������� list ��
	function count_imp_checklist_v1($profile_id=""){
		global $dbtemp_check;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
				 
		$sql = "SELECT 
		SUM(if(status_IDCARD='IDCARD_FAIL' AND  status_chang_idcard='NO',1,0)) AS F,
		SUM(if((status_IDCARD_REP='IDCARD_REP' OR status_IDCARD_REP='IDCARD_REP_NO_PERSON' OR status_IDCARD_REP='REP_CHECKLISTSITE') and (status_id_replace='0'),1,0)) AS FR,
		SUM(if(status_retire='1',1,0)) AS R,siteid 
		FROM  tbl_checklist_kp7_false WHERE   profile_id='$profile_id'  GROUP BY siteid
		";
			$result = mysql_db_query($dbtemp_check,$sql);
			while($rs = mysql_fetch_assoc($result)){
					$arr[$rs[siteid]]['F'] = $rs[F];
					$arr[$rs[siteid]]['FR'] = $rs[FR];
					$arr[$rs[siteid]]['R'] = $rs[R];
			}// end while($rs = mysql_fetch_assoc($result)){

	return $arr;
	}// end function count_imp_checklist($get_secid){

	function count_imp_checklist_v2($profile_id=""){
		global $dbtemp_check;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
				 
		$sql = "SELECT COUNT(idcard) AS numIMP,siteid FROM tbl_checklist_kp7 WHERE profile_id='$profile_id' GROUP BY siteid
		";
			$result = mysql_db_query($dbtemp_check,$sql);
			while($rs = mysql_fetch_assoc($result)){
					$arr[$rs[siteid]]= $rs[numIMP];
			}// end while($rs = mysql_fetch_assoc($result)){

	return $arr;
	}// end  function count_imp_checklist_v2($profile_id=""){



### �Ѻ�ӹǹ��¡�÷���ҹ��õ�Ǩ�ͺ����͡�õ�Ǩ�ͺs
	function count_checklist_kp7($get_siteid,$get_type,$get_school="",$profile_id){
		global $dbtemp_check;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
		
		if($get_school != ""){
			$con_s = " AND schoolid='$get_school'  AND profile_id='$profile_id'";
		}else{
			$con_s = " AND profile_id='$profile_id'";
		}
		if($get_type == "Y"){
			$sql_c1 = "SELECT COUNT(idcard) AS numc1 FROM tbl_checklist_kp7 WHERE status_check_file = 'YES' AND status_file='1' AND siteid='$get_siteid' $con_s";
		}else if($get_type == "YN"){
			$sql_c1 =  "SELECT COUNT(idcard) AS numc1 FROM tbl_checklist_kp7 WHERE status_check_file = 'YES' AND status_file='0' AND siteid='$get_siteid' $con_s";
		}else if($get_type == "N"){
			$sql_c1 = "SELECT COUNT(idcard) AS numc1 FROM tbl_checklist_kp7 WHERE status_check_file='NO' AND siteid='$get_siteid' $con_s";
		}
		//echo $sql_c1."<br>";
		$result_c1 = mysql_db_query($dbtemp_check,$sql_c1);
		$rs_c1 = mysql_fetch_assoc($result_c1);
		return $rs_c1[numc1];
	}//end 	function count_checklist_kp7($get_siteid,$get_type){
		
	#####  function �Ѻ�š�õ�Ǩ�͡��� version 1
	function CountCheckListKp7($get_siteid,$get_school="",$profile_id=""){
	global $dbtemp_check;
		if($profile_id == ""){
				$profile_id = LastProfile();
		}
	
		if($get_school != ""){
			$con_s = " AND schoolid='$get_school' AND profile_id='$profile_id'";
		}else{
			$con_s = " AND profile_id='$profile_id'";
		}
	
	$sql_count = "SELECT 
sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' ,1,0 )) as NumPass, 
sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0' ,1,0 )) as NumNoPass, 
sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0',1,0 )) as NumNoMain, 
sum(if(status_numfile='1' and status_file='0' and status_check_file='NO'  ,1,0)) as NumDisC, 
sum(page_num) as NumPage, 
sum(if(status_numfile='1' ,1,0)) as NumQL, 
sum(pic_num) as NumPic, 
count(idcard) as NumAll,
sum(if(status_id_false='1',1,0)) as numidfalse,
sum(if(status_numfile='0',1,0)) as numnorecive
 FROM tbl_checklist_kp7
 WHERE siteid='$get_siteid' $con_s";	
		
	$result_count = mysql_db_query($dbtemp_check,$sql_count);
	$rs_c = mysql_fetch_assoc($result_count);
		$ArrNum['NumPass'] = $rs_c[NumPass];
		$ArrNum['NumNoPass'] = $rs_c[NumNoPass];
		$ArrNum['NumDisC'] = $rs_c[NumDisC];
		$ArrNum['NumPage'] = $rs_c[NumPage];
		$ArrNum['NumPic'] = $rs_c[NumPic];
		$ArrNum['NumAll'] = $rs_c[NumAll];
		$ArrNum['NumM'] = $rs_c[NumM];
		$ArrNum['NumF'] = $rs_c[NumF];
		$ArrNum['NumQL'] = $rs_c[NumQL];
		$ArrNum['NumNoMain'] = $rs_c[NumNoMain];
		$ArrNum['numidfalse'] = $rs_c[numidfalse];
		$ArrNum['numnorecive'] = $rs_c[numnorecive];
	return $ArrNum;
	}//end 	function CountCheckListKp7($get_siteid,$get_type,$get_school=""){
	###  end function �Ѻ�š�õ�Ǩ�͡��� version 1
		
function CountCheckListKp7V1($profile_id=""){
	global $dbtemp_check;
		if($profile_id == ""){
				$profile_id = LastProfile();
		}
	

			$con_s = " WHERE  profile_id='$profile_id'";
	
	
	$sql_count = "SELECT 
	siteid,
sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' ,1,0 )) as NumPass, 
sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0' ,1,0 )) as NumNoPass, 
sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0',1,0 )) as NumNoMain, 
sum(if(status_numfile='1' and status_file='0' and status_check_file='NO' ,1,0)) as NumDisC, 
sum(if(status_numfile='1',1,0)) as NumQL, 
sum(page_num) as NumPage, 
sum(pic_num) as NumPic, 
count(idcard) as NumAll,
sum(if(status_id_false='1',1,0)) as numidfalse,
sum(if(status_numfile='0',1,0)) as numnorecive
 FROM tbl_checklist_kp7
   $con_s
 group by siteid
 ";	
		
	$result_count = mysql_db_query($dbtemp_check,$sql_count);
	while($rs_c = mysql_fetch_assoc($result_count)){
		$ArrNum[$rs_c[siteid]]['NumPass'] = $rs_c[NumPass];
		$ArrNum[$rs_c[siteid]]['NumNoPass'] = $rs_c[NumNoPass];
		$ArrNum[$rs_c[siteid]]['NumDisC'] = $rs_c[NumDisC];
		$ArrNum[$rs_c[siteid]]['NumPage'] = $rs_c[NumPage];
		$ArrNum[$rs_c[siteid]]['NumPic'] = $rs_c[NumPic];
		$ArrNum[$rs_c[siteid]]['NumAll'] = $rs_c[NumAll];
		$ArrNum[$rs_c[siteid]]['NumM'] = $rs_c[NumM];
		$ArrNum[$rs_c[siteid]]['NumF'] = $rs_c[NumF];
		$ArrNum[$rs_c[siteid]]['NumQL'] = $rs_c[NumQL];
		$ArrNum[$rs_c[siteid]]['NumNoMain'] = $rs_c[NumNoMain];
		$ArrNum[$rs_c[siteid]]['numidfalse'] = $rs_c[numidfalse];
		$ArrNum[$rs_c[siteid]]['numnorecive'] = $rs_c[numnorecive];
	}
	return $ArrNum;
}//end 	function function CountCheckListKp7V1($get_siteid,$get_school="",$profile_id=""){
	###  end function �Ѻ�š�õ�Ǩ�͡��� version 1	
		
###  �ʴ�����ࢵ��鹷�����֡��
	function show_area($get_secid){
		global $dbnamemaster;
		$sql_area = "SELECT secname FROM eduarea WHERE secid='$get_secid'";
		$result_area = mysql_db_query($dbnamemaster,$sql_area);
		$rs_area = mysql_fetch_assoc($result_area);
		return $rs_area[secname];
	}//end function show_area($get_secid){
	
###  �ѧ�����ʴ�˹��§ҹ
	function show_school($get_schoolid){
		global $dbnamemaster;
		$sql_school = "SELECT office FROM allschool WHERE id='$get_schoolid'";
		$result_school = mysql_db_query($dbnamemaster,$sql_school);
		$rs_school = mysql_fetch_assoc($result_school);
		return $rs_school[office];
	}//end function show_school($get_schoolid){

## end �ѧ�����ʴ�˹��§ҹ
	function devidepage($total, $kwd , $sqlencode ){
	$per_page		= 11;	
	$page_all 		= $total;
	global $page,$key_name,$key_surname,$key_idcard,$sentsecid,$schoolid,$xsiteid,$lv,$profile_id,$office;

	if($total >= 1){
		$table	= "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		$table	= $table."<tr align=\"right\">";
		$table	= $table."<td width=\"80%\" align=\"left\" height=\"30\">&nbsp;";
				
		if($page_all <= $per_page){
			$min		= 1;
			$max		= $page_all;
		} elseif($page_all > $per_page && ($page - 5) >= 2 ) {			
			$min		= $page - 5;
			$max		= (($page + 5) > $page_all) ? $page_all : $page + 5;
		} else {
			$min	= 1;
			$max	= $per_page; 			
		}
	
		if($min >= 4){ 
			$table .= "<a href=\"?page=1&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&sentsecid=$sentsecid&xsiteid=$xsiteid&schoolid=$schoolid&lv=$lv&profile_id=$profile_id&office=$office&displaytype=people".$kwd."\"><u><font color=\"black\">˹���á</font></u></a>&nbsp;"; 
		}
		
		for($i=$min;$i<=$max;$i++){			
			$i	= str_pad($i, 2, "0", STR_PAD_LEFT);
			if($i != $page){
				$table .= "<a href=\"?page=".$i."&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&sentsecid=$sentsecid&xsiteid=$xsiteid&schoolid=$schoolid&lv=$lv&profile_id=$profile_id&office=$office&displaytype=people". $kwd."\"><span class=\"pagelink\">".$i."</span></a>";
			} else {
				$table .= "<span class=\"page\">".$i."</span>";
			}	
		}
		
		if(($page + 5) <= $page_all){ 
			$table .= "&nbsp;<a href=\"?page=".$page_all."&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&sentsecid=$sentsecid&xsiteid=$xsiteid&schoolid=$schoolid&lv=$lv&profile_id=$profile_id&office=$office&displaytype=people". $kwd."\"><u><font color=\"black\">˹���ش����</font></u></a>"; 
		}
		
		if($page_all > 1){
			$table .= "&nbsp;<a href=\"?page=".($page_all+1)."&key_name=$key_name&key_surname=$key_surname&key_idcard=$key_idcard&sentsecid=$sentsecid&xsiteid=$xsiteid&schoolid=$schoolid&lv=$lv&profile_id=$profile_id&office=$office&displaytype=people". $kwd."\"><u><font color=\"black\">�ʴ�������</font></u></a>";
		}
#		$table .= "&nbsp;<a href=\"search_excel.php?page=$sqlencode\"><u><font color=\"black\">���͡�ٻẺ MS Excel </font></u></a>";

		unset($max,$i,$min);
	
		$table	= $table."</td>";	
		$table	= $table."<td width=\"20%\">�ӹǹ������ <b>".number_format($page_all, 0, "", ",")."</b>&nbsp;˹��&nbsp;</td>";
		$table	= $table."</tr>";
		$table	= $table."</table>";
	}
 	return $table;
}


###########   function �ʴ���������ó�����������ó�ͧ��¡��<img src="../../images_sys/unapprove.png" width="16" height="16">
	function show_icon_check($get_value,$get_status ="",$get_numfile="",$file_comp=""){
		
		if($get_status != ""){/// �óյ�Ǩ�ͺ 3 ʶҹ� ��� �ѧ������Ǩ�ͺ , ��Ǩ�ͺ���Ǽ�ҹ, ��Ǩ�ͺ�����ѧ����ҹ 
				if($get_status == "YES"){
					if($get_value == "1"){
						$g_icon = "<img src=\"../../images_sys/right.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"��¡������ó�\">";
					}else{						
							if($get_numfile == "1" and $file_comp == ""){
							$g_icon = "<img src=\"../../images_sys/person.gif\" width=\"16\" height=\"13\" border=\"0\" title=\"ʶҹС�õ�Ǩ�Ѻ���º��������\">";
							}else{
							$g_icon = "<img src=\"../salary_mangement/images/bullet_error.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"��Ǩ�ͺ�����ѧ����ҹ\">";	
							}
					}
				}else{
					if($get_numfile == "1" and $file_comp == ""){
						$g_icon = "<img src=\"../../images_sys/person.gif\" width=\"16\" height=\"13\" border=\"0\" title=\"ʶҹС�õ�Ǩ�Ѻ���º��������\">";
					}else{
						$g_icon = "<img src=\"../salary_mangement/images/delete.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"��¡���ѧ������Ѻ��õ�Ǩ�ͺ\">";
					}
				}//end if($get_status == "YES"){
		}else{ /// �� 2 ʶҹ� ��ͼ�ҹ, ����ҹ
			if($get_value == "0"){

				$g_icon = "<img src=\"../salary_mangement/images/delete.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"�ѧ������Ѻ��õ�Ǩ�ͺ\">";
			}else if($get_value == "1"){
				$g_icon = "<img src=\"../../images_sys/right.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"��¡������ó�\">";
			} // end if($get_value == "0"){
		}//end 
		
		return $g_icon;
	}//end function show_icon_check(){ 
	
	###########  function �Ѻ�ӹǹ�� �ӹǹ�ٻ
	function count_page_pic($get_secid,$get_lv="area",$get_school="",$profile_id){
		global $dbname_temp;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}

		if($get_lv == "area"){
			$sql = "SELECT sum(page_num) as sum_page, sum(pic_num) as sum_pic FROM tbl_checklist_kp7 where siteid='$get_secid' AND profile_id='$profile_id'";
		}else if($get_lv == "school"){
			$sql = "SELECT sum(page_num) as sum_page, sum(pic_num) as sum_pic FROM tbl_checklist_kp7 where siteid='$get_secid' AND schoolid='$get_school' AND profile_id='$profile_id'";
		}
		$result = mysql_db_query($dbname_temp,$sql);
		$rs = mysql_fetch_assoc($result);
		$arr_val['page'] = $rs[sum_page];
		$arr_val['pic'] = $rs[sum_pic];
		return $arr_val;		
	}// end function count_page_pic($get_secid,$get_lv="area",$get_school=""){
	
	### �ѧ�����ʴ���� exsum
	function show_val_exsum($get_lv="",$get_siteid="",$get_school="",$profile_id=""){
		global $dbname_temp;
			if($profile_id == ""){
					$profile_id = LastProfile();
			}
		 if($get_lv == "1"){ // ����ࢵ
			$conv = " where siteid='$get_siteid' AND profile_id='$profile_id'";	
		}else if($get_lv == "2"){ // �����ç���¹
			$conv = " where siteid='$get_siteid' AND schoolid='$get_school' AND profile_id='$profile_id'";	
		}else{
			$conv = " where profile_id='$profile_id'";
		}



		$sql = "SELECT 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0',1,0 )) as numY0, 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='YES' and status_id_false='0',page_num,0 )) as numY0page, 
		sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0' ,1,0 )) as numY1, 
		sum(if(status_numfile='1' and status_file='1' and status_check_file='YES' and status_id_false='0' ,page_num,0)) as numY1page, 
		sum(if(status_numfile='1' and status_check_file='YES' and mainpage ='0' and status_file='1' and status_id_false='0',1,0 )) as NumNoMain, 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='NO',1,0)) as numN, 
		sum(if(status_numfile='1' and status_file='0' and status_check_file='NO' ,page_num,0)) as numNpage,  
		sum(if(page_num <> page_upload and page_upload > 0,1,0)) as PageNoMath,
		sum(if(status_file='1' and page_upload > 0,1,0)) as NumFile,
    	count(idcard) as numall,
		sum(page_num) as numpage,
		sum(pic_num) as numpic,
		sum(if(status_id_false='1',1,0)) as numidfalse,
		sum(if(status_numfile='0',1,0)) as numnorecive,
		sum(if(status_numfile='1',1,0)) as NumQL
    	FROM tbl_checklist_kp7   $conv";	
		//echo $sql;
		$result = mysql_db_query($dbname_temp,$sql);

		$rs = mysql_fetch_assoc($result);
		$arr['numY0'] = $rs[numY0];														//  ��Ǩ�ͺ�͡������� �������ó�  
		$arr['numMY0'] = $rs[numMY0];	
		$arr['numFY0'] = $rs[numFY0];
		$arr['numY1'] = $rs[numY1];														//  ��Ǩ�ͺ�͡�������  ����ó
		  $arr['NumMY1'] = $rs[NumMY1];	
		 $arr['NumFY1'] = $rs[NumFY1];	
		  $arr['NumM'] = $rs[NumM];	
		 $arr['NumF'] = $rs[NumF];	
		 
		$arr['numN'] = $rs[numN];															// ���������ҧ��õ�Ǩ�ͺ
         $arr['NumMN'] = $rs[NumMN];	
		 $arr['NumFN'] = $rs[NumFN];	
		
		$arr['numall'] = $rs[numall];															// 
		$arr['numpage'] = $rs[numpage];												// 
		$arr['numpageM'] = $rs[numpageM];
		$arr['numpageF'] = $rs[numpageF];
		$arr['numpic'] = $rs[numpic];	
		$arr['numpicM'] = $rs[numpicM];	
		$arr['numpicF'] = $rs[numpicF];	
		// �ӹǹ�ٻ�Ҿ

		$arr['numY0page'] = $rs[numY0page];										// ��Ǩ�ͺ�͡������� �������ó�   �ӹǹ��
		$arr['numY1page'] = $rs[numY1page]; 										// ��Ǩ�ͺ�͡�������  ����ó �ӹǹ��
		$arr['numNpage'] = $rs[numNpage]; 	// ���������ҧ��õ�Ǩ�ͺ�ӹǹ��  =0
		$arr['PageNoMath']  = $rs[PageNoMath];// �ӹǹ��¡�÷��Ѻ�������ҡѺ�к�
		$arr['NumFile'] = $rs[NumFile]; // �Ѻ�ӹǹ��������
		$arr['NumM'] = $rs[NumM];
		$arr['NumF'] = $rs[NumF];
		$arr['NumNoMain'] = $rs[NumNoMain];
		$arr['numidfalse'] = $rs[numidfalse];
		$arr['numnorecive'] = $rs[numnorecive];
		$arr['NumQL'] = $rs[NumQL];
		return $arr;
	}//end function show_val_exsum($get_lv="",$get_type){
	
	#########  function �Ҥ���Ǩ�͡���
	function search_person_check_kp7($get_idcard){
		global $dbcallcenter_entry,$dbtemp_check;
		$sql_log = "SELECT * FROM tbl_checklist_log WHERE idcard='$get_idcard' AND type_action='1' group by user_update ORDER BY time_update DESC ";
		$result_log = mysql_db_query($dbtemp_check,$sql_log);
		while($rs = mysql_fetch_assoc($result_log)){
			$sql_staff = "SELECT * FROM keystaff  WHERE staffid='$rs[user_update]'";
			$result_staff = mysql_db_query($dbcallcenter_entry,$sql_staff);
			$rs1 = mysql_fetch_assoc($result_staff);
			$arr['user'] = "$rs1[prename]$rs1[staffname]  $rs1[staffsurname]";
			$arr['time'] = get_dateThai($rs[time_update]);
		}
		return $arr;
	}//end function search_person_check_kp7(){

	########### fucntion �ʴ�ʶҹо�ѡ�ҹ
	function show_type_staff($get_type){
		if($get_type == "1"){
			return "��ѡ�ҹ sapphire";
		}else if($get_type == "0"){
			return "�١��ҧ���Ǥ���";
		}else if($get_type =="2"){
			return "Subcontract";
		}
	}//end function show_type_staff(){
	
	function count_check_kp7($get_staff,$get_date){
		global $dbtemp_check;
		$sql_count = "SELECT COUNT(tbl_checklist_log.idcard) as num FROM tbl_checklist_log WHERE user_update='$get_staff' AND date(time_update) like '$get_date' AND edubkk_checklist.tbl_checklist_log.type_action='1' GROUP BY tbl_checklist_log.idcard ";
		$result_count = mysql_db_query($dbtemp_check,$sql_count);
		$numc = @mysql_num_rows($result_count);
		//$rs_c = mysql_fetch_assoc($result_count);
		return $numc;
	} //end 	function count_check_kp7($get_staff,$get_date){
	
	##  function �Ѻ�ӹǹ����Ǩ�͡�����ͧ���Ф�
	function CountPersonCheck($get_staffid){
		global $dbtemp_check;
		$sql_count = "SELECT COUNT(tbl_checklist_log.idcard) as numC FROM tbl_checklist_log WHERE user_update='$get_staffid' AND edubkk_checklist.tbl_checklist_log.type_action='1' GROUP BY tbl_checklist_log.idcard";
		$result_count = mysql_db_query($dbtemp_check,$sql_count);
		$numC = @mysql_num_rows($result_count);
		return $numC;
	}
	
	###  funciton �Ѻ�ӹǹ����µ���ѹ����Ǩ�ͺ�͡�����
	function CountCheckAvg($get_staffid){
		global $dbtemp_check;
		$numall = CountPersonCheck($get_staffid);// �ӹǹ������������Ǩ�ͺ�͡�����
		$sql1 = "SELECT 
count(date(time_update)) as num1
FROM
edubkk_checklist.tbl_checklist_log
Inner Join callcenter_entry.keystaff ON edubkk_checklist.tbl_checklist_log.user_update = callcenter_entry.keystaff.staffid
WHERE
edubkk_checklist.tbl_checklist_log.type_action =  '1' and edubkk_checklist.tbl_checklist_log.user_update='$get_staffid' GROUP BY date(time_update) ";
		$result1 = mysql_db_query($dbtemp_check,$sql1);
		//$rs1 = mysql_fetch_assoc($result1);
		$numr1 = @mysql_num_rows($result1);
		if($numall > 0 ){
			$result_num = number_format($numall/$numr1);
		}else{
			$result_num = "0";
		}
	return $result_num;
	}
	###  ��Ǩ�ͺ��������ó����
function checkretireDate($date,$add=0){ 
    $d  = explode("-",$date);
    $year    = $d[0]+$add;
    $month    = $d[1];
    $date    = $d[2];
    if($month == 1 || $month == 2 || $month == 3){        
        $retire_year    = ($year < 2484) ? $year + 61 : $year + 60 ;        
    } else if($month == 10 || $month == 11 || $month == 12){        
        $retire_year     = ($date <= 1 && $month == 10) ? $year + 60 :  $year + 61;        
    } else {
        $retire_year     = $year + 60;
    }        
   
    $year_now=(date('Y')+543);         

     if($retire_year<=$year_now){
         return "0"; 
     }else{
         return "1";
     } 
}// end function checkretireDate($date,$add=0){ 

############  sql 
function ChRetireDate($date){
	$year_now=(date('Y')+543);   
	$yynow = "$year_now-09-30";
	if($date != "" and $date != "0000-00-00"){
		$sql = "select FLOOR(TIMESTAMPDIFF(MONTH,'$date','$yynow')/12) as agv_gov";	
		$result = mysql_query($sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[agv_gov] > 60){
			return "0";
		}else{
			return "1";	
		}
	}
}


function retireDate($date){

	$d			= explode("-",$date);
	$year	= $d[0];
	$month	= $d[1];
	$date	= $d[2];
	
	
		
	if($month == 1 || $month == 2 || $month == 3){		
		$retire_year	= ($year < 2484) ? $year + 61 : $year + 60 ;		
	} else if($month == 10 || $month == 11 || $month == 12){		
		$retire_year 	= ($date <= 1 && $month == 10) ? $year + 60 :  $year + 61;		
	} else {
		$retire_year 	= $year + 60;
	}		

	return "30 �ѹ��¹ �.�. ".$retire_year;
}
#############  �ʴ���Ǵ��¡�õ�Ǩ�ͺ
function GetTypeMenu($get_menu){
	global $dbtemp_check;
	$sql_menu = "SELECT * FROM tbl_check_menu WHERE menu_id='$get_menu'";
	//echo $sql_menu;
	$result_menu = mysql_db_query($dbtemp_check,$sql_menu);
	$rs_menu = mysql_fetch_assoc($result_menu);
	return $rs_menu[menu_detail];
}
##### �ʴ���Ǵ�ͧ�ѭ��
function GetTypeProblem($get_problem){
global $dbtemp_check;
	$sql_p = "SELECT * FROM tbl_problem WHERE problem_id='$get_problem'";
	$result_p = mysql_db_query($dbtemp_check,$sql_p);
	$rs_p = mysql_fetch_assoc($result_p);
	return $rs_p[problem];
}




function remove_zero($temp) 
{
	$num_chk = strlen($temp);
	if($num_chk == 2) {	
		$num_1 = substr($temp, 0, 1);  
		if($num_1 == 0){ 
			$rnum = substr($temp, 1, 2); 
		} else { 
			$rnum = $temp; 
		}
	} else { 
	$rnum = $temp; 
	}
	return $rnum;
}

function add_zero($temp) 
{
	$num_chk = strlen($temp);
	if($num_chk == 1) {	
		$rnum = "0".$temp;
	} else {
		$rnum = $temp;
	}
	return $rnum;
}

function upload($path, $file, $file_name, $type,$idcard="",$date_file=""){
$file_ext 	= strtolower(getFileExtension($file_name));		
global $height;
global $width;

if($type == "all"){

	$approve = "y";
	
}elseif($type == "img"){

	$chk_img = ($file_ext != "jpg" and $file_ext != "gif" and $file_ext != "jpeg"  and $file_ext != "png") ? "n" : "y" ;
	if($chk_img == "y"){
	
		$width 		= (!isset($width) || $width == "") ? 801 : $width ; 
		$height 		= (!isset($height) || $height == "") ? 801 : $height ; 
		$img_size 	= GetImageSize($file);  
		
		if(($img_size[0] >= $width) || ($img_size[1] >= $height)) {
			$approve 	= "n";
			$status[0]	= "error_scale";
		}else{
			$approve 	= "y";
		}
		
	} else {
		$approve 	= "n";
		$status[0]	= "error_img";
	}  
	
} elseif($type == "fla") {

		$approve 	= ($file_ext != "swf") ? "n" : "y" ;
	
} elseif($type == "doc") {

	$chk_doc = ($file_ext != "pdf") ? "n" : "y" ;
	if($chk_doc == "y"){
		$approve 	= "y";
	} else {
		$approve 	= "n";
		$status[0]	= "error_doc";
	}

} else {

	$approve 	= "n";
	$status[0]	= "error_type";
	
}

/* -------------------------------------------------------------Check file Exists  */
if($type == "doc"){	
	//$file_n		= chk_file($file_name, $path);
	if($date_file != ""){
		$file_n		= $idcard."_".$date_file.".".$file_ext;
	}else{
		$file_n		= $idcard.".".$file_ext;	
	}

	
	//echo $file_n;die;
	$filename	= $path.$file_n;
} elseif($type == "img" || $type == "fla" || $type == "all") {
	if($date_file != ""){
		$file_n		= $idcard."_".$date_file.".".$file_ext; // gen ����������Ţ�ѵû�ЪҪ�	
	}else{
		$file_n		= $idcard.".".$file_ext; // gen ����������Ţ�ѵû�ЪҪ�
	}
	$filename 	= $path.$file_n;	
}
$status[1] = $file_n;

/* ---------------------------------------------------------Begin Uploading File */
if($approve == "y"){

	if($file_size >= "80000000") {
		$status[0] = "error_size";		
	} else {	
		if(is_uploaded_file($file)){ 
			if (!copy($file,$filename)){	 
				$status[0] = "error_upload";
			} else {
				$status[0] = "complete";
				
				chmod("$filename",0777);
				//echo $filename;die;
			}
			unlink($file);  					
		} else { 	$status[0] = "error_cmod";	}	
	}
	
}	
return $status;

}

//Function Delete File
function del_file($temp){
	if(file_exists($temp)){ unlink($temp); }
}

//Function check file exist
function chk_file($file_name, $folder){
	if(file_exists($folder.$file_name)){ 
		
		$f 				= explode(".", $file_name);
		$f_name 	= $f[0];	
		$f_ext 		= $f[1];		

		//find number in () 
		$f_otag 		= (strrpos($f[0], "(") + 1);	
		$f_ctag 		= (strrpos($f[0], ")") - $f_otag) ;		
		$f_num		= substr($f_name, $f_otag, $f_ctag);
		
		//if is number just increse it 		
		if(is_numeric($f_num)){ 	
			$filename 	= substr($f[0],0, strrpos($f[0], "("))."(".($f_num + 1).").".$f[1];					
		} else { 
			$filename 	= $f[0]."(1).".$f[1]; 
		}
		
	} else {	 
			$filename 		= $file_name; 
	}
		
return $filename;	
}

//Status of Uploading
function upload_status($temp){
global $height;
global $width;
$button 		= "<hr size=\"1\"><button name=\"button\" style=\"width:90px;\" onClick=\"history.go(-1);\">Back</button>";
$width 		= (!isset($width) || $width == "") ? 801 : $width ; 
$height 		= (!isset($height) || $height == "") ? 801 : $height ; 

	if($temp == "error_scale"){	
		$msg = "<br><b class=\"warn\">Error</b> : ��Ҵ�ͧ�Ҿ�Թ�ҡ����˹����<br>��Ҵ�ٻ�Ҿ��ͧ����Թ $height x $width<br>";		
	} elseif($temp == "error_img") 	{	
		$msg = "<br><b class=\"warn\">Error</b><br>�ٻẺ�ͧ file ���١��ͧ<br>�ٻ�Ҿ��ͧ�չ��ʡ���� jpg, jpeg ��� gif ��ҹ��<br>";		
	} elseif($temp == "error_type") 	{	
		$msg = "<br><b class=\"warn\">Error</b><br>�ٻẺ�ͧ file ������������١��ͧ<br>";		
	} elseif($temp == "error_size") 	{	
		$msg = "<br><b class=warn>Error</b><br>�ٻ��Ҵ�ͧ file �ҡ���ҷ���к���˹�<br>����ͧ�բ�Ҵ����Թ 800 Kilo Bytes<br>";
	} elseif($temp == "error_upload") {	
		$msg = "<br><b class=\"warn\">Warning</b><br>����ͼԴ��Ҵ㹡�� Upload ��������к�<br>�ô�Դ��ͼ�����<br>";			
	} elseif($temp == "error_cmod")	{	
		$msg = "<br><b class=\"warn\">Warning</b><br>����ͼԴ��Ҵ㹡�� Upload ��������к�<br>�ô��Ǩ�ͺ CHMOD �ͧ Folder<br>";				
	} elseif($temp == "error_doc"){	
		$msg = "<br><b class=\"warn\">Warning</b><br>�ٻẺ������١��ͧ<br>�͡��õ�ͧ�չ��ʡ���� doc, xls ��� pdf ��ҹ��<br>";			
	} 
$msg	 = ($msg != "") ? $msg.$button : "" ;
return $msg;
}


//Random Generater
function random($length){
	
	$template = "1234567890abcdefghijklmnopqrstuvwxyz";  
    
	settype($length, "integer");
    settype($rndstring, "string");
    settype($a, "integer");
    settype($b, "integer");
      
    for ($a = 0; $a <= $length; $a++) {
    	$b = mt_rand(0, strlen($template) - 1);
        $rndstring .= $template[$b];
    }
       
    return $rndstring;
}

// function ������ʴ���������´��ҧ � �ͧ files ���зӡ�� upload
function getFileExtension($str) 
{
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
	$ext = strtolower($ext);		
    return $ext;
}

## function �Ѻ�ӹǹ �͡��� �.�.7 #################   credit  by ������ #################################3
function count_page($idcard,$siteid) {
		
		$file = "../../../checklist_kp7file/$siteid/$idcard.pdf";
		//echo "<a href='$file'>$file</a>";die;
        if(file_exists($file)) { 

            //open the file for reading 
            if($handle = @fopen($file, "rb")) { 
                $count = 0; 
                $i=0; 
                while (!feof($handle)) { 
                    if($i > 0) { 
                        $contents .= fread($handle,8152); 
                    } 
                    else { 
                          $contents = fread($handle, 1000); 
                        //In some pdf files, there is an N tag containing the number of 
                        //of pages. This doesn't seem to be a result of the PDF version. 
                        //Saves reading the whole file. 
                        if(preg_match("/\/N\s+([0-9]+)/", $contents, $found)) { 
                            return $found[1]; 
                        } 
                    } 
                    $i++; 
                } 
                fclose($handle); 
  
  	//echo "numpage ";die;
                //get all the trees with 'pages' and 'count'. the biggest number 
                //is the total number of pages, if we couldn't find the /N switch above.                 
                if(preg_match_all("/\/Type\s*\/Pages\s*.*\s*\/Count\s+([0-9]+)/", $contents, $capture, PREG_SET_ORDER)) { 
//				echo "<pre>aaa<br>";
//				print_r($capture);
//				die;
                    foreach($capture as $c) { 
                        if($c[1] > $count) 
                            $count = $c[1]; 
                    } 
                    return $count;             
                } 
            } 
        } 
        return 0; 
}

###  end function  �Ѻ�ӹǹ˹��

require_once('fpdi/fpdf.php');
require_once('fpdi/FPDI_Protection.php');
### function �Ѻ�ӹǹ˹�� pdf by ������
function CountPageSystem($pathfile){
	$pdf =& new FPDI_Protection();
	$pagecount = $pdf->setSourceFile($pathfile);
	return $pagecount;
}
### end function CountPageSystem($pathfile){
	
function RmkDirPath($path,$mode = 0777){
	$exp=explode("/",$path);
	$way='';
	foreach($exp as $n){
	$way.=$n.'/';
	if(!file_exists($way))
	mkdir($way);
	}
}
	

## funciton copyfile �ҡ checklist_kp7file ������ kp7file
function CopyKp7File($get_idcard,$path_s,$path_d){
	if(!is_dir($path_d)){
		RmkDirPath($path_d);
	}
	$file_source = $path_s.$get_idcard.".pdf";
	$file_dest = $path_d.$get_idcard.".pdf";
	if(copy($file_source,$file_dest)){
		chmod("$file_dest",0777);
		$copy_status = "1";	
	}else{
		$copy_status = "0";	
	}
	return $copy_status;
}//end function CopyKp7File($get_idcard,$path_s,$path_d){
	
### ��Ǩ�ͺ fied ���й����
function CheckField($secid,$xfield){
		$sql_check = "SELECT COUNT(secid) AS  num_field  FROM tbl_status_field_import WHERE secid='$secid'  AND $xfield='1'";
		$result_check =mysql_db_query("edubkk_checklist",$sql_check);
		$rs_ch = mysql_fetch_assoc($result_check);
		return $rs_ch[num_field];
}//end 	function check_field($xfield){

## funciton �� ���ʤӹ�˹�Ҫ���
function GetPrenameId($get_prename){
	global $dbnamemaster;
	$sql = "SELECT sex,gender,PN_CODE FROM prename_th WHERE prename='$get_prename' or prename_th='$get_prename'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	$arrG['sex'] = $rs[sex];
	$arrG['gender'] = $rs[gender];
	$arrG['PN_CODE'] = $rs[PN_CODE];
	return $arrG;
}//end function GetPrenameId(){
## end funnction �� ���ʤӹ�˹�Ҫ���
###  function �����ʵ��˹�
function GetPositionId($get_position){
	global $dbnamemaster;		
	$sql = " SELECT * FROM hr_addposition_now WHERE position='$get_position'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	$arrP['pid'] = $rs[pid];
	$arrP['Gpid'] = substr($rs[pid],0,1);
	return $arrP;
}
### end function �����ʵ��˹�
###  function ��Ǩ�ͺ��Ң������ࢵ�����������������
function CheckDataInDb($get_siteid,$get_idcard){
	$db_site = "cmss_$get_siteid";
	$sql = "SELECT COUNT(id) AS num FROM general WHERE id='$get_idcard'";
	$result = mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num];
}//end function CheckDataInDb($get_siteid,$get_idcard)

#############  function 㹡�õ�Ǩ�ͺ������ç��ûշ������
function CheckDataOldYear($get_idcard){
	global $dbname_temp,$config_yy;
	//$tblyy = substr((date("Y")+543),-2);
	$tbl = "tbl_check_data".$config_yy;
	$sql = "SELECT count(idcard) as num1 FROM $tbl WHERE idcard='$get_idcard'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function CheckDataOldYear($get_idcard){

## �ѧ����㹡�õ�Ǩ�ͺ���� tbl_check_data �������������
function CheckDataTable($get_idcard,$profile_id=""){
	global $dbname_temp;
			if($profile_id == ""){
				$profile_id =  LastProfile();
		}

	$sql = "SELECT COUNT(idcard) AS NUM1 FROM tbl_check_data WHERE idcard='$get_idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[NUM1];
	
}//end function CheckDataTable(){
	
###  �ѧ���蹵�Ǩ�ͺࢵ�鹷ҧ�������¢������ҡó�����ࢵ���
function CheckDataListOld($getsiteid,$get_idcard){
	$db_site = "cmss_$getsiteid";
	$sql = "SELECT COUNT(id) AS numList FROM general WHERE id='$get_idcard'";
	$result= mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numList];
	
}//end function CheckDataListOld(){
	
###  �ѧ���蹵�Ǩ�ͺ ��ù���Ң�����
function CheckImportData($get_siteid,$profile_id=""){
	$db_site = "cmss_$get_siteid";
			if($profile_id == ""){
				$profile_id =  LastProfile();
		}

	$sql = "SELECT
Count(edubkk_checklist.tbl_check_data.idcard) AS NumAll,
sum(if(edubkk_checklist.tbl_check_data.status_id_replace = '1',1,0)) as TranferIn,
sum(if(edubkk_checklist.tbl_check_data.status_id_replace = '0',1,0)) as InSite
FROM
edubkk_checklist.tbl_check_data
Inner Join $db_site.general ON edubkk_checklist.tbl_check_data.idcard = $db_site.general.idcard
WHERE edubkk_checklist.tbl_check_data.secid='$get_siteid' and edubkk_checklist.tbl_check_data.profile_id='$profile_id'";
	$result = mysql_db_query($db_site,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['NumAll'] = $rs[NumAll];
	$arr['TranferIn'] = $rs[TranferIn];
	$arr['InSite'] = $rs[InSite];
	return $arr;
		
}//end function CheckImportData($get_siteid){
	
## �ѧ���� ��Ǩ�ͺ��͹ ����Ң�����
function CheckBeforImport($xsiteid,$profile_id=""){
	global $dbname_temp;
		if($profile_id == ""){
				$profile_id =  LastProfile();
		}
	$sql = "SELECT count(schoolid) as num_school FROM tbl_checklist_kp7 WHERE  (siteid = '$xsiteid') and (schoolid='0' or schoolid IS NULL or schoolid ='') and profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
		if($rs[num_school] > 0){
			$result1 = 1;
		}else{
			$result1 = 0;	
		}
	
	return $result1;
}//end function CheckBeforImport($get_siteid){
	
### �ѧ���蹹Ѻ�ӹǹ�ٻ�������к���ԧ<br />
function CountPicSys($get_siteid,$get_schoolid="",$get_idcard="",$profile_id){
	$db_site = "cmss_$get_siteid";
			if($profile_id == ""){
				$profile_id =  LastProfile();
		}
	
	if($get_schoolid != ""){
		$conv = " AND  edubkk_checklist.tbl_checklist_kp7.schoolid ='$get_schoolid' AND edubkk_checklist.tbl_checklist_kp7.profile_id='$profile_id'";
	}
	if($get_idcard != ""){
		$conp = " AND  edubkk_checklist.tbl_checklist_kp7.idcard='$get_idcard' and edubkk_checklist.tbl_checklist_kp7.profile_id='$profile_id'";
	}
	
	
	$sql = "SELECT
Count($db_site.general_pic.id) AS num1
FROM
edubkk_checklist.tbl_checklist_kp7
Inner Join $db_site.general_pic ON edubkk_checklist.tbl_checklist_kp7.idcard = $db_site.general_pic.id
WHERE
edubkk_checklist.tbl_checklist_kp7.siteid =  '$get_siteid' $conv  $conp";
$result = mysql_db_query($db_site,$sql);
$rs = mysql_fetch_assoc($result);
return $rs[num1];
		
}// end function CountPicSys($get_siteid,$get_schoolid=""){
## end �ѧ���� ��Ǩ�ͺ��͹ ����Ң�����

### function �Ѻ�ӹǹ��¡�úؤŷ��ӡ�õѴ�ҡࢵ������������㹶ѧ��ҧ���ͧ�ҡ�Ҩ���ա�������ࢵ������͢������Ţ�ѵ������㹰ҹ������ Checklikst ���й����Ң�����
	function CountDataCenter($get_siteid){
		global $dbnamemaster;
		$sql_c = "SELECT COUNT(idcard) as num_id FROM temp_general WHERE siteid='$get_siteid'" ;
		$result_c = mysql_db_query($dbnamemaster,$sql_c);
		$rs_c = mysql_fetch_assoc($result_c);
		return $rs_c[num_id];
	}///end function CountDataCenter($get_siteid){
		
####  funciton �ʴ�����������ش
function LastProfile(){
	global $dbname_temp;
		$sql_profile = "SELECT * FROM tbl_checklist_profile WHERE status_active ='1' ORDER BY profile_date DESC LIMIT 0,1";
		$result_profile = mysql_db_query($dbname_temp,$sql_profile);
		$rspro = mysql_fetch_assoc($result_profile);
		$profile_id = $rspro[profile_id];
		return $profile_id;

}//end function LastProfile(){
	
###  �ʴ�����������
function ShowProfile_name($profile_id){
	global $dbname_temp;
	$sqlp = "SELECT profilename FROM tbl_checklist_profile WHERE profile_id='$profile_id'";
	$resultp = mysql_db_query($dbname_temp,$sqlp);
	$rsp = mysql_fetch_assoc($resultp);
	return $rsp[profilename];
}
######################################  ������������ش
if($profile_id == ""){// �ó���������͡���� ������
	$profile_id = LastProfile();
}//end if($profile_id == ""){// �ó���������͡���� ������

##########   function �红�����˹��§ҹ������㹡�÷Ӻѭ�դ��
	function SaveTempOrderSchool($get_schoolid,$get_siteid,$get_order){
		global $dbname_temp;
		$sql = "REPLACE INTO temp_order_school SET schoolid='$get_schoolid', siteid='$get_siteid', orderby='$get_order'";
		$result = mysql_db_query($dbname_temp,$sql);
	}//end 	function SaveTempOrderSchool(){
		
			### function ��Ǩ�ͺ field owner _sys ������������
	function AlterField($get_dbsite,$get_tblname,$get_field){
			$sql = "SHOW FIELDS FROM $get_tblname WHERE Field='$get_field'";
			$result = mysql_db_query($get_dbsite,$sql);
			$numF = @mysql_num_rows($result);
			if($numF < 1){
				$sql_alter = "ALTER TABLE $get_tblname  ADD ( $get_field varchar(20) )";
				@mysql_db_query($get_dbsite,$sql_alter);	
			}//end if($numF < 1){
	}//end function AlterField(){

	function AddLogPicToCmss($get_idcard,$get_no,$get_siteid){
			global $dbname_temp;
			$ip_import = get_real_ip();
			$sql_log = "INSERT INTO log_importpic_to_cmss(idcard,no,siteid,import_staffid,ip_import)VALUES('$get_idcard','$get_no','$get_siteid','".$_SESSION[session_staffid]."','$ip_import')";
			mysql_db_query($dbname_temp,$sql_log);
	}//end function AddLogPicToCmss(){
		
	###  function 㹡�ùӢ������ٻ�ҡ����� checklist ������ cmss  ���ҧ upload_general_pic
	function ImportPicToCmss($get_siteid,$get_idcard){
		global $dbname_temp;
		$path_sorece = "../../../temp_image_kp7/$get_siteid/";
		$path_dest = "../../../image_file/$get_siteid/";
		$db_site = "cmss_$get_siteid";
		$sql = "SELECT * FROM upload_general_pic WHERE id='$get_idcard' AND site='$get_siteid' AND approve_status='uncomplete' AND cmss_entry='no'";
		$result = mysql_db_query($dbname_temp,$sql);
		$num_r = @mysql_num_rows($result);
		if($num_r > 0){ // ��Ǩ�ͺ ��ճ�բ������ temp 	��͹�ӡ��ź
			### �ӡ��ź�������ٻ��͹�ӡ�ù����Ң�����
			$sql_del = "DELETE FROM general_pic WHERE id='$get_idcard'";
			mysql_db_query($db_site,$sql_del);
			###  end �ӡ��ź�������ٻ��͹�ӡ�ù����Ң�����
		}// end if($num_r > 0){
		while($rs = mysql_fetch_assoc($result)){
			if($rs[imgname] != ""){
					$file_sorece = $path_sorece.$rs[imgname];
					$file_dest = $path_dest.$rs[imgname];
					###  �Ѵ�ͧ���
					if(copy($file_sorece,$file_dest)){
						@chmod("$file_dest",0777);
						$sql_insert = "INSERT INOT general_pic SET id='$rs[id]', no='$rs[no]', imgname='$rs[imgname]',  yy='$rs[yy]', img_owner='$rs[img_owner]' ";
						@mysql_db_query($db_site,$sql_insert);
						// update ʶҹС�� upload
						$sql_update = "UPDATE upload_general_pic SET cmss_entry='yes'  WHERE id='$rs[id]' AND no='$rs[no]'";
						@mysql_db_query($db_site,$sql_update);
						AddLogPicToCmss($rs[id],$rs[no],$get_siteid);// ���� log ��ù���Ң����ż�ҹ�к� checklist
					}//end if(copy($file_sorece,$file_dest)){
			}//end if($rs[imgname] != ""){
		}//end 	while($rs = mysql_fetch_assoc($result)){	
	}//end function ImportPicToCmss($get_siteid,$get_idcard){


	function CheckMonitorKey($get_idcard){
		global $dbcallcenter_entry;
		$sql = "SELECT count(idcard) as numid  FROM monitor_keyin where idcard='$get_idcard' group by idcard";
		$result = mysql_db_query($dbcallcenter_entry,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[numid];
	}//end function CheckMonitorKey($get_idcard){
		
		##  function �ʴ�˹��§ҹ � pobec
function ShowOrgInPobec($get_site,$get_idcard){
		global $db_temp_pobec;
		$tbl_pobec = "pobec_".$get_site;
		$tbl_school = "school_".$get_site;
		$sql_pobec = "SELECT
$tbl_school.S_NAME
FROM
$tbl_pobec
Inner Join $tbl_school ON $tbl_pobec.I_CODE = $tbl_school.I_CODE
WHERE
$tbl_pobec.IDCODE =  '$get_idcard'";
//echo $db_temp_pobec.":: ".$sql_pobec;
$result_pobec = mysql_db_query($db_temp_pobec,$sql_pobec);
$rs_pobec  = mysql_fetch_assoc($result_pobec);
		
return $rs_pobec[S_NAME];
}//end function ShowOrgInPobec(){
	
		$dbname_temp = "edubkk_checklist";
	
	$month = array("","���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");
function ShowDateProfile($get_profile){
	global $dbname_temp,$month;
	$sql = "SELECT * FROM tbl_checklist_profile WHERE profile_id='$get_profile'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
		if($rs[profile_date] != "" and $rs[profile_date] != "0000-00-00"){
			$arr = explode("-",$rs[profile_date]);
			return "(������ � �ѹ��� ".intval($arr[2])." ".$month[intval($arr[1])]." ".($arr[0]+543).")";
		}else{
			return $rs[profilename];	
		}

		
}//end function ShowDateProfile(){
	
$mname	= array("","���Ҥ�", "����Ҿѹ��", "�չҤ�", "����¹", "����Ҥ�", "�Զع�¹", "�á�Ҥ�", "�ԧ�Ҥ�", "�ѹ��¹", "���Ҥ�", "��Ȩԡ�¹", "�ѹ�Ҥ�");

				function thai_date($temp){
				global $mname;
				if($temp != "0000-00-00"){
					$x = explode("-",$temp);
					$m1 = $mname[intval($x[1])];
					if($x[0] > 2500){
							$y1 = intval($x[0]);
					}else{
						$y1 = intval($x[0]+543);
					}//end if($x[0] > 2500){
					$xrs = intval($x[2])." $m1 "." $y1 ";
				}else{
					$xrs = "";	
				}
				return $xrs;
			}
######################  �Ѻ�ӹǹࢵ��鹷��� profile ���
function CountAreaProfile($profile_id){
	global $dbnamemaster;
	$sql = "SELECT
count(secid) as numsite
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata' AND
eduarea_config.profile_id =  '$profile_id'
group by group_type";
	$result = mysql_db_query($dbnamemaster);
	$rs = mysql_fetch_assoc($result);
	return $rs[numsite];
}//end function CountAreaProfile($profile_id){

function CountSchool($siteid){
	global $dbnamemaster;
	$sql = "SELECT count(id) as num1 FROM `allschool` where siteid='$siteid'";
	$result = mysql_db_query($dbnamemaster,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end 

##############  function �Ѻ�ӹǹ�͡��÷���ͺ���§ҹ����Ѻ��� �᡹�͡���
function CountAssignScan(){
	global $dbname_temp,$profile_id;
	$sql = "SELECT count(ticketid) as numid, staffid  FROM `tbl_checklist_assign` WHERE  profile_id='$profile_id'  GROUP BY staffid";
	//echo $sql." :: ".$dbname_temp;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffid]] = $rs[numid];
	}//end while($rs = mysql_fetch_assoc($result)){	
	return $arr;
}//end function CountAssignScan(){
	
###########  �Ѻ�ӹǹ�͡��âͧ㺧ҹ
function CountScanDetail($staffid){
	global $dbname_temp,$profile_id;
	$sql = "SELECT
Count(idcard) AS NUM1,
tbl_checklist_assign_detail.idcard,
tbl_checklist_assign.ticketid
FROM
tbl_checklist_assign
Inner Join tbl_checklist_assign_detail ON tbl_checklist_assign.ticketid = tbl_checklist_assign_detail.ticketid
WHERE tbl_checklist_assign.profile_id='$profile_id' AND staffid='$staffid' group by tbl_checklist_assign.ticketid";
	//echo "$dbname_temp :: ".$sql;
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[ticketid]] = $rs[NUM1];
	}
	return $arr;	
}//end function CountScanDetail(){
	
	####  function �ʴ� icon ����ͺ���§ҹ
function ShowIconAssign($status_approve){
		if($status_approve == "1"){
				$xicon = "<img src=\"../userentry/images/greendot.gif\" width=\"20\" height=\"17\" border='0' title='ʶҹ����ͺ�ҹ���º��������'>";
		}else if($status_approve == "0"){
				$xicon = "<img src=\"../userentry/images/yellowdot.gif\" width=\"20\" height=\"17\" border='0' title='���������ҧ���Թ���'>";
		}else if($status_approve == "2"){
				$xicon = "<img src=\"../userentry/images/reddot.gif\" width=\"20\" height=\"17\" border='0' title='ʶҹ��͡��������'>";	
		}else{
				$xicon = "<img src=\"../userentry/images/yellowdot.gif\" width=\"20\" height=\"17\" border='0' title='���������ҧ���Թ���'>";
		}
		
		
	return $xicon;
}//end function ShowIconAssign(){
	
##########  �ӹǹ���͡�����¤�
function CountPagePerPerson($ticketid,$profile_id){
		global $dbname_temp;
		$sql = "SELECT
tbl_checklist_assign_detail.idcard,
tbl_checklist_kp7.page_num
FROM
tbl_checklist_assign_detail
Inner Join tbl_checklist_kp7 ON tbl_checklist_assign_detail.idcard = tbl_checklist_kp7.idcard
WHERE
tbl_checklist_assign_detail.ticketid =  '$ticketid' AND
tbl_checklist_assign_detail.profile_id =  '$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr[$rs[idcard]] = $rs[page_num];
	}//end while($rs = mysql_fetch_assoc($result)){ 
	return $arr;
}//end function CountPagePerPerson(){
	
###########  �Ѻ�ӹǹ�ش�����㺧ҹ

function CountTicketDetail($ticketid){
	global $dbname_temp,$profile_id;
	$sql = "SELECT
Count(idcard) AS NUM1
FROM
tbl_checklist_assign
Inner Join tbl_checklist_assign_detail ON tbl_checklist_assign.ticketid = tbl_checklist_assign_detail.ticketid
WHERE tbl_checklist_assign.ticketid='$ticketid' AND tbl_checklist_assign.profile_id='$profile_id' group by tbl_checklist_assign.ticketid";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[NUM1];
}

#################  �ʴ����������´�ͧ�ؤ�ҡ�� checklist
function ShowPersonDetail($idcard){
	global $dbname_temp,$profile_id,$xyear;
	$sql = "SELECT idcard,position_now,schoolid,(TIMESTAMPDIFF(MONTH,tbl_checklist_kp7.begindate,'$xyear')/12) as age_gov FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	//echo $sql;
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['schoolid'] = show_school($rs[schoolid]);
	$arr['position_now'] =  $rs[position_now];
	$arr['age_gov'] = $rs[age_gov];
	return $arr;
}//end function ShowPersonDetail(){
	
	
	
?>