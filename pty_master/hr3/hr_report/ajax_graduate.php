<?php
    header("Content-Type: text/plain; charset=windows-874");

    //ข้อมูลเกี่ยวกับฐานข้อมูลที่ใช้
	include ("../../../config/conndb_nonsession.inc.php")  ;
	$id=substr($degree_id,2);
	$sql_select = "select * from hr_addmajor where major_id = '$id' order by runid ";
    $result1= mysql_query( $sql_select );
     //เริ่มวนรอบแสดงข้อมูล
    while ($result = mysql_fetch_array($result1))
	
    //แสดงค่าในฐานข้อมูล

    {
	//$name = substr($result[secname], -1, 2);
	echo"$result[major]::$result[major_id],";
   }
       // ปิดการเชื่อมต่อ
 	mysql_close();
?>