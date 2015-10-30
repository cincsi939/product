<?php

    header("Content-Type: text/plain; charset=windows-874");
include("../../../config/config_hr.inc.php");

    //ข้อมูลเกี่ยวกับฐานข้อมูลที่ใช้
//	include ("../../../inc/conndb_nonsession.inc.php")  ;
    $sql_select=" select   runid , name,name_short from $dbnamemaster.cordon_list where groupid = '$runid'  ";
    $result1= mysql_query(  $sql_select )or die(mysql_error());
     //เริ่มวนรอบแสดงข้อมูล
    while ($result = mysql_fetch_array($result1))

    //แสดงค่าในฐานข้อมูล
    {
	$runid =  $result[runid] ;
	$name =  $result[name] ;
	$sname=  ($result[name_short])?" (".$result[name_short].")":"" ;
	$mixname=$name.$sname."::".  $runid.'::'.$result[name_short] ;
	
	if ($result[name] == "  ส่วนกลาง"){
		//echo" ส่วนกลาง ,";
	}else{
	echo "$mixname,"; 
		//echo"$name$result[runid],$result[name] "." "."($result[name_short])";
			//echo" $name::$result[runid],";
	}
   }

       // ปิดการเชื่อมต่อ
 	mysql_close();
?>
