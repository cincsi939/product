<?php
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
?>

<script type="text/javascript">
 
  var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
  	  }
	}
		/*function check_benzine_value(value)
	{
	var id_instruct = document.getElementById("id_instruction").value;
	var spt_source = document.getElementById("list").value;
   //var people_id= document.getElementById("benzine_value_id").innerHTML = value;
   	document.form2.list3.value = spt_source ;
	document.form2.list4.value =  value ;
	document.form2.instruct_id.value = id_instruct ;
	}*/
function aaa()
{
document.form.type_showdate2.disabled=false;
}
 function doClear(type_showdate2) 
{
	document.form.type_showdate2.disabled=true;
     if (document.form.type_showdate2.value!="")
 	{
       document.form.type_showdate2.value="";
	   document.form.type_showdate2.disabled=true;
    }
}
</script>
<?
 	 $sql77="SELECT type_showbegindate  from general where idcard='$_SESSION[idoffice]' ";
	 $q77=mysql_db_query($dbname,$sql77)or die (mysql_error());
	 $rs77=mysql_fetch_assoc($q77);
	 
	 $sql78="SELECT * FROM  type_showdate where id_type='$rs77[type_dateshow2]' and type_nec='n' ";
	 $q78=mysql_query($sql78)or die (mysql_error());
	 $rs78=mysql_fetch_assoc($q78);
	 
	mysql_db_query($dbname, "select 1 " ) ; 
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
<body <?=$onload ?>>





<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" bgcolor="#2C2C9E"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="15%">&nbsp;</td>
              <td width="85%"><B class="pheader">เลือกรูปแบบการแสดงผล วันที่ ใน ก.พ.7 </B></td>
            </tr>
        </table></td>
      </tr>
      <tr>

        <td></td>
      </tr>
    </table>
<?
# print_r($_SESSION) ; 
$general_id = $_SESSION[id] ; 
if ($addnew  != ""){ 
$tmpdate = explode("/" , $xdate) ;
$dd1 = $tmpdate[0] ; $mm1 = $tmpdate[1] ; $yy1 = $tmpdate[2] ; 
if ($yy1 > 2350){ $yy1 -=  543 ;  } 
$daterec = $yy1 ."-". $mm1  ."-". $dd1  ;  
if($type_showdate=="other")
{
	$type_showdate1=$type_showdate2;
	$type="n";
	
			if($rs78[type_date]==$type_showdate1)
					{
						$update="UPDATE type_showdate set type_date='$type_showdate1' where id_type='$rs78[id_type]' " 	;
						$query_update=mysql_db_query ($dbname,$update) or die (mysql_error());
					}
					else
					{
					$sql_showdate="INSERT INTO type_showdate SET type_date='$type_showdate1', type_nec='$type' ";
					//echo $sql_showdate;
					$query_showdate=mysql_db_query($dbname,$sql_showdate)or die(mysql_error());
					}

	$sql_date="select id_type from  type_showdate where type_date='$type_showdate1' ";

	$q_date=mysql_db_query($dbname,$sql_date)or die (mysql_error());
	$rsd=mysql_fetch_assoc($q_date);
	$type_showdate3=$rsd[id_type];
}
else
{
	$type_showdate3=$type_showdate;

	}
$sql = "UPDATE general SET type_showbegindate='$type_showdate3' where idcard='$_SESSION[idoffice]' ";

$result = mysql_db_query($dbname,$sql) or die (mysql_error()) ;
if($result)
{
	$msg="รูปแบบการแสดงผลวันที่วันเริ่มปฏิบัติงานได้ถูกบันทึกเสร็จสิ้น";
				echo"<script language=\"javascript\">
				alert(\"$msg\\n \");
				</script>";
				//echo"<meta http-equiv='refresh' content='0;URL=type_showdate2.php'>";
				echo"<script language=\"javascript\">window.close();</script>";
				exit;	
}
else
{
				$msg="ไม่สามารถบันทึกข้อมูลได้";
				echo"<script language=\"javascript\">
				alert(\"$msg\\n \");
				</script>";
				//echo"<meta http-equiv='refresh' content='0;URL=type_showdate2.php'>";
				echo"<script language=\"javascript\">window.close();</script>";
				exit;
	}


} ########## if ($addnew  != ""){  
?>
<?  if ($act == ""){   ?>
<form name="form" method="post" action="?">

  <table width="98%" border="0" align="center">
    <tr>
      <td colspan="5" bgcolor="#A3B2CC">&nbsp;<strong> ระบุรูปแบบการแสดงผล ของวันที่ วันเริ่มปฎิบัติงาน ใน ก.พ.7 </strong></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="center"><img src="../../../images_sys/date3.GIF" width="887" height="111" border="1"></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    
     <? $sql6="SELECT * FROM  type_showdate where type_nec='y' order by id_type ASC ";
	  		$query6=mysql_db_query($dbname,$sql6)or die (mysql_error());
			while($rs6=mysql_fetch_assoc($query6))
			{
	  ?>
    <tr>
      <td width="9%">&nbsp;</td>
      <td width="23%"><p>
        <input type="radio" name="type_showdate" value="<?=$rs6[id_type]?>"<? if($rs77[type_showbegindate]==$rs6[id_type]){ echo "checked";}?> onClick="doClear(this);">
        <?=$rs6[type_date]?>
      </td>
	  <td width="68%"><font color="#FF0000">
	    <?= "**". $rs6[type_detail]?>
	  </font></td>
    </tr> <? }?>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><input type="radio" name="type_showdate" value="other" onClick="aaa();"<? if($rs77[type_showbegindate]==$rs78[id_type]){echo "checked";}?> >
      อื่นๆ(ระบุ)
        <input name="type_showdate2" type="text" disabled="disabled" value="<?=$rs78[type_date]?>" size="50"></td>
      </tr>
	 
    
    <tr>
      <td colspan="5" align="center"><br>
        <input name="addnew" type="submit" id="addnew" value="บันทึก">
        &nbsp;
        <input type="button" name="Submit22" value="ปิดหน้านี้" onClick="window.close(); "></td>
      </tr>
  </table>
</form>
<? } #######   if ($act == ""){   ?> 
<table width="98%" border="0" align="center">
  <tr>
    <td colspan="2"><strong>หมายเหตุ</strong></td>
  </tr>
  <tr>
    <td width="8%">&nbsp;</td>
    <td width="92%">เมื่อบันทึกข้อมูลระบบจะเรียกดึงข้อมูล หน้าบันทึกข้อมูลทั่วไป(หน้าก่อนนี้)ใหม่ หากมีการบันทึกข้อมูลในหน้าข้อมูลทั่วไป กรุณาบันทึกหน้าบันทึกข้อมูลทั่วไป(หน้าก่อนนี้) ก่อนบันทึก รูปแบบการแสดงผลวันเกิด ใน ก.พ.7 </td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
