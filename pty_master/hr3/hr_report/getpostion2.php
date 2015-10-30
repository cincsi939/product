<?php   
header("Content-Type: text/plain; charset=windows-874");    
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
$sql="SELECT pid as id ,`position` as value FROM $dbnamemaster.hr_addposition_now where pid like'$id_pos%' order by `position`";
 $select1  = mysql_query($sql);  
 
 echo" <select name=\"pos_onduty\" style=\"width:250px;\" id=\"posduty\"";
 echo " <option value=\"\" class=\"warn\">ไม่ระบุ</option> ";
 
 while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){  
  echo"<option value=\"$rselect1[id]\" >$rselect1[value]</option>";
 }
 echo"</select> ";
?>