<?php
	include ("../../../../config/conndb_nonsession.inc.php")  ;

    header("Content-Type: text/plain; charset=windows-874");

	

	$sql_select=" SELECT
view_general.CZ_ID,
view_general.name_th,
view_general.surname_th,
view_general.siteid
FROM
view_general where ( view_general.name_th LIKE '%$names%'  OR   view_general.surname_th LIKE '%$names%'  OR CZ_ID LIKE '%$names%' )  AND ( siteid LIKE '50%' )  ";
    $result= mysql_db_query(DB_MASTER, $sql_select );

   //เริ่มวนรอบแสดงข้อมูล
   while ($rs = mysql_fetch_array($result))

   //แสดงค่าในฐานข้อมูล
   {	  		 
	    echo"$rs[name_th] $rs[surname_th]::$rs[CZ_ID]::$rs[siteid] ,";	
   }
    
   //ปิดการเชื่อมต่อฐานข้อมูล
	mysql_close();
?>