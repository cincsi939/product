<?php   
header("Content-Type: text/html; charset=windows-874");    
session_start();

#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
$ApplicationName	= "hr_general";
$module_code 		= "5002.xx";
$process_id 			= "xxxxxxx";
$VERSION 				= "9.x";
#########################################################
#Developer		::	Alongkot
#DateCreate		::	17/03/2007
#LastUpdate		::	17/03/2007
#DatabaseTabel	::	general
#END
//include ("../libary/function.php");
//include ("checklogin.php");
//include ("../../../config/phpconfig.php");
//include ("timefunc.inc.php");
//ข้อมูลเกี่ยวกับฐานข้อมูลที่ใช้
include ("../../../config/config_hr.inc.php")  ;                                                       
$sql="SELECT hr_addposition_now.status_vitaya  FROM hr_addposition_now where hr_addposition_now.pid='$id_pos'"; 
$result=mysql_db_query(DB_MASTER,$sql);
$row=mysql_fetch_array($result);
echo $row[status_vitaya];   
?>