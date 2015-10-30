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
function checkmathradub($radub1){
    $array_radub['ปฏิบัติการ']=array('3','4','5');  
    $array_radub['ชำนาญการ']=array('6','6ว','7','7ว','7วช');  
    $array_radub['ชำนาญการพิเศษ']=array('8','8ว','8วช');     
    $array_radub['เชียวชาญ']=array('9วช','9ชช');  
    $array_radub['ทรงคุณวุฒิ']=array('10วช','10ชช','11วช','11ชช');       
    $array_radub['ปฏิบัติงาน']=array('1','2','3','4'); 
    $array_radub['ชำนาญงาน']=array('5','6');    
    $array_radub['อาวุโส']=array('7','8');       
    $array_radub['ทักษะพิเศษ']=array('9ชช');     
   
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
    global $xyear;
     $sql="SELECT  tbl_salary_math_radub.salary_radub_id  FROM
hr_addradub Inner Join tbl_salary_math_radub ON hr_addradub.runid = tbl_salary_math_radub.radub_id 
       where hr_addradub.radub='$radub' and  tbl_salary_math_radub.profile_id in(SELECT profile_id FROM tbl_salary_profile Where  active_status='1' and yy='$xyear')"; //  echo   $sql;
    $result=mysql_db_query("cmss_master",$sql);
    $row=mysql_fetch_array($result); 
    return $row[salary_radub_id];
}

#=========================================================================
$radub2 = $_REQUEST["radub"]; 
$salary2 = str_replace(',','',  $_REQUEST["salary"] ) ;  

$xsiteid=$_REQUEST[xsiteid]; 
$xyear=$_REQUEST[xyear];
$month=$_REQUEST[month]; 
$xyear2=$_REQUEST[xyear];

$xpos_lv = strpos($radub2,"คศ.");
if($xyear>=2547){ 
    if($xyear==2547&&$month<12){ 
	  if($xpos_lv === false){
		   $xyear = $xyear;
		}else{
			$xyear='2538' ;	
		}
	 

    }else {
     if($xyear>=2550){ 
         $xyear='2552' ;  
        if($xyear==2550&&$month<10){ 
          $xyear='2547' ; 
		  //echo "yy = ".$xyear."<br>"; 
        }                                 
       $radub2= checkmathradub($radub2); 
       
      }else{
        $xyear='2547' ;
       $radub2= checkmathradub($radub2);    
      }        
      
    }   
} else{
    $xyear='2538' ;
}
$radub2_id= get_runid_viataya(trim($radub2));     
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
        where  hr_addradub.radub='$radub2'  and tbl_salary_level.money='$salary2' and  tbl_salary_radub.profile_id in(SELECT profile_id FROM tbl_salary_profile Where  active_status='1' and yy='$xyear')";  
        //echo  $sql_level;    
        $result=mysql_db_query("cmss_master",$sql_level);
        $row=mysql_fetch_array($result);
        $money=$row[money];
   $sl="../../salary_mangement/salary_level.php?salary_radub_id=$radub2_id&action=view&xtitle=$radub2";
   if($money>0){
       echo"ok";
     }else{
       if($xyear2=='2550' && $xyear=='2552' && $month=='10'){
          $xyear=2547;  
          $radub2_id= get_runid_viataya(trim($radub2)); 
           $sl="../../salary_mangement/salary_level.php?salary_radub_id=$radub2_id&action=view&xtitle=$radub2||$sl";   
       } 
 
       echo"no:$sl:$xyear2:$month";
     }
 ?>