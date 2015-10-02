<?php
	@session_start();
	include("../../config/config_host.php"); #อ้างหาค่า Define
	include('../survey/lib/class.function.php');
	$con = new Cfunction();
	$con->connectDB();

	$user = $_POST['user'];
	$pass = $_POST['pass'];
	
	//$sql ="SELECT user_id,pass,user_status FROM user WHERE user_id='".$user."' AND pass='".$pass."'";
	$sql = "SELECT
				epm_staff.username AS user_id,
				epm_staff.`password` AS pass,
				org_groupmember.staffid,
				org_groupmember.gid,
				org_staffgroup.groupname
			FROM
			epm_staff
			INNER JOIN org_groupmember ON epm_staff.staffid = org_groupmember.staffid
			INNER JOIN org_staffgroup ON org_groupmember.gid = org_staffgroup.gid WHERE epm_staff.username = '".$user."' AND epm_staff.password = '".$pass."'";
			
	$results  = mysql_db_query(DB_USERMANAGER,$sql) or die(mysql_error() . $sql);
	$rs = mysql_fetch_array($results);
	$count_data = mysql_num_rows($results);
	if($count_data <= 0) { 
	echo "<script>alert('Username หรือรหัสผ่านไม่ถูกต้อง');</script>";
	?>
        <meta http-equiv="refresh" content="0;url=<?php echo HOMEPAGE_MAIN?>">
	<?php	
	}else{
	$_SESSION['username'] = $rs['user_id'];
	$_SESSION['email'] = $rs['email'];
	$_SESSION['pass'] = $rs['pass'];		
	$_SESSION['session_staffid'] = $rs['staffid'];
	$_SESSION['session_group'] = $rs['gid'];
		
	echo ' <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=../survey/dashboard.php">';

	}
    ?>