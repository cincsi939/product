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
//����������ǡѺ�ҹ�����ŷ����
include ("../../../config/config_hr.inc.php")  ;  
function checkmathradub($radub1){
    $array_radub['��Ժѵԡ��']=array('3','4','5');  
    $array_radub['�ӹҭ���']=array('6','6�','7','7�','7Ǫ');  
    $array_radub['�ӹҭ��þ����']=array('8','8�','8Ǫ');     
    $array_radub['���Ǫҭ']=array('9Ǫ','9��');  
    $array_radub['�ç�س�ز�']=array('10Ǫ','10��','11Ǫ','11��');       
    $array_radub['��Ժѵԧҹ']=array('1','2','3','4'); 
    $array_radub['�ӹҭ�ҹ']=array('5','6');    
    $array_radub['������']=array('7','8');       
    $array_radub['�ѡ�о����']=array('9��');     
   
  $radub="";
  foreach($array_radub as $index=>$value){
     if(count($value)>0){  
        if (in_array($radub1, $value)){ 
         $radub=$index;    
        }
    }
  }
  if($radub==""){$radub=$radub1;}   
  return $radub; 
}
#========================================================================
function get_runid_viataya($radub){
     $sql="SELECT  tbl_salary_math_radub.salary_radub_id  FROM
hr_addradub Inner Join tbl_salary_math_radub ON hr_addradub.runid = tbl_salary_math_radub.radub_id 
       where hr_addradub.radub='$radub'";
    $result=mysql_db_query(DB_MASTER,$sql);
    $row=mysql_fetch_array($result); 
    return $row[salary_radub_id];
}

#=========================================================================
$radub2 = $_REQUEST["radub"]; 
$salary2 = str_replace(',','',  $_REQUEST["salary"] ) ;  
$radub2_id= get_runid_viataya($radub2); 
$xsiteid=$_REQUEST[xsiteid];                              
$radub2= checkmathradub($radub2);
 $sql_level="SELECT
        hr_addradub.radub,
        tbl_salary_math_radub.salary_radub_id as radub_id,
        salary_level_id as level_id,
        tbl_salary_level.level as level,
        tbl_salary_level.money as money
        FROM
        hr_addradub
        Inner Join tbl_salary_math_radub ON hr_addradub.runid = tbl_salary_math_radub.radub_id
        Inner Join tbl_salary_level ON tbl_salary_math_radub.salary_radub_id = tbl_salary_level.salary_radub_id
        Inner Join tbl_salary_radub ON tbl_salary_level.salary_radub_id = tbl_salary_radub.salary_radub_id
        where  hr_addradub.radub='$radub2'  and tbl_salary_level.money='$salary2' and  tbl_salary_radub.profile_id in(SELECT profile_id FROM tbl_salary_profile Where  active_status='1')";      
        $result=mysql_db_query(DB_MASTER,$sql_level);
        $row=mysql_fetch_array($result);
        $money=$row[money];
   $sl="../../salary_mangement/salary_level.php?salary_radub_id=$radub2_id&action=view&xtitle=$radub2";
   if($money>0){
       echo"ok";
     }else{
       echo"no:$sl";
     }
 ?>