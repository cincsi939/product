<?
session_start();
header("Expires: Mon, 26 April 2003 09:09:09 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("cache-Control: no-store, no-cache, must-revalidate"); 
header("cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache"); 
require_once("../../config/conndb_nonsession.inc.php");





$db_name =DB_USERENTRY;
$dbnamemaster=DB_MASTER;
$dbsystem = "edubkk_system";
$dbnameuse = $db_name;
$base_point = 240;
$base_point_pm = 120;
$point_w = 0.5; // ค่าคะแนนที่คิดเป็นเงิน
$numdoc = 3;// ค่าเฉลี่ยในการคูณจำนวณชุดที่ผิด
$val5 = 5;// ค่าคะแนนคูณ 5 ในตำแหน่งสายบริหารการศึกษา
$date_checkkey = "2552-10-01"; // ข้อมูล ณ วันที่ 
$dbnameuse = DB_USERENTRY;
$db_temp = DB_CHECKLIST;
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
$staff_recivekey = 10238;



//system data base
$sysdbname =""  ;
$aplicationpath=DB_MASTER;
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
			
$path_pdf = "../../../edubkk_kp7file/";
$imgpdf = "<img src='../../images_sys/gnome-mime-application-pdf.png' alt='สำเนา ก.พ.7 ต้นฉบับ' width='20' height='21' border='0'>";	
			
			// gen_id
			$arr_f_tbl3 = array( "hr_addhistoryaddress#gen_id||runid","hr_addhistoryfathername#gen_id||runid" , "hr_addhistorymarry#gen_id||runid" , "hr_addhistorymothername#gen_id||runid" , "hr_addhistoryname#gen_id||runid" );			

			$subfix = "_log_after";
			$subfix_befor = "_log_before";
			
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


function DBThaiLongDateFull($d){
global $monthname;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . (intval($d1[0]) + 543);
}


function DBThaiLongDateS($d){
global $shortmonth;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $shortmonth[intval($d1[1])] . " " . substr((intval($d1[0]) + 543),-2);
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
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " พ.ศ. " . $d1[0];
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
		$strsql = "SELECT 
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
";
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
validate_checkdata.status_cal='0' and validate_checkdata.status_process_point='YES'";

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
	
	
function ShowRatioDate($kgroup){
	global $dbnameuse;
	$sql = "SELECT rpoint FROM keystaff_group WHERE groupkey_id='$kgroup'";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[rpoint];
}//end function ShowRatioDate($kgroup){
	
function CheckGroupKeyRatio($staffid,$datekeyin){
	global $dbnameuse;
	$sql = "SELECT rpoint  FROM stat_user_keyin  WHERE  staffid='$staffid' AND datekeyin='$datekeyin'";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[rpoint];
}// end function CheckGroupKeyRatio($staffid,$datekeyin){
	
#####  function แสดงค่า Ratio การ QC ของแต่ละกลุ่มข้อมูล
function ShowQvalue($get_staffid){
	global $dbnameuse;
/*	$sqlQ = "SELECT
keystaff_group.rpoint
FROM
keystaff
Inner Join keystaff_group ON keystaff.keyin_group = keystaff_group.groupkey_id
WHERE
keystaff.staffid =  '$get_staffid'";
	$resultQ = mysql_db_query($dbnameuse,$sqlQ);
	$rsQ = mysql_fetch_assoc($resultQ);
	return $rsQ[rpoint];*/
	return GetRatioGroup($get_staffid);
}//end function ShowQvalue($get_staffid){

function NumP($get_staffid,$get_idcard){
	global $dbnameuse;
	$sqlP = "SELECT COUNT(distinct idcard) as num1 FROM `validate_checkdata`  where staffid='$get_staffid'  and idcard ='$get_idcard' GROUP BY idcard";
	$resultP = mysql_db_query($dbnameuse,$sqlP) or die(mysql_error()."$sqlP<br>LINE::".__LINE__);
	$rsp = mysql_fetch_assoc($resultP);
	#$numP = @mysql_num_rows($resultP);
	return $rsp[num1];
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
	
	################  funciton แบ่งกลุ่มการ QC
	function SubGroupQC($get_staffid){
		global $dbnameuse;
		$kvalgroup  = ShowQvalue($get_staffid); // จำนวนชุดที่ต้อง QC
		$str1 = "SELECT MAX(flag_qc) AS max_flag FROM stat_user_keyperson WHERE staffid='$get_staffid'";
		//echo $str1."<br>";
		$result1 = mysql_db_query($dbnameuse,$str1);
		$rs1 = mysql_fetch_assoc($result1);
		//$maxid = $rs1[max_flag];
		### ตรวจสอบว่าจำนวนรายการที่คีย์ใหม่ครบจำนวนที่จะ QC รึยัง
		if($rs1[max_flag] > 0){
			$sqlc1 = "SELECT COUNT(staffid) AS num2 FROM stat_user_keyperson WHERE staffid='$get_staffid' AND flag_qc='$rs1[max_flag]'";
			$resultc1 = mysql_db_query($dbnameuse,$sqlc1);
			$rsc1 = mysql_fetch_assoc($resultc1);
			$numcheck = $rsc1[num2]; // นับจำนวนรายการสุดท้ายหลังจากแบ่งชุด
		}//end 	if($rs1[max_flag] > 0){
			
			if(($kvalgroup > $numcheck) and ($rs1[max_flag] > 0)){ // กรณีชุดสุดท้ายไม่ครบตามจำนวนที่คีย์
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
				$sql_flag_qc = "SELECT COUNT(idcard) as numid  FROM stat_user_keyperson WHERE idcard='$rs[idcard]' group by idcard ";
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
				$sql_random_qc = "SELECT COUNT(idcard) as numqc  FROM stat_user_keyperson WHERE flag_qc='$maxid' and staffid='$get_staffid' AND status_random_qc='1' ";
				$result_random_qc = mysql_db_query($dbnameuse,$sql_random_qc);
				$rsr_qc = mysql_fetch_assoc($result_random_qc);
				$xflag_qc = $rsr_qc[numqc];
					$sql_insert = "REPLACE INTO stat_user_person_temp(flag_id,staffid,dateqc,num_doc,qc_pass)VALUES('$maxid','$get_staffid','$rs[datekeyin]','$j','$xflag_qc')";
					$result_insert = mysql_db_query($dbnameuse,$sql_insert);
					$maxid++;
					$j=0;
					$loop1++;
				}//end if($j == $kvalgroup){
				if($loop1 == $loop_save){ 
				$sql_random_qc = "SELECT COUNT(idcard) as numqc  FROM stat_user_keyperson WHERE flag_qc='$maxid' and staffid='$get_staffid' AND status_random_qc='1' ";
				$result_random_qc = mysql_db_query($dbnameuse,$sql_random_qc);
				$rsr_qc = mysql_fetch_assoc($result_random_qc);
				$xflag_qc = $rsr_qc[numqc];

					$sql_insert = "REPLACE INTO stat_user_person_temp(flag_id,staffid,dateqc,num_doc,qc_pass)VALUES('$maxid','$get_staffid','$rs[datekeyin]','$loop1','$xflag_qc')";
					$result_insert = mysql_db_query($dbnameuse,$sql_insert);
				}
					
				}//end if($num_idcard == 1){
			}//end while($rs = mysql_fetch_assoc($result)){
		//}//end if($loop_save > 0){
	}//end function SubGroupQC(){
		
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
		$result_log = mysql_db_query($dbnameuse,$sql_log) or die(mysql_error());
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
	
#######  หาค่า ratio ของกลุ่ม ณ วันที่
function GetKeyinGroupDate($get_staffid,$get_date){
	global $dbnameuse;
	$sql = "SELECT keyin_group  FROM stat_user_keyin  WHERE  staffid='$get_staffid' AND datekeyin='$get_date' ";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[keyin_group];
}//end function GetKeyinGroupDate($get_staffid,$get_date){
	
	
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
		
		
		$dbname_temp = DB_CHECKLIST;
	
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
	$sql = "SELECT idcard,siteid,pic_num,pic_upload FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($db_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	$db_site = STR_PREFIX_DB.$rs[siteid];
	$sql_general_pic = "SELECT COUNT(id) as numpic FROM general_pic WHERE id='$idcard'";
	$result_general_pic = mysql_db_query($db_site,$sql_general_pic);
	$rspic = mysql_fetch_assoc($result_general_pic);
	$numpic_sys = $rspic[numpic];// จำนวนรูปจริงในระบบ
	
	$numch_pic = intval($rs[pic_num]); // จำนวนคนนับใน checklist
	if($numch_pic == 0){
			return 1;
	}else if($numch_pic > 0 and $rs[pic_num] == $numpic_sys){
			return 1;
	}else if($numch_pic  > 0 and  $rs[pic_num] != $numpic_sys){
			return 2;// 
	}else{
			return 0;	
	}
	
}//end CheckFileImageKp7($idcard,$profile_id)

##########  ตรวจสอบสถานะเอกสารที่สมบูรณ์จาก checklist
function CheckStatusChecklist($idcard,$profile_id){
	global $db_temp;
	$sql = "SELECT COUNT(idcard) AS numid FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id' and status_numfile='1' and status_file='1' and status_check_file='YES' and (mainpage IS NULL  or mainpage='' or mainpage='1') and status_id_false='0'";
	$result = mysql_db_query($db_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numid];
}//end CheckStatusChecklist($idcard,$profile_id)

###############  function แสดงการตรวจสอบไฟล์ pdf ต้นฉบับในระบบ รวมทั้งแสดง icon ไฟล์ pdf จากระบบ

############  function ตรวจสอบ protection ก่อนมอบหมายงาน
function CheckProtectionAssign($idcard,$siteid,$profile_id){
	global $db_name,$path_pdf,$imgpdf,$db_temp;
	$path_pdfx = $path_pdf.$siteid."/".$idcard.".pdf";
	$xsql = "SELECT * FROM tbl_assign_protection WHERE status_active='1'";
	$xresult = mysql_db_query($db_name,$xsql);
	$intA=0;
	while($xrs = mysql_fetch_assoc($xresult)){
		if($xrs[status_file_name] == "status_file"){/// กรณีการตรวจสอบไฟล์ไม่พบเนื่องจากอาจจะทำการย้ายไปเขตอื่นแล้ว
					$str = CheckFileKp7($idcard,$siteid);
				//echo "before : $str<br>";
				if($str < 1){ ##  ตรวจสอบโดยการหาที่อยู่ไฟล์ จากเขตอื่น 
					//echo "<a href='$path_pdfx' target='_blank'><img src='$imgpdf'></a><br>";
					$xarr = GetPdfOrginal($idcard,$path_pdf,$imgpdf,"","pdf");
					$str = $xarr['numfile'];
				}//end if($str < 1){ ##  ตรวจสอบโดยการหาที่อยู่ไฟล์ จากเขตอื่น 
				
				
		}else if($xrs[status_file_name] == "status_img"){
				$str = CheckFileImageKp7($idcard,$profile_id);
		}else if($xrs[status_file_name] == "status_data"){
				$str = CheckStatusChecklist($idcard,$profile_id);
		}
		
		//$str = $xrs[string_function];
		//echo $str." :: $idcard :: $siteid :: $profile_id <br>";
		if($xrs[status_file_name] == "status_img"){
			if($str > 1){ // จำนวนรูปคนนับกับระบบ up ไม่เท่ากัน
			$sql_pic = "SELECT idcard,siteid,pic_num,pic_upload FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
			$result_pic = mysql_db_query($db_temp,$sql_pic);
			$rspic = mysql_fetch_assoc($result_pic);
				$db_site = STR_PREFIX_DB.$rspic[siteid];
				$sql_general_pic = "SELECT COUNT(id) as numpic FROM general_pic WHERE id='$idcard'";
				$result_general_pic = mysql_db_query($db_site,$sql_general_pic);
				$rspic1 = mysql_fetch_assoc($result_general_pic);
				$numpic_sys = $rspic1[numpic];// จำนวนรูปจริงในระบบ

			
			
				$intA++;	
				$msg .= "จำนวนรูปในระบบไม่ครบ พนักงานนับมี $rspic[pic_num] รูป นำเข้าไปในระบบมี $numpic_sys รูป<br>";
				$status_file = "$xrs[runid]";	 
			}else if($str == 0){
				$intA++;
				$msg .= "$xrs[msg_name]<br>";
				$status_file = "$xrs[runid]";	 	
			}
		}else{
			if($str < 1){
				$intA++;
				$msg .= "$xrs[msg_name]<br>";
				$status_file = "$xrs[runid]";	 
			}	
		}
	}//end while($xrs = mysql_fetch_assoc($xresult)){
		
	$arr[0] = $intA;
	$arr[1] = "$msg";
	$arr[2] = $status_file;
	$arr[3] = $xarr['linkfile'];
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
	
function CheckNunPointList($idcard,$staffid,$datekey){
	global $dbnameuse;
		$sql = "SELECT COUNT(idcard) AS NUM1 FROM stat_user_keyperson_table WHERE idcard='$idcard' AND staffid='$staffid' AND datekeyin='$datekey'  GROUP BY idcard";
		$result = mysql_db_query($dbnameuse,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[NUM1];
		
}//end function CheckNunPointList(){
	
function SumPageTicket($ticketid){
	global $dbnameuse;
	$sql = "SELECT
	count(t2.idcard) as num_doc,
sum(t3.page_upload) as sumpage
FROM ".DB_USERENTRY.".tbl_assign_sub as t1
Inner Join ".DB_USERENTRY.".tbl_assign_key as t2 ON t1.ticketid =t2.ticketid
Inner Join  ".DB_CHECKLIST.".tbl_checklist_kp7 as t3  ON t2.idcard = t3.idcard AND t2.profile_id = t3.profile_id
WHERE t1.ticketid =  '$ticketid' group by t1.ticketid";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	$arr['num_doc'] = $rs[num_doc];
	$arr['sumpage'] = $rs[sumpage];
	return $arr;
}// end function SumPageTicket($ticketid){
	
#####  function แสดงจำนวนรูปและจำนวนแผ่นเอกสาร ก.พ. 7
function GetNumPicPage($idcard,$profile_id){
	global $dbname_temp;
	$sql = "SELECT page_upload,pic_num FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['pic'] = intval($rs[pic_num]);
	$arr['page'] = intval($rs[page_upload]);
	
	return $arr;
		
}//end function GetNumPicPage(){
	
	
	function CheckNumKp7File($idcard,$profile_id){
	global $dbname_temp;	
	
	$sql = "SELECT page_num, page_upload,siteid FROM tbl_checklist_kp7 WHERE idcard='$idcard' AND profile_id='$profile_id'";
	$result = mysql_db_query($dbname_temp,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[page_num] != $rs[page_upload]){
		 if(CheckFileKp7($idcard,$rs[siteid]) == "1"){
			$arr['nump'] = 0;
			$arr['msg_err'] = "<font color='#CC0000'>จำนวนแผ่นเอกสาร ก.พ.ไม่ตรงกัน<br>พนักงานนับมี $rs[page_num] แผ่น ระบบนับมี $rs[page_upload] แผ่น</font>";
		 }
	}else{
			$arr['nump'] = 1;
			$arr['msg_err'] = "";	
	}
	return $arr;
	
}//end CheckNumKp7File

###  function คำนวนหาจำนวนชุดที่ต้องคีย์ในแต่ละสัปดาห์ เพื่อใช้ในการมอบหมายงานคีย์ข้อมูล

function GetNumKeyPerWeek($staffid,$gmonth){
	global $db_name,$DayOfWeek,$percenP;
	$sql_check = "SELECT COUNT(staffid) as num1 FROM stat_user_keyin WHERE staffid='$staffid' AND datekeyin LIKE '$gmonth%'";
	$result_check = mysql_db_query($db_name,$sql_check);
	$rsc = mysql_fetch_assoc($result_check);
	if($rsc[num1] < 6){
		$arrid = explode("-",$gmonth);
		if(intval($arrid[1]) == "1"){ // กรณีเป็นเดือน มกราคม ขจงปี
			$yy = $arrid[0]-1; // ปีลบ1
				$gmonth = $yy."-12";
		}else{
				$mm = sprintf("%02d",$arrid[1]-1);
				$gmonth = $arrid[0]."-$mm";
		}//end 	if(intval($arrid[1]) == "1"){
			
	}//end if($rsc[num1] < 6){
	
	$sql = "SELECT t1.staffid, floor(avg(t1.numperson)) as avgnumkey
FROM stat_user_keyin as t1 where t1.datekeyin  LIKE '$gmonth%' and t1.staffid='$staffid'
group by t1.staffid";	
//echo $sql;
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[avgnumkey] > 0){
		$numkeyw = ($rs[avgnumkey]*$DayOfWeek);	
		$numavg = floor((($numkeyw*$percenP)/100)+$numkeyw);
		$numpw = $rs[avgnumkey] ;
	}else{
		$numavg = $numFixkey;
		$numpw = $DayOfKey;
	}//end if($rs[avgnumkey] > 0){
	$arr['numday'] = $numpw;
	$arr['numweek'] = $numavg;
	
return $arr;
}//end function GetNumKeyPerWeek($staffid,$gmonth){
###########  จำนวนชุดที่คีย์ได้ในแต่ละสัปดาห์


#######  function ตรวจสอบจำนวนชุดที่ค้างคีย์ข้อมูลในระบบ
function CheckNumKeyStaff($staffid,$profile_id){
	global $db_name;
	$sql = " SELECT
count(tbl_assign_key.idcard) as numk
FROM
tbl_assign_sub
Inner Join tbl_assign_key ON tbl_assign_sub.ticketid = tbl_assign_key.ticketid
where tbl_assign_key.status_keydata='0' and tbl_assign_key.profile_id='$profile_id' and tbl_assign_sub.staffid='$staffid' ";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numk];
		
}//end 

#######################  เขตที่ต้อง assign ต่อในกรณีที่หมดข้อมูลที่จะ assign
function GetSiteKeyOther($siteid,$profile_id){
		global $db_temp;
		$sql = "SELECT secid  FROM `tbl_check_data` where secid <>'$siteid' and profile_id='$profile_id'  group by secid  ORDER BY  timeupdate desc limit 5";
		$result = mysql_db_query($db_temp,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr[] = $rs[secid];
		}//end while($rs = mysql_fetch_assoc($result)){
			return $arr;
}//end function GetSiteKeyOther($siteid,$profile_id){
	
	
############  function Get Flag Qc 
function GetFlagQC($yymm,$key_group,$ratio_id="",$con_id=""){
	global $dbnameuse;
	if($ratio_id != ""){
		$conv = " AND t2.ratio_id='$ratio_id'";	
	}//end 	if($ratio_id != ""){
	
	if($con_id != ""){
			$con_card_id = "  AND t2.card_id IN($con_id)";
	}
	
	$arr_vratio = GetRatio();// ค่าอัตราส่วนของการ QC
	
	$sql = "SELECT
t1.flag_id,
t1.staffid,
t1.num_doc,
t3.rpoint,
t2.ratio_id
FROM
stat_user_person_temp AS t1
Inner Join keystaff AS t2 ON t1.staffid = t2.staffid
Inner Join keystaff_group as t3 ON t2.keyin_group = t3.groupkey_id
WHERE
t1.dateqc LIKE  '$yymm%' AND
t2.keyin_group =  '$key_group'
and t1.qc_pass='0'
and t1.num_doc > 0
$conv
$con_card_id
order by  t1.staffid asc ,t1.num_doc desc
";
//echo $sql."<br>";
	$result = mysql_db_query($dbnameuse,$sql);
	while($rs = mysql_fetch_assoc($result)){
		if($arr_vratio[$rs[ratio_id]] != ""){
			$xrpoint = 	$arr_vratio[$rs[ratio_id]];
		}else{
			$xrpoint = $rs[rpoint];	
		}//end if($arr_vratio[$rs[ratio_id]] != ""){
		
		$arr[$rs[staffid]][$rs[flag_id]] = $rs[num_doc]."||".$xrpoint;
	}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;	
}//end function GetFlagQC()

####  function ในการหาคะแนนมาตรฐานการคีย์ข้อมูลและเปอร์เซ้นส่วนเพิ่มจากการ ,หมายงาน

function GetBasePointAndPercenAdd($staffid){
		global $dbnameuse;
		$sql = "SELECT
keystaff_group.base_point,
keystaff_group.percen_assign_add,
keystaff.staffid
FROM
keystaff_group
Inner Join keystaff ON keystaff_group.groupkey_id = keystaff.keyin_group
where keystaff.staffid= '$staffid' ";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	$arr['percen_add'] = $rs[percen_assign_add];
	$arr['base_point'] = $rs[base_point];
	return $arr;
}//end 

#####  function CheckPointReplace

function CheckPointReplacePerPerson($yymm,$idcard,$staffid,$numpoint){
	global $dbnameuse;
	$sql = "SELECT Count(idcard) AS num1 FROM stat_user_keyperson WHERE datekeyin LIKE '$yymm%' AND idcard='$idcard'  AND staffid='$staffid'AND numpoint='$numpoint'";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."LINE :: ".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}// end function CheckPointReplacePerPerson($yymm,$idcard,$staffid,$numpoint){
	
	
###################  function ตรวจสอบพนักงงานแก้ไขกลุ่มเฉพาะกิจ
function CheckStaffEditKeySpecail($staffid){
	global $dbnameuse;
	$sql = "SELECT
COUNT(t1.staffid) AS num1
FROM
tbl_assign_edit_staffkey as t1
Inner Join tbl_assign_edit_profile as t2 ON t1.profile_edit_id = t2.profile_edit_id
WHERE
t1.staffid =  '$staffid' AND
t2.status_profile =  '1'
GROUP BY
t1.staffid";
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__); 
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}// end function CheckStaffEditKeySpecail(){
	
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
	
	
	function XShowDayOfMonth($yymm){
	$arr_d1 = explode("-",$yymm);
	$xdd = "01";
	$xmm = "$arr_d1[1]";
	$xyy = "$arr_d1[0]";
	$get_date = "$xyy-$xmm-$xdd"; // วันเริ่มต้น
	//echo $get_date."<br>";
	$xFTime1 = getdate(date(mktime(0, 0, 0, intval($xmm+1), intval($xdd-1), intval($xyy))));
	$numcount = $xFTime1['mday']; // ฝันที่สุดท้ายของเดือน
	if($numcount > 0){
		$j=1;
			for($i = 0 ; $i < $numcount ; $i++){
				$xbasedate = strtotime("$get_date");
				 $xdate = strtotime("$i day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป		
				 $arr_d2 = explode("-",$xsdate);
				 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d2[1]), intval($arr_d2[2]), intval($arr_d2[0]))));	
				 if($xFTime['wday'] == 0){
					 $j++;
						 
					}
					if($xFTime['wday'] != "0"){
						$arr_date[$j][$xFTime['wday']] = $xsdate;	
					}
				 
			}
			
	}//end if($numcount > 0){
	return $arr_date;	
}//end function ShowDayOfMonth($yymm){
	
	
	function GetDiffTime($datetime_start,$datetime_end){
	$arr1 = explode(" ",$datetime_start);
	$arr1_d = explode("-",$arr1[0]);
	$arr1_t = explode(":",$arr1[1]);
	
	$arr2 = explode(" ",$datetime_end);
	$arr2_d = explode("-",$arr2[0]);
	$arr2_t = explode(":",$arr2[1]);
	
	$mk_data=mktime(intval($arr1_t[0]), intval($arr1_t[1]), intval($arr1_t[2]), intval($arr1_d[1]), intval($arr1_d[2]), $arr1_d[0]);
	//echo intval($arr1_t[0]).",". intval($arr1_t[1]).",". intval($arr1_t[2]).",". intval($arr1_d[1]).",". intval($arr1_d[2]).",".$arr1_d[0]."<br>";
	//echo "A :  ".$mk_data."<br>";
 	$mk_data2=mktime(intval($arr2_t[0]), intval($arr2_t[1]), intval($arr2_t[2]), intval($arr2_d[1]), intval($arr2_d[2]), $arr2_d[0]);
	//echo "intval($arr2_t[0]), intval($arr2_t[1]), intval($arr2_t[2]), intval($arr2_d[1]), intval($arr2_d[2]), $arr2_d[0]<br>";
	//echo "B :  ".$mk_data2."<br>";
	$mk_data3=($mk_data2-$mk_data);
	//echo "<hr>$mk_data3<br></hr>";
	
	 $days=intval($mk_data3/86400);
	 $remain=$mk_data3%86400;
	 $hours=intval($remain/3600);
	 $remain=$remain%3600;
	 $mins=intval($remain/60);
	 $secs=$remain%60;
	 $arr['d'] = $days;
	 $arr['H'] = $hours;
	 $arr['i'] = $mins;
	 $arr['s'] = $secs;
	 $arr['all'] = $mk_data3;
	 return $arr;		
	 
}// end function GetDiffTime($datetime_start,$datetime_end){
	
function CheckKeyApprove($idcard,$staffid){
	global $dbnameuse;
	$sql = "SELECT t2.userkey_wait_approve as status_approve FROM tbl_assign_sub as t1 Inner Join tbl_assign_key as t2 ON t1.ticketid = t2.ticketid WHERE t2.idcard =  '$idcard' AND t1.staffid =  '$staffid' ORDER BY t2.profile_id DESC LIMIT 1 ";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[status_approve];
}// end function CheckKeyApprove($idcard,$staffid){
	
	function ShowSecnameArea($secid){
	global $dbnamemaster;
	$sql = "SELECT * FROM eduarea WHERE secid='$secid'";	
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$rs[secname]);
}//end 	function ShowSecnameArea($secid){
	
	##### แสดงจำนวนไฟล์แนบผลการตรวจคำผิด
	
	function GetNumFileQc(){
		global $dbnameuse;
		$sql = "SELECT count(distinct t1.ticketid) as num1
FROM ".DB_USERENTRY.".validate_checkdata as t1
Inner Join ".DB_USERENTRY.".keystaff  as t2 ON t1.staffid = t2.staffid
Inner Join  ".DB_MASTER.".view_general as t3 ON t1.idcard = t3.CZ_ID
Inner Join ".DB_USERENTRY.".validate_checkdata_upload as t4 ON t1.ticketid=t4.ticketid AND t1.staffid=t4.staffid AND t1.idcard=t4.idcard
WHERE   t2.staffid='".$_SESSION['session_staffid']." '
GROUP BY  t2.staffid";	
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
	}// end 	function GetNumFileQc(){
		
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
	
	############  
	
	function CheckQCPassV1($idcard,$staffid){
		global $dbnameuse;
		$sql = "SELECT count(idcard) as num1  FROM `validate_checkdata` where idcard='$idcard' and staffid='$staffid' group by idcard";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
	}//end function CheckQCPassV1(){
		
	function GetCard_idExcerent(){
		global $dbnameuse;
		$sql = "SELECT card_id FROM keystaff_excerent WHERE status_active='1'";
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE::".__LINE__);
		$in_id = "";
		while($rs = mysql_fetch_assoc($result)){
				if($in_id > "") $in_id .= ",";
				$in_id .= "'$rs[card_id]'";
		}//end while($rs = mysql_fetch_assoc($result)){
			
		return $in_id;
		
	}//end function GetCard_idExcerent(){
		
	function GetdateEnd($date1){
		$lastd = "+1";
		//echo $date1."<br>";
		 $xbasedate1 = strtotime("$date1");
		 //echo $xbasedate1."<br>";
		 $xdate1 = strtotime("$lastd month",$xbasedate1);
		 $xsdate1 = date("Y-m-d",$xdate1);// วันถัดไป
		 return $xsdate1;
	}//end GetdateEnd($date1){




?>