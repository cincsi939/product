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
echo '<center>�������ö�������Ͱҹ�������� ��سҡ�͡�����������ա����</br></br><a href="login.php"><button>��Ѻ</button></a></center>';
echo '<meta http-equiv="refresh" content="3;url=login.php">';
}


?>

