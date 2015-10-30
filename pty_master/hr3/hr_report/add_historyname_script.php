<?php
session_start();
/*            
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include ("checklogin.php");
include ("phpconfig.php");
include("alert.php");
*/        

include ("session.inc.php");
session_start();
#include ("checklogin.php");
include ("../../../config/phpconfig.php");

Conn2DB();

if ($_SERVER[REQUEST_METHOD] == "POST"){

}
?>
<?
$smonth = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย", "พ.ค", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
function  convert_date1($date001){  // convert  form format   2004-11-25  (YYYY-MM-DD)
				global $smonth ; 
				$syear = substr ("$date001", 0,4); // ปี
				if ($syear < 2300 ){  $syear = $syear + 543 ;  }
				$smm =  number_format(substr ("$date001", 5,2))  ; // เดือน
				$sday = (int)substr ("$date001", 8,2); // วัน
				$convert_date1 = "  $sday   ". $smonth[$smm] ." $syear  ";		
				return $convert_date1 ;
}
?>		
<html>
<head>
<title>ข้อมูลข้าราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
-->
</style>
</head>
<body >
<?
$tbname = "hr_addhistoryname" ; 
# print_r($_SESSION) ; 
$general_id = $_SESSION[id] ; 
?>

<?
if ($addnew  != ""){ 
$tmpdate = explode("/" , $xdate) ;
$dd1 = $tmpdate[0] ; $mm1 = $tmpdate[1] ; $yy1 = $tmpdate[2] ; $yy1 -=  543 ; 

$daterec = $yy1 ."-". $mm1  ."-". $dd1  ;  

$sql = " 
INSERT INTO `hr_addhistoryname` ( `gen_id`,`prename_th`,`name_th`,`surname_th`,
`secondname_th`,`prename_en`,`name_en`,`surname_en`,`secondname_en`,`daterec`,`updatetime`) 
VALUES (   '$general_id','$prename_th','$name_th','$surname_th','$secondname_th',
'$prename_en','$name_en','$surname_en','$secondname_en','$daterec',NOW()  )
";  
$result = mysql_query($sql) ; 
}
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" bgcolor="#2C2C9E"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="15%"><img src="bimg/hr.gif" width="177" height="60" /></td>
              <td width="85%"><B class="pheader">
                <?=($rs[runid]!=0?"แก้ไข":"เพิ่ม")?>ประวัติการเปลี่ยนแปลงคำนำหน้าชื่อ นามสกุล และ ชื่อรอง </B></td>
            </tr>
        </table></td>
      </tr>
      <tr>

        <td>&nbsp;
		
		
		
		</td>
      </tr>
    </table>
<?
$sql = " 
SELECT
general.id, general.birthday, 
general.prename_th, general.prename_en, general.name_th, general.surname_th, 
general.name_en, general.surname_en 
FROM   general
" ; 
$query = mysql_query($sql ) ;
while ($rs =mysql_fetch_assoc($query)){ 
$tmpyear = explode ( "-",$rs[birthday] ) ;
$old15 = $tmpyear[0]  + 15  ; 
$next15 =    $old15  ."-". $tmpyear[1] ."-". $tmpyear[2] ; 



# $rs[prename_th]
# $rs[prename_en]
if (($rs[prename_th] == "นาง") or ($rs[prename_th] == "นางสาว") or   ($rs[prename_th] == "น.ส.")){
	$th_prename = "นางสาว";
	$en_prename = "Mrs";
}else{
	$th_prename = "นาย";
	$en_prename = "Mr";
} 
$sqlins = " 
INSERT INTO `hr_addhistoryname` ( `gen_id`,`prename_th`,`name_th`,`surname_th`,
`secondname_th`,`prename_en`,`name_en`,`surname_en`,`secondname_en`,`daterec`,`updatetime`) 
VALUES (   '$rs[id]','$th_prename','$rs[name_th]','$rs[surname_th]','$rs[secondname_th]',
'$en_prename','$rs[name_en]','$rs[surname_en]','$rs[secondname_en]','$next15',NOW()  )
"; 

echo  " <br><br> #   $rs[birthday] ::::::::  <br> ". $sqlins  ."   ";
mysql_query($sqlins) ; 
}
?>
	
	
	
</td>
  </tr>
</table>
</body>
</html>