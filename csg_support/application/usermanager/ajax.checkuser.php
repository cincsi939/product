<?php
	@session_start();
	include('../../config/config_host.php');
	include('../survey/lib/class.function.php');
	$con = new Cfunction();
	$con->connectDB();

	$user = $_POST['user'];
	$pass = $_POST['pass'];
	
	$sql ="SELECT staffid FROM epm_staff WHERE username = '{$user}' AND password = '{$pass}' ";
	$results  = mysql_db_query(DB_USERMANAGER,$sql);
	$rs = mysql_fetch_object($results);
	if($rs->staffid == '') { 
		echo 'N::'.md5($pass);
	}else{
		echo $rs->staffid.'::'.md5($pass);
	}
    ?>