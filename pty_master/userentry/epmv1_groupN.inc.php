<?
session_start();
header("Expires: Mon, 26 April 2003 09:09:09 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("cache-Control: no-store, no-cache, must-revalidate"); 
header("cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache"); 
require_once("../../config/conndb_nonsession.inc.php");

$db_name ="edubkk_userentry"  ;
$dbnamemaster="edubkk_master";
$dbsystem = "edubkk_system";
$dbnameuse = $db_name;
$base_point = 240;
$base_point_pm = 120;
$point_w = 0.5;
$numdoc = 3;// ค่าเฉลี่ยในการคูณจำนวณชุดที่ผิด
$val5 = 5;// ค่าคะแนนคูณ 5 ในตำแหน่งสายบริหารการศึกษา
$date_checkkey = "2552-10-01"; // ข้อมูล ณ วันที่ 
$dbnameuse = "edubkk_userentry";
$db_temp = "edubkk_checklist";
$length_var = 7;
$structure_key =10;
$keydata_key = 20;
$pathkp7file = "../../../edubkk_kp7file/";
//$ratio_t1 = 1;
//$ratio_t2 = 0.5;
$ratio_t1 = 1;
$ratio_t2 = 1;


//system data base
$sysdbname =""  ;
$aplicationpath="edubkk_master";
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
			// id
			$arr_f_tbl1 = array("getroyal#id||runid","goodman#runid||runno","graduate#id||runid","hr_absent#id||yy","hr_nosalary#id||no","hr_other#id||no","hr_prohibit#id||no",
	"hr_specialduty#id||no","salary#id||runid","seminar#id||runid","special#id||runid||runno","general#id"   );
			
			
			
			// gen_id
			$arr_f_tbl3 = array( "hr_addhistoryaddress#gen_id||runid","hr_addhistoryfathername#gen_id||runid" , "hr_addhistorymarry#gen_id||runid" , "hr_addhistorymothername#gen_id||runid" , "hr_addhistoryname#gen_id||runid" );			

			$subfix = "_log_after_temp_incen";
			$subfix_befor = "_log_before_temp_incen";
			
			function cond_str($str){
				$str_result = "";
				$strx = explode("||",$str);
				foreach($strx AS $key1 => $val1){
						if(trim(strip_tags($str_result)) > ""){ $str_result .= ",";} // ใส่คอมมา
						$str_result .= "$val1";
				}
				return $str_result ;
			}
			

			


mysql_select_db($db_name) or die( "Unable to select database");
$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");


$epm_staff = "keystaff";
$epm_groupmember = "epm_groupmember";
$officetable = "epm_main_menu";

//$isLocked = GetSysInfo("lock") == 1; // สถานะการเปิดให้แก้ไข
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

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

$ThaiWeekDay = array("Monday"=>"จันทร์","Tuesday"=>"อังคาร","Wednesday"=>"พุธ", "Thursday"=>"พฤหัสบดี","Friday"=>"ศุกร์","Saturday"=>"เสาร์","Sunday"=>"อาทิตย์");

$project_status_array = array("ยังไม่เริ่มโครงการ","ดำเนินตามกำหนด","ล่าช้า","แล้วเสร็จแล้ว");



##### funciton ตัดจุดทศนิยม 2 หลัก
function CutNumberPoint($gennumber,$lengh=2){
		$arr = explode(".",$gennumber);
		if(count($arr) > 1){ // แสดงว่ามีจุดทศนิยม
			$npoint = substr($arr[1],0,$lengh);
			$result_num = $arr[0].".".$npoint;	
		}else{
			$result_num = $gennumber;
		}//end if(count($arr) > 1){
	return $result_num;
}//end function CutNumberPoint(){


function addLog($epm_id,$action,$detail){
//action 8=login fail, 9 = login , 10 = logout

	if ($epm_id > ""){
		//หา %
		$sql = "select * from epm_detail where epm_id='$epm_id';";
		$result = mysql_query($sql);
		$rs = mysql_fetch_assoc($result);
		$pcomplete = $rs[pcomplete];
		$total_budget = $rs[budget_nm];

		$sql = "select sum(value) as total_issue from epm_budget_issue where epm_id='$epm_id';";
		$result = mysql_query($sql);
		$rs = mysql_fetch_assoc($result);
		$total_issue = $rs[total_issue];
	}

	$ip = get_real_ip();

	$sql = "insert into epm_log(logtime,staffid,epm_id,act,detail,pcomplete,bpercent,ip) values(now(),'$_SESSION[session_staffid]','$epm_id','$action','$detail','$pcomplete','$bpercent','$ip');"; 
	$result = mysql_query($sql);

}


function GetSysInfo($fldname){
	$sql = "select value from epm_sysinfo where fldname='$fldname';";
	$result = mysql_query($sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[value];
}

function SetSysInfo($fldname,$value){
//	$sql = "update epm_sysinfo set value='$value' where fldname='$fldname';";
	$sql = "replace into epm_sysinfo(fldname,value) values('$fldname','$value');";
	$result = mysql_query($sql);
	$rs = mysql_fetch_assoc($result);
}


function GetProjectStatus($status){
	$result = mysql_query("select * from project_status_lbl where project_status_id = '$status';");
	$rs = mysql_fetch_assoc($result);
	return $rs[status_name];
}

function GetProjectType($type){
	$result = mysql_query("select * from project_type_lbl where type_id = '$type';");
	$rs = mysql_fetch_assoc($result);
	return $rs[type_name];
}

function GetProjectDevName($devid){
	$result = mysql_query("select  dev_name from epm_detail where dev_id = '$devid' GROUP BY dev_name;");
	$rs = mysql_fetch_assoc($result);
	return $rs[dev_name];
}

function GetProvincePolicy($id){
	$result = mysql_query("select policy_name from policy_lbl where policy_id = '$id' GROUP BY policy_name;");
	$rs = mysql_fetch_assoc($result);
	return $rs[policy_name];
}

function GetClusterPolicy($id){
	$result = mysql_query("select  policy_name from policycluster_lbl where policy_id = '$id' GROUP BY policy_name;");
	$rs = mysql_fetch_assoc($result);
	return $rs[policy_name];
}

function GetMinistryName($devid){
	$result = mysql_query("select name from ministry_lbl where moc_id = '$devid';");
	$rs = mysql_fetch_assoc($result);
	if ($rs[name] == "") $rs[name] = "(ไม่ระบุ)";
	return $rs[name];
}

function GetDevName($devid){
global $officetable;
	$result = mysql_query("select NLABEL from $officetable where NID = '$devid';");
	$rs = mysql_fetch_assoc($result);
	return $rs[NLABEL];
//	$result = mysql_query("select name from department_lbl where dev_id = '$devid';");
//	$rs = mysql_fetch_assoc($result);
//	return $rs[name];
}

function GetOfficeName($id){
global $officetable;
	$sql = "select NLABEL from $officetable where NID = '$id';"; 
	$result = mysql_query($sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[NLABEL];
}

function GetExpenseType($etype){
	$result = mysql_query("select name from expense_type_lbl where id = '$etype';");
	$rs = mysql_fetch_assoc($result);
	return $rs[name];
}

function Query1($sql){
	$result  = mysql_query($sql);
	echo mysql_error();
	if (mysql_errno() != 0 ){ echo " <hr>\n\n $sql \n\n<hr> "; }
	$rs = mysql_fetch_array($result);
	return $rs[0];
}

function showError($msg){
	echo "<SCRIPT LANGUAGE=\"JavaScript\">
	<!--
	alert(\"$msg\");
	history.back();
	//-->
	</SCRIPT>";
	exit;	
}

function DBThaiDate($d){
global $monthname;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return $d1[2] . "/" . $d1[1] . "/" . (intval($d1[0]) + 543);
}

function ThaiDateTime($d){
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	if ($d == "0000-00-00 00:00:00") return "";
	
	$xd=explode(" ",$d);

	$d1=explode("-",$xd[0]);
	return $d1[2] . "/" . $d1[1] . "/" . (intval($d1[0]) + 543)  . " " . $xd[1];
}


function DBThaiLongDate($d){
global $shortmonth;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $shortmonth[intval($d1[1])] . " " . (intval($d1[0]) + 543);
}


function ThaiDate2DBDate($d){
	if (!$d) return "";
	if ($d == "00-00-0000") return "";
	
	$d1=explode("/",$d);
	return (intval($d1[2]) - 543) . "-" . $d1[1] . "-" . $d1[0];
}

function UpdateParentActivity1($id){
	$sql = "select parent as parent_id from epm_activity1 where epm_id='$id' and level > 0 GROUP BY parent;";
	$result = mysql_query($sql); 
	while ($rs=mysql_fetch_assoc($result)){
		$sql = "select sum(q1) as q1,sum(q2) as q2,sum(q3) as q3,sum(q4) as q4 from epm_activity1 where parent='$rs[parent_id]' and level=1";
		$result2 = mysql_query($sql);
		$rs2=mysql_fetch_assoc($result2);

		$sql = "update epm_activity1 set q1='$rs2[q1]',q2='$rs2[q2]',q3='$rs2[q3]',q4='$rs2[q4]' where act_id='$rs[parent_id]';";
		mysql_query($sql); 
	}


}

function SumUpBudget($epm_id,$yy){
	$sql = "SELECT * FROM main_budget_lbl where main_budget_id like '%00'  order by main_budget_id ;";
	$result = mysql_query($sql);
	while  ($rs=mysql_fetch_assoc($result)){
		$main_id = substr($rs[main_budget_id],0,2);

		$sql = "SELECT count(epm_id) FROM epm_main_budget where main_budget_id not like '%00'  and main_budget_id like '$main_id%' and epm_id = '$epm_id' and yy='$yy' ;"; 
		if (Query1($sql) > 0){
			$sql = "SELECT sum(budget_nm) as sum_budget FROM epm_main_budget where epm_id='$epm_id' and main_budget_id not like '" . $main_id . "00'  and main_budget_id like '$main_id%' and yy='$yy';";
			$result2 = mysql_query($sql);
			$rs2=mysql_fetch_assoc($result2); 

			$sum_budget = floatval($rs2[sum_budget]);
			$sql = "replace into epm_main_budget (epm_id,yy,main_budget_id,budget_nm) values('$epm_id','$yy', '$rs[main_budget_id]', '$sum_budget' );"; 
			mysql_query($sql); 
		}

	} // while


}


function GetLevel($id){
	$n =  count(explode(".",$id)) - 1;
	if ($n < 0) $n = 0;
	return ($n);
}




function AddDate($d,$n){
	$x = explode("-",$d); 
	$new = date("Y-m-d",mktime(0,0,0,$x[1],$x[2] + $n,$x[0]));
	return ($new);
}

function DayDiff($StartDate, $StopDate)
{
   // converting the dates to epoch and dividing the difference
   // to the approriate days using 86400 seconds for a day
   //
   return (date('U', strtotime($StopDate)) - date('U', strtotime($StartDate))) / 86400; //seconds a day
}


function AddComma($v){
	$x = explode(".",$v);
	$s = number_format($x[0]);
	if ($x[1] > ""){
		$s .= "." . $x[1];
	}
	return $s;
}

function LimitText($s,$n){
	if (strlen($s) > $n){
		$s = substr($s,0,$n) . "...";
	}
	return $s;
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


function hasAssignedActivity($epm_id,$act_id,$act_type){
	$staffid = $_SESSION[session_staffid];
	if (Query1("select count(epm_id) from  epm_activity_staff where epm_id='$epm_id' and act_id='$act_id' and act_type='$act_type' and staffid='$staffid';") > 0){
		return true;
	}

	if (Query1("select count(t1.epm_id) from  epm_activity_group t1 inner join epm_groupmember t2 on t1.gid=t2.gid where t1.epm_id='$epm_id' and t1.act_id='$act_id' and t1.act_type='$act_type' and t2.staffid='$staffid';") > 0){
		return true;
	}

	return false;
}

function canEditActivity($epm_id,$act_id,$act_type){
	$staffid = $_SESSION[session_staffid];
	if (Query1("select count(epm_id) from  epm_activity_staff_edit where epm_id='$epm_id' and act_id='$act_id' and act_type='$act_type' and staffid='$staffid';") > 0){
		return true;
	}

	if (Query1("select count(t1.epm_id) from  epm_activity_group_edit t1 inner join epm_groupmember t2 on t1.gid=t2.gid where t1.epm_id='$epm_id' and t1.act_id='$act_id' and t1.act_type='$act_type' and t2.staffid='$staffid';") > 0){
		return true;
	}

	return false;
}

function isCreateActivity($epm_id,$act_id,$act_type){
	$staffid = $_SESSION[session_staffid];
	if (Query1("select count(epm_id) from  epm_activity2 where epm_id='$epm_id' and act_id='$act_id' and act_owner_id='$staffid';") > 0){
		return true;
	}

	return false;
}

function isInvolved($epm_id){
	$staffid = $_SESSION[session_staffid];
	if (Query1("select count(epm_id) from  epm_activity_staff where epm_id='$epm_id' and staffid='$staffid';") > 0){
		return true;
	}

	if (Query1("select count(t1.epm_id) from  epm_activity_group t1 inner join epm_groupmember t2 on t1.gid=t2.gid where t1.epm_id='$epm_id' and t2.staffid='$staffid';") > 0){
		return true;
	}

	return false;
}

function isOwner($epm_id){
	if (Query1("select owner_id from epm_detail where epm_id='$epm_id';") == $_SESSION[session_staffid]){
		return true;
	}else{
		return false;
	}
}

function isDevAdmin(){
	if ($_SESSION[session_username] == "admin_" . $_SESSION[session_dev_id]){
		return true;
	}else{
		return false;
	}
}

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$month 			= array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

function DateInput($d,$pre){
	global $monthname;
	if (!$d){
		$d = (intval(date("Y")) + 543) . "-" . date("m-d"); // default date is today
	}

	$d1=explode("-",$d);
?>
วันที่
<select name="<?=$pre?>_day" >
<?
for ($i=1;$i<=31;$i++){
	if (intval($d1[2])== $i){
		echo "<option SELECTED>" .  sprintf("%02d",$i) . "</option>";
	}else{
		echo "<option>" .  sprintf("%02d",$i) . "</option>";
	}
}
?>
</select>

เดือน 
<select name="<?=$pre?>_month" >
<?
for ($i=1;$i<=12;$i++){
	$xi = sprintf("%02d",$i);
	if (intval($d1[1])== $i){
//		echo "<option value='$xi' SELECTED>$xi</option>";
		echo "<option value='$xi' SELECTED>$monthname[$i]</option>";
	}else{
//		echo "<option value='$xi'>$xi</option>";
		echo "<option value='$xi'>$monthname[$i]</option>";
	}
}
?>
</select>

ปี พ.ศ. 
<select name="<?=$pre?>_year" >
<?
$thisyear = date("Y") + 543;
$y1 = $thisyear - 80;
$y2 = $thisyear ;
					
for ($i=$y1;$i<=$y2;$i++){
	if ($d1[0]== $i){
		echo "<option SELECTED>$i</option>";
	}else{
		echo "<option>$i</option>";
	}
}
?>
</select>
<?
}




function MakeDate($d){
global $monthname;
	if (!$d) return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . $d1[0];
}

function MakeDate2($d){
	
	global $month;	
	if (!$d) return "";	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $month[intval($d1[1])] . " " . $d1[0];
	
}

function checkFloat($temp){

	if(strpos($temp, ".") >= 1){
		$s			= explode(".", $temp);
		$data	= ($s[1] >= 1) ? $s[0].".".$s[1] : $s[0] ;
	} else {
		$data 	= $temp;
	}
	return $data;
	
}

function retireDate($date){

	$d= explode("-",$date);
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

	return "30 กันยายน พ.ศ. ".$retire_year;
}

//function ที่ใช้แสดงวันที่แบบไทย
function showdaythai($temp){
if($temp != "0000-00-00"){
	$month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$num = explode("-", $temp);			
	if($num[0] == "0000"){
	  $date = "ไม่ระบุ";
	} else {
	  $tyear = $num[0] +  543;
	  $date = remove_zero($num[2])."&nbsp;".$month[$num[1] - 1 ]."&nbsp; พ.ศ. ".$tyear;	
	}
} else { 	$date = "ไม่ระบุ"; }	
return $date;
}

##########  function  คำนวนจุดผิด
function CalPointF($get_staffid,$get_date){
		global $db_name,$numdoc,$ratio_t1,$ratio_t2;
		/*$strsql = "SELECT 
monitor_keyin.idcard,
monitor_keyin.staffid,
tbl_assign_key.ticketid
FROM
monitor_keyin
Inner Join tbl_assign_key ON monitor_keyin.idcard = tbl_assign_key.idcard
WHERE
tbl_assign_key.nonactive =  '0' 
AND  monitor_keyin.timestamp_key like '$get_date%' 
AND monitor_keyin.staffid='$get_staffid'
GROUP BY monitor_keyin.idcard
";*/
$strsql = "SELECT
t1.idcard,
t1.staffid,
t1.ticketid
FROM
validate_checkdata as t1
Inner Join tbl_assign_key as t2 ON t1.idcard = t2.idcard AND t1.ticketid = t2.ticketid
Inner Join monitor_keyin as t3  ON t1.idcard = t3.idcard AND t1.staffid = t3.staffid
where
 t3.staffid='$get_staffid' and t1.status_process_point='YES' and t3.timestamp_key LIKE '$get_date%'  group by t1.idcard ";


//echo "$strsql<br><br>";
	$result = mysql_db_query($db_name,$strsql);
	$subtract_sum=0;
	while($rs = mysql_fetch_assoc($result)){
			$sql1 = "SELECT
sum(if(validate_datagroup.mistaken_id='2',num_point*$ratio_t1,num_point*$ratio_t2)) as sumval
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
WHERE
validate_checkdata.idcard =  '$rs[idcard]' AND
validate_checkdata.staffid =  '$rs[staffid]' AND
validate_checkdata.ticketid =  '$rs[ticketid]'  AND 
validate_checkdata.status_cal='0' and validate_checkdata.status_process_point='YES' "; 

		$sql_up1 = "UPDATE validate_checkdata SET validate_checkdata.status_cal='1' ,validate_checkdata.datecal='$get_date'  WHERE validate_checkdata.idcard='$rs[idcard]' AND validate_checkdata.staffid='$rs[staffid]' AND validate_checkdata.ticketid='$rs[ticketid]' and status_cal='0'";
		@mysql_db_query($db_name,$sql_up1);
		
			$result1 = mysql_db_query($db_name,$sql1);
			$rs1 = mysql_fetch_assoc($result1);
			$subtract_sum += $rs1[sumval];
	}//end while($rs = mysql_fetch_assoc($result)){
		###  บันทึกข้อมูลใน ตารางข้อมูล ลบ
			$arrdate = ShowSdateEdate($get_date); // หาวันเริ่มต้นและสิ้นสุดของแต่ละสัปดาห์
		if(CheckGroupKey($get_staffid) > 0){// แสดงว่าเป็น กลุ่ม A หรือ B
				//$subtract_sum = (CalSubtractAB($get_staffid,$get_date))*$numdoc;
				$conUPdate = " ,sdate='".$arrdate['start_date']."', edate='".$arrdate['end_date']."' ";
				$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint,sdate,edate)VALUE('$get_staffid','$get_date','$subtract_sum','".$arrdate['start_date']."','".$arrdate['end_date']."')";
		}else{
				$conUPdate = " ";
				$subtract_sum = $subtract_sum;
				$sql_insert1 = "REPLACE INTO stat_subtract_keyin(staffid,datekey,spoint)VALUE('$get_staffid','$get_date','$subtract_sum')";
		}
		
		$sql_select = "SELECT * FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date'";
		$result_select = mysql_db_query($db_name,$sql_select);
		$rs_s = mysql_fetch_assoc($result_select);
		if($rs_s[spoint] > 0){ // กรณีมีข้อมูล ค่าลบอยู่ในตารางอยู่แล้วให้ตรวจสอบค่าก่อนบันทึก
			if($subtract_sum > 0){
				$sql_insert = "UPDATE  stat_subtract_keyin SET spoint='$subtract_sum' $conUPdate WHERE staffid='$get_staffid' AND datekey='$get_date'";
				//echo "update :: $sql_insert<br><br>";
				mysql_db_query($db_name,$sql_insert);
				
			}//end 	if($val > 0){	
		}else{
				if($subtract_sum > 0){
					//echo "insert :: $sql_insert1<br><br>";
					mysql_db_query($db_name,$sql_insert1);
				}//end 
		}//end if($rs_s[spoint] > 0){
		## end ###  บันทึกข้อมูลใน ตารางข้อมูล ลบ
	return $subtract_sum;		
}//end function CalPointF(){
	
#### funnction ในการคำนวณค่า incentive 
function CalulateIncentive($get_netpoint){
		global $base_point,$point_w;
		if($get_netpoint > 0){
			return $get_netpoint*$point_w;
		}else{
			return 0; 	
		}
		
}//end CalulateIncentive($get_netpoint){
#### คำนวณคะแนนสุทธิ
function CaluateNetPoint($get_numpoint,$get_subtract){
	global $base_point;
	if($get_numpoint > 0){
		return ($get_numpoint-$get_subtract)-$base_point;
	}else{
		return 0;	
	}
}

### แสดงชื่อพนักงาน
function ShowStaffOffice($get_staffid){
	global $db_name;
	$sql1 = "SELECT prename,staffname,staffsurname FROM keystaff WHERE staffid='$get_staffid'";
	$result1 = mysql_db_query($db_name,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return "$rs1[prename]$rs1[staffname]  $rs1[staffsurname]";
}//end function ShowStaffOffice(){


function ShowKpoint($get_date,$get_staffid){
	global $db_name;
	$sql = "SELECT numkpoint FROM stat_user_keyin WHERE datekeyin='$get_date' AND staffid='$get_staffid'";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numkpoint];	
}//end function ShowKpoint(){
	
function IncentivePerMonth($get_month){
	global $db_name;
	$sql = "SELECT
Sum(stat_user_keyin.numkpoint) AS sumkpoint,
sum(stat_incentive.subtract) as sumsubtract,
sum(stat_incentive.net_point) as sumnetpoint,
sum(stat_incentive.incentive) as sumincentive,
stat_incentive.staffid
FROM
stat_incentive
Inner Join stat_user_keyin ON stat_incentive.staffid = stat_user_keyin.staffid AND stat_incentive.datekeyin = stat_user_keyin.datekeyin
where stat_incentive.datekeyin LIKE '$get_month%' group by stat_incentive.staffid";
	$result = mysql_db_query($db_name,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arr_sumpoint[$rs[staffid]]["sumkpoint"]	 = $rs[sumkpoint];
		$arr_sumpoint[$rs[staffid]]["sumsubtract"]	 = $rs[sumsubtract];
		$arr_sumpoint[$rs[staffid]]["sumnetpoint"]	 = $rs[sumnetpoint];
		$arr_sumpoint[$rs[staffid]]["sumincentive"]	 = $rs[sumincentive];
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr_sumpoint;
}

####  funciton ตรวจสอบว่ามีการ รับรองยอดแล้วหรือไม่
function CheckAppriveIncentive($temp_date){
	global $db_name;
	$sql = "SELECT COUNT(datekeyin) AS num1 FROM stat_incentive WHERE datekeyin LIKE '$temp_date%' GROUP BY datekeyin";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}//end function CheckAppriveIncentive(){
	
### function ตรวจสอบกลุ่มที่จะนำไปคำนวณช่ว่งเวลาในการตรวจสอบ
function CheckGroupKey($get_staffid){
	global $db_name;
	$sql_staff = "SELECT if(keyin_group='1' or keyin_group='2', 1,0) as group_val  FROM keystaff  WHERE  staffid='$get_staffid'";
	$result_staff = mysql_db_query($db_name,$sql_staff);
	$rs_staff = mysql_fetch_assoc($result_staff);
	return $rs_staff[group_val];
}//end function CheckGroupKey($get_staffid){
	
	
	function ShowSdateEdate($get_date){ 
 $arr_d1 = explode("-",$get_date);
 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]), intval($arr_d1[2]), intval($arr_d1[0]))));
 $curent_week = $xFTime["wday"];
 
 ## 1 คือ เลขสัปดาห์ ของวันจันทร์
 ## 6 คือ เลขสัปดาห์ ของวันเสาร์
	 $curent_week = $xFTime["wday"];
	 $xsdate = $curent_week -1;
	 $xedate = 6-$curent_week;
	// echo " $datereq1  :: $xsdate  :: $xedate<br>";
	 if($xsdate > 0){ $xsdate = "-$xsdate";}
	 
				
				 $xbasedate = strtotime("$get_date");
				 $xdate = strtotime("$xsdate day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป

				 $xbasedate1 = strtotime("$get_date");
				 $xdate1 = strtotime("$xedate day",$xbasedate1);
				 $xsdate1 = date("Y-m-d",$xdate1);// วันถัดไป	
				 
				 $arr_date['start_date'] = $xsdate;
				 $arr_date['end_date'] = $xsdate1;
	return $arr_date;
}//end function ShowSdateEdate(){
	
	
	### function ในการคำนวน ค่าคะแนนจุดผิด
function CalSubtract($get_idcard,$get_staffid,$get_ticketid){
	global $dbnameuse,$ratio_t1,$ratio_t2;
	$sql_cal = "SELECT count(idcard) as num1  FROM `validate_checkdata`
where  validate_checkdata.idcard =  '$get_idcard' AND
validate_checkdata.staffid =  '$get_staffid' AND
validate_checkdata.ticketid =  '$get_ticketid'  AND 
validate_checkdata.status_cal='0' and validate_checkdata.result_check='1' group by idcard ";
	$result_true = mysql_db_query($dbnameuse,$sql_cal);
	$rst = mysql_fetch_assoc($result_true);
	if($rst[num1] > 0){ // แสดงว่า qc แล้วและไม่พบจดผิด
			$xresult = 0; // ไม่พบข้อผิดพลาด
	}else{
	$sql_cal = "SELECT
sum(if(validate_datagroup.mistaken_id='2',num_point*$ratio_t1,num_point*$ratio_t2)) as sumval
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
WHERE
validate_checkdata.idcard =  '$get_idcard' AND
validate_checkdata.staffid =  '$get_staffid' AND
validate_checkdata.ticketid =  '$get_ticketid'  AND 
validate_checkdata.status_cal='0' ";
//echo $sql_cal."<br>";
//echo $sql_cal."<br>";
	$result_cal = mysql_db_query($dbnameuse,$sql_cal);
	$rs_cal = mysql_fetch_assoc($result_cal);
	if($rs_cal[sumval] == ""){
		$xresult = 0;
	}else{
		$xresult = $rs_cal[sumval];
	}
}//end if($rst[num1] > 0){ 
//echo "ค่าคะแนน :: $get_idcard  :: $get_staffid :: $get_ticketid  ::  ".$xresult;die;
	return $xresult;
	

}//end function CalSubtract(){


function CalSubtractAB($get_staff,$get_date){
	global $dbnameuse,$ratio_t1,$ratio_t2;
	$arrdate = ShowSdateEdate($get_date); // หาวันเริ่มต้นและสิ้นสุดของแต่ละสัปดาห์
	$sql_ab = "SELECT
sum(if(validate_datagroup.mistaken_id='2',num_point*$ratio_t1,num_point*$ratio_t2)) as sumval
FROM
validate_checkdata
Inner Join validate_datagroup ON validate_checkdata.checkdata_id = validate_datagroup.checkdata_id
WHERE
validate_checkdata.staffid =  '$get_staff' AND
validate_checkdata.datecal BETWEEN  '".$arrdate['start_date']."' AND '".$arrdate['end_date']."'
group by validate_checkdata.idcard
order by sumval DESC
LIMIT 1";
	$result_ab = mysql_db_query($dbnameuse,$sql_ab);
	$rs_ab = mysql_fetch_assoc($result_ab);
	return $rs_ab[sumval];
}//end function CalSubtractAB($get_staff,$get_date){
	
#####  function แสดงค่า Ratio การ QC ของแต่ละกลุ่มข้อมูล
function ShowQvalue($get_staffid){
	global $dbnameuse;
	return GetRatioGroup($get_staffid);
}//end function ShowQvalue($get_staffid){

function NumP($get_staffid,$get_idcard){
	global $dbnameuse;
	$sqlP = "SELECT idcard FROM `validate_checkdata`  where staffid='$get_staffid'  and idcard ='$get_idcard' GROUP BY idcard";
	$resultP = mysql_db_query($dbnameuse,$sqlP);
	$numP = @mysql_num_rows($resultP);
	return $numP;
}

function CheckGroupStaff($get_staffid){
	global $dbnameuse;	
	$sql = "SELECT keyin_group FROM keystaff WHERE staffid='$get_staffid'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[keyin_group];
}
function CutPoint($temp_point){
	$arr1 = explode(".",$temp_point);
	if(count($arr1) > 1){
		if(strlen($arr1[1]) < 2){ $dot_point = $arr1[1]."0";}else{ $dot_point = substr($arr1[1],0,2);}
		$result = $arr1[0].".".$dot_point;
	}else{
		if($temp_point > 0){
			$result = $temp_point.".00";	
		}else if($temp_point == "0"){
			$result = "0.00";	
		}else{
			$result = $temp_point;
		}
	}
	//echo "$result :: $temp_point";
	return $result;
}//end function CutPoint($temp_point){
	
	function ViewCutPoint($temp_point){
	$arr1 = explode(".",$temp_point);
	if(count($arr1) > 1){
		if(strlen($arr1[1]) < 2){ $dot_point = $arr1[1]."0";}else{ $dot_point = substr($arr1[1],0,2);}
		$result = number_format($arr1[0]).".".$dot_point;
	}else{
		if($temp_point > 0){
			$result = number_format($temp_point).".00";	
		}else if($temp_point == 0){
			$result = "0.00";	
		}else{
			$result = $temp_point;
		}
	}
	//echo "$result :: $temp_point";
	return $result;
}//end function CutPoint($temp_point){


###  ตรวจสอบว่าภายใน 1 สัปดาห์ มีการตรวจเกินเกณฑ์ที่ำกำหนดรึเปล่า กลุ่ม A 1 ชุดต่อสัปดาห์ กลุ่ม B 2 ชุดต่อสัปดาห์ ถ้าเกินจะคำนวณค่าคะแนนถ่วงน้ำหนักโดยการเฉลี่ย
function CheckQC_Per_Week($get_staffid,$get_date){
	global $dbnameuse;
	$arrd = ShowSdateEdate($get_date);
	$xsdate = $arrd['start_date'];
	$xedate = $arrd['end_date'];
	$group_type = CheckGroupStaff($get_staffid);
	if($group_type == "1" or $group_type == "2"){ // เป็นกลุ่ม a และ b
		$sql1 = "SELECT sum(num_p) AS nump FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey between '$xsdate' and '$xedate'";
		//echo $sql1."<br>";
		$result1 = mysql_db_query($dbnameuse,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
			if($rs1[nump] > $group_type){ // กรณีที่จำนวนชุดที่สุ่มตรวจมากกว่าค่ามาตรฐานที่สุ่มตรวจ
			$sql2 = "SELECT (sum(spoint)/sum(num_p)) as numval FROM `stat_subtract_keyin` where (staffid='$get_staffid') and ( datekey between '$xsdate' and '$xedate')";
			$result2 = mysql_db_query($dbnameuse,$sql2);
			$rs2 = mysql_fetch_assoc($result2);
			$pval = CutPoint($rs2[numval]);
			
			## หาวันที่จะทำการบันทึกในช่วงสัปดาห์ห
			$sql3 = "SELECT datekey FROM `stat_subtract_keyin` where (staffid='$get_staffid' ) and ( datekey between '$xsdate' and '$xedate') order by spoint DESC LIMIT 1";
			$result3 = mysql_db_query($dbnameuse,$sql3);
			$rs3 = mysql_fetch_assoc($result3);
			$date_save = $rs3[datekey];
			
			$sql4 = "SELECT COUNT(staffid) AS NUM1 FROM stat_subtract_keyin_avg  WHERE staffid='$get_staffid' and datekey between '$xsdate' and '$xedate' GROUP BY staffid";
			$result4 = mysql_db_query($dbnameuse,$sql4);
			$rs4 = mysql_fetch_assoc($result4);
				//if($rs4[NUM1] < 1){ // กรณียังไม่ไ้ด้เก็บค่าเฉลี่ยการบันทึกข้อมูล
					$sql_insert = "REPLACE INTO stat_subtract_keyin_avg SET staffid='$get_staffid' , datekey='$date_save', spoint='$pval', num_p='$rs1[nump]',sdate='$xsdate',edate='$xedate'";
					//echo $sql_insert."<br>";
					$result_insert = mysql_db_query($dbnameuse,$sql_insert);
				//}
				### กรณีที่จำนวนชุดที่ตรวจตรงกับค่ามาตรฐาน			
			}else{
			$xsql2 = "SELECT sum(spoint)as numval FROM `stat_subtract_keyin` where (staffid='$get_staffid') and ( datekey between '$xsdate' and '$xedate')";
			$xresult2 = mysql_db_query($dbnameuse,$xsql2);
			$xrs2 = mysql_fetch_assoc($xresult2);
			$pval = CutPoint($xrs2[numval]);
			
			## หาวันที่จะทำการบันทึกในช่วงสัปดาห์ห
			$xsql3 = "SELECT datekey FROM `stat_subtract_keyin` where (staffid='$get_staffid' ) and ( datekey between '$xsdate' and '$xedate') order by spoint DESC LIMIT 1";
			$xresult3 = mysql_db_query($dbnameuse,$xsql3);
			$xrs3 = mysql_fetch_assoc($xresult3);
			$date_save = $xrs3[datekey];
			
			$xsql4 = "SELECT COUNT(staffid) AS NUM1 FROM stat_subtract_keyin_avg  WHERE staffid='$get_staffid' and datekey between '$xsdate' and '$xedate' GROUP BY staffid";
			echo "<br>$xsql4<br>";
			$xresult4 = mysql_db_query($dbnameuse,$xsql4);
			$xrs4 = mysql_fetch_assoc($xresult4);
				//if($xrs4[NUM1] < 1){
						$sql_insert = "REPLACE INTO stat_subtract_keyin_avg SET staffid='$get_staffid' , datekey='$date_save', spoint='$pval', num_p='$rs1[nump]',sdate='$xsdate',edate='$xedate'";
						echo "<br><br>$sql_insert<br>";
					$result_insert = mysql_db_query($dbnameuse,$sql_insert);
				//}
	
			}//end if($rs1[nump] > $group_type){
	### กรณีที่ไม่ใช่กลุ่ม A และ B
	}else{
		$sql_insert1 = "REPLACE INTO stat_subtract_keyin_avg(staffid,datekey,spoint,num_p) SELECT stat_subtract_keyin.staffid,
		stat_subtract_keyin.datekey,stat_subtract_keyin.spoint,stat_subtract_keyin.num_p
  FROM stat_subtract_keyin  WHERE stat_subtract_keyin.staffid='$get_staffid' AND stat_subtract_keyin.datekey='$get_date'";	
  		mysql_db_query($dbnameuse,$sql_insert1);
	}//end 	if($group_type == "1" or $group_type == "2"){ 
	
}//end function CheckQC_Per_Week($get_staffid,$get_date){
	
####  ตรวจสอบค่าสะสมว่ามีการหักค่าคะแนนลบรึยัง
function CheckSubpointAvg($get_staffid,$get_date){
	global $dbnameuse;
	$arrd = ShowSdateEdate($get_date);
	$xsdate = $arrd['start_date'];
	$xedate = $arrd['end_date'];
	$sql = "SELECT sum(subtract) as s_val FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin  between '$xsdate' and '$xedate'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[s_val];
}
###  function รวมค่าสะสมเอามาเป็นค่่าคะแนนที่จะเอาไปลบกับคะแนนถ่วงน้ำหนัก
function SumTempPoint($get_staffid,$get_date){
	global $dbnameuse;
	$arrxd = explode("-",$get_date);
	$start_date1 = $arrxd[0]."-".$arrxd[1]."-01";
	$arr_d1 = explode("-",$get_date);
	$xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d1[1]+1), intval($arr_d1[2]-1), intval($arr_d1[0]))));
	$end_date = $arr_d1[0]."-".$arr_d1[1]."-".$xFTime['mday'];
	$sql = "SELECT
sum(stat_incentive_temp.kpoint_add) as kpoint_add,
sum(stat_incentive_temp.subtract) as subtract
FROM `stat_incentive_temp`
where staffid='$get_staffid' and datekeyin  between '$start_date1' and '$end_date' ";
//echo $sql."<br>";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	//echo $rs[net_point]."<br>";
	return $rs[kpoint_add]-$rs[subtract];
}

###  function ตรวจสอบค่าสะสมก่อนการคำนวณใหม่
function CheckPointADD($get_staffid,$get_date){
	global $dbnameuse;
	$sql = "SELECT COUNT(staffid) AS numc FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin='$get_date' GROUP BY staffid";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numc];
}

### function ตรวจสอบว่ามีการ QC หรือไม่
function CheckQC1($get_staffid,$get_date){
	global $dbnameuse;	
	$sql = "SELECT COUNT(staffid) AS NUM1 FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date' GROUP BY staffid";
//	echo $sql;
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[NUM1];
}
###  รวมคะแนนสะสมโดยไม่ต้องหัก
function SumAdd($get_staffid,$get_date){
	global $dbnameuse;
	$arrxd = explode("-",$get_date);
	$start_date1 = $arrxd[0]."-".$arrxd[1]."-01";
	$sql = "SELECT ROUND(SUM(kpoint_add),2) AS sumadd FROM stat_incentive WHERE staffid='$get_staffid' AND datekeyin BETWEEN '$start_date1' AND '$get_date'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[sumadd];
}//end function SumAdd(){
	
### sum ค่าลบก่อน
function xSumSubtract($get_staffid,$get_date){
	global $dbnameuse;
	$arrxd = explode("-",$get_date);
	$start_date1 = $arrxd[0]."-".$arrxd[1]."-01";
	$yymm = $arrxd[0]."-".$arrxd[1];
	if($arrxd[2] != "01"){ // กรณีไม่ใช่วันที่ 1 ของเดือน
		$xbasedate = strtotime("$get_date");
		$xdate = strtotime("-1 day",$xbasedate); // ย้อนหลังไป 1 วัน
		$xsdate = date("Y-m-d",$xdate);// วันถัดไป
		$condate = $xsdate;
	}else{
		$condate = $get_date;	
	}
	## ตรวจสอบก่อนว่าก่อนหน้านี้มีค่าสะสมอยู่รึเปล่า
	$sqlx = "SELECT SUM(net_point) as sumx1 FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin BETWEEN '$start_date1' AND '$get_date' ";
	$resultx = mysql_db_query($dbnameuse,$sqlx);
	$rsx = mysql_fetch_assoc($resultx);
	
	
	$sql = "SELECT net_point  FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin='$condate'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[net_point] == 0){
		if($rsx[sumx1] != 0){
			$sql1 = "SELECT net_point  FROM stat_incentive_temp WHERE staffid='$get_staffid' AND datekeyin LIKE '$yymm%' AND net_point <> 0 ORDER BY datekeyin DESC LIMIT 1";	
			$result1 = mysql_db_query($dbnameuse,$sql1);
			$rs1 = mysql_fetch_assoc($result1);
			$stat_val = $rs1[net_point];
		}	
	}else{
			$stat_val = $rs[net_point];
	}
	
	return $stat_val;
}
### หาวันเริ่มปฏิบัติงาน
function ShowStartDate($staffid){
	global $dbnameuse,$monthname;
	$sql = "SELECT date(timeupdate) as start_date  FROM `monitor_keyin` where staffid='$staffid' AND date(timeupdate) <> '0000-00-00' order by timeupdate ASC LIMIT 1";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	$d1=explode("-",$rs[start_date]);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . (intval($d1[0]) + 543);
	
}// end function ShowStartDate($staffid){
	
####  function หาความซับซ้อนของการคีย์ข้อมูล
function CalHiddenPersonPoint(){
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
WHERE (hidden_point IS NULL OR hidden_point = '') AND stat_user_keyperson.status_approve='1' and stat_user_keyperson.flag_qc='0'
ORDER BY datekeyin ASC";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$db_site = STR_PREFIX_DB.$rs[siteid];
		###########  ตรวจสอบว่าเป็นสายบริหารรึเปล่าถ้าเป็นสายบริหารการศึกาา ให้ คูณ 5 คะแนนต่อ 1 ตำแหน่ง
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
	
	
function UpdateQcPass($staffid,$yymm,$kvalgroup){
	global $dbnameuse;
	//$kvalgroup  = ShowQvalue($staffid); // จำนวนชุดที่ต้อง QC
	$sql = "SELECT * FROM `stat_user_person_temp` where dateqc LIKE '$yymm%' and num_doc='$kvalgroup' and qc_pass='0' AND staffid='$staffid'";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$sql1 = "SELECT COUNT(idcard) as num1  FROM `stat_user_keyperson` WHERE `flag_qc` = '$rs[flag_id]' AND `staffid` = '$rs[staffid]'  AND status_random_qc='1' ";
			$result1 = mysql_db_query($dbnameuse,$sql1);
			$rs1 = mysql_fetch_assoc($result1);
			if($rs1[num1] > 0){
					$sql_up = "UPDATE  stat_user_person_temp SET qc_pass='1' WHERE flag_id='$rs[flag_id]' AND staffid='$rs[staffid]'";
					//echo $rs[dateqc]." => ".$sql_up."<br>";
					$result_up = mysql_db_query($dbnameuse,$sql_up) or die(mysql_error()."$sql_up<br>LINE::".__LINE__);
			}//end if($rs1[num1] > 0){
	}//end while($rs = mysql_fetch_assoc($result)){

}// end function UpdateQcPass(){

	
	
function CleanFlagQcTemp($staffid,$yymm,$kvalgroup){
		global $dbnameuse;
		//$kvalgroup  = ShowQvalue($staffid); // จำนวนชุดที่ต้อง QC
		$sql = "SELECT * FROM stat_user_person_temp WHERE staffid='$staffid' AND dateqc LIKE '$yymm%'  AND qc_pass='0'  and (num_doc < '$kvalgroup' or num_doc IS NULL)";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$sql1 = "SELECT sum(if(status_random_qc='1',1,0)) as numqc,count(distinct idcard) as numid FROM stat_user_keyperson WHERE staffid = '$rs[staffid]' AND flag_qc = '$rs[flag_id]'";
			$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql<br>LINE::".__LINE__);
			$rs1  = mysql_fetch_assoc($result1);
			if($rs1[numid] == $kvalgroup){ // จำนวนชุดครบแล้ว
				if($rs1[numqc] > 0){ // แสดงว่าจำนวนชุดครบและมีการ QC แล้ว
						$qc_pass = "1";
				}else{
						$qc_pass = "0";	
				}// end if($rs1[numqc] > 0){
				$sql_up = "UPDATE stat_user_person_temp SET num_doc='$kvalgroup', qc_pass='$qc_pass',status_qc='$qc_pass' WHERE staffid='$rs[staffid]' AND dateqc LIKE '$yymm%' AND flag_id='$rs[flag_id]' ";
				$result_up = mysql_db_query($dbnameuse,$sql_up) or die(mysql_error()."$sql_up<br>LINE::".__LINE__);
			}else{
				$sql_c = "UPDATE   stat_user_keyperson  SET flag_qc=NULL WHERE staffid = '$rs[staffid]' AND flag_qc = '$rs[flag_id]'";	
				$result_c = mysql_db_query($dbnameuse,$sql_c) or die(mysql_error()."$sql_c<br>LINE::".__LINE__);
				if($result_c){
						$sqldel = "DELETE FROM stat_user_person_temp WHERE staffid='$rs[staffid]' AND flag_id='$rs[flag_id]' AND dateqc LIKE '$yymm%'";
						mysql_db_query($dbnameuse,$sqldel) or die(mysql_error()."$sqldel<br>LINE::".__LINE__);
				}
			}// end if($rs1[numid] == $kvalgroup){
				
		}// end while($rs = mysql_fetch_assoc($result)){	
		
		
	#### sql max
	$sql_max1 = "SELECT max(flag_id) as flag_max  FROM stat_user_person_temp WHERE staffid='$staffid' AND dateqc LIKE '$yymm%'";
	$result_max1 = mysql_db_query($dbnameuse,$sql_max1) or die(mysql_error()."$sql_max1<br>LINE::".__LINE__);
	$rsm = mysql_fetch_assoc($result_max1);
	$sqlc = "SELECT COUNT(distinct idcard) AS num1,flag_qc  FROM stat_user_keyperson WHERE flag_qc > '$rsm[flag_max]' and staffid='$staffid' GROUP BY  flag_qc ";
	$resultc = mysql_db_query($dbnameuse,$sqlc);
	while($rsc = mysql_fetch_assoc($resultc)){
		if($rsc[num1] < $kvalgroup){
			$sqlup1 = "UPDATE stat_user_keyperson SET flag_qc=NULL WHERE  flag_qc = '$rsc[flag_qc]' and staffid='$staffid' and status_random_qc='0' and status_random_flag='0'  and datekeyin LIKE '$yymm%'";
			$sqlup2 = "UPDATE  stat_user_keyperson SET flag_qc='1' WHERE  flag_qc = '$rsc[flag_qc]' and staffid='$staffid' and status_random_qc='1' and datekeyin LIKE '$yymm%' ";
			mysql_db_query($dbnameuse,$sqlup1);
			mysql_db_query($dbnameuse,$sqlup2);
		}
	}//end while(){
}// end function CleanFlagQcTemp($staffid,$yymm){
	
	
function GetMonthBefore($yymm){

	$xbasedate = strtotime("$yymm");
	 $xmonth = strtotime("$yymm -1 month",$xbasedate);
	 $month_before = date("Y-m",$xmonth);// เดือนก่อนหน้านี้	
	 return $month_before;
}	// end function GetMonthBefore($yymm){
	
function NextDate($date){
	$xbasedate = strtotime("$date");
	 $xday = strtotime("$date +1 day",$xbasedate);
	 $daynex = date("Y-m-d",$xday);// เดือนก่อนหน้านี้	
	 return $daynex;
	
}// end function NextDate($date){


function CleanTempMonthBefore($staffid,$yymm,$kvalgroup){
	global $dbnameuse;
		$month_before = GetMonthBefore($yymm); // เดือนก่อนหน้านี้
		//$kvalgroup  = ShowQvalue($staffid); // จำนวนชุดที่ต้อง QC
		$sql = "DELETE  FROM stat_user_person_temp WHERE staffid='$staffid' AND dateqc LIKE '$month_before%'  AND qc_pass='0'  and (num_doc < '$kvalgroup' or num_doc IS NULL) ";
		$result = mysql_db_query($dbnameuse,$sql);
		
		
}// end function CleanTempMonthBefore($staffid,$yymm){
	
	
function CleanDataFlagReplace($staffid,$yymm,$kvalgroup){
	global $dbnameuse;
	$sql = "SELECT * FROM stat_user_person_temp WHERE staffid='$staffid' AND dateqc LIKE '$yymm%'  AND qc_pass='0'  and (num_doc <= '$kvalgroup' or num_doc IS NULL)";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$sql1 = "SELECT COUNT(idcard) as num1 FROM stat_user_keyperson WHERE (status_random_qc='1' OR status_random_flag='1') AND staffid='$rs[staffid]' AND flag_qc='$rs[flag_id]'";
			$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE::".__LINE__);
			$rs1 = mysql_fetch_assoc($result1);
			if($rs1[num1] < 1){ // แสดงว่ายังไม่มีการปริ้นงาน
					$sql_up1 = "UPDATE stat_user_keyperson SET flag_qc=NULL WHERE staffid='$rs[staffid]' AND flag_qc='$rs[flag_id]' ";
					mysql_db_query($dbnameuse,$sql_up1) or die(mysql_error()."$sql_up1<br>LINE::".__LINE__);
					$sql_del = "DELETE FROM stat_user_person_temp WHERE staffid='$staffid' AND dateqc LIKE '$yymm%'  AND flag_id='$rs[flag_id]'";
					mysql_db_query($dbnameuse,$sql_del) or die(mysql_error()."$sql_del<br>LINE::".__LINE__);
			}// end if($rs1[num1] < 1){ // แสดงว่ายังไม่มีการปริ้นงาน
	}// end while($rs = mysql_fetch_assoc($result)){
}//end function CleanDataFlagReplace($staffid,$yymm,$kvalgroup){
	
function SubGroupOfMonth($staffid,$yymm){
	global $dbnameuse;
	$kvalgroup  = ShowQvalue($staffid); // จำนวนชุดที่ต้อง QC
	$month_before = GetMonthBefore($yymm); // เดือนก่อนหน้านี้
	$date1 = $yymm."-01";
	if($yymm == "2011-05" or $yymm == "2011-04"  or $yymm == "2011-02"){
			$condate = " and datekeyin LIKE '$yymm%'";
	}else{
			$condate = "and (datekeyin LIKE '$yymm%' or datekeyin LIKE '$month_before%')";
	}
	
	
	#####  ทำการ clean ข้อมูลใหม่
	ResetSubGroupQC($staffid,$yymm,$kvalgroup);	
	CleanDataFlagReplace($staffid,$yymm,$kvalgroup);
	UpdateQcPass($staffid,$yymm,$kvalgroup); // update ชุดที่ QC ไปแล้ว
	CleanFlagQcTemp($staffid,$yymm,$kvalgroup); // ล้างข้อมูลก่อนสร้าง flag ใหม่
	CleanTempMonthBefore($staffid,$yymm,$kvalgroup); // ลบข้อมูลที่จำนวนชุดไม่เต็บเดือนก่อนหน้านี้
	$sqlmax = "SELECT MAX(flag_qc) AS max_flag FROM stat_user_keyperson WHERE staffid='$staffid'";
	$resultmax = mysql_db_query($dbnameuse,$sqlmax) or die(mysql_error()."$sqlmax<br>LINE::".__LINE__);
	$rsmax = mysql_fetch_assoc($resultmax);
	$flagqc_temp = $rsmax[max_flag]+1;
	$sql_loop = "SELECT * FROM stat_user_keyperson WHERE status_approve='1' AND staffid='$staffid' AND (flag_qc='0' or flag_qc IS NULL) $condate  GROUP BY idcard  ORDER BY datekeyin ASC";
	$result_loop = mysql_db_query($dbnameuse,$sql_loop) or die(mysql_error()."$sql_loop<br>LINE::".__LINE__);
	$j=0;
	$flagqc = $flagqc_temp;
	$k=0;
	while($rsp = mysql_fetch_assoc($result_loop)){
		
		$sql_check = "SELECT * FROM stat_user_keyperson WHERE status_approve='1' AND  staffid='$staffid'  AND idcard='$rsp[idcard]' AND flag_qc > '0' $condate";
		$result_check = mysql_db_query($dbnameuse,$sql_check) or die(mysql_error()."$sql_check<br>LINE::"._LINE__);
		$rsc1 = mysql_fetch_assoc($result_check);
		
		$check_list_qc = CheckListQCPerson($rsp[idcard],$staffid,$yymm);
		if($check_list_qc > 0){ // กรณีมีการ ลง list qc ไปแล้ว
			$sql_updata = "UPDATE stat_user_keyperson SET flag_qc='1' WHERE idcard='$rsc1[idcard]' AND  staffid='$staffid' and status_approve='1'  $condate";
			mysql_db_query($dbnameuse,$sql_updata) or die(mysql_error()."$sql_updata<br>LINE::".__LINE__);
		}else if($rsc1[idcard] != ""){
			$sql_updata = "UPDATE stat_user_keyperson SET flag_qc='$rsc1[flag_qc]' WHERE idcard='$rsc1[idcard]' AND  staffid='$staffid' and status_approve='1'  $condate";
			mysql_db_query($dbnameuse,$sql_updata) or die(mysql_error()."$sql_updata<br>LINE::".__LINE__);
		}else{
		
		
		$j++;
		$sqlupdate = "UPDATE  stat_user_keyperson SET flag_qc='$flagqc' WHERE staffid='$staffid' AND idcard='$rsp[idcard]' ";
		mysql_db_query($dbnameuse,$sqlupdate) or die(mysql_error()."$sqlupdate<br>LINE::".__LINE__);
		if($j == $kvalgroup){ // ครบ loop
				$dateqc = NextDate($date1); // วันที่แสดงใน qc
				$sql_replace = "REPLACE INTO  stat_user_person_temp SET flag_id='$flagqc',staffid='$staffid',dateqc='$dateqc',status_qc='0',num_doc='$kvalgroup'";
				mysql_db_query($dbnameuse,$sql_replace) or die(mysql_error()."$sql_replace<br>LINE::".__LINE__);
				$flagqc++;
				$j=0;
				$k=1;
		}else{
				$sql_replace = "REPLACE INTO  stat_user_person_temp SET flag_id='$flagqc',staffid='$staffid',dateqc='$date1',status_qc='0',num_doc='$j'";
				mysql_db_query($dbnameuse,$sql_replace) or die(mysql_error()."$sql_replace<br>LINE::".__LINE__);	
		}// if($j == $kvalgroup){ 
			
	}//end iif($rsc1[idcard] != ""){
			
	}//end 	while($rsp = mysql_fetch_assoc($result_loop)){
		
	### reset ชุดเอกสารที่แบ่งกลุ่ม qc
	
}//end 	function SubGroupOfMonth(){
	
	
function ResetSubGroupQC($staffid,$yymm,$kvalgroup){
	global $dbnameuse;
				$sql = "SELECT
			stat_user_person_temp.flag_id,
			stat_user_keyperson.datekeyin,
			stat_user_keyperson.staffid,
			Count(distinct idcard) AS num1,
			stat_user_person_temp.num_doc
			FROM
			stat_user_person_temp
			Inner Join stat_user_keyperson ON stat_user_person_temp.flag_id = stat_user_keyperson.flag_qc AND stat_user_person_temp.staffid = stat_user_keyperson.staffid
			WHERE
			stat_user_person_temp.dateqc LIKE  '$yymm%' AND
			stat_user_person_temp.num_doc =  '$kvalgroup' AND stat_user_keyperson.staffid='$staffid'
			group by stat_user_person_temp.staffid,stat_user_person_temp.flag_id
			having num1 < $kvalgroup
			order by num1 asc";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
			while($rs = mysql_fetch_assoc($result)){
					$sql1 = "SELECT DISTINCT
			stat_user_keyperson.idcard,
			stat_user_keyperson.datekeyin,
			stat_user_keyperson.staffid,
			stat_user_person_temp.flag_id,
			stat_user_person_temp.num_doc
			FROM
			stat_user_person_temp
			Inner Join stat_user_keyperson ON stat_user_person_temp.flag_id = stat_user_keyperson.flag_qc AND stat_user_person_temp.staffid = stat_user_keyperson.staffid
			WHERE
			stat_user_person_temp.dateqc LIKE  '$yymm%' AND
			stat_user_person_temp.num_doc <> '$kvalgroup' and stat_user_keyperson.staffid='$staffid' 
			group by stat_user_keyperson.idcard
			order by  stat_user_keyperson.idcard asc";
					$result1 = mysql_db_query($dbnameuse,$sql1) or die(mysql_error()."$sql1<br>LINE::".__LINE__);
					$numr1 = mysql_num_rows($result1);
					if($numr1 > 0){ // มีข้อมูลใน flag_qc อื่น
					$i=$rs[num1];
					while($rs1 = mysql_fetch_assoc($result1)){
						$i++;
						$sql_up1 = "UPDATE stat_user_keyperson SET flag_qc='$rs[flag_id]' WHERE datekeyin LIKE '$configdate%' AND idcard='$rs1[idcard]' AND staffid='$rs1[staffid]' ";
						//echo "$i :: $sql_up1<br>";
						mysql_db_query($dbnameuse,$sql_up1) or die(mysql_error()."$sql_up1<br>LINE::".__LINE__);
						if($i==$kvalgroup){ break;}
					}// end while($rs1 = mysql_fetch_assoc($result1)){
					
					}else{
							$sql_up2 = "REPLACE  INTO stat_user_person_temp SET flag_id='$rs[flag_id]',staffid='$rs[staffid]', num_doc='$rs[num1]'";
							mysql_db_query($dbnameuse,$sql_up2) or die(mysql_error()."$sql_up2<br>LINE::".__LINE__);
					}// end if($numr1 > 0){ 
			}//end while($rs = mysql_fetch_assoc($result)){	
			
}// end function ResetSubGroupQC($staffid,$yymm,$kvalgroup){
	
function SubQCGroupL($group_id,$yymm,$staffid=""){
	global $dbnameuse;
	if($staffid != ""){
			$constaff = "AND staffid='$staffid'";
	}else{
			$constaff = "";	
	}
	$sql = "SELECT
keystaff.staffid
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
WHERE
keystaff_group.groupkey_id =  '$group_id' AND
keystaff.status_permit =  'YES' AND
keystaff.status_extra =  'NOR' $constaff";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			 SubGroupOfMonth($rs[staffid],$yymm);
	}// end while($rs = mysql_fetch_assoc($result)){
		
}// end function SubQCGroupL(){
	
	################  funciton แบ่งกลุ่มการ QC
	function SubGroupQC($get_staffid){
		global $dbnameuse;
		$kvalgroup  = ShowQvalue($get_staffid); // จำนวนชุดที่ต้อง QC
		$str1 = "SELECT MAX(flag_qc) AS max_flag FROM stat_user_keyperson WHERE staffid='$get_staffid'";
		//echo $str1."<br>";
		$result1 = mysql_db_query($dbnameuse,$str1);
		$rs1 = mysql_fetch_assoc($result1);
		
		
		$str1x = "SELECT max(flag_id ) as max_flag FROM `stat_user_person_temp`  WHERE staffid='$get_staffid' ";
		$resultx = mysql_db_query($dbnameuse,$str1x);
		$rs1x = mysql_fetch_assoc($resultx);
		if($rs1[max_flag] > $rs1x[max_flag]){
				$xmaxFlag = $rs1x[max_flag];
		}else{
				$xmaxFlag = $rs1[max_flag];
		}//  end 	if($rs1[max_flag] > $rs1x[max_flag]){
		//$maxid = $rs1[max_flag];
		### ตรวจสอบว่าจำนวนรายการที่คีย์ใหม่ครบจำนวนที่จะ QC รึยัง
		//echo $rs1[max_flag]."<br>";
		if($xmaxFlag > 0){
			$sqlc1 = "SELECT COUNT(staffid) AS num2 FROM stat_user_keyperson WHERE staffid='$get_staffid' AND flag_qc='$xmaxFlag'";
			$resultc1 = mysql_db_query($dbnameuse,$sqlc1);
			$rsc1 = mysql_fetch_assoc($resultc1);
			$numcheck = $rsc1[num2]; // นับจำนวนรายการสุดท้ายหลังจากแบ่งชุด
		}//end 	if($rs1[max_flag] > 0){
			//echo "$kvalgroup :: $numcheck  :: $xmaxFlag ";die;
			if(($kvalgroup > $numcheck) and ($xmaxFlag > 0)){ // กรณีชุดสุดท้ายไม่ครบตามจำนวนที่คีย์
					$maxid = $rs1[max_flag];
					$j=$numcheck;
			}else{
					$maxid = $rs1[max_flag]+1;// กรณี
					$j=0;
			}
		
		
		$sql_count = "SELECT COUNT(idcard) AS num1  FROM stat_user_keyperson WHERE status_approve='1' AND staffid='$get_staffid' AND flag_qc='0'  GROUP BY staffid";
		$result_count = mysql_db_query($dbnameuse,$sql_count);
		$rs_count = mysql_fetch_assoc($result_count);
		$numr = $rs_count[num1];
		
		$sql = "SELECT * FROM stat_user_keyperson WHERE status_approve='1' AND staffid='$get_staffid' AND flag_qc='0'  ORDER BY datekeyin ASC";
		/// AND status_random_qc='0'
		$result = mysql_db_query($dbnameuse,$sql);
		//$numr = @mysql_num_rows($result);
		$loop_save = floor($numr/$kvalgroup); // จำนวนครั้งที่ต้อง qc
		//echo "<br>".$loop_save;
	//if($loop_save > 0){
			//$j=0;
			$loop1 = 0;
			while($rs = mysql_fetch_assoc($result)){
				####  ตรวจสอบกรณีมีเลขบัตรซ้ำ
				$sql_flag_qc = "SELECT COUNT(idcard) as numid FROM stat_user_keyperson WHERE idcard='$rs[idcard]'";
				$result_flag_qc = mysql_db_query($dbnameuse,$sql_flag_qc);
				$rs_qc = mysql_fetch_assoc($result_flag_qc);
				$num_idcard = $rs_qc[numid];
				#### end ตรวจสอบเลขบัตรซ้ำไม่นำมาคำนวณ
				if($num_idcard == 1){ // กำหนดจุด Qc เฉพาะ ที่มีเลขบัตรไม่ซ้ำเท่านั้น
				$j++;
				$sql_up = "UPDATE stat_user_keyperson SET flag_qc='$maxid' WHERE datekeyin='$rs[datekeyin]' AND staffid='$rs[staffid]' AND idcard='$rs[idcard]'";
				//echo "$sql_up<br>";
				mysql_db_query($dbnameuse,$sql_up);
				if($j == $kvalgroup){ // กรณีแบ่งกลุ่มครบจำนวนที่ต้อง qc
					$sql_insert = "REPLACE INTO stat_user_person_temp(flag_id,staffid,dateqc)VALUES('$maxid','$get_staffid','$rs[datekeyin]')";
					$result_insert = mysql_db_query($dbnameuse,$sql_insert);
					$maxid++;
					$j=0;
					$loop1++;
				}//end if($j == $kvalgroup){
				if($loop1 == $loop_save){ 
					$sql_insert = "REPLACE INTO stat_user_person_temp(flag_id,staffid,dateqc)VALUES('$maxid','$get_staffid','$rs[datekeyin]')";
					$result_insert = mysql_db_query($dbnameuse,$sql_insert);
				}
					
				}//end if($num_idcard == 1){
			}//end while($rs = mysql_fetch_assoc($result)){
		//}//end if($loop_save > 0){
	}//end function SubGroupQC(){
		
	function SubGroupQC_Script($get_staffid,$get_date=""){
		global $dbnameuse;
		
		if($get_date == ""){
				$condate = "AND datekeyin LIKE '".date("Y-m")."%'";
		}else{
				$condate = " AND datekeyin LIKE '$get_date%'";	
		}
		$kvalgroup  = ShowQvalue($get_staffid); // จำนวนชุดที่ต้อง QC
		$str1 = "SELECT MAX(flag_qc) AS max_flag FROM stat_user_keyperson WHERE staffid='$get_staffid' $condate ";
		//echo $kvalgroup." :: ".$str1."<br>";die;
		$result1 = mysql_db_query($dbnameuse,$str1) or die(mysql_error()."$str1<br>".__LINE__);
		$rs1 = mysql_fetch_assoc($result1);
		$maxloop = $rs1[max_flag];
				
		$str1x = "SELECT max(flag_id ) as max_flag FROM `stat_user_person_temp`  WHERE staffid='$get_staffid' ";
		$resultx = mysql_db_query($dbnameuse,$str1x) or die(mysql_error()."$str1x<br>".__LINE__);
		$rs1x = mysql_fetch_assoc($resultx);
		$minloop = $rs1x[max_flag];
		//echo "minloop :: $minloop  :: maxloop :: $maxloop <br>";
		//if($minloop != $maxloop){
			for($j=$minloop ; $j <= $maxloop;$j++){
					$sql_flag_qc = "SELECT status_random_qc,datekeyin,count(idcard) as num1  FROM stat_user_keyperson WHERE flag_qc='$j' AND staffid='$get_staffid'  $condate GROUP BY flag_qc";
					$result_flag_qc = mysql_db_query($dbnameuse,$sql_flag_qc)or die(mysql_error()."$sql_flag_qc<br>".__LINE__);
					$rs_qc = mysql_fetch_assoc($result_flag_qc);
					if($rs_qc[status_random_qc] == "1"){
							$qc_pass = 1;
					}else{
							$qc_pass = 0;	
					}
				
						$sql_count = "SELECT COUNT(idcard) as NUM1 FROM stat_user_keyperson WHERE flag_qc='$j' AND staffid='$get_staffid' GROUP BY flag_qc ";
						$result_count = mysql_db_query($dbnameuse,$sql_count)or die(mysql_error()."$sql_count<br>".__LINE__);
						$rscount = mysql_fetch_assoc($result_count);
					
					
					if($rscount[NUM1] > 1){
						$sql_insert = "REPLACE INTO stat_user_person_temp(flag_id,staffid,dateqc,num_doc,qc_pass)VALUES('$j','$get_staffid','$rs_qc[datekeyin]','$rs_qc[num1]','$qc_pass')";
						mysql_db_query($dbnameuse,$sql_insert)or die(mysql_error()."$sql_insert<br>".__LINE__);
					}//end 
					//echo $sql_insert."<br>";
					
			}
		//}//end if($minloop != $maxloop){
		
	}//end function SubGroupQC(){
		
		
		
	####### function update  alert key
	function UpdateAlertKey($month,$staffid=""){
			global $dbnameuse;
			if($staffid != ""){
					$constaff = " AND  staffid='$staffid'";
			}else{
					$constaff = "";	
			}
			$sql = "SELECT flag_id, staffid, dateqc FROM stat_user_person_temp WHERE  dateqc LIKE '$month%' AND qc_pass='0' $constaff";
			$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
			while($rs = mysql_fetch_assoc($result)){
				$sq_count = "SELECT count(distinct idcard) as num1 FROM  stat_user_keyperson WHERE flag_qc='$rs[flag_id]' and staffid='$rs[staffid]'
group by staffid";	
				$result_count = mysql_db_query($dbnameuse,$sq_count) or die(mysql_error()."$sq_count<br>LINE::".__LINE__);
				$rsc = mysql_fetch_assoc($result_count);
				if($rsc[num1] > 0){
						$sql_update = "UPDATE  stat_user_person_temp SET num_doc='$rsc[num1]'  WHERE flag_id='$rs[flag_id]' AND staffid='$rs[staffid]' ";
						mysql_db_query($dbnameuse,$sql_update) or die(mysql_error()."$sql_update<br>LINE::".__LINE__);
				}//end if($rsc[num1] > 0){
			}//end while($rs = mysql_fetch_assoc($result)){
	}//end function UpdateAlertKey($staffid,$month){

		
	#####  function ตรวจสอบ
function CheckLoopQC($get_date){
			global $dbnameuse;
			
//			$sql = "SELECT
//	Count(distinct flag_qc) AS num1,
//	staffid
//	FROM
//	stat_user_keyperson
//	WHERE
//	stat_user_keyperson.status_approve =  '1' AND
//	stat_user_keyperson.datekeyin LIKE  '$get_date%'  and flag_qc > 0
//	group by staffid";
			
			
	$sql = "
	SELECT
	staffid
	FROM
	stat_user_keyperson
	WHERE
	stat_user_keyperson.status_approve =  '1' AND
	stat_user_keyperson.datekeyin LIKE  '$get_date%'  and flag_qc > 0
	group by staffid";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$sql1 = "SELECT flag_qc FROM stat_user_keyperson WHERE stat_user_keyperson.status_approve =  '1' AND
	stat_user_keyperson.datekeyin LIKE  '$get_date%'  and flag_qc > 0 and staffid='$rs[staffid]' GROUP BY flag_qc";
		$result1 = mysql_db_query($dbnameuse,$sql1);
		$numr1 = @mysql_num_rows($result1);
		if($numr1 < 1){ $numr1 = 0;}
		//$arr1[$rs[staffid]] = $rs[num1];	
		$arr1[$rs[staffid]] = $numr1;	
	}//end while($rs = mysql_fetch_assoc($result)){
		return $arr1;
}//end  function CheckLoopQC($get_date){
	
####  นับช่องว่ามีการ QC แล้ว
	function CheckFlagQc($get_staffid,$get_flag_qc){
		global $dbnameuse;
		$sql = "SELECT COUNT(staffid) AS num1 FROM stat_user_keyperson WHERE staffid='$get_staffid'  AND flag_qc='$get_flag_qc' AND status_random_qc='1'";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
	}//end function CheckFlagQc($get_staffid,$get_flag_qc){
	
	#####  function หา flag_qc
	function FalgQcValue($loopx,$datekey,$staffid){
		global $dbnameuse;
		$sql = "SELECT
			stat_user_keyperson.datekeyin,
			stat_user_keyperson.flag_qc
			FROM `stat_user_keyperson`
			where datekeyin LIKE '$datekey%' and staffid='$staffid' and status_approve = '1'
			group by flag_qc";
			$result = mysql_db_query($dbnameuse,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
				$i++;
				if($i == $loopx){ $flag_qc = $rs[flag_qc];  break;}		
			}//end 
		return $flag_qc;
	}//end function FalgQcValue($loopx,$datekey,$staffid){
		
function GetMaxLoop($get_month,$key_group=""){
	global $dbnameuse;
	if($key_group != ""){
		$sql = "SELECT
max(stat_user_person_temp.flag_id) as flag_id,
stat_user_person_temp.staffid,
stat_user_person_temp.dateqc,
stat_user_person_temp.status_qc
FROM
stat_user_person_temp
Inner Join keystaff ON stat_user_person_temp.staffid = keystaff.staffid
WHERE
stat_user_person_temp.dateqc LIKE  '$get_month%' AND
keystaff.keyin_group =  '$key_group'
group by stat_user_person_temp.staffid";
	}else{
		$sql = "SELECT * FROM stat_user_person_temp WHERE dateqc LIKE '$get_month%'";
	}
	//echo $sql."<br>";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arrF[$rs[staffid]][$rs[flag_id]] = $rs[flag_id];	
	}
	//echo "<pre>";
	//print_r($arrF);
	return $arrF;
}//end function GetMaxLoop($get_month){

####   หาค่า ต่ำสุดของ flag_id ของแต่ละคน

function GetMinFlag($get_month,$key_group){
	global $dbnameuse;
		$sql = "SELECT
MIN(stat_user_person_temp.flag_id) as flag_id,
stat_user_person_temp.staffid,
stat_user_person_temp.dateqc,
stat_user_person_temp.status_qc
FROM
stat_user_person_temp
Inner Join keystaff ON stat_user_person_temp.staffid = keystaff.staffid
WHERE
stat_user_person_temp.dateqc LIKE  '$get_month%' AND
keystaff.keyin_group =  '$key_group'
group by stat_user_person_temp.staffid";
//echo $sql."<br>";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arrF[$rs[staffid]] = intval($rs[flag_id]);	
	}
	
	return $arrF;
}//end function GetMinFlag($get_month,$key_group){
	
	
function GetMaxFlag($get_month,$key_group){
	global $dbnameuse;
		$sql = "SELECT
MAX(stat_user_person_temp.flag_id) as flag_id,
stat_user_person_temp.staffid
FROM
stat_user_person_temp
Inner Join keystaff ON stat_user_person_temp.staffid = keystaff.staffid
WHERE
stat_user_person_temp.dateqc LIKE  '$get_month%' AND
keystaff.keyin_group =  '$key_group'
group by stat_user_person_temp.staffid";

	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		$arrF[$rs[staffid]] = intval($rs[flag_id]);	
	}
	
	return $arrF;
}//end function GetMinFlag($get_month,$key_group){
	
	function CheckAlertQcOld($get_flagid,$get_staffid){
	global $dbnameuse;
	$sql = "SELECT count(stat_user_keyperson.idcard) as num1, stat_user_keyperson.idcard FROM
validate_checkdata Inner Join stat_user_keyperson ON validate_checkdata.idcard = stat_user_keyperson.idcard AND validate_checkdata.staffid = stat_user_keyperson.staffid
where stat_user_keyperson.flag_qc='$get_flagid' and stat_user_keyperson.staffid='$get_staffid'
group by stat_user_keyperson.idcard";
//echo "db :: ".$dbnameuse." :::  $sql<br>";
	$result = mysql_db_query($dbnameuse,$sql);
	//$numr1 = @mysql_num_rows($result);
	$rs = mysql_fetch_assoc($result);
//		if($rs[idcard] != ""){
//				$sql_update = "UPDATE stat_user_keyperson SET status_random_qc='1' WHERE staffid='$get_staffid' AND flag_qc='$get_flagid' AND  idcard='$rs[idcard]'";
//				@mysql_db_query($dbnameuse,$sql_update);
//		}
	//$arrF[$rs[idcard]] = $rs[num1];
	return $rs[idcard]."::".$rs[num1];
}//end function CheckAlertQcOld($get_flagid,$get_staffid){
	
function CheckAlertQcOld1($get_flagid,$get_staffid){
	global $dbnameuse;
	$sql = "SELECT count(stat_user_keyperson.idcard) as num1, stat_user_keyperson.idcard FROM
validate_checkdata Inner Join stat_user_keyperson ON validate_checkdata.idcard = stat_user_keyperson.idcard AND validate_checkdata.staffid = stat_user_keyperson.staffid
where stat_user_keyperson.flag_qc='$get_flagid' and stat_user_keyperson.staffid='$get_staffid'
group by stat_user_keyperson.idcard";
//echo "db :: ".$dbnameuse." :::  $sql<br>";
	$result = mysql_db_query($dbnameuse,$sql);
	//$numr1 = @mysql_num_rows($result);
	$rs = mysql_fetch_assoc($result);
		if($rs[idcard] != ""){
				$sql_update = "UPDATE stat_user_keyperson SET status_random_qc='1' WHERE staffid='$get_staffid' AND flag_qc='$get_flagid' AND  idcard='$rs[idcard]'";
				mysql_db_query($dbnameuse,$sql_update);
		}
	//$arrF[$rs[idcard]] = $rs[num1];
	return $rs[idcard]."::".$rs[num1];
}//end function function CheckAlertQcOld1($get_flagid,$get_staffid){

	
##  function ตรวจสอบ ข้อมูลบรรทัดสุดท้ายใน salary ว่าเป็นข้อมูลปัจจุบันรึยัง
function KeyDataCurrent($get_idcard){
	global $date_checkkey,$dbnamemaster;
	$sql_view = "SELECT siteid FROM view_general WHERE CZ_ID = '$get_idcard' ";
	$result_view = mysql_db_query($dbnamemaster,$sql_view);
	$rsv = mysql_fetch_assoc($result_view);
	$db_site = STR_PREFIX_DB.$rsv[siteid];
	$sql_salary = "SELECT COUNT(id) AS numsalary FROM salary WHERE id='$get_idcard' AND date LIKE '%$date_checkkey%'";
	$result_salary = mysql_db_query($db_site,$sql_salary);
	$rs_salary = mysql_fetch_assoc($result_salary);
	return $rs_salary[numsalary];
}//end function KeyDataCurrent($get_idcard){
	
	
	###  ตรวจสอบว่าถ้ามีการคีย์อยู่จะไม่อนุญาติให้ QC
function CheckOnlineKey($get_idcard){
	global $dbsystem;
	$sql = "SELECT COUNT(username) as numkey FROM useronline WHERE username='$get_idcard'";
	//echo "$sql";
	$result = mysql_db_query($dbsystem,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numkey];	
}// end function CheckOnlineKey(){
	
	
function SaveGroupKeyData($staffid,$key_group,$change_group=""){
	global $dbnameuse;
	
	if($change_group != ""){
			$change_date = $change_group;
	}else{
			$change_date = date("Y-m-d");		
	}//end if($change_group != ""){
		
	$sql_check = "SELECT *  FROM keystaff  WHERE staffid='$staffid'";
	$result_check = mysql_db_query($dbnameuse,$sql_check);
	$rsc = mysql_fetch_assoc($result_check);
	if($rsc[keyin_group] != $key_group){
		$sql_log = "SELECT * FROM keystaff_log_group WHERE staffid='$staffid' AND keyin_group='$rsc[keyin_group]' ORDER BY updatetime DESC LIMIT 0,1";
		$result_log = mysql_db_query($dbnameuse,$sql_log);
		$rsl = mysql_fetch_assoc($result_log);
		if($rsl[start_date] != "0000-00-00" and $rsl[start_date] != ""){
				$sql_update = "UPDATE keystaff_log_group SET end_date='$change_date'  WHERE runid='$rsl[runid]'";
				mysql_db_query($dbnameuse,$sql_update);
		}//end if($rsl[start_date] != "0000-00-00" and $rsl[start_date] != ""){
		
		$sql_save = "INSERT INTO keystaff_log_group SET staffid='$staffid' , keyin_group='$key_group',start_date='$change_date'";	
		mysql_db_query($dbnameuse,$sql_save);
	}else{
			$sql_count = "SELECT COUNT(staffid) AS num1 FROM keystaff_log_group WHERE staffid='$staffid'";
			$result_count = mysql_db_query($dbnameuse,$sql_count);
			$rsc1 = mysql_fetch_assoc($result_count);
		if($rsc1[num1] < 1){
		$sql_save = "INSERT INTO keystaff_log_group SET staffid='$staffid' , keyin_group='$key_group',start_date='$change_date'";	
		mysql_db_query($dbnameuse,$sql_save);	
		}//end if($rsc1[num1] < 1){
	}//end if($rsc[keyin_group] != $key_group){
		
}//end function SaveGroupKeyData(){
	
	
function SaveJobNameData($staffid,$jobname){
	global $dbnameuse;
	$sql_check = "SELECT *  FROM keystaff  WHERE staffid='$staffid'";
	$result_check = mysql_db_query($dbnameuse,$sql_check);
	$rsc = mysql_fetch_assoc($result_check);
	if($rsc[status_extra] != $jobname){
		$sql_log = "SELECT * FROM keystaff_log_change_job WHERE staffid='$staffid' AND keyin_group='$rsc[status_extra]' ORDER BY updatetime DESC LIMIT 0,1";
		$result_log = mysql_db_query($dbnameuse,$sql_log);
		$rsl = mysql_fetch_assoc($result_log);
		if($rsl[start_date] != "0000-00-00" and $rsl[start_date] != ""){
				$sql_update = "UPDATE keystaff_log_change_job SET end_date='".date("Y-m-d")."'  WHERE runid='$rsl[runid]'";
				mysql_db_query($dbnameuse,$sql_update);
		}//end if($rsl[start_date] != "0000-00-00" and $rsl[start_date] != ""){
		
		$sql_save = "INSERT INTO keystaff_log_change_job SET staffid='$staffid' , jobname='$jobname',start_date='".date("Y-m-d")."'";	
		mysql_db_query($dbnameuse,$sql_save);
	}//end if($rsc[keyin_group] != $key_group){
}//end function SaveJobNameData($staffid,$jobname){

######## ฟังก์ชั้นหาวันที่ทำการ QC
function GetDateQC($get_idcard,$staffid,$ticketid){
	global $dbnameuse;
	$sql_date = "SELECT qc_date FROM validate_checkdata WHERE validate_checkdata.idcard='$get_idcard' AND validate_checkdata.staffid='$staffid' AND validate_checkdata.ticketid='$ticketid' ";
	$result_date = mysql_db_query($dbnameuse,$sql_date);
	$rsd = mysql_fetch_assoc($result_date);
	return $rsd[qc_date];	
}//end function GetDateQC(){
	
#####  funciton หาคะแนน Ratio กลุ่มการคีย์ข้อมูลตามช่วงเวลา
function FindGroupKeyData($get_staffid,$yymm){
	global $dbnameuse;
	$sql = "SELECT  stat_user_keyin.datekeyin, stat_user_keyin.keyin_group, stat_user_keyin.rpoint FROM stat_user_keyin WHERE  staffid='$get_staffid' AND datekeyin LIKE '$yymm%' ORDER BY datekeyin ASC ";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[datekeyin]]['kgroup'] = $rs[keyin_group];
			$arr[$rs[datekeyin]]['rpoint'] = $rs[rpoint];
	}// end 	while($rs = mysql_fetch_assoc($result)){
		return $arr;

}//end function FindGroupKeyData($get_staffid,$get_date){

	
	
function ShowThaiDateTime($d){
global $shortmonth;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	$xd1 = explode(" ",$d);
	$d1=explode("-",$xd1[0]);
	if($xd1[1] != ""){
			$time1 = " เวลา ".$xd1[1];
	}else{
			$time1 = "";	
	}
	return intval($d1[2]) . " " . $shortmonth[intval($d1[1])] . " " . (intval($d1[0]) + 543).$time1;
}

###################################  end หาคะแนน Ratio กลุ่มการคีย์ข้อมูลตามช่วงเวลา
####  สำหรับกลุ่ม C ตรวจสอบการ qc ก่อนการเปลี่ยนกลุ่ม  เงื่อนไขคือต้อง QC หมดก่อนแล้วจึงสามารถเปลี่ยนกลุ่มได้
	function CheckQCChangeGroup($get_staffid,$get_date=""){
		global $db_name;
		if($get_date == ""){
				$get_date = date("Y-m");// กรณีไม่ส่งวันที่มาให้เอาค่าวันที่ ปัจุบันเป็นการตรวจสอบ
		}
		$sql = "SELECT count(staffid) as num1  FROM temp_check_qc WHERE staffid='$get_staffid' AND datekeyin LIKE '$get_date%'  and numkey > 0 and numkey<>numqc ORDER BY datekeyin ASC";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
	}// end function CheckQCChangeGroup(){
		
	###  ตรวจสอบการ QC  ก่อนเปลี่ยนกลุ่มสำหรับกลุ่ม A และ B
	function CheckQCChangeGroupAB($get_staffid,$get_date=""){
		global $db_name;	
		if($get_date == ""){
				$get_date = date("Y-m");// กรณีไม่ส่งวันที่มาให้เอาค่าวันที่ ปัจุบันเป็นการตรวจสอบ
		}
			
			$rpoint = ShowQvalue($get_staffid);
			
		$sql = "SELECT count(flag_qc) as numf, flag_qc,staffid  FROM `stat_user_keyperson` where datekeyin like '$get_date%' and staffid='$get_staffid' and flag_qc > 0  group by flag_qc having numf >= $rpoint  order by flag_qc DESC  LIMIT 1";
		$result = mysql_db_query($db_name,$sql);
		$intA=0;
		while($rs = mysql_fetch_assoc($result)){
			$sql_temp = "SELECT count(idcard) as num1 FROM `stat_user_keyperson` WHERE stat_user_keyperson.status_random_qc =  '1' AND
stat_user_keyperson.staffid =  '$get_staffid' AND stat_user_keyperson.flag_qc =  '$rs[flag_qc]' GROUP BY stat_user_keyperson.staffid";
			//echo $sql_temp."<br>";
			$result_temp = mysql_db_query($db_name,$sql_temp);
			$rst = mysql_fetch_assoc($result_temp);

			$sql1 = "SELECT count(stat_user_keyperson.idcard) as num1, stat_user_keyperson.idcard FROM
validate_checkdata Inner Join stat_user_keyperson ON validate_checkdata.idcard = stat_user_keyperson.idcard AND validate_checkdata.staffid = stat_user_keyperson.staffid
where stat_user_keyperson.flag_qc='$rs[flag_qc]' and stat_user_keyperson.staffid='$get_staffid'
group by stat_user_keyperson.idcard";	
			//echo $sql1."<br>";
			$result1 = mysql_db_query($db_name,$sql1);
			$rs1 = mysql_fetch_assoc($result1);
			if($rst[num1] < 1 and $rs1[num1] < 1){
				$intA++;
			}	
			//echo "<hr>";
		}// end while($rs = mysql_fetch_assoc($result)){
			//echo "ค้าง QC  :: $intA<br>";
		return $intA;
	}// end 	function CheckQCChangeGroupAB($get_staffid,$get_date=""){
		
		
		$dbname_temp = "edubkk_checklist";
	
	$month = array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
function ShowDateProfile($get_profile){
	global $dbname_temp,$month;
	$sql = "SELECT * FROM tbl_checklist_profile WHERE profile_id='$get_profile'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
		if($rs[profile_date] != "" and $rs[profile_date] != "0000-00-00"){
			$arr = explode("-",$rs[profile_date]);
			return "(ข้อมูล ณ วันที่ ".intval($arr[2])." ".$month[intval($arr[1])]." ".($arr[0]+543).")";
		}else{
			return $rs[profilename];	
		}

		
}//end function ShowDateProfile(){
	
### function ตรวจสอบไฟล์ scan
function CheckFileKp7($idcard,$siteid){
	global $db_temp,$pathkp7file;
	$kp7file = "$pathkp7file".$siteid."/".$idcard.".pdf";
	//echo "<a href='$kp7file'>$kp7file</a>".$kp7file."<br>";
	if(is_file($kp7file)){
			return 1;
	}else{
			return 0;	
	}	
}//end function CheckFileKp7($idcard,$siteid){
	
##########  function ตรวจสอบ รูปภาพใน ก.พ.7
function CheckFileImageKp7($idcard,$profile_id){
	global $db_temp;
	$sql = "SELECT
count(tbl_checklist_kp7.idcard) AS numid,
tbl_checklist_kp7.pic_num
FROM
tbl_checklist_kp7
Inner Join upload_general_pic ON tbl_checklist_kp7.idcard = upload_general_pic.id
WHERE
tbl_checklist_kp7.idcard =  '$idcard' AND tbl_checklist_kp7.profile_id='$profile_id' AND upload_general_pic.cmss_entry='yes'
GROUP BY tbl_checklist_kp7.idcard";
//echo $db_temp." :: ".$sql;


$sql_checklist = "SELECT count(idcard) as num1 FROM tbl_checklist_kp7 WHERE  idcard='$idcard' and profile_id='$profile_id' and pic_num > 0 group by idcard";
$result_checklist = mysql_db_query($db_temp,$sql_checklist);
$rsc = mysql_fetch_assoc($result_checklist);

	$result = mysql_db_query($db_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	$check_list = intval($rsc[num1]);
	if($rs[numid] > 0 and $rs[pic_num] > 0){
			return 1;
	}else if($check_list < 1){
			return 1;
	}else{
			return 0;	
	}//end if($rs[numid] > 0){
}//end CheckFileImageKp7($idcard,$profile_id)

##########  ตรวจสอบสถานะเอกสารที่สมบูรณ์จาก checklist
function CheckStatusChecklist($idcard,$profile_id){
	global $db_temp;
	$sql = "SELECT COUNT(idcard) AS numid FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($db_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numid];
}//end CheckStatusChecklist($idcard,$profile_id)
############  function ตรวจสอบ protection ก่อนมอบหมายงาน
function CheckProtectionAssign($idcard,$siteid,$profile_id){
	global $db_name;
	$xsql = "SELECT * FROM tbl_assign_protection WHERE status_active='1'";
	$xresult = mysql_db_query($db_name,$xsql);
	$intA=0;
	while($xrs = mysql_fetch_assoc($xresult)){
		if($xrs[status_file_name] == "status_file"){
				$str = CheckFileKp7($idcard,$siteid);
		}else if($xrs[status_file_name] == "status_img"){
				$str = CheckFileImageKp7($idcard,$profile_id);
		}else if($xrs[status_file_name] == "status_data"){
				$str = CheckStatusChecklist($idcard,$profile_id);
		}
		
		//$str = $xrs[string_function];
		//echo $str." :: $idcard :: $siteid :: $profile_id <br>";
		if($str < 1){
			$intA++;
			$msg .= "$xrs[msg_name]<br>";
			$status_file = "$xrs[runid]";	 
		}	
	}//end while($xrs = mysql_fetch_assoc($xresult)){
		
	$arr[0] = $intA;
	$arr[1] = "$msg";
	$arr[2] = $status_file;
	return $arr;
}//end function CheckProtectionAssign($idcard,$siteid,$profile_id){\\


####  funciton แสดงโฟร์ไฟล์ล่าสุด
function LastProfile(){
	global $db_temp;
		$sql_profile = "SELECT * FROM tbl_checklist_profile WHERE status_active ='1' ORDER BY profile_date DESC LIMIT 0,1";
		$result_profile = mysql_db_query($db_temp,$sql_profile);
		$rspro = mysql_fetch_assoc($result_profile);
		$profile_id = $rspro[profile_id];
		return $profile_id;

}//end function LastProfile(){
	
function CheckPicChecklistToCmss($profile_id,$idcard,$siteid){
	global $db_temp;
	$db_site = STR_PREFIX_DB.$siteid;
	$sql = "SELECT pic_num FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	//echo $db_temp." ".$sql."<br>";
	$result = @mysql_db_query($db_temp,$sql);
	$rs = @mysql_fetch_assoc($result);
	$sql_site = "SELECT COUNT(id) as numid FROM general_pic WHERE id='$idcard' AND kp7_active='1'";
	//echo $db_site." ".$sql_site;
	$result_site = @mysql_db_query($db_site,$sql_site);
	$rss = @mysql_fetch_assoc($result_site);
	if($rs[pic_num] == $rss[numid]){
		return 1;
	}else{
		return 0;	
	}
		
}//end 
	
#############  function หา staffid parttime
function GetStaffid($type="",$gid=""){
	global $dbnameuse;
	if($type == ""){
			$conw = " AND period_time='pm'";
	}else if($type == "am"){
			$conw = " AND period_time='am'";
	}else{
			$conw = " AND period_time='pm' ";	
	}//end 	if($type == ""){
		
	if($gid != ""){
			$conw1 = " AND keyin_group='$gid'";
	}else{
			$conw1 = "";	
	}
		
		$sql = "SELECT staffid FROM keystaff WHERE status_permit='YES' $conw $conw1 ";
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
			if($inid > "") $inid .= ",";
			$inid .= "'$rs[staffid]'";
				
		}//end while($rs = mysql_fetch_assoc($result)){
	return $inid;	
}//end function GetStaffid($type=""){
	
	
########## function ตรวจสอบว่าข้อมูลบัตรประชาชนนี้ได้ทำการสุ่มตรวจไปแล้ว
function GetSubGroupQC($idcard,$staffid,$yymm){
	global $dbnameuse;
	$sql = "SELECT * FROM stat_user_keyperson WHERE idcard='$idcard' AND staffid='$staffid' and flag_qc > 0 and datekeyin >= '$yymm' ";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[flag_qc];
}// end function GetSubGroupQC($idcard,$staffid){
	
function CheckListQCPerson($idcard,$staffid,$yymm){
	global $dbnameuse;
		$month_before = GetMonthBefore($yymm); // เดือนก่อนหน้านี้
		$sql = "SELECT count(idcard) as num1 FROM validate_checkdata WHERE idcard='$idcard' and staffid='$staffid' and (qc_date LIKE '$yymm%' or qc_date LIKE '$month_before%')";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}//end 


	function GetRatio(){
		global $dbnameuse;
		$sql = "SELECT * FROM `keystaff_ratio`";	
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$arr_group[$rs[ratio_id]] = $rs[ratio_value];	
		}
		return $arr_group;
	}//end function GetRatio(){
		
	function GetRatioFromGroup(){
		global $dbnameuse;
		$sql = "SELECT groupkey_id,rpoint FROM `keystaff_group`";	
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
			$arr_group[$rs[groupkey_id]] = $rs[rpoint];	
		}
		return $arr_group;

	}
	
	#### GetRatio กลุ่ม N
	function GetRatioGroup($staffid){
		global $dbnameuse;
		$arr_ratio = GetRatio();
		$arr_rgroup = GetRatioFromGroup();
		$sql = "SELECT * FROM keystaff WHERE staffid='$staffid' ";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		$rs = mysql_fetch_assoc($result);
		$ratio = $arr_ratio[$rs[ratio_id]];
		if($ratio == ""){
			$ratio = $arr_rgroup[$rs[keyin_group]];	
		}
		return $ratio;	
	}//end function GetRatioGroup($staffid){

?>