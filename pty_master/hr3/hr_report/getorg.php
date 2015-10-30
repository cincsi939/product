<?php   
header("content-type: application/x-javascript; charset=tis-620");   
ob_start();
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
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");   
$sql="SELECT runid,ministry FROM $dbnamemaster.hr_addministry where OL_CODE='02' and runid like  concat(left(  ( SELECT xx.runid   FROM $dbnamemaster.hr_addministry as xx    where  ministry ='$orgid'  limit 1),2),'%') order by ministry";
//echo $sql;
 echo"<select name=\"subminis_now\"  style=\"width:300;\" >";
 
 $select1  = mysql_query( $sql);
 while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){  
  echo"<option value=\"$rs[runid]\" >$rselect1[ministry]</option>";
 }
 echo"</select> ";
?>