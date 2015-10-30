<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_entry13group";
$module_code 		= "entry13group"; 
$process_id			= "entry13group";
$VERSION 				= "9.91";
$BypassAPP 			= true;
#########################################################
#Developer 	:: Rungsit
#DateCreate	::19/2/2551
#LastUpdate	::19/2/2551
#DatabaseTabel::
#END
#########################################################
include("../libary/function.php");
include("../../../config/conndb_nonsession.inc.php");
include("../../../common/common_competency.inc.php");
require_once "../../../common/class.writeexcel_workbook.inc.php";
require_once "../../../common/class.writeexcel_worksheet.inc.php";
$time_start = getmicrotime();


set_time_limit(36000);
if ($maxlimit = ""){ $maxlimit=200 ; } 
$getdepid = $depid ;

$nowIPx =  $_SERVER[SERVER_ADDR] ; 
if ($nowIPx == "127.0.0.1"){
	$masterIP = "127.0.0.1";
	$nowIP = "localhost";
}else{
	$masterIP = "192.168.2.12";	
	$nowIP =  HOST ;
} ############### END  if ($nowIP == "127.0.0.1"){
#$masterIP = "192.168.2.12";	
$masterDB = $dbnamemaster ; 
$title 	= "จำแนกตามสังกัด"; 



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<title>รายงานสถานะการขอปรับปรุงข้อมูล</title>
</head>
<body><?
$arrsiteid = array ( 
1001 ,1002 ,1003 ,1101 ,1102 ,1201 ,1202 ,1301 ,1302 ,1401 ,1402 ,1501 ,1601 ,1602 ,1701 ,1801 ,
1901 ,1902 ,2001 ,2002 ,2003 ,2101 ,2102 ,2201 ,2202 ,2301 ,2401 ,2402 ,2501 ,2601 ,2701 ,2702 ,
3001 ,3002 ,3003 ,3004 ,3005 ,3006 ,3007 ,3101 ,3102 ,3103 ,3104 ,3201 ,3202 ,3203 ,3301 ,3302 ,
3303 ,3304 ,3401 ,3402 ,3403 ,3404 ,3405 ,3501 ,3502 ,3601 ,3602 ,3603 ,3701 ,3901 ,3902 ,4001 ,
4002 ,4003 ,4004 ,4005 ,4101 ,4102 ,4103 ,4104 ,4201 ,4202 ,4301 ,4302 ,4303 ,4401 ,4402 ,4501 ,
4502 ,4503 ,4601 ,4602 ,4603 ,4701 ,4702 ,4703 ,4801 ,4802 ,4901 ,5001 ,5002 ,5003 ,5004 ,5005 ,
5101 ,5102 ,5201 ,5202 ,5203 ,5301 ,5302 ,5401 ,5402 ,5501 ,5502 ,5601 ,5602 ,5701 ,5702 ,5703 ,
5704 ,5801 ,5802 ,6001 ,6002 ,6003 ,6101 ,6201 ,6202 ,6301 ,6302 ,6401 ,6402 ,6501 ,6502 ,6503 ,
6601 ,6602 ,6701 ,6702 ,6703 ,7001 ,7002 ,7101 ,7102 ,7103 ,7201 ,7202 ,7203 ,7301 ,7302 ,7401 ,
7501 ,7601 ,7602 ,7701 ,7702 ,8001 ,8002 ,8003 ,8004 ,8101 ,8201 ,8301 ,8401 ,8402 ,8403 ,8501 ,
8601 ,8602 ,9001 ,9002 ,9003 ,9101 ,9201 ,9202 ,9301 ,9401 ,9402 ,9403 ,9501 ,9502 ,9503 ,9601 ,
9602 ,9603 ,9910 ,9911 ,9912 ,9914 ,9915 ,9999  ) ; 

#    echo "<pre>";           print_r($arrsiteid) ;           echo "</pre>";
if ($nextq == ""){ $nextq = 0 ;  echo " <h4>  SET  nextq   ==&#62;  0 </h4> ";} 
$xsiteid =  $arrsiteid[$nextq] ; 
$nextq++ ; 

$nowdbname = STR_PREFIX_DB. $xsiteid ; 

$sql = " SELECT secname,  IP, intra_ip   FROM eduarea  
Inner Join area_info ON eduarea.area_id = area_info.area_id    WHERE `secid` LIKE '$xsiteid'  "; 
$result = mysql_db_query($masterDB , $sql) ;  
$rs = mysql_fetch_assoc($result) ; 
$rssecname  = $rs[secname] ; 
$ipintra = $rs[intra_ip] ; 
$ipinter = $rs[IP] ; 

conn($ipintra) ; 
echo " <h4>   $rssecname  ($xsiteid)    </h4>  ";  
echo " <br> $ipintra   ";  

################### ประวัติการศึกษา    graduate
$sql = "  SELECT id , count(id) AS countnm   FROM  graduate   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 


while ($rs = mysql_fetch_assoc($query)){ 
#	echo " <br>   $idcard   ";
	$idcard = $rs[id] ; 
	$arr_graduate[$idcard] = $rs[countnm] ; 
} ################### ประวัติการศึกษา    graduate 
# print_r($arr_graduate ) ; 

################### salary	ตำแหน่งและอัตราเงินเดือน  
$sql = "  SELECT id , count(id) AS countnm   FROM  salary   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_salary[$idcard] = $rs[countnm] ; 
} ################### salary	ตำแหน่งและอัตราเงินเดือน   

###################      seminar	ฝึกอบรมและดูงาน  
$sql = "  SELECT id , count(id) AS countnm   FROM  seminar   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_seminar[$idcard] = $rs[countnm] ; 
} ################### seminar	ฝึกอบรมและดูงาน   

################### getroyal	เครื่องราชอิสริยาภรณ์  
$sql = "  SELECT id , count(id) AS countnm   FROM  getroyal   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_getroyal[$idcard] = $rs[countnm] ; 
} ################### getroyal	เครื่องราชอิสริยาภรณ์   

################### special	ความรู้ความสามารถพิเศษ  
$sql = "  SELECT id , count(id) AS countnm   FROM  special   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_special[$idcard] = $rs[countnm] ; 
} ################### special	ความรู้ความสามารถพิเศษ   

################### hr_absent	จำนวนวันลาหยุดราชการ ขาดราชการมาสาย  
$sql = "  SELECT id , count(id) AS countnm   FROM  hr_absent   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_hr_absent[$idcard] = $rs[countnm] ; 
} ################### hr_absent	จำนวนวันลาหยุดราชการ ขาดราชการมาสาย   

################### hr_nosalary	วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็ม
$sql = "  SELECT id , count(id) AS countnm   FROM  hr_nosalary   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_hr_nosalary[$idcard] = $rs[countnm] ; 
} ################### hr_nosalary	วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็ม 

################### hr_prohibit	การได้รับโทษทางวินัย  
$sql = "  SELECT id , count(id) AS countnm   FROM  hr_prohibit   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_hr_prohibit[$idcard] = $rs[countnm] ; 
} ################### hr_prohibit	การได้รับโทษทางวินัย   

################### hr_specialduty	การปฏิบัติราชการพิเศษ  
$sql = "  SELECT id , count(id) AS countnm   FROM  hr_specialduty   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_hr_specialduty[$idcard] = $rs[countnm] ; 
} ################### hr_specialduty	การปฏิบัติราชการพิเศษ   

################### hr_other	รายการอื่น ๆ ที่จำเป็น  
$sql = "  SELECT id , count(id) AS countnm   FROM  hr_other   group by id   ";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_hr_other[$idcard] = $rs[countnm] ; 
} ################### hr_other	รายการอื่น ๆ ที่จำเป็น   
?><?
################### ลบรายการ ใน site นี้ออกจาก table view ก่อน  
$sql = " DELETE  FROM `aview_entrydata` WHERE  siteid = $xsiteid   " ; 
$query = mysql_db_query($masterDB , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 

################### General 
$sql = " 
SELECT general.id,  general.birthday, general.prename_th, general.schoolid as scid , 
general.name_th, general.surname_th, general.position_now,  general.approve_status , 
$masterDB.allschool.office 
FROM  general 
Left Join $masterDB.allschool ON general.schoolid = $masterDB.allschool.id
";
$query = mysql_db_query($nowdbname , $sql ) ; 
if (mysql_errno() != 0){ echo "<br>LINE ".__LINE__. " <br> $sql <br> ".mysql_error() ."<br>"  ;   } 
while ($rs = mysql_fetch_assoc($query)){ 
	$idcard = $rs[id] ; 
	$arr_scid[$idcard] = $rs[scid] ; 	
	$arr_birthday[$idcard] = $rs[birthday] ; 
	$arr_prename_th[$idcard] = $rs[prename_th] ; 
	$arr_name_th[$idcard] = $rs[name_th] ; 
	$arr_surname_th[$idcard] = $rs[surname_th] ; 
	$arr_position_now[$idcard] = $rs[position_now] ; 
	$arr_office[$idcard] = $rs[office] ; 
	$arr_approve[$idcard] = $rs[approve_status] ; 
} ################### General 
?><?
# print_r($arr_birthday) ; 
 while (list ($idcard, $birthday) = each ($arr_birthday)) {


	$sqlins = " 
	REPLACE INTO aview_entrydata 
	(idcard,siteid,schoolid,schoolname, birthday,prename_th,name_th,      surname_th, position_now,approvestatus,graduate,
	salary,seminar,getroyal,special,hr_absent,                     hr_nosalary,hr_prohibit,hr_specialduty,hr_other
	) VALUES (
	'$idcard','$xsiteid','$arr_scid[$idcard]', '$arr_office[$idcard]','$birthday','$arr_prename_th[$idcard]','$arr_name_th[$idcard]',
	'$arr_surname_th[$idcard]','$arr_position_now[$idcard]','$arr_approve[$idcard]', '$arr_graduate[$idcard]',
	'$arr_salary[$idcard]', '$arr_seminar[$idcard]','$arr_getroyal[$idcard]','$arr_special[$idcard]','$arr_hr_absent[$idcard]',
	'$arr_hr_nosalary[$idcard]','$arr_hr_prohibit[$idcard]','$arr_hr_specialduty[$idcard]','$arr_hr_other[$idcard]'
	) " ; 
	mysql_db_query($masterDB , $sqlins) ; 
	$nonm++ ;  
}
echo " <h4>  บันทึกแล้วทั้งสิ้น  $nonm  คน </h4> ";
?>
<meta http-equiv="refresh" content="3;URL=?nextq=<?=$nextq?>" />
