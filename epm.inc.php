<?
ob_start();
session_start();
include('../../config/config_host.phpp');
/*  include_once "../../config/config.inc.php";
if (!$nochecklogin){
	if ($_SESSION[session_staffid] <= 0){
		echo " <script language=\"JavaScript\">  alert(\" กรุณา loginเข้าสู่ระบบอีกครั้ง \") ;  top.location.replace('../login.php') </script>  " ;  
		exit;
	}
} */
$host = "localhost"  ;
$username = "wandc"  ;
$password = "c;ofu:u" ;
$dbname = DB_USERMANAGER;
$myconnect = mysql_connect($host, $username, $password) OR DIE("Unable to connect to database");
mysql_select_db($dbname) or die("cannot select database $dbname");
$iresult = mysql_query("SET character_set_results=tis-620");
$iresult = mysql_query("SET NAMES TIS620");
if($type=="profile"){
$table_groupmember = $profile_groupmember;
$table_staffgroup= $profile_staffgroup;
}

if($type=="system"){
$table_groupmember = $table_groupmember;
$table_staffgroup= $table_staffgroup;
}

// echo $table_staff;
// echo $table_mainmenu;
//echo $table_staffgroup;
//echo $table_groupmember;


$max_graphitem = 5;
//$graph_path = "http://localhost/graphservice/graphservice.php";
$graph_path = "http://192.168.2.13/graphservice/graphservice.php";  //sapphire Graph
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

$project_status_array = array("<img src='images/project_status1.gif' alt='ยังไม่เริ่มโครงการ' style='margin-top:8px'>","<img src='images/project_status2.gif' alt='อยู่ระหว่างดำเนินการและเป็นไปตามแผนที่ตั้งเป้าหมายไว้' style='margin-top:8px'>","<img src='images/project_status3.gif' alt='อยู่ระหว่างดำเนินการแต่ล่าช้ากว่าแผนที่ตั้งเป้าหมายไว้' style='margin-top:4px'>","<img src='images/project_status4.gif' alt='โครงการสิ้นสุด' style='margin-top:8px'>");
$project_status_array1 = array("ยังไม่เริ่มโครงการ","ดำเนินตามกำหนด","ล่าช้า","แล้วเสร็จแล้ว");

/*
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
*/
function Query1($sql){
global $dbname,$db_epm,$db_mode,$logon_mode,$table_staff,$table_groupmember,$table_staffgroup,$table_mainmenu,$profile_staffgroup,$profile_groupmember,$type;
	$result  = mysql_query($sql);
	echo mysql_error();
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
/*
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

		$sql = "SELECT count(*) FROM epm_main_budget where main_budget_id not like '%00'  and main_budget_id like '$main_id%' and epm_id = '$epm_id' and yy='$yy' ;"; 
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
*/

function GetLevel($id){
	$n =  count(explode(".",$id)) - 1;
	if ($n < 0) $n = 0;
	return ($n);
}


function GetBudgetUse($id,$yy,$xid){
	$sum = 0;
	$sql = "select count(*) from epm_budget_use where epm_id='$id' and yy='$yy' and detail_budget_id like '$xid.%';"; 
	if (Query1($sql) >0){ // หากมี child 
		$hasChild = true;
		$sql = "select sum(val) as val from epm_budget_use where epm_id='$id' and yy='$yy' and detail_budget_id like '$xid.%';"; 
	}else{
		$hasChild = false;
		$sql = "select sum(val) as val from epm_budget_use where epm_id='$id' and yy='$yy' and detail_budget_id like '$xid';"; 
	}
	return array($hasChild,Query1($sql));
}


function GetActivityInQuarter($yy,$act_id,$q){
	$yy = $yy - 543;
	$y0 = $yy - 1;
	$y1 = $yy + 1;
	$d1 = array("","$y0-10-01","$yy-01-01","$yy-04-01","$yy-07-01","$yy-10-01","$y1-01-01");
	$d2 = array("","$y0-12-31","$yy-03-31","$yy-06-30","$yy-09-30","$yy-12-31","$y1-03-31");
	$sql = "select sum(t2.nm * weight) from epm_activity1 t1 inner join epm_activity1_detail t2 on t1.act_id = t2.act_id where t2.act_id='$act_id' and t2.act_date >= '" . $d1[$q] . "' and t2.act_date <= '" . $d2[$q] . "';"; 
//	$sql = "select sum(nm) from epm_activity1_detail where act_id='$act_id' and act_date >= '" . $d1[$q] . "' and act_date <= '" . $d2[$q] . "';"; 
	return Query1($sql);
}

function GetActivityInQuarterNoWeight($yy,$act_id,$q){
	$yy = $yy - 543;
	$y0 = $yy - 1;
	$y1 = $yy + 1;
	$d1 = array("","$y0-10-01","$yy-01-01","$yy-04-01","$yy-07-01","$yy-10-01","$y1-01-01");
	$d2 = array("","$y0-12-31","$yy-03-31","$yy-06-30","$yy-09-30","$yy-12-31","$y1-03-31");
	$sql = "select sum(t2.nm) from epm_activity1 t1 inner join epm_activity1_detail t2 on t1.act_id = t2.act_id where t2.act_id='$act_id' and t2.act_date >= '" . $d1[$q] . "' and t2.act_date <= '" . $d2[$q] . "';"; 
//	$sql = "select sum(nm) from epm_activity1_detail where act_id='$act_id' and act_date >= '" . $d1[$q] . "' and act_date <= '" . $d2[$q] . "';"; 
	return Query1($sql);
}

function GetAllActivity($act_id){
	$sql = "select sum(t2.nm * weight) from epm_activity1 t1 inner join epm_activity1_detail t2 on t1.act_id = t2.act_id where t2.act_id='$act_id' ;"; 
//	$sql = "select sum(nm) from epm_activity1_detail where act_id='$act_id';"; 
//echo $sql;
	return Query1($sql);
}

function GetSumActivityInQuarter($yy,$act_id,$q){
	$yy = $yy - 543;
	$y0 = $yy - 1;
	$y1 = $yy + 1;
	$d1 = array("","$y0-10-01","$yy-01-01","$yy-04-01","$yy-07-01","$yy-10-01","$y1-01-01");
	$d2 = array("","$y0-12-31","$yy-03-31","$yy-06-30","$yy-09-30","$yy-12-31","$y1-03-31");
	$sql = "select sum(t2.nm * weight) from epm_activity1 t1 inner join epm_activity1_detail t2 on t1.act_id = t2.act_id where t1.parent='$act_id' and t2.act_date >= '" . $d1[$q] . "' and t2.act_date <= '" . $d2[$q] . "';"; 
	return Query1($sql);
}

function GetSumAllActivity($act_id){
	$sql = "select sum(t2.nm * t1.weight) from epm_activity1 t1 inner join epm_activity1_detail t2 on t1.act_id = t2.act_id where t1.parent='$act_id' ;"; //echo $sql;
	return Query1($sql);
}

function GetSumActivityInQuarterNoWeight($yy,$act_id,$q){
	$yy = $yy - 543;
	$y0 = $yy - 1;
	$y1 = $yy + 1;
	$d1 = array("","$y0-10-01","$yy-01-01","$yy-04-01","$yy-07-01","$yy-10-01","$y1-01-01");
	$d2 = array("","$y0-12-31","$yy-03-31","$yy-06-30","$yy-09-30","$yy-12-31","$y1-03-31");
	$sql = "select sum(t2.nm) from epm_activity1 t1 inner join epm_activity1_detail t2 on t1.act_id = t2.act_id where t1.parent='$act_id' and t2.act_date >= '" . $d1[$q] . "' and t2.act_date <= '" . $d2[$q] . "';"; 
	return Query1($sql);
}

function GetSumWeight($yy,$act_id){
	$yy = $yy - 543;
	$y0 = $yy - 1;
	$y1 = $yy + 1;
	$d1 = array("","$y0-10-01","$yy-01-01","$yy-04-01","$yy-07-01","$yy-10-01","$y1-01-01");
	$d2 = array("","$y0-12-31","$yy-03-31","$yy-06-30","$yy-09-30","$yy-12-31","$y1-03-31");
	$sql = "select sum(weight) from epm_activity1 where parent='$act_id' ;"; 
	return Query1($sql);
}


function UpdateParentActivity2($parent){

	//@27/1/2550 ไม่ต้องขยายช่วงเวลาของ parent ให้ child อยู่ภายในเท่านั้น ห้ามเกิน
/*	$sql = "select min(start_date) as mindate,max(finish_date) as maxdate from epm_activity2 where parent='$parent';";
	$result = mysql_query($sql); 
	$rs = mysql_fetch_assoc($result);

	if (!is_null($rs[mindate]) && !is_null($rs[maxdate])){
		$sql = "update  epm_activity2 set start_date='$rs[mindate]',finish_date='$rs[maxdate]' where act_id='$parent';";
		mysql_query($sql); 
	}
*/

}

/*
function UpdatePercentComplete1($id){

	$sql = "SELECT hold FROM epm_detail where epm_id='$id';";
	$hold = Query1($sql);
	if ($hold == 1){  //โครงการถูกเปลี่ยนแปลง ไม่ต้อง update อะไร และ set status เป็น 0 (ยังไม่เริ่ม)
		$sql = "update epm_detail set status='0' where epm_id='$id';";
		mysql_query($sql);
		return;		
	}

	$sql = "SELECT yy FROM epm_detail where epm_id='$id';";
	$yy = Query1($sql);

	$d1 = ($yy - 1) . "-12-31" ;
	$d2 = $yy . "-03-31" ;
	$d3 = $yy . "-06-30" ;
	$d4 = $yy . "-09-30" ;
	$d5 = $yy . "-12-31" ;
	$d6 = ($yy+1) . "-03-31" ;

	$d = (date("Y") + 543 ) . date("-m-d");

	$totalweight = 0; $q1 = $q2 = $q3 = $q4 = $grandtotal = $totalval = 0;
	$sql = "SELECT * FROM epm_activity1 where  epm_id='$id';";
	$result = mysql_query($sql);
	while ($rs = mysql_fetch_assoc($result)){
		
		$sql = "select count(*) from epm_activity1 where epm_id='$id' and level=1  and parent = '$rs[act_id]' ;";
		if (Query1($sql) > 0){  //มีรายการย่อย
			//$q1x = GetSumAllActivity($rs[act_id]);
			$q1x = GetSumActivityInQuarter($yy,$rs[act_id],1);
			$q2x = GetSumActivityInQuarter($yy,$rs[act_id],2);
			$q3x = GetSumActivityInQuarter($yy,$rs[act_id],3);
			$q4x = GetSumActivityInQuarter($yy,$rs[act_id],4);
			$q5x = GetSumActivityInQuarter($yy,$rs[act_id],5);
			$q6x = GetSumActivityInQuarter($yy,$rs[act_id],6);

			$w1 = GetSumWeight($yy,$rs[act_id]);
			$qx = GetSumAllActivity($rs[act_id]);
		}else{
			$q1x = GetActivityInQuarter($yy,$rs[act_id],1);
			$q2x = GetActivityInQuarter($yy,$rs[act_id],2);
			$q3x = GetActivityInQuarter($yy,$rs[act_id],3);
			$q4x = GetActivityInQuarter($yy,$rs[act_id],4);
			$q5x = GetActivityInQuarter($yy,$rs[act_id],5);
			$q6x = GetActivityInQuarter($yy,$rs[act_id],6);

			$qx = GetAllActivity($rs[act_id]);
			$w1 = $rs[weight];
		}

		$val = ($qx) ;
		$total = ($rs[q1]+$rs[q2]+$rs[q3]+$rs[q4]+$rs[q5]+$rs[q6]) ;
		$percent = @round($val * 100 / ($total * $w1),2);



		$q1 += ($rs[q1] * $rs[weight]);
		$q2 += ($rs[q2] * $rs[weight]);
		$q3 += ($rs[q3] * $rs[weight]);
		$q4 += ($rs[q4] * $rs[weight]);
		$q5 += ($rs[q5] * $rs[weight]);
		$q6 += ($rs[q6] * $rs[weight]);
		$totalweight += $rs[weight];
		$grandtotal += $total;
		$totalval += $val;

		if ($d > $d6){
			if ($val < $total * $w1){
				$status = 2; // late
			}else{
				$status = 1; // by plan
			}
		}else if ($d > $d5){
			if ($val < ($rs[q1] + $rs[q2] + $rs[q3] + $rs[q4] + $rs[q5]) * $w1 ){
				$status = 2; // late
			}else{
				$status = 1; // by plan
			}
		}else if ($d > $d4){
			if ($val < ($rs[q1] + $rs[q2] + $rs[q3] + $rs[q4] ) * $w1 ){
				$status = 2; // late
			}else{
				$status = 1; // by plan
			}
		}else if ($d > $d3){
			if ($val < ($rs[q1] + $rs[q2] + $rs[q3]) * $w1 ){
				$status = 2; // late
			}else{
				$status = 1; // by plan
			}
		}else if ($d > $d2){
			if ($val < ($rs[q1] + $rs[q2])  * $w1){
				$status = 2; // late
			}else{
				$status = 1; // by plan
			}
		}else if ($d > $d1){
			if ($val < $rs[q1] * $w1){
				$status = 2; // late
			}else{
				$status = 1; // by plan
			}
		}else{
			$status = 1; // by plan
		}
		$sql="update epm_activity1 set pcomplete = '$percent',status='$status' where act_id='$rs[act_id]';";
		//echo $sql;
		mysql_query($sql);

	} // while

/*	$sql = "SELECT sum(t2.nm)  FROM epm_activity1 t1 inner join epm_activity1_detail t2 on t1.act_id=t2.act_id where t1.epm_id='$id';";
	$val = Query1($sql);

	$sql = "SELECT sum(q1+q2+q3+q4) as total,sum(q1) as q1,sum(q2) as q2,sum(q3) as q3,sum(q4) as q4  FROM epm_activity1 where epm_id='$id';";
	$result = mysql_query($sql);
	$rs = mysql_fetch_assoc($result);

	$total = $rs[total];


	//$val = $q1 + $q2 + $q3 + $q4;
	$rs[q1] = $q1;
	$rs[q2] = $q2;
	$rs[q3] = $q3;
	$rs[q4] = $q4;
	$rs[q5] = $q5;
	$rs[q6] = $q6;
	$val = $totalval;
	$percent = @round($val * 100 / ($grandtotal * $totalweight),2);

	if ($d > $d6){
		if ($val < $total *  $totalweight){
			$status = 2; // late
		}else{
			$status = 1; // by plan
		}
	}else if ($d > $d5){
		if ($val < ($rs[q1] + $rs[q2] + $rs[q3] + $rs[q4] + $rs[q5]) ){
			$status = 2; // late
		}else{
			$status = 1; // by plan
		}
	}else if ($d > $d4){
		if ($val < ($rs[q1] + $rs[q2] + $rs[q3] + $rs[q4]) ){
			$status = 2; // late
		}else{
			$status = 1; // by plan
		}
	}else if ($d > $d3){
		if ($val < ($rs[q1] + $rs[q2] + $rs[q3])  ){
			$status = 2; // late
		}else{
			$status = 1; // by plan
		}
	}else if ($d > $d2){
		if ($val < ($rs[q1] + $rs[q2])){
			$status = 2; // late
		}else{
			$status = 1; // by plan
		}
	}else if ($d > $d1){
		if ($val < $rs[q1] ){
			$status = 2; // late
		}else{
			$status = 1; // by plan
		}
	}else{
		$status = 1; // by plan
	}

	$sql = "update epm_detail set pcomplete = '$percent',status='$status' where epm_id='$id';";
	//echo $sql; exit;
	mysql_query($sql);

}


function UpdateSubTree($parent_id,$old_pcomplete){
global $id,$hasChid;
	$hasChild = false;
	$pcomplete = 0;

	$w1 = 0; $pw = 0;
	$n = 0;
	$sql = "SELECT * FROM epm_activity2 where epm_id='$id' and parent = '$parent_id';";

	$result2 = mysql_query($sql);
	while ($rs2 = mysql_fetch_assoc($result2)){
		$hasChild = true;
 		$x = UpdateSubTree($rs2[act_id],$rs2[pcomplete]); // update ตัวลูก
	} //while

	//requery
	$result2 = mysql_query($sql);
	while ($rs2 = mysql_fetch_assoc($result2)){

		$nday = intval(Daydiff($rs2[start_date],$rs2[finish_date])); // จำนวนวันของ Task
		if ($nday <=0 ) $nday = 1;
		$taskday = intval($nday * $rs2[pcomplete]/100);  //จำนวนวันตาม percent complete

		// เก็บค่าเอาไปคำนวณตัวแม่
		$pw += ($rs2[pcomplete] * $rs2[weight]);
		$w1 += $rs2[weight];


		$taskdate = AddDate($rs2[start_date],$taskday);

		$pcomplete += $rs2[pcomplete];
		$n++;

		if ($rs2[pcomplete] >= 100){
			$status = 1;
		}else if ($rs2[start_date] > $d){
			$status = 0;
		}else if ($taskdate >= $d){  // ทำได้เกินวันปัจจุบัน
			$status = 1;
		}else {
			//@6/5/2550 ถ้าไม่ถึงวันสิ้นสุดให้ถือว่าไม่ช้า
			if ($rs2[finish_date] >= date("Y-m-d")){
				$status = 1;
			}else{
				$status = 2; // late
				$isLate = true;
			}
		} // if

		//กำหนดค่า lastfinish_date @3/5/2550
		if ($rs2[pcomplete] < 100){
			$today = date("Y-m-d");
			$sql = "update epm_activity2 set status='$status',lastfinish_date='$today' where act_id='$rs2[act_id]';"; 
		}else{
			$sql = "update epm_activity2 set status='$status' where act_id='$rs2[act_id]';"; 
		}

		mysql_query($sql);
	} // while

	if ($hasChild){
		$pcomplete = $pw / $w1; //เฉลี่ยจากตัวลูก (หากมี)
		if ($pcomplete < 100){
			$today = date("Y-m-d");
			$sql = "update epm_activity2 set pcomplete='$pcomplete',lastfinish_date='$today' where act_id='$parent_id';";
		}else{
			$sql = "update epm_activity2 set pcomplete='$pcomplete' where act_id='$parent_id';";
		}
		mysql_query($sql); 
	}else{
		$n = 1;
		$pcomplete = $old_pcomplete;
	} // if

	return $pcomplete;
}


function UpdatePercentComplete2($id){
/*
	$sql = "SELECT hold FROM epm_detail where epm_id='$id';";
	$hold = Query1($sql);
	if ($hold == 1){  //โครงการถูกเปลี่ยนแปลง ไม่ต้อง update อะไร และ set status เป็น 0 (ยังไม่เริ่ม)
		$sql = "update epm_detail set status='0' where epm_id='$id';";
		mysql_query($sql);
		return;		
	}

	$sql = "SELECT yy FROM epm_detail where epm_id='$id';";
	$yy = Query1($sql);

	$d = date("Y-m-d");

	$allcomplete = 0;
	$ntask = 0;
	$isLate = false;

	$totalweight = $totalpw = 0;

	$sql = "SELECT * FROM epm_activity2 where epm_id='$id' and (parent = 0 or parent is null);";
	$result = mysql_query($sql);
	while ($rs = mysql_fetch_assoc($result)){


		$pcomplete = UpdateSubTree($rs[act_id],$rs[pcomplete]);
		$rs[pcomplete] = $pcomplete;



		$totalnday = intval(Daydiff($rs[start_date],$rs[finish_date])); // จำนวนวันของ Task
		if ($totalnday <=0 ) $totalnday = 1;
		$taskday = intval($totalnday * $rs[pcomplete]/100);  //จำนวนวันตาม percent complete


		// เก็บค่าเอาไปคำนวณตัวโครงการ
		$totalpw += ($rs[pcomplete] * $rs[weight]);
		$totalweight += $rs[weight];


		$taskdate = AddDate($rs[start_date],$taskday);
//echo "$rs[act_name] $totalnday / $taskday / $taskdate / $d<br> ";
		if ($pcomplete >= 100){
			$status = 1;
		}else if ($rs[start_date] > $d){
			$status = 0;
		}else if ($taskdate >= $d){  // ทำได้เกินวันปัจจุบัน
			$status = 1;
		}else {
			if ($rs[finish_date] >= date("Y-m-d")){
				$status = 1;
			}else{
				$status = 2; // late
				$isLate = true;
			}
		} // if

		if ($pcomplete < 100){
			$today = date("Y-m-d");
			$sql = "update epm_activity2 set status='$status',pcomplete='$pcomplete',lastfinish_date='$today' where act_id='$rs[act_id]';";
		}else{
			$sql = "update epm_activity2 set status='$status',pcomplete='$pcomplete' where act_id='$rs[act_id]';";
		}
		mysql_query($sql); 

		$allcomplete += $pcomplete;
		$ntask ++;

	} // while
	
	if ($ntask > 0){
		//$allcomplete = $allcomplete / $ntask; 
		$allcomplete = round($totalpw / $totalweight,2);
	}else{
		$allcomplete = 0; 
	}

	if ($isLate){
		$status = 2;
	}else{
		$status = 1;
	}

	$sql = "update epm_detail set pcomplete = '$allcomplete',status='$status' where epm_id='$id';";
	//echo $sql;
	mysql_query($sql); //die($sql);

}


function UpdatePercentCompleteAll(){
	$yy = GetSysInfo("year");
	$sql = "select epm_id from epm_detail where yy='$yy';";
	$result = mysql_query($sql);
	while ($rs=mysql_fetch_assoc($result)){
		if ($rs[act_type] == 0){
			UpdatePercentComplete1($rs[epm_id]);
		}else{
			UpdatePercentComplete2($rs[epm_id]);
		}

	}

}
*/

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

/*
function hasAssignedActivity($epm_id,$act_id,$act_type){
	$staffid = $_SESSION[session_staffid];
	if (Query1("select count(*) from  epm_activity_staff where epm_id='$epm_id' and act_id='$act_id' and act_type='$act_type' and staffid='$staffid';") > 0){
		return true;
	}

	if (Query1("select count(*) from  epm_activity_group t1 inner join epm_groupmember t2 on t1.gid=t2.gid where t1.epm_id='$epm_id' and t1.act_id='$act_id' and t1.act_type='$act_type' and t2.staffid='$staffid';") > 0){
		return true;
	}

	return false;
}

function canEditActivity($epm_id,$act_id,$act_type){
	$staffid = $_SESSION[session_staffid];
	if (Query1("select count(*) from  epm_activity_staff_edit where epm_id='$epm_id' and act_id='$act_id' and act_type='$act_type' and staffid='$staffid';") > 0){
		return true;
	}

	if (Query1("select count(*) from  epm_activity_group_edit t1 inner join epm_groupmember t2 on t1.gid=t2.gid where t1.epm_id='$epm_id' and t1.act_id='$act_id' and t1.act_type='$act_type' and t2.staffid='$staffid';") > 0){
		return true;
	}

	return false;
}

function isCreateActivity($epm_id,$act_id,$act_type){
	$staffid = $_SESSION[session_staffid];
	if (Query1("select count(*) from  epm_activity2 where epm_id='$epm_id' and act_id='$act_id' and act_owner_id='$staffid';") > 0){
		return true;
	}

	return false;
}

function isInvolved($epm_id){
	$staffid = $_SESSION[session_staffid];
	if (Query1("select count(*) from  epm_activity_staff where epm_id='$epm_id' and staffid='$staffid';") > 0){
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
	}else if (Query1("select t1.owner_id from $table_staffgroup t1 inner join epm_detail t2 on t1.gid=t2.gid where t2.epm_id='$epm_id';") == $_SESSION[session_staffid]){
		// เชคว่าเป็นหัวหน้ากลุ่มงานหรือไม่
		return "true";
	}else{
		return false;
	}
}

function isDevAdmin(){
	// @10/5/2550 หาว่า user นี้อยู่ใน group ชื่อ Administrator ของหน่วยงานนี้ หรือไม่
	$sql = "select count(*) from epm_groupmember t1 inner join $table_staffgroup t2 on t1.gid=t2.gid where t1.staffid='$_SESSION[session_staffid]' and t2.org_id='$_SESSION[session_dev_id]' and t2.groupname='Administrator';";

//	if ($_SESSION[session_username] == "admin_" . $_SESSION[session_dev_id]){
	if (Query1($sql) > 0){
		return true;
	}else{
		return false;
	}
}



function GroupOwner_Direct(){
	$garray = array();
	$sql = "select * from $table_staffgroup where owner_id='$_SESSION[session_staffid]';"; //echo $sql;
	$result = mysql_query($sql);
	while ($rs=mysql_fetch_assoc($result)){
		$garray[] = $rs[gid];
	}
	return $garray;
}

function GroupOwner_inDirect(){
	$garray = array();
	$sql = "select * from $table_staffgroup where owner_id='$_SESSION[session_staffid]';"; //echo $sql."<hr>";
	$result = mysql_query($sql);
	while ($rs=mysql_fetch_assoc($result)){
		$xgroup = FindSubGroup($rs[gid]);
		$garray = array_merge($garray,$xgroup);
	}
	return $garray;
}


function FindSubGroup($gid){
	$subgroup = array();
	$sql="select * from $table_staffgroup where parent='$gid';"; //echo $sql;
	$result=mysql_query($sql);
	while ($rs=mysql_fetch_assoc($result)){
		$xgroup = FindSubGroup($rs[gid]);
		$subgroup = array_merge($subgroup,$xgroup);
		if ($rs[owner_id] != $_SESSION[session_staffid]){ //ถ้าไม่ได้เป็น indirect owner
			$subgroup = array_merge($subgroup,array($rs[gid]));
		}
	}
	return $subgroup;
}


if (!function_exists("ChkOwner")){
	function ChkOwner($epm_id){
		if (Query1("select owner_id from epm_detail where epm_id='$epm_id';") == $_SESSION[session_staffid]){
			return "true";
		}else if (Query1("select t1.owner_id from $table_staffgroup t1 inner join epm_detail t2 on t1.gid=t2.gid where t2.epm_id='$epm_id';") == $_SESSION[session_staffid]){
			// เชคว่าเป็นหัวหน้ากลุ่มงานหรือไม่
			return "true";
		}else{
			return "false";
		}
	}
}
// check approve
function checkdate_approve($dateinput,$staffid){
	$dsql	= "  SELECT  COUNT(t1.approve_status),t1.approve_status   FROM  epm.epm_dailyreport  t1  Inner Join cost.type_project  t2  ON  t2.code_project = t1.refcode ";
	$dsql	= $dsql." where  (t1.staffid = '$staffid') and  t1.workdate LIKE '$dateinput%' AND  t1.approve_status = 'approve'  GROUP BY t1.approve_status  ";
	//echo $dsql;echo "<br>";
	$result 	= mysql_query($dsql)or die("Query Line " . __LINE__ . " Error<hr>".mysql_error());
	$row 	= mysql_num_rows($result);
	if($row == 1 ){
		return 1;
	}else{
		return 0;
	}
}
*/

// function เรียงตัวอักษรภาษาไทย mysql 4
function thai2sortable($input) { 
$output = ''; 
$rightbuf = ''; 
$len = strlen($input); 

for ($i = 0; $i < $len; $i++) { 
if (is_vowel($input[$i]) && (($i + 1) != $len)) { 
if (!is_vowel($input[$i + 1]) && (!is_tone($input[$i +1]))) { 
$output .= $input[$i + 1]; 
$output .= $input[$i]; 
$i++; 
} 
} 
else if (is_tone($input[$i])) { 
$rightbuf.=sprintf("%02d", $len - $i); 
$rightbuf.=$input[$i]; 
} 
else { 
$output.=$input[$i]; 
} 
} 
return $output."00".$rightbuf; 
} 

function is_tone($c) { 
return ((chr(0xE6) <= ($c)) && (($c) <= chr(0xEC))); 
} 

function is_vowel($c) { 
return ((chr(0xE0) <= ($c)) && (($c) <= chr(0xE4))); 
} 

function th_sort(&$thai_array) {
$i = 0;
while (list ($key, $val) = each ($thai_array)) { 
$arr1[$i] = $thai_array[$key]; unset($thai_array[$key]);
$arr2[$i] = thai2sortable($arr1[$i]); $i++;
}
asort ($arr2); reset ($arr2); $i=0;
while (list ($key, $val) = each ($arr2)) { 
$thai_array[$i++] = $arr1[$key];
}
}

function th_rsort(&$thai_array) {
$i = 0;
while (list ($key, $val) = each ($thai_array)) { 
$arr1[$i] = $thai_array[$key]; unset($thai_array[$key]);
$arr2[$i] = thai2sortable($arr1[$i]); $i++;
}
asort ($arr2); reset ($arr2);
while (list ($key, $val) = each ($arr2)) { 
$arr3[]= $arr1[$key];
}
$thai_array = array_reverse($arr3);
}

function th_asort(&$thai_array) {
$i = 0;
while (list ($key, $val) = each ($thai_array)) { 
$arr1[$key] = $thai_array[$key]; unset($thai_array[$key]);
$arr2[$key] = thai2sortable($arr1[$key]); $i++;
}
asort ($arr2); reset ($arr2);
while (list ($key, $val) = each ($arr2)) { 
$thai_array[$key] = $arr1[$key];
}
}
function th_arsort(&$thai_array) {
$i = 0;
while (list ($key, $val) = each ($thai_array)) { 
$arr1[$key] = $thai_array[$key]; unset($thai_array[$key]);
$arr2[$key] = thai2sortable($arr1[$key]); $i++;
}
asort ($arr2); reset ($arr2);
while (list ($key, $val) = each ($arr2)) { 
$arr3[$key]= $arr1[$key];
}
$thai_array = array_reverse($arr3,TRUE);
}

function th_ksort(&$thai_array) {
$i = 0;
while (list ($key, $val) = each ($thai_array)) { 
$arr1[$key] = $thai_array[$key]; unset($thai_array[$key]);
$arr2[$key] = thai2sortable($key); $i++;
}
asort ($arr2); reset ($arr2);
while (list ($key, $val) = each ($arr2)) { 
$thai_array[$key] = $arr1[$key];
}
}

function th_krsort(&$thai_array) {
$i = 0;
while (list ($key, $val) = each ($thai_array)) { 
$arr1[$key] = $thai_array[$key]; unset($thai_array[$key]);
$arr2[$key] = thai2sortable($key); $i++;
}
asort ($arr2); reset ($arr2);
while (list ($key, $val) = each ($arr2)) { 
$arr3[$key]= $arr1[$key];
}
$thai_array = array_reverse($arr3,TRUE);
}

// end // function เรียงตัวอักษรภาษาไทย mysql 4
?>

