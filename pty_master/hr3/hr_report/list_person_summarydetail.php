<?

#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_list_person";
$module_code 		= "list_person"; 
$process_id			= "list_person";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: Rungsit
#DateCreate	::05/102007
#LastUpdate	::05/102007
#DatabaseTabel::
#END
#########################################################

include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
$time_start = getmicrotime();
require_once("../../../common/preloading.php");

//include("timefunc.inc.php");

set_time_limit(3600);
if ($maxlimit = ""){ $maxlimit=200 ; } 
$getdepid = $depid ;

if  ( $_SESSION[secid] == ""){ echo " Session is empty "; } 
if ($xsiteid == "") { $xsiteid = $_SESSION[secid] ; } 

# $hr_dbname  ;
$masterdb = "cmss";
# $masterdb = "cmss_otcsc" ; 


$masterIP = "192.168.2.12";
#$masterIP = "127.0.0.1";
$nowIP =  HOST ; 

$sql = " SELECT secname  FROM $dbnamemaster.`eduarea` WHERE `secid` LIKE '$xsiteid'  "; 
$result = mysql_db_query($masterdb , $sql) ;  
$rs = mysql_fetch_assoc($result) ; 
$rssecname  = $rs[secname] ; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>รายงานสถานะความครบถ้วน</title>

</head>
<body  >
<?
####################  xsiteid=5002&xtype=0&xcol=3 
$strparam  = "";
if ($xsiteid != ""){ $strparam .= "&xsiteid=$xsiteid";  } 
if ($xtype != ""){ $strparam .= "&xtype=$xtype";  } 
if ($xcol != ""){ $strparam .= "&xcol=$xcol";  } 
if ($orderby != ""){ 
	if ($orderway =="desc"){ 
		$orderway = "asc"; $neworderway="desc";  
	}else{
		$orderway = "desc"; $neworderway="asc";   
	} ##################################### if ($orderway =="desc"){ 
	$orderstr = "ORDER BY $orderby  $orderway  "; 
}else{
	$orderstr = "";
	$urlorder = "";
}

$urlorder = "&". $strparam   ."&orderway=". $orderway  ;
?>

<?
# $smonth = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย", "พ.ค", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$arrkey = array(
" บุคลากรทั้งหมด "  , 
" ผอ.สพท."  , 
" รอง ผอ.สพท."  , 
" ศึกษานิเทศน์ "  , 
" บุคคลากรทางการศึกษาอื่นตามมาตรา 38 ค.(2)"  , 
" ผู้อำนวยการโรงเรียน"  , 
" รองผู้อำนวยการโรงเรียน "  , 
) ; 
####################### 
#$xcol == 1	ทั้งหมดที่ต้องบันทึกข้อมูลเข้าสู่ระบบตามหนังสือสั่งการ  
#$xcol == 2	อยู่ระหว่างบันทึกข้อมูล  
#$xcol == 3	ตรวจสอบและรับรองความถูกต้องของข้อมูล ตามเอกสาร กพ.7 แล้ว 
if ($xcol == 1){ 
	$str_approve =""; 
}else  if ($xcol == 2){ 
	$str_approve = " and approve_status  <> 'approve'      ";
}else  if ($xcol == 3){ 
	$str_approve = " and approve_status  = 'approve'      ";
}else{
	$str_approve =""; 
} ######################## if ($xcol == 1){  
 $arrsql= array(
##############################################  0 รวม 
"  
SELECT
general.position_now,general.idcard,general.prename_th,general.name_th,
general.surname_th,general.approve_status,$dbnamemaster.allschool.office , general.siteid 
FROM        general
Left Join  $dbnamemaster.allschool ON general.schoolid = $dbnamemaster.allschool.id  
WHERE   general.siteid =  $xsiteid   
AND ( general.position_now   NOT LIKE  '%ครู%'  AND  general.position_now   NOT LIKE  '%ครูใหญ่%'  )  
$str_approve $orderstr
"  , 
############################################## 1 ผอ. เขต 
"   
  SELECT    position_now, idcard, prename_th, name_th, surname_th, approve_status  FROM   general  
WHERE 
general.siteid =  $xsiteid 
AND ( general.position_now LIKE  'ผู้อำนวยการ%' OR  general.position_now LIKE  'ผอ%'   )
AND (  general.position_now LIKE  '%สำนักงานเขตพื้นที่การศึกษา%' OR general.position_now LIKE  '%สพท%' )
AND( general.position_now not  LIKE  '%โรงเรียน%' and general.position_now not LIKE  '%สถานศึกษา%'  )
AND ( general.schoolid IS NULL    or  general.schoolid  ='' ) 
$str_approve $orderstr
"  , 
##############################################  2 รอง ผอ. เขต
" 
  SELECT    position_now, idcard, prename_th, name_th, surname_th, approve_status  FROM   general  
WHERE 
 general.siteid =  $xsiteid 
AND ( general.position_now LIKE  '%ผู้อำนวยการ%' OR  general.position_now LIKE  '%ผอ%'   )
AND (general.position_now NOT LIKE  'ผู้อำนวยการ%' and  general.position_now  NOT LIKE  'ผอ%'   ) 
AND (  general.position_now LIKE  '%สำนักงานเขตพื้นที่การศึกษา%' OR general.position_now LIKE  '%สพท%' )
AND( general.position_now not  LIKE  '%โรงเรียน%' and general.position_now not LIKE  '%สถานศึกษา%'  )
AND ( general.schoolid IS NULL    or  general.schoolid  ='' ) 
$str_approve $orderstr
"  ,   
############################################## 3 ศึกษานิเทศน์  
"
  SELECT  position_now, idcard, prename_th, name_th, surname_th, approve_status   FROM   general  
WHERE    general.siteid =  $xsiteid 
AND ( general.position_now    LIKE  '%ศึกษานิ%'    ) and   siteid = $xsiteid   
$str_approve  $orderstr 
   "  , 
##############################################   4  บุคคลากรทางการศึกษาอื่นตามมาตรา 38 ค.(2)   
" 
 SELECT  position_now, idcard, prename_th, name_th, surname_th, approve_status   FROM   general  
WHERE 
 general.siteid = $xsiteid      
 AND ( general.position_now not LIKE  '%ผู้อำนวยการ%' and   general.position_now not LIKE  '%ผอ%'   )
 AND ( general.position_now not  LIKE  '%ศึกษานิ%'    ) AND ( general.position_now not  LIKE  '%ครู%'    )
 AND ( general.schoolid IS NULL    or  general.schoolid  ='' ) 
 $str_approve $orderstr
"  , 
# AND(  general.position_now not  LIKE  '%โรงเรียน%' and general.position_now not LIKE  '%สถานศึกษา%'  )
##############################################   5  ผอ. 
"
SELECT
general.position_now,general.idcard,general.prename_th,general.name_th,
general.surname_th,general.approve_status,$dbnamemaster.allschool.office
FROM        general
Left Join $dbnamemaster.allschool ON general.schoolid = $dbnamemaster.allschool.id  
WHERE  general.siteid = $xsiteid   and position_now like 'ผู้อำนวยการ%' 
and position_now not like '%สำนักงานเขตพื้นที่การศึกษา%' and position_now not like '%สพท%'
$str_approve $orderstr
"  , 
 ##############################################   6 รอง / ผู้ช่วย ผอ.
" 
	SELECT  position_now, idcard, prename_th, name_th, surname_th, approve_status ,$dbnamemaster.allschool.office  FROM   general
	Left Join $dbnamemaster.allschool ON general.schoolid = $dbnamemaster.allschool.id   
	where  general.siteid =  $xsiteid  and     position_now like  'รอง%'  
	and position_now not like '%สำนักงานเขตพื้นที่การศึกษา%' 	and position_now not like '%สพท%'
	$str_approve $orderstr
"   
) ;   
?>
 <table width="98%" border="0" align="center">
   <tr>
     <td align="center" class="strong_black">
	  <?=$rssecname?> <br />รายชื่อ  <?=$arrkey[$xtype]?>
<?
if ($xcol ==2) { 
	$str_xcol = " ที่อยู่ระหว่างบันทึกข้อมูล " ; 
}elseif ($xcol ==3) {  
	$str_xcol = " ที่ตรวจสอบและรับรองความถูกต้องของข้อมูล ตามเอกสาร กพ.7 แล้ว  " ; 
}

echo $str_xcol ;
?>
	  
	   </td>
   </tr>
 </table>
 <table width="98%" border="0" align="center">
   <tr>
     <td align="right">&nbsp;
     
         <a href="#"  onclick="onclick=window.close() ; " >ปิดหน้านี้</a> </td>
   </tr>
 </table>
 <br />
<?
$sql1 =  $arrsql[$xtype] ; 
/*        
echo "<pre> ";  
print_r($sql1) ; 
echo "</pre> ";  
*/          
if ($debug == "on"){  	echo "  <hr><pre>  $sql1</pre> <hr>  "; } ## 
$result1= mysql_db_query($hr_dbname , $sql1); 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql1 <br> ".mysql_error() ."<br>"  ;   }
?> 
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr bgcolor="#99CC99" class="strong_black"   align="center"  >
    <td width="8%"  >ลำดับ </td>
    <td width="25%">ชื่อ - นามสกุล </td>
    <td width="21%">หมายเลขประจำตัวประชาชน</td>
    <td width="24%"><a href="?<?=$urlorder?>&orderby=position_now" target="_self"></a>ตำแหน่ง </td>
    <td width="22%"><a href="?<?=$urlorder?>&orderby=approve_status" target="_self"></a>สถานะการตรวจสอบข้อมูล </td>
  </tr>
<?  while ($rs1 =  mysql_fetch_assoc($result1)){    
# position_now, idcard, prename_th, name_th, surname_th, approve_status 
if ($bgcolor1 == "EFEFEF"){  $bgcolor1 = "DDDDDD"  ; } else {$bgcolor1 = "EFEFEF" ;}
if ($xtype == 5 or $xtype == 6){   
	$scname = $rs1[office] ;
	if ($scname != ""){ $scname = "(รร.". $scname .")" ; } 
} ########### END  if ($xtype == 5 or $xtype == 6){   
if( $rs1[approve_status] == "approve"){
	$rs1_approve_status = "ผ่านการรับรองข้อมูลแล้ว";
}else{
	$rs1_approve_status = "อยู่ระหว่างการบันทึกข้อมูล";
}	

?>  
  <tr bgcolor="<?=$bgcolor1?>" align="center">
    <td   > <? ++$nonm ; ?> <?=$nonm?></td>
    <td align="left"   >&nbsp;<?=$rs1[prename_th]?>
      <?=$rs1[name_th]?>
      <?=$rs1[surname_th]?></td>
    <td   >&nbsp;      <?=$rs1[idcard]?>  </td>
    <td align="left"   >&nbsp;
    <?=$rs1[position_now]?><?=$scname?><? $scname=""; ?></td>
    <td   >&nbsp; <?=$rs1_approve_status?></td>
  </tr>
<?  } #### END  while ($rs1 =  mysql_fetch_assoc($result1)){    ?>    
</table>
 

<br />
<table width="98%" border="0" align="center">
  <tr>
    <td align="right"> 
    &nbsp; 
   <a href="#"  onclick="onclick=window.close() ; " >ปิดหน้านี้</a>    </td>
  </tr>
</table>
</body>
</html>
