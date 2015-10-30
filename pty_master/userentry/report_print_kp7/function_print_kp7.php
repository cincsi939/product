<?
	$db_name ="edubkk_userentry"  ;
$dbnamemaster="edubkk_master";
$dbsystem = "edubkk_system";
$dbnameuse = $db_name;
$base_point = 240;
$base_point_pm = 120;
$point_w = 0.5; // ค่าคะแนนที่คิดเป็นเงิน
$numdoc = 3;// ค่าเฉลี่ยในการคูณจำนวณชุดที่ผิด
$val5 = 5;// ค่าคะแนนคูณ 5 ในตำแหน่งสายบริหารการศึกษา
$date_checkkey = "2552-10-01"; // ข้อมูล ณ วันที่ 
$dbnameuse = "edubkk_userentry";
$db_temp = "edubkk_checklist";
$length_var = 7;
$structure_key =10;
$keydata_key = 20;
$pathkp7file = "../../../edubkk_kp7file/";
$DayOfWeek = 6;// จำนวนวันในรอบสัปดาห์
$numFixkey = 35; // ถ้าไม่มีให้ค่าเฉลี่ยอยู่ที่ 35  ชุดต่อสัปดาห์
$DayOfKey = 5; // ห้าชุดต่อสัปดาห์
$percenP = 10;
$maxWait = 20;
//$ratio_t1 = 1;
//$ratio_t2 = 0.5;
$ratio_t1 = 1; // การคำนวณจุดผิดต่อหนึ่งจุดการตรวจพบ
$ratio_t2 = 1; //  การคำนวณจุดผิดต่อหนึ่งจุดการตรวจพบ
$activity1 = 3;// กิจกรรมมอบหมายงานคีย์
$ratio_n = 3; // อัตราส่วนของกลุ่ม N
$ratio_l = 20;// อัตราส่วนของกลุ่ม N และกลุ่ม L


$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

function GetThaiDateTime($d){
	global $monthFull;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	if ($d == "0000-00-00 00:00:00") return "";
	
	$xd=explode(" ",$d);

	$d1=explode("-",$xd[0]);
	return intval($d1[2]) . " " . $monthFull[intval($d1[1])] . " " . (intval($d1[0]) + 543)  . " เวลา " . $xd[1];
}// END function GetThaiDateTime($d){


	
##### function ตรวจสอบการหาค่าคะแนนความซับซ้อน ###########
function CheckDataHidden($staffid,$flag_qc){
	global $dbnameuse;
		$sql_check = "SELECT count(distinct idcard) as num1 FROM stat_user_keyperson WHERE staffid='$staffid' and   (hidden_point='' OR hidden_point IS NULL) and flag_qc='$flag_qc' AND flag_qc > 0 and status_approve='1'  GROUP BY flag_qc ";
		$result_check = mysql_db_query($dbnameuse,$sql_check) or die(mysql_error()."$sql_check<br>LINE__".__LINE__);
		$rsc = mysql_fetch_assoc($result_check);
		return $rsc[num1];
}//end function CheckDataHidden($staffid,$flag_qc){
	
	
	
	function CalHiddenPersonPointFlag($get_staffid,$get_flagid){
	global $dbnameuse,$dbnamemaster,$val5;
	$year1 = (date("Y")+543)."-09-30";
	$sql = "SELECT
stat_user_keyperson.idcard,
monitor_keyin.siteid,
stat_user_keyperson.datekeyin,
stat_user_keyperson.staffid
FROM
stat_user_keyperson
Inner Join monitor_keyin ON stat_user_keyperson.idcard = monitor_keyin.idcard AND stat_user_keyperson.staffid = monitor_keyin.staffid
WHERE (hidden_point IS NULL OR hidden_point = '') AND stat_user_keyperson.status_approve='1' and stat_user_keyperson.flag_qc='$get_flagid' AND stat_user_keyperson.staffid='$get_staffid'
ORDER BY datekeyin ASC";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$db_site = STR_PREFIX_DB.$rs[siteid];
		
		$sql_position1 = "SELECT count(id) as numid, position_id FROM `salary` where id='$rs[idcard]' and position_id LIKE '1%'  group by position_id;";
		$result_position1 = mysql_db_query($db_site,$sql_position1);
		$rs_position1 = mysql_fetch_assoc($result_position1);
		$position_value = intval($rs_position1[numid]) * $val5;

		##########################  ค่าคะแนนความซับซ้อน
		$sqlsum = "SELECT
sum(if($dbnamemaster.hr_order_type.hidden_point IS NULL ,5,$dbnamemaster.hr_order_type.hidden_point)) as numk
FROM
$db_site.salary
Left Join $dbnamemaster.hr_order_type ON $db_site.salary.order_type = $dbnamemaster.hr_order_type.id
WHERE
$db_site.salary.id =  '$rs[idcard]'";
	$resultsum = mysql_db_query($db_site,$sqlsum);
	$rs_sum = mysql_fetch_assoc($resultsum);
		### อายุราชการ
	$sqlage = "SELECT FLOOR((TIMESTAMPDIFF(MONTH,begindate,'$year1')/12)) as age_gov  FROM `general` where id='$rs[idcard]';";
	$resultage = mysql_db_query($db_site,$sqlage);
	$rsage = mysql_fetch_assoc($resultage);
	$hpoint = $rs_sum[numk]+$position_value;
	####  update ค่าคะแนนความยาก
	$sql_update = "UPDATE stat_user_keyperson SET hidden_point='$hpoint', age_point='$rsage[age_gov]' WHERE datekeyin='$rs[datekeyin]' AND staffid='$rs[staffid]' AND idcard='$rs[idcard]'";
	mysql_db_query($dbnameuse,$sql_update);
		
	}//end while($rs = mysql_fetch_assoc($result)){
}//end function CalHiddenPersonPoint($get_staffid){
	
###########  function update random qc
function UpdateFlag_Randomqc($datekeyin,$staffid,$idcard,$flag_qc){
	global $dbnameuse;
	$sql = " SELECT COUNT(*) AS num1 FROM stat_user_keyperson WHERE flag_qc='$flag_qc' and staffid='$staffid' and status_random_flag='1' GROUP BY staffid";
	$result = mysql_db_query($dbnameuse,$sql)or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	if($rs[num1] < 1){
			$sql_up = "UPDATE stat_user_keyperson SET status_random_flag='1'  WHERE  datekeyin='$datekeyin' AND staffid='$staffid' AND idcard='$idcard' AND flag_qc='$flag_qc'";	
			mysql_db_query($dbnameuse,$sql_up) or die(mysql_error()."$sql_up<br>LINE::".__LINE__);
	}//end if($rs[num1] < 1){
	
}//end function UpdateFlag_Randomqc($datekeyin,$staffid,$idcard,$flag_qc){
	
	
			
	#### เก็บ Log การปริ้นเอกสาร	
	function SaveLogPrintKp7($idcard,$staffid,$datekqc,$flag_qc,$subject,$action){
		global $dbnameuse;
		$ip = GET_IPADDRESS();// get ip	
		$staffid = $_SESSION['session_staffid'];
		$sql_insert = "INSERT INTO tbl_person_print_kp7_log SET idcard='$idcard',staffid='$staffid',datekqc='$datekqc',flag_qc='$flag_qc',staff_print='$staffid',ip_server='$ip',subject='$subject',action='$action'";
		$result_insert = mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE__".__LINE__);
	}//end function SaveLogPrintKp7(){
	


### ตรวจสอบเอกสารก่อนทำการ insert
function GetNumDoc($idcard,$staffid,$datekqc){
		global $dbnameuse;
		$sql = "SELECT COUNT(idcard) as num1 FROM  tbl_person_print_kp7 WHERE idcard='$idcard' AND staffid='$staffid'  AND datekqc='$datekqc'";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}//end function GetNumDoc(){

## เพิ่มข้อมูลที่จะปริ้นเอกสาร ก.พ.7
function Insertkp7Print($idcard,$staffid,$datekqc,$flag_qc){
		global $dbnameuse;
		$sql = "REPLACE INTO tbl_person_print_kp7 SET idcard='$idcard',staffid='$staffid',datekqc='$datekqc',flag_qc='$flag_qc'";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
}//end function Insertkp7Print($idcard,$siteid,$staffid,$datekqc,$flag_qc){
			
function GetDataPrint($yymm,$staffid=""){
	global $dbnameuse,$ratio_n,$ratio_l;
	if($staffid != ""){
		$constaff = " AND staffid='$staffid'";
	}else{
		$constaff = " ";	
	}
	
	$sql = "SELECT flag_id, staffid  FROM  stat_user_person_temp WHERE dateqc LIKE '$yymm%' and qc_pass='0' and  (num_doc='$ratio_n' OR num_doc='$ratio_l') $constaff";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
		if(CheckDataHidden($rs[staffid],$rs[flag_id]) > 0){
			CalHiddenPersonPointFlag($rs[staffid],$rs[flag_id]); //คำนวณหาค่าคะแนนความซับซ้อนของข้อมูลที่ใช้ในการคีย์
		}// end if(CheckDataHidden($rs[staffid],$rs[flag_id]) > 0){
		$sql1 = "SELECT t1.datekeyin, t1.staffid, t1.idcard, t1.status_random_flag FROM stat_user_keyperson as t1 WHERE t1.flag_qc = '$rs[flag_id]' AND t1.staffid = '$rs[staffid]'
group by t1.idcard ORDER BY t1.status_random_qc DESC, t1.status_random_flag DESC , t1.hidden_point DESC ,t1.age_point DESC LIMIT 1";
		$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
		$rs1 = mysql_fetch_assoc($result1);
			UpdateFlag_Randomqc($rs1[datekeyin],$rs1[staffid],$rs1[idcard],$rs[flag_id]);
			if(GetNumDoc($rs1[idcard],$rs1[staffid],$rs1[datekeyin]) < 1){
				 Insertkp7Print($rs1[idcard],$rs1[staffid],$rs1[datekeyin],$rs[flag_id]); // เพิ่มข้อมูลก่อนทำการปริ้นเอกสาร QC	
			}//end if(GetNumDoc($idcard,$siteid,$staffid,$datekqc) < 1){
			
		#########################  เก็บข้อมูลลงในตาราง temp_print ###########################
	}// end 	while($rs = mysql_fetch_assoc($result)){
}//end function GetDataPrint($yymm){
	

############  update กรณีเอกสารนั้นได้ทำการปริ้นไปแล้ว ######################################
function UpdateFlagPrintKp7($idcard,$staffid,$datekqc){
	global $dbnameuse;
	$sql = "UPDATE tbl_person_print_kp7 SET status_print='1',timeprint=NOW() WHERE idcard='$idcard' AND staffid='$staffid' AND datekqc='$datekqc' ";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
}//end function UpdateFlagPrintKp7(){


############  funciton ในการหาพนักงานคีย์ข้อมูลกับพนักงาน QC
function GetQcMathkey($staffqc){
	global $dbnameuse;
	$sql = "SELECT
t1.staffkey
FROM  keystaff_qc_math_key as t1
WHERE t1.staffqc='$staffqc'";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			if($in_staff > "") $in_staff .= ",";
			$in_staff .= "'$rs[staffkey]'";
	}//end while($rs = mysql_fetch_assoc($result)){
		return $in_staff;
}//end function GetQcMathkey(){
	
#######################  function get staff ##############################
function GetStaff($staffid){
	global $dbnameuse;
	$sql = "SELECT
t1.staffid,
t1.prename,
t1.staffname,
t1.staffsurname,
t1.card_id,
t2.groupname
FROM
keystaff as t1
Inner Join keystaff_group as t2 ON t1.keyin_group = t2.groupkey_id
where t1.staffid='$staffid'";
$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
$rs = mysql_fetch_assoc($result);
	$arr['fullname'] = "$rs[prename]$rs[staffname] $rs[staffsurname]";
	$arr['groupname']  = $rs[groupname];
	$arr['pin'] = $rs[card_id];
	return $arr;
}//end function GetStaff($staffid){
	
############  function แสดงพนักงาน QC
function GetStaffQc(){
		global $dbnameuse;
		$sql = "SELECT
t1.staffqc,
t2.prename,
t2.staffname,
t2.staffsurname
FROM
keystaff_qc_math_key as t1
Inner Join keystaff  as t2 ON t1.staffqc = t2.staffid
group by t1.staffqc";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[staffqc]] = "$rs[prename]$rs[staffname] $rs[staffsurname]";
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function GetStaffQc($staffid){
	
######################  function ดึงจำนวน ########################

function GetPersonKeyGroupN1To1($yymm=""){
	global $dbnameuse;
	if($yymm != ""){
			$conv = " AND date(t3.timeupdate) LIKE '$yymm%'";
	}
	$sql = "SELECT t1.staffid,t1.keyin_group FROM keystaff as t1 WHERE  (t1.keyin_group='3' or t1.keyin_group='4') AND t1.status_permit='YES'   AND t1.ratio_id='1' ";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
	$sql1 = "SELECT
date(t3.timeupdate) as datekey,
t1.idcard,
t1.siteid,
t3.staffid
FROM
tbl_assign_key as t1
Inner Join tbl_assign_sub as t2 ON t1.ticketid = t2.ticketid
Inner Join monitor_keyin as t3 ON t1.idcard = t3.idcard AND t2.staffid = t3.staffid
left Join stat_user_keyperson_groupn1_1 as t4  ON t1.idcard=t4.idcard and t2.staffid=t4.staffid 
where t3.staffid='$rs[staffid]' and t1.userkey_wait_approve='1' and t4.idcard IS NULL $conv";	
	$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE__".__LINE__);
	while($rs1 = mysql_fetch_assoc($result1)){
		$sql_insert = "REPLACE INTO stat_user_keyperson_groupn1_1 SET datekeyin='$rs1[datekey]',staffid='$rs1[staffid]',idcard='$rs1[idcard]',status_approve='1',keyin_group='$rs[keyin_group]',rpoint='1'";
		mysql_db_query($dbnameuse,$sql_insert) or die(mysql_error()."$sql_insert<br>LINE__".__LINE__);
			
	}//end 	while($rs1 = mysql_fetch_assoc($result1)){
		
	}//end while($rs = mysql_fetch_assoc($result)){
}//end function GetPersonKeyGroupN1To1(){
	
####################### function ในการ mark สถานะชุดที่ทำการ qc แล้ว ###############
function ProcessDocQC($yymm=""){
	global $dbnameuse;
	if($yymm != ""){
			$con1 = " AND t1.datekeyin LIKE '$yymm%' ";
	}
	$sql = "SELECT
t1.datekeyin,
t1.staffid,
Count(t2.idcard) AS numqc,
t1.idcard
FROM
stat_user_keyperson_groupn1_1 as t1
Inner Join validate_checkdata as t2 ON t1.staffid = t2.staffid AND t1.idcard = t2.idcard
group by t2.idcard";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$sql_update = "UPDATE stat_user_keyperson_groupn1_1 SET  status_random_qc='1',status_random_flag='1' WHERE datekeyin='$rs[datekeyin]' AND staffid='$rs[staffid]' AND idcard='$rs[idcard]' ";
			mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."$sql_update<br>LINE__".__LINE__);
	}
}// end function ProcessDocQC($yymm=""){
	
function AddQPrintkp7Gn($yymm=""){
	global $dbnameuse;
	if($yymm != ""){
			$con1 = " AND t1.datekeyin LIKE '$yymm%'";
	}
/*	$sql = "SELECT t1.datekeyin, t1.staffid, t1.idcard, t1.status_random_qc, t1.status_random_flag
FROM  stat_user_keyperson_groupn1_1 as t1 where t1.status_random_flag='0' $con1";	*/
$sql = "SELECT t1.datekeyin, t1.staffid, t1.idcard, t1.status_random_qc, t1.status_random_flag
FROM
stat_user_keyperson_groupn1_1 AS t1
left Join tbl_person_print_kp7 AS t2 ON t1.staffid = t2.staffid AND t1.idcard = t2.idcard AND t1.datekeyin = t2.datekqc
where t1.status_random_flag='0' and t2.idcard IS NULL $con1";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			Insertkp7Print($rs[idcard],$rs[staffid],$rs[datekeyin],"0");
	}//end while($rs = mysql_fetch_assoc($result)){
}//end function AddQPrintkp7Gn($yymm=""){
 
 ?>