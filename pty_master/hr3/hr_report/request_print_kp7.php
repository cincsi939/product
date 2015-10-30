<?php
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");

function todate($din){
		
	$t			= explode(" ",$din);
	$d			= explode("-",$t[0]);
	$month = array("ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
	return intval($d[2])."-".$month[intval($d[1]) - 1]."-".(intval($d[0])+543)." [".substr($d[1],0,5)."]";
	
}

$sdate = (!empty($sdate)) ? $sdate : (date("Y") + 543).date("-m-d") ;
?>
<html>
<head>
<title>ข้อมูลข้าราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="libary/style.css" type="text/css" rel="stylesheet">
<script language="javascript" src="chk_number.js"></script>
<script language="javascript" src="libary/popcalendar.js"></script>
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style4 {
	font-size: 16px;
	color: #FFFFFF;
}
-->
</style>
</head>
<body  background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom ">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td valign="top">
<form name="post" method="post" action="<?=$PHP_SELF?>">	
<table  width="100%" border="0" cellspacing="0" cellpadding="0">
<tr align="left" bgcolor="#4752A3" class="shadetabs style4">
	<td height="40" background="../images/hr-banner.gif" style="background-repeat: no-repeat; background-position:right bottom;">
	รายงานการออกเอกสารสำเนา กพ.7</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000">
<tr bgcolor="#eeeeee" class="fieldset" style="font-weight:bold;">
	<td height="25" colspan="5">
	&nbsp;ประจำวันที่&nbsp;<b>:</b>&nbsp;
	<input type="text" name="sdate" id="Txt-Field" class="input" maxlength="10" style="width:80px;" value="<?=$sdate?>" readonly>
	<script language='javascript'>	if (!document.layers) {	
	document.write("<input type='button' onclick='popUpCalendar(this, post.sdate, \"yyyy-mm-dd\")' value=' เลือกวัน ' class='input'>")	
	}</script>  
	<input name="submit" type="submit" value="ตกลง">
	</td>
</tr>
<tr align="center" bgcolor="#9999CC" class="fieldset" style="font-weight:bold;">
	<td width="05%" height="20">ลำดับ</td>
	<td width="17%">เจ้าของข้อมูล</td>
	<td width="22%">ประเภทคำร้อง</td>
	<td width="35%">รายละเอียด</td>
	<td width="21%">แจ้งเมื่อ</td>
</tr>
<?
$sql 		= " select req_print_kp7.*, general.prename_th, general.name_th, general.surname_th ";
$sql 		.= " from `req_print_kp7` left join `general` on req_print_kp7.id=general.id  ";
$sql 		.= " where req_print_kp7.request_time like '".$sdate."%'; group by req_print_kp7.id; ";
$result 	= mysql_query($sql);
while($rs = mysql_fetch_assoc($result)){
?>
<tr bgcolor="#F4F4F4"  class="normal_black" align="left">
 	<td height="20" align="center" ><?=$i?></td>
	<td><?=$rs[owner_name]." ".$arr[owner_sername]?></td>
	<td><?=$rs[activity_name];?></td>
	<td><?=$rs[admin_name]." ".$arr[admin_sername]?></td>
	<td><?=$rs[servername]." <span class='brown style5'>IP ".$arr[serveraddress]."</span>"?></td>
</tr>
<? 
}
?>
</table>
</form>
	</td>
</tr>
</table>
</body>
</html>