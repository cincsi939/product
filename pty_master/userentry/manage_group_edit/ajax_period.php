<?php
    header("Content-Type: text/plain; charset=windows-874");

    //ข้อมูลเกี่ยวกับฐานข้อมูลที่ใช้
	include ("../../../config/conndb_nonsession.inc.php")  ;

    $sql_select=" select  *  from tbl_assign_edit_period_detail  where period_master_id = '$mid' order by periodname asc";
    $result1= mysql_db_query($dbnameuse,$sql_select );
     //เริ่มวนรอบแสดงข้อมูล
    while ($rs = mysql_fetch_array($result1)) {

	echo"  $rs[periodname]::$rs[period_id],";
   }
       // ปิดการเชื่อมต่อ
 	mysql_close();
?>