<?php
	@session_start();
	include('../../config/config_host.php');
	include('../survey/lib/class.function.php');
	$con = new Cfunction();
	$con->connectDB();

	$id = $_POST['id'];
	$prename = iconv('utf8','tis-620',$_POST['prename']);
	$name = iconv('utf8','tis-620',$_POST['name']);
	$surname = iconv('utf8','tis-620',$_POST['surname']);
	$tel = iconv('utf8','tis-620',$_POST['tel']);
	$email = iconv('utf8','tis-620',$_POST['email']);
	$sex = iconv('utf8','tis-620',$_POST['sex']);
	$newpass = iconv('utf8','tis-620',$_POST['newpass']);
	
	
	$sql ="UPDATE epm_staff SET 
	prename = '{$prename}',
	staffname = '{$name}',
	staffsurname = '{$surname}',
	telno = '{$tel}',
	email = '{$email}',
	sex = '{$sex}',
	password = '{$newpass}'
	WHERE staffid = '{$id}' ";
	mysql_db_query(DB_USERMANAGER,$sql)or die('error');
	echo 'save';
    ?>