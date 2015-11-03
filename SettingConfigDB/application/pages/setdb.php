<?php
session_start();
set_time_limit(0);
$_SESSION['HostDB'] = $_POST['HostDB'];
$_SESSION['UserDB'] = $_POST['UserDB'];
$_SESSION['PasswordDB'] = $_POST['PasswordDB'];
include("../../config/config.inc.php");
if($conn){
	header( "location: index.php" );
 exit(0);
}else{
echo '<center>ไม่สามารถเชื่อมต่อฐานข้อมูลได้ กรุณากรอกข้อมูลใหม่อีกครั้ง</br></br><a href="login.php"><button>กลับ</button></a></center>';
echo '<meta http-equiv="refresh" content="3;url=login.php">';
}


?>

