<?php
    header("Content-Type: text/plain; charset=windows-874");

    //ข้อมูลเกี่ยวกับฐานข้อมูลที่ใช้
	include ("../../../config/conndb_nonsession.inc.php")  ;
	include ("../libary/function.php");

	echo get_hisname($xid,$xsiteid);
       // ปิดการเชื่อมต่อ
 	mysql_close();
?>