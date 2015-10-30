<?
session_start();
header("Expires: Mon, 26 April 2003 09:09:09 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("cache-Control: no-store, no-cache, must-revalidate"); 
header("cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache"); 

include("../../config/conndb_nonsession.inc.php");
$db_name =DB_USERENTRY;
$dbnamemaster=DB_MASTER;
$dbsystem =DB_SYSTEM;

//system data base
$sysdbname =""  ;
$aplicationpath=APP_MAIN;
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
			$arr_f_tbl1 = array("general_pic#id||no","getroyal#id||runid","goodman#runid||runno","graduate#id||runid","hr_absent#id||yy","hr_nosalary#id||no","hr_other#id||no","hr_prohibit#id||no",
	"hr_specialduty#id||no","hr_teaching#id||runid","salary#id||runid","seminar#id||runid","seminar_form#id||runid","special#id||runid||runno","general#id"   );
			
			// gen_id
			$arr_f_tbl3 = array( "hr_addhistoryaddress#gen_id||runid","hr_addhistoryfathername#gen_id||runid" , "hr_addhistorymarry#gen_id||runid" , "hr_addhistorymothername#gen_id||runid" , "hr_addhistoryname#gen_id||runid" );			

			$subfix = "_log_after";
			
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
	$result = mysql_query("select distinct dev_name from epm_detail where dev_id = '$devid';");
	$rs = mysql_fetch_assoc($result);
	return $rs[dev_name];
}

function GetProvincePolicy($id){
	$result = mysql_query("select distinct policy_name from policy_lbl where policy_id = '$id';");
	$rs = mysql_fetch_assoc($result);
	return $rs[policy_name];
}

function GetClusterPolicy($id){
	$result = mysql_query("select distinct policy_name from policycluster_lbl where policy_id = '$id';");
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
global $monthname;
	if (!$d) return "";
	if ($d == "0000-00-00") return "";
	
	$d1=explode("-",$d);
	return intval($d1[2]) . " " . $monthname[intval($d1[1])] . " " . (intval($d1[0]) + 543);
}


function ThaiDate2DBDate($d){
	if (!$d) return "";
	if ($d == "00-00-0000") return "";
	
	$d1=explode("/",$d);
	return (intval($d1[2]) - 543) . "-" . $d1[1] . "-" . $d1[0];
}

function UpdateParentActivity1($id){
	$sql = "select distinct(parent) as parent_id from epm_activity1 where epm_id='$id' and level > 0;";
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

		$sql = "SELECT count(main_budget_id) FROM epm_main_budget where main_budget_id not like '%00'  and main_budget_id like '$main_id%' and epm_id = '$epm_id' and yy='$yy' ;"; 
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

	if (Query1("select count(*) from  epm_activity_group t1 inner join epm_groupmember t2 on t1.gid=t2.gid where t1.epm_id='$epm_id' and t2.staffid='$staffid';") > 0){
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

############################################################################################  function  ส่วนของรายงาน


	function DateDiff($strDate1,$strDate2){

		return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24   
	} 
	
	function TimeDiff($strTime1,$strTime2) { 
		return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60 
	} 

	function DateTimeDiff($strDateTime1,$strDateTime2) {             
		return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60 
	} 


function StartDateKey($get_staffid){
	global $db_name;	
	$sql = "SELECT
	min(date(monitor_keyin.timeupdate)) as mindate
	FROM
	tbl_assign_key
	Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
	WHERE
	monitor_keyin.staffid =  '$get_staffid' AND
	tbl_assign_key.nonactive =  '0'
	";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[mindate];
}

###  function นับจำนวนรายการที่คีย์ทั้งหมด
function NumStaffKey($get_staffid){
	global $db_name;
	$sql = "SELECT
	count(distinct monitor_keyin.idcard) as num
	FROM
	tbl_assign_key
	Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
	WHERE
	monitor_keyin.staffid =  '$get_staffid' AND
	tbl_assign_key.nonactive =  '0'";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num];
}

## function การจำนวนวันที่บันทึกข้อมูลจริง
function CountDateKey($get_staffid,$get_date){
	global $db_name;
	$sql = "SELECT
	count(monitor_keyin.timeupdate) as count_data
	FROM
	tbl_assign_key
	Inner Join monitor_keyin ON tbl_assign_key.idcard = monitor_keyin.idcard
	WHERE
	monitor_keyin.staffid = '$get_staffid' AND
	tbl_assign_key.nonactive =  '0'
	and date(monitor_keyin.timeupdate) >= '$get_date'
	group by date(monitor_keyin.timeupdate)";
	$result = @mysql_db_query($db_name,$sql);
	$numr = @mysql_num_rows($result);
	return $numr ;
}

### นับจำนวนผลการการตรวจสอบทั้งหมด
function CountNumCheckAll($get_staffid){
	global $db_name;
	$sql = "SELECT
count(distinct validate_checkdata.idcard) as num1
FROM validate_checkdata
where 
staffid='$get_staffid'";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}

### นับจำนวนผลการการตรวจสอบไม่ผ่าน
function CountNumCheckFalse($get_staffid){
	global $db_name;
	$sql = "SELECT
count(distinct validate_checkdata.idcard) as num1
FROM validate_checkdata
where 
staffid='$get_staffid' and result_check='0'";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}

### นับจำนวนผลการการตรวจสอบผ่าน
function CountNumCheckTrue($get_staffid){
	global $db_name;
	$sql = "SELECT
count(distinct validate_checkdata.idcard) as num1
FROM validate_checkdata
where 
staffid='$get_staffid' and result_check='1'";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
}

####  แสดงชื่อพนักงาน
function ShowStaff($get_staffid){
global $db_name;
$sql = "SELECT * FROM keystaff WHERE staffid='$get_staffid'";
$result = mysql_db_query($db_name,$sql);
$rs = mysql_fetch_assoc($result);
return "$rs[prename]$rs[staffname]  $rs[staffsurname]";
	
}


function ConDateC($get_date,$sysb="/"){
	if($get_date != ""){
			$arr = explode("$sysb",$get_date);
			return ($arr[2]-543)."-".$arr[1]."-".$arr[0];
	}else{
			return "";	
	}
		
}

###  function จำนวนรายการที่พนักงานคีย์ผิดพลาดแต่ละเมนู
function CountKeyCheck($get_staffid,$get_checkdata_id,$get_date){
	global $db_name;
	$sql = "SELECT 
COUNT(distinct idcard) AS NUM
FROM validate_checkdata
WHERE
validate_checkdata.result_check =  '0' AND
validate_checkdata.staffid =  '$get_staffid' AND
validate_checkdata.checkdata_id =  '$get_checkdata_id' AND
validate_checkdata.date_check =  '$get_date' ";
	$result = mysql_db_query($db_name,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[NUM];
		
}//end function CountKeyCheck(){


?>