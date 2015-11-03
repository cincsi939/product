<?
include("../../../config/config_hr.inc.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ระบบยืนยันข้อมูล</title>
<style type="text/css">
body,td{
	font-family:tahoma;
	font-size:13px;
}
.header_text{
	font-size:16px;

}
.fill_bg
{	vertical-align: top;
	padding: 0pt;
	background-color:#F8F8F8;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#F8F8F8', EndColorStr='#ffffff');
}
<!--
-->
</style>
<link href="../libary/style.css" rel="stylesheet" type="text/css" />
</head>
<body topmargin="0" leftmargin="0">
<? if ($id == ""){ echo " <center>Not exist id value</center> "; die; } ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td align="right" bgcolor="#4752A3"><img src="../images/hr-banner.gif" width="780" height="40" /></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="10" cellspacing="0" class="fill_bg">
<tr align="center">
    <td height="200">
<?
$sql 		= " SELECT  siteid, `general`.`prename_th`, `general`.`name_th`, `general`.`surname_th`, "; 
$sql 		.= " `general`.`idcard`, `general`.`birthday`,  `general`.`position_now`  , subminis_now "; 
$sql 		.= " FROM `general`   where id = $id "; 
$result 	= mysql_query($sql);
$rs 		= mysql_fetch_assoc($result) ; 
?>
<table width="96%" border="0" cellspacing="0" cellpadding="3" style="border: #8D99C4 1px solid">
<tr>
    <td class="login_fill2">
<table width="100%"  border="0" cellpadding="1" cellspacing="1">
<tr>
	<td colspan="3" align="center"><span class="header_text"><b>ท่านต้องการที่จะแจ้งความจำนงการปรับปรุงข้อมูล<br />
	ทะเบียนประวัติข้าราชการ</b><strong>(ก.พ.7)</strong></span></td>
</tr>
<tr align="center">
	<td width="23%" rowspan="5" valign="middle">
<?  
$personal_img = "../../../../image_file/$rs[siteid]/". $id .".jpg" ; 
if (is_file($personal_img)){
	echo  " <img src='".  $personal_img  ."'  width='120' height='160' />" ; 	
}else{
	echo  "<img src='../../../images_sys/noimage.jpg' />";
}	
?>
	</td>
	<td width="19%" align="right"><strong>ชื่อ นามสกุล : </strong></td>
	<td width="58%" align="left">&nbsp;<?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?></td>
</tr>
<tr>
	<td align="right"><strong>ตำแหน่ง : </strong></td>
	<td align="left">&nbsp;<? if ($rs[position_now]==""){ echo "-"; }else{ echo $rs[position_now] ; } ?></td>
</tr>
<tr>
	<td align="right"><strong>หน่วยงาน : </strong></td>
	<td align="left">&nbsp;<? if ($rs[subminis_now]==""){ echo "-"; }else{ echo $rs[subminis_now] ; } ?></td>
</tr>
<tr>
	<td align="right"><strong>เลขบัตรประจำตัวประชาชน : </strong></td>
	<td align="left">&nbsp;<?=$rs[idcard]?></td>
</tr>
<tr>
	<td align="right"> <strong>วันที่ยื่นคำร้อง&nbsp;:</strong> </td>
	<td align="left">&nbsp;
<?  
function find_month($num_month){
	
	$num_month  = (int)$num_month ;
	switch ($num_month) {
		case "01"	:	$num_month =  1; break;
		case "1"		:	$num_month =  1; break;
		case "02"	:	$num_month =  2;	break;
		case "2"		:	$num_month =  2;	break;
		case "03"	:	$num_month =  3;	break;		
		case "3"		:	$num_month =  3;	break;		
		case "04"	:	$num_month =  4;	break;
		case "4"		:	$num_month =  4;	break;
		case "05"	:	$num_month =  5;	break;
		case "5"		:	$num_month =  5;	break;
		case "06"	:	$num_month =  6;	break;		
		case "6"		:	$num_month =  6;	break;		
		case "07"	:	$num_month =  7;	break;
		case "7"		:	$num_month =  7; break;
		case "08"	:	$num_month =  8;	break;
		case "8"		:	$num_month =  8;	break;
		case "09"	:	$num_month =  9;	break;		
		case "9"		:	$num_month =  9;	break;		
		case "10"	:	$num_month =  10;	break;
		case "11"	:	$num_month =  11;	break;
		case "12"	:	$num_month =  12;	break;		
	default: 
		$num_month =  0;					break;
	}	

	$arr_month =  array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	return $arr_month[$num_month] ;
	
}
$month_nm 	= date("n") ; 
$th_yy 			= date("Y")+543 ; 
$timenow 		= date("j") ." ". find_month($month_nm) ." ". $th_yy." (".(int)date("H").":".(int)date("i").":".(int)date("s").")" ;  # 20 พ.ค. 2549 (12:30:41)
echo $timenow ; 
?>        
	</td>
</tr>
</table>
	</td>
</tr>
</table>
<table width="96%"   align="center" cellpadding="0" cellspacing="0" style="border: #8D99C4 1px solid">
<tr>
    <td>
<table width="100%" align="center" cellpadding="4" cellspacing="1">
<tr align="center" bgcolor="#CCCCCC" style="font-weight:bold;">
	<td width="36%" height="25" ><strong>หมวดที่ต้องการเปลี่ยนแปลงข้อมูล</strong></td>
	<td width="64%"><strong> รายละเอียดที่แจ้งเข้ามา</strong></td>
</tr>
<?
$sql 		= " select max(runid) as runid from `log_req_notapprove` where general_id='$id'; "; 
$result 	= mysql_query($sql)or die($sql."<br>".mysql_error());
$rs 		= mysql_fetch_assoc($result) ; 
$runid	= $rs[runid];
mysql_free_result($result);
unset($rs,$sql);


$sql 		= " select * from `log_req_notapprove` where general_id='$id' and runid='$runid'; "; 
$result 	= mysql_query($sql)or die($sql."<br>".mysql_error());
$rs 		= mysql_fetch_assoc($result) ; 

if($rs[i1_general] == "1"){ 
?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">ข้อมูลทั่วไป&nbsp;<b>:</b>&nbsp;</td>
    <td bgcolor="#F5F5F5"><?=$rs[i1_general_notes]?></td>
</tr>
<? } if($rs[i2_graduate] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">การศึกษา&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i2_graduate_notes]?></td>
</tr>
<? } if($rs[i3_salary] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">การขึ้นเงินเดือน&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i3_salary_notes]?></td>
</tr>
<? } if($rs[i4_seminar] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">อบรม/ดูงาน/สัมนา&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i4_seminar_notes]?></td>
</tr>
<? } if($rs[i5_sheet] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">ผลงานทางวิชาการ&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i5_sheet_notes]?></td>
</tr>
<? } if($rs[i6_getroyal] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">เครื่องราช ฯ &nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i6_getroyal_notes]?></td>
</tr>
<? } if($rs[i7_special] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">ความรู้ความสามารถพิเศษ&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i7_special_notes]?></td>
</tr>
<? } if($rs[i8_goodman] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">รายการความดีความชอบ&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i8_goodman_notes]?></td>
</tr>
<? } if($rs[i9_absent] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">จำนวนวันลาหยุดราชการ&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i9_absent_notes]?></td>
</tr>
<? } if($rs[i10_nosalary] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">วันที่ไม่ได้รับเงินเดือนหรือ ได้รับเงินเดือนไม่เต็มจำนวน&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i10_nosalary_notes]?></td>
</tr>
<? } if($rs[i11_prohibit] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">การได้รับโทษทางวินัย&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i11_prohibit_notes]?></td>
</tr>
<? } if($rs[i12_specialduty] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">การปฏิบัติราชการพิเศษ&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i12_specialduty_notes]?></td>
</tr>
<? } if($rs[i13_other] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">รายการอื่น ๆ ที่จำเป็น&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i13_other_notes]?></td>
</tr>
<? } ?>
</table>
	</td>
</tr>
</table>
	</td>
</tr>
</table>
</body>
</html>