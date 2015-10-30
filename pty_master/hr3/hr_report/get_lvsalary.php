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

     
function checkmathradub($radub1,$radub2){
    $array_radub['ปฏิบัติการ']=array('3','4','5');  
    $array_radub['ชำนาญการ']=array('6','6ว','7','7ว','7วช');  
    $array_radub['ชำนาญการพิเศษ']=array('8','8ว','8วช');     
    $array_radub['เชียวชาญ']=array('9วช','9ชช');  
    $array_radub['ทรงคุณวุฒิ']=array('10วช','10ชช','11วช','11ชช');       
    $array_radub['ปฏิบัติงาน']=array('1','2','3','4'); 
    $array_radub['ชำนาญงาน']=array('5','6');    
    $array_radub['อาวุโส']=array('7','8');       
    $array_radub['ทักษะพิเศษ']=array('9ชช');     
   
  //1
  $radub="";
  $arr=$array_radub[$radub2]; 
  if(count($arr)>0){
   if (in_array($radub1, $arr)){
        $radub=$radub2;
   }
  }
  if($radub==""){
    $arr=$array_radub[$radub1]; 
    if(count($arr)>0){  
        if (in_array($radub2, $arr)){ 
         $radub=$radub1;    
        }
    }
  }
  return $radub;
    
 }







#======================================================================== 
function getmax_salary($radub,$salary,$radub_id){

   global    $year ; 
     if($radub=="ทักษะพิเศษ" or $radub=="ชำนาญงาน" or $radub=="เชี่ยวชาญ" or $radub=="อาวุโส" or $radub=="ปฏิบัติงาน" or $radub=="ทรงคุณวุติ" or   $radub=="ชำนาญการ" or  $radub=="ชำนาญการพิเศษ" or $radub=="ปฏิบัติการ"  ){
        $array_radub['อาวุโส']['34710']=array('money0_5'=>'0','money1'=>'0','money1_5'=>'730'); 
        $array_radub['อาวุโส']['35360']=array('money0_5'=>'0','money1'=>'730','money1_5'=>'1450');        
        $array_radub['ปฏิบัติงาน']['17600']=array('money0_5'=>'0','money1'=>'0','money1_5'=>'370');
        $array_radub['ปฏิบัติงาน']['17890']=array('money0_5'=>'0','money1'=>'370','money1_5'=>'730');
        $array_radub['ปฏิบัติงาน']['18190']=array('money0_5'=>'370','money1'=>'730','money1_5'=>'1100');        
        $array_radub['ทรงคุณวุติ']['62200']=array('money0_5'=>'0','money1'=>'0','money1_5'=>'1290');
        $array_radub['ทรงคุณวุติ']['63270']=array('money0_5'=>'0','money1'=>'1290','money1_5'=>'2580');
        $array_radub['ทรงคุณวุติ']['64340']=array('money0_5'=>'1290','money1'=>'2580','money1_5'=>'3870');     
        $array_radub['ชำนาญการ']['34220']=array('money0_5'=>'0','money1'=>'0','money1_5'=>'210'); 
        $array_radub['ชำนาญการ']['34890']=array('money0_5'=>'0','money1'=>'210','money1_5'=>'880');     
        $array_radub['ปฏิบัติการ']['21520']=array('money0_5'=>'0','money1'=>'0','money1_5'=>'450');  
        $array_radub['ปฏิบัติการ']['21880']=array('money0_5'=>'0','money1'=>'450','money1_5'=>'890');  
        $array_radub['ปฏิบัติการ']['22220']=array('money0_5'=>'450','money1'=>'890','money1_5'=>'1340');     
        $array_radub['ชำนาญการพิเศษ']['48400']=array('money0_5'=>'0','money1'=>'0','money1_5'=>'700');      
        $array_radub['ชำนาญการพิเศษ']['49350']=array('money0_5'=>'0','money1'=>'700','money1_5'=>'1650');
        $arr=$array_radub[$radub][$salary];          
        $salary=(is_array($arr))?$salary:"";

    }else{
        $sql_maxlevel="SELECT
            tbl_salary_math_radub.salary_radub_id as radub_id,
            max(salary_level_id) as level_id,
            max(tbl_salary_level.level) as maxlevel,
            max(tbl_salary_level.money) as maxmoney
            FROM
            hr_addradub
            Inner Join tbl_salary_math_radub ON hr_addradub.runid = tbl_salary_math_radub.radub_id
            Inner Join tbl_salary_level ON tbl_salary_math_radub.salary_radub_id = tbl_salary_level.salary_radub_id
            Inner Join tbl_salary_radub ON tbl_salary_level.salary_radub_id = tbl_salary_radub.salary_radub_id
            where  tbl_salary_math_radub.radub_id='$radub_id' and  tbl_salary_radub.profile_id in(SELECT profile_id FROM tbl_salary_profile Where  active_status='1' and yy='$year')
            group by tbl_salary_math_radub.radub_id order by tbl_salary_math_radub.salary_radub_id";
            //echo $sql_maxlevel;
            $result=mysql_db_query(DB_MASTER,$sql_maxlevel);
            $row=mysql_fetch_array($result); 
            $salary=$row[maxmoney].":".$row[maxlevel];
     }
    
    return $salary;
}
#======================================================================== 
function get_level_salary($radub,$salary,$radub_id){
 global    $year ,$xxx;
     if($radub=="ทักษะพิเศษ" or $radub=="ชำนาญงาน" or $radub=="เชี่ยวชาญ" or $radub=="อาวุโส" or $radub=="ปฏิบัติงาน" or $radub=="ทรงคุณวุติ" or   $radub=="ชำนาญการ" or  $radub=="ชำนาญการพิเศษ" or $radub=="ปฏิบัติการ"  ){
             $sql_level="SELECT
        hr_addradub.radub,
        tbl_salary_math_radub.salary_radub_id as radub_id,
        salary_level_id as level_id,
        tbl_salary_level.level as level,
        tbl_salary_level.money0_5 as money0_5,
        tbl_salary_level.money1 as money1,  
        tbl_salary_level.money1_5 as money1_5  
        FROM
        hr_addradub
        Inner Join tbl_salary_math_radub ON hr_addradub.runid = tbl_salary_math_radub.radub_id
        Inner Join tbl_salary_level ON tbl_salary_math_radub.salary_radub_id = tbl_salary_level.salary_radub_id
        Inner Join tbl_salary_radub ON tbl_salary_level.salary_radub_id = tbl_salary_radub.salary_radub_id
        where  hr_addradub.radub='$radub'  and tbl_salary_level.money='$salary' and  tbl_salary_radub.profile_id in(SELECT profile_id FROM tbl_salary_profile Where  active_status='1' and yy='$year')";
        $xxx=$sql_level;
        $result=mysql_db_query(DB_MASTER,$sql_level);
        $row=mysql_fetch_array($result); 
        
           $level1[$salary]="0";  
           $level1[$row[money0_5]]="0.5"; 
           $level1[$row[money1]]="1";  
           $level1[$row[money1_5]]="1.5";    
     
     
     

    }else{
        //level1
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
        where  hr_addradub.radub='$radub'  and tbl_salary_level.money='$salary' and  tbl_salary_radub.profile_id in(SELECT profile_id FROM tbl_salary_profile Where  active_status='1' and yy='$year')"; 
       // echo $sql_level;  
       $xxx=$sql_level;     
            $result=mysql_db_query(DB_MASTER,$sql_level);
            $row=mysql_fetch_array($result);
            $level1=$row[level];
      
     }
  
  
 return $level1;
}
#========================================================================
function get_runid_viataya($radub){
    $sql="SELECT  runid,    radub       FROM hr_addradub  where radub='$radub'";
    $result=mysql_db_query(DB_MASTER,$sql);
    $row=mysql_fetch_array($result); 
    return $row[runid];
}

#=========================================================================    
 
$radub2 =   $_REQUEST["radub"]  ; 
$salary2 = str_replace(',','',  $_REQUEST["salary"] ) ;  
$radub2_id= get_runid_viataya($radub2); 
$xidcard=$_REQUEST[xidcard]; 
$xsiteid=$_REQUEST[xsiteid]; 
$year=$_REQUEST[year]; 
$month=$_REQUEST[month]; 
$day=$_REQUEST[day]; 
 $xxx='' ; 
$date_sel="$year-$month-$day";
  $sql="SELECT   `date`,  radub, salary  FROM salary where id='$xidcard' and date(`date`) < date('$date_sel')order by  date(`date`) desc  limit  1  ";

 $result=mysql_db_query(STR_PREFIX_DB.$xsiteid,$sql);
 $row=mysql_fetch_array($result);
 $salary1=$row[salary];
 $radub1=$row[radub]; 
if( $year>=2547){ 
    if($month<12 && $year==2547){
          $year='2538';
    }else{
        if($year>=2550){
         $year='2552' ;  
         if($year==2550&&$month<10){ 
          $xyear='2547' ;   
        }
        }else{
          $year='2547' ;
        }
        if($radub1!=$radub2){
          $radub1=checkmathradub($radub1,$radub2);
          $radub2=checkmathradub($radub2,$radub1);        
        }
          
         
    }
         
      
} else{
    $year='2538'; 
} 
 
 $radub1_id= get_runid_viataya($radub1);
 if($salary2!=$salary1){
     $tem_salary1=explode(":", getmax_salary($radub1,$salary1,$radub1_id)); 
     
      if($salary1==$tem_salary[0]){
        //เป็นขั้นสูงสุด
        $status= "max";
      }else{
         //ไม่เป็นขั้นสูงสุด
         
       $level1=get_level_salary($radub1,$salary1,$radub1_id) ;
       $c=$level1;
       if(is_array($level1)){
          $level =$level1[$salary2];
       }else{
           $level2=get_level_salary($radub2,$salary2,$radub2_id) ;
           $level=$level2-$level1;
       }
                       
       
       
       
       
       if($level==0){
         $status="nomal";  
       }else{
         $status="up"; 
       } 
      }
 }else{
    $status="nomal";
    $level="0";
 }  
  echo"$status:$level";
?>