<?php
	session_start();
    header("Content-Type: text/plain; charset=windows-874");
	include("../../../config/config_hr.inc.php");

    $sql =" UPDATE hr_addhistoryfathername SET kp7_active = 0 WHERE  gen_id =  $_SESSION[id] ";
    mysql_query( $sql );

	 $sql1 =" UPDATE hr_addhistoryfathername SET kp7_active = '1' WHERE  runid =  $runid  ";
    mysql_query( $sql1 );

     // ปิดการเชื่อมต่อ
 	mysql_close();
?>