<?
include("../hr_report/db.inc.php");


 $logsql = "select office,pri1,office_refid  from login where (username='$username' and pwd='$password') ";
$result = mysql_query($logsql);
if(mysql_num_rows($result)){
	$arr = mysql_fetch_array($result);
	if($arr['pri1']==100){
		$_SESSION[isprivilage] = "superadmin";
		$_SESSION[islogin] = 1;
		echo "pri=superadmin";
	}elseif($arr['pri1']==111){
		$_SESSION[isprivilage] = "super";
		$_SESSION[islogin] = 1;
		$_SESSION[idoffice] = $arr[office_refid];
		echo "pri=executive";
	}else if($arr['pri1']==110){
		$_SESSION[isprivilage] = "exhr";
		$_SESSION[islogin] = 1;
		$_SESSION[idoffice] = $arr[office_refid];
		echo "pri=executive";
	}else if($arr['pri1']==120){
		$_SESSION[isprivilage] = "hradmin";
		$_SESSION[islogin] = 1;
		$_SESSION[idoffice] = $arr[office_refid];
		echo "pri=hradmin";
	}else if($arr['pri1']==130){
		$_SESSION[isprivilage] = "hrmanagement";
		$_SESSION[islogin] = 1;
		$_SESSION[idoffice] = $arr[office_refid];
		echo "pri=hrmanagement";
	}else{
		$_SESSION[isprivilage] = "none";
		$_SESSION[islogin] = 0;
		echo "pri=none";
	}
}else{
		$_SESSION[isprivilage] = "none";
		$_SESSION[islogin] = 0;
		$_SESSION[idoffice] = $arr[office_refid];
		echo "pri=none";
}


?>