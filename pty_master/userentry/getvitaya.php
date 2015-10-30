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
// include ("../../../config/conndb_nonsession.inc.php")  ; 
                                                        
    $sql="SELECT
    vitaya_stat.name,
    vitaya_stat.id,
    vitaya_stat.date_command,
    vitaya_stat.date_start,
    vitaya_stat.remark,
    vitaya_stat.vitaya_id,
     ".DB_MASTER.".vitaya.orderby
    FROM
    vitaya_stat
    Inner Join  ".DB_MASTER.".vitaya ON vitaya_stat.vitaya_id =  ".DB_MASTER.".vitaya.runid
    WHERE  vitaya_stat.id ='$xidcard' ORDER BY   vitaya_stat.date_command DESC   limit 1 "; 
    $result=mysql_db_query(STR_PREFIX_DB.$xsiteid,$sql);
    $idmax=""; 
    $i=0;
  
    while($row=mysql_fetch_array($result)){    
      $idate=$row[date_start]; 
      $idmax=$row[orderby];
    }  

 
 list($year_max, $month_max, $day_max) = explode("-", $idate);
 list($year_now, $month_now, $day_now) = explode("-", $sdate);   

 if(@checkdate($month_max, $day_max, $year_max-543)&&@checkdate($month_now, $day_now, $year_now-543)){
  $tmax=  mktime(0, 0, 0, $day_max, $month_max, $year_max-543); 
  $tnow=  mktime(0, 0, 0, $day_now, $month_now, $year_now-543);

 if($tmax==$tnow){ //ทีแก้ไขเป้นรายการล่าสุด
 $con=" (vitaya.orderby >= $idmax)";   
 }elseif( $tmax >$tnow)  { //ทีแก้ไขน้อยกว่ารายการล่าสุด 
          if($xvitaya!=""){
            $con=" vitaya.runid  = $xvitaya"; 
          } else{
			   $con="1=1"; 
           // $con=" vitaya.orderby > 999";  
          }
 }else{ //เพิ่มใหม่
    $con=" vitaya.orderby > $idmax"; 
 }
 } else{
 $con='1=1'   ;
 }
$dbnamemaster="edubkk_master";
$sql="SELECT      
vitaya.vitayaname  as value ,
vitaya.runid as id
FROM
position_math_vitaya
Inner Join hr_addposition_now ON hr_addposition_now.runid = position_math_vitaya.position_id
Inner Join vitaya ON position_math_vitaya.vitaya_id = vitaya.runid
where hr_addposition_now.`pid`= '$postname' and $con  GROUP BY vitaya.vitayaname  order by vitaya.orderby";
$sql="SELECT 
vitaya.vitayaname AS value,
vitaya.runid AS id,
hr_addradub.radub ,
hr_addradub.level_id 
FROM
vitaya
Inner Join radub_math_vitaya ON radub_math_vitaya.vitaya_id = vitaya.runid
Inner Join hr_addradub ON hr_addradub.level_id = radub_math_vitaya.level_id where 
radub_math_vitaya.level_id='$radub_id' and $con GROUP BY vitaya.vitayaname  order by vitaya.orderby";


 //echo $sql;
 $select1 = mysql_db_query($dbnamemaster,$sql);  

 echo" <select name=\"vitaya\" id=\"vitaya\" >";
 echo " <option value=\"\" class=\"warn\">ไม่ระบุวิทยฐานะ</option> ";
 
 while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){ 
   if($idsel==$rselect1[id]){$sel="selected";}
  echo"<option $sel  value=\"$rselect1[id]\" >$rselect1[value]</option>";
  $sel="";

  }
?>