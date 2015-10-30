<?
session_start();
include_once "../../config/config_epm2.inc.php";


$epm_staff = "login";
$epm_groupmember = "epm_groupmember";


$officetable = "epm_main_menu";

//$isLocked = GetSysInfo("lock") == 1; // สถานะการเปิดให้แก้ไข
$isLocked = 0;

$max_graphitem = 5;
$graph_path = "http://localhost/graphservice/graphservice.php";
$gstyle="srd_sf_014";
$gtype="pie";
$g_ydata = "";
$g_xdata = "";


$headcolor="#3355FF";
//$bodycolor="#DDDDFF";
$bodycolor="#A3B2CC";
$nextyearcolor="#003333";

$monthname = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$shortmonth = array( "","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.", "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

$ThaiWeekDay = array("Monday"=>"จันทร์","Tuesday"=>"อังคาร","Wednesday"=>"พุธ", "Thursday"=>"พฤหัสบดี","Friday"=>"ศุกร์","Saturday"=>"เสาร์","Sunday"=>"อาทิตย์");

$project_status_array = array("ยังไม่เริ่มโครงการ","ดำเนินตามกำหนด","ล่าช้า","แล้วเสร็จแล้ว");


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
?>