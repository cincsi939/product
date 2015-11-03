<?
include("../hr_report/db.inc.php");
 $logsql = "select office,pri1 from login where (username='$username' and pwd='$password') ";
$result = mysql_query($logsql);
if(mysql_num_rows($result)){
	$arr = mysql_fetch_array($result);
	if($arr['pri1']==0){
		$_SESSION[isprivilage] = "superadmin";
		$_SESSION[islogin] = 1;
		echo "pri=superadmin";
	}else if($arr['pri1']==40){
		$_SESSION[isprivilage] = "executive";
		$_SESSION[islogin] = 1;
		echo "pri=executive";
	}else if($arr['pri1']==60){
		$_SESSION[isprivilage] = "hradmin";
		$_SESSION[islogin] = 1;
		echo "pri=hradmin";
	}else{
		$_SESSION[isprivilage] = "none";
		$_SESSION[islogin] = 0;
		echo "pri=none";
	}
}else{
		$_SESSION[isprivilage] = "none";
		$_SESSION[islogin] = 0;
		echo "pri=none";
}


?>