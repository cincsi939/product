<?php
	@session_start();
	include('../survey/lib/class.function.php');
	$con = new Cfunction();
	$con->connectDB();

	$user = $_SESSION['username'];
	$pass = $_SESSION['pass'];
	
	$sql ="SELECT
				epm_staff.username AS user_id,
				epm_staff.`password` AS pass,
				org_groupmember.staffid,
				org_groupmember.gid,
				org_staffgroup.groupname
			FROM
			epm_staff
			INNER JOIN org_groupmember ON epm_staff.staffid = org_groupmember.staffid
			INNER JOIN org_staffgroup ON org_groupmember.gid = org_staffgroup.gid WHERE epm_staff.username = '".$user."' AND epm_staff.password = '".$pass."'";
	$results  = mysql_db_query(DB_USERMANAGER,$sql);
	$rs = mysql_fetch_array($results);
	$count_data = mysql_num_rows($results);
	echo $count_data;
	die();
	if($count_data <=0) { 
	header( "location:../usermanager/login.php");

	}
    ?>