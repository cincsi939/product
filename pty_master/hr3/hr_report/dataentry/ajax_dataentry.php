<?php
    header("Content-Type: text/plain; charset=windows-874");

    //ข้อมูลเกี่ยวกับฐานข้อมูลที่ใช้
	include ("../../../config/conndb_nonsession.inc.php")  ;

    $sql_select=" select  secid,secname from eduarea where provid = '$Tid' order by secid ";
    $result1= mysql_query( $sql_select );
     //เริ่มวนรอบแสดงข้อมูล
    while ($result = mysql_fetch_array($result1))
	
    //แสดงค่าในฐานข้อมูล
    {
	//$name = substr($result[secname], -1, 2);
	//echo"$result[secname]::$result[secid],";
	$name = str_replace("สำนักงานเขตพื้นที่การศึกษา","สพท.",$result[secname] ) ; 
	echo"  $name::$result[secid],";
   }
       // ปิดการเชื่อมต่อ
 	mysql_close();
?>