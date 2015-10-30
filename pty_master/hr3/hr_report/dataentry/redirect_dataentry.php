<? 
session_start();
//session_destroy();

include ("../../../config/conndb_nonsession.inc.php")  ;
function AreaKeyKp7(){
	global $dbnamemaster;
	$sql = "SELECT
eduarea.secid
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata'";
	$result = mysql_db_query($dbnamemaster,$sql);
	while($rs = mysql_fetch_assoc($result)){
			$arr_site[$rs[secid]] = $rs[secid];
	}
		return $arr_site;
}//end function AreaKeyKp7(){ 


?>
<html>
<head>
<title>เข้าสู่ระบบฐานข้อมูล</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../../../common/style.css" rel="stylesheet" type="text/css">
<LINK   href="close_files/template_css.css" type=text/css rel=stylesheet>
<style type="text/css">
<!--
.style2 {font-size: 12}
-->
</style>
</head>
</html><body bgcolor="#FFFFFF">
<?

$xsellect_siteid = $secname ; 
# if ($xsellect_siteid == 5001
#  echo " <br> <h4> <center> ขออภัย  ปิดระบบเพื่อสำรองข้อมูล <br>  ตั้งแต่วันจันทร์ที่ 23 มิถุนายน 2551 เวลา 08.00 - วันอังคารที่ 24 มิุถุนายน 2552 ";die; 


$sql = " select  IP,secid   from eduarea  INNER JOIN  area_info  ON  eduarea.area_id = area_info.area_id   where eduarea.secid = '$secname'  ";
$result = mysql_query($sql);
$rs = mysql_fetch_assoc($result);

##  ทำการปิดเขตที่จะทำการบันทึกข้อมูลโดยบริษัท
//$xsql_area = "SELECT * FROM eduarea WHERE config_area='1'";
////echo $xsql_area."$dbnamemaster";die;
//$xresult_area = mysql_db_query($dbnamemaster,$xsql_area);
//while($xrs_a = mysql_fetch_assoc($xresult_area)){
//	$arrsite[$xrs_a[secid]] = $xrs_a[secid];
//}//end while(){
/*
############################################## <== Start comment
	$reporturl = "http://$rs[IP]/$aplicationpath/application/hr3/index.php?secid=$rs[secid]&action=login";
	//echo $reporturl;echo "<hr>$sql";die;
	echo "<script language=\"javascript\">
	window.open('$reporturl','_top');
	</script>" ;
	exit;       die; 	
############################################## <== END  comment	
*/
################  หากต้องการ lock server ให้เอา IP  ใส่ในบรรทัดที่ 41 และ comment บบรทัดที่ 32 - 38
## ip เครื่อง อีสาน 2
###  4501,4502,4503,4601,4602,4603,4701,4702,4703,4801,4802 

//$arrsite = array("0000");
$arrsite = AreaKeyKp7(); // เขตนำร่องที่ไม่สามารถเข้าสู่ระบบได้
//$arrsite = array("6601","4101","3405","7102","4005","6002","6302","7103","6502","8602","6302","5101","7002","5701","6702","7203","4802","7302","3303");
//echo "<pre>";
//print_r($arrsite);die;
if (!in_array($rs[secid],$arrsite)){ 	 ?>
<?
	#// เข้ารหัส paramiter ที่ส่งไป
	$encode_secid = base64_encode(base64_encode($rs[secid]));  
	$encode_login = base64_encode(base64_encode("login"));

	$reporturl = "http://$rs[IP]/$aplicationpath/application/hr3/index.php?secid=$encode_secid&action=$encode_login";	
	echo "<script language=\"javascript\">
	top.location.href = \"$reporturl\";
	</script>" ;
	exit;
//	window.open('$reporturl','_top');

}else{

?>
<table width="455" border="0" align="center" cellspacing="1" style="border:1px solid #E3B933; ">
  <tr>
    <td height="165" align="center" valign="top" background="../../../../competency_cms/close/call.jpg" bgcolor="#FFFFFF" style="background-repeat:no-repeat; padding:5px 5px 5px 200px"><table width="100%" border="0" cellpadding="20" cellspacing="1" bgcolor="#FFFFFF" style="background-color:#FFFBA7; border:1px solid #E3B933">
      <tr>
        <td width="68%" align="center" style="font:tahoma; font-size:16px; font-weight:bold;filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#FFFBA7', EndColorStr='#FFB836'); "><img src="../../../../competency_cms/close/emblem-important.png" width="32" height="32" /><br />
            <span class="style2">ขออภัย <br>
            ไม่สามารถเข้าสู่ระบบได้เนื่องจาก<br>
            ท่านเป็น สพท.นำร่องเพื่อพัฒนา<br>
            ระบบทะเบียนประวัติอิเล็กทรอนิกส์<br>
            ประจำปี 2553<br>
            หากมีข้อสงสัยโปรดติดต่อ<br>
            เจ้าหน้าที่ Callcenter</td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<br>
<?  }  ###### if ($rs[IP]  != "202.129.35.103"){   ?> 