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
//¢éÍÁÙÅà¡ÕèÂÇ¡Ñº°Ò¹¢éÍÁÙÅ·Õèãªé
include ("../../../config/config_hr.inc.php")  ; 
include ("../../../common/class.salarylevel.php")  ; 
$radub_now= $_REQUEST["radub"]  ; 
$salary_now= str_replace(',','',  $_REQUEST["salary"] ) ;  
$xidcard=$_REQUEST[xidcard]; 
$xsiteid=$_REQUEST[xsiteid]; 
$year=$_REQUEST[xyear]-543; 
$month=$_REQUEST[month]; 
$day=$_REQUEST[day]; 
$obj=new salary_level("$radub_now",$salary_now,"$year-$month-$day");
$r=$obj->check();
$obj->get_radubid("$radub_now");

$k38=$obj->check_pos_38($obj->radub_id);

  if($r==true){
	   echo "ok|:|$radub_now|:|$year|:|$month|:|$day";
  }else{ //
  
    $arr=$obj->genurl($radub_now,$salary_now,"$year-$month-$day");
	if($arr){
		$url=implode(",", $arr);
		}
	if($year>=2011&&$year<=2012){
		$obj=new salary_level("$radub_now",$salary_now,"2011-03-31");
		$r=$obj->check();
		 if($r==true){
	   			echo "ok|:|$radub_now|:|$year|:|$month|:|$day";
	     }else{
		 		 echo "no|:|$url|:|$year|:|$month|:|$k38";
		 }
  }else{ //

		  echo "no|:|$url|:|$year|:|$month|:|$k38";
	}
	
   }
?>