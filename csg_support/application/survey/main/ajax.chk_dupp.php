<?php
	include("../lib/class.function.php");
	$con = new Cfunction();
	$con->connectDB();
	$sql="SELECT eq_id FROM eq_person WHERE eq_idcard = '".$_GET['dupp_idcard']."'";
	$res = mysql_query($sql);
	$data= mysql_fetch_assoc($res);
	echo $data['eq_id'];
?>