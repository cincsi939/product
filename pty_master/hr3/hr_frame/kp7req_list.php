<?
include("../../../config/config_hr.inc.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>�к��׹�ѹ������</title>
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
	<td colspan="3" align="center"><span class="header_text"><b>��ҹ��ͧ��÷����駤����ӹ���û�Ѻ��ا������<br />
	����¹����ѵԢ���Ҫ���</b><strong>(�.�.7)</strong></span></td>
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
	<td width="19%" align="right"><strong>���� ���ʡ�� : </strong></td>
	<td width="58%" align="left">&nbsp;<?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?></td>
</tr>
<tr>
	<td align="right"><strong>���˹� : </strong></td>
	<td align="left">&nbsp;<? if ($rs[position_now]==""){ echo "-"; }else{ echo $rs[position_now] ; } ?></td>
</tr>
<tr>
	<td align="right"><strong>˹��§ҹ : </strong></td>
	<td align="left">&nbsp;<? if ($rs[subminis_now]==""){ echo "-"; }else{ echo $rs[subminis_now] ; } ?></td>
</tr>
<tr>
	<td align="right"><strong>�Ţ�ѵû�Шӵ�ǻ�ЪҪ� : </strong></td>
	<td align="left">&nbsp;<?=$rs[idcard]?></td>
</tr>
<tr>
	<td align="right"> <strong>�ѹ�����蹤���ͧ&nbsp;:</strong> </td>
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

	$arr_month =  array("","���Ҥ�","����Ҿѹ��","�չҤ�","����¹","����Ҥ�","�Զع�¹","�á�Ҥ�","�ԧ�Ҥ�","�ѹ��¹","���Ҥ�","��Ȩԡ�¹","�ѹ�Ҥ�");
	return $arr_month[$num_month] ;
	
}
$month_nm 	= date("n") ; 
$th_yy 			= date("Y")+543 ; 
$timenow 		= date("j") ." ". find_month($month_nm) ." ". $th_yy." (".(int)date("H").":".(int)date("i").":".(int)date("s").")" ;  # 20 �.�. 2549 (12:30:41)
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
	<td width="36%" height="25" ><strong>��Ǵ����ͧ�������¹�ŧ������</strong></td>
	<td width="64%"><strong> ��������´����������</strong></td>
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
	<td align="right">�����ŷ����&nbsp;<b>:</b>&nbsp;</td>
    <td bgcolor="#F5F5F5"><?=$rs[i1_general_notes]?></td>
</tr>
<? } if($rs[i2_graduate] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">����֡��&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i2_graduate_notes]?></td>
</tr>
<? } if($rs[i3_salary] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">��â���Թ��͹&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i3_salary_notes]?></td>
</tr>
<? } if($rs[i4_seminar] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">ͺ��/�٧ҹ/�����&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i4_seminar_notes]?></td>
</tr>
<? } if($rs[i5_sheet] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">�ŧҹ�ҧ�Ԫҡ��&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i5_sheet_notes]?></td>
</tr>
<? } if($rs[i6_getroyal] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">����ͧ�Ҫ � &nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i6_getroyal_notes]?></td>
</tr>
<? } if($rs[i7_special] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">��������������ö�����&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i7_special_notes]?></td>
</tr>
<? } if($rs[i8_goodman] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">��¡�ä����դ����ͺ&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i8_goodman_notes]?></td>
</tr>
<? } if($rs[i9_absent] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">�ӹǹ�ѹ����ش�Ҫ���&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i9_absent_notes]?></td>
</tr>
<? } if($rs[i10_nosalary] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">�ѹ���������Ѻ�Թ��͹���� ���Ѻ�Թ��͹�������ӹǹ&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i10_nosalary_notes]?></td>
</tr>
<? } if($rs[i11_prohibit] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">������Ѻ�ɷҧ�Թ��&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i11_prohibit_notes]?></td>
</tr>
<? } if($rs[i12_specialduty] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">��û�Ժѵ��Ҫ��þ����&nbsp;<b>:</b>&nbsp;</td>
	<td bgcolor="#F5F5F5"><?=$rs[i12_specialduty_notes]?></td>
</tr>
<? } if($rs[i13_other] == 1) { ?>
<tr align="left" bgcolor="#EAEAEA">
	<td align="right">��¡����� � ������&nbsp;<b>:</b>&nbsp;</td>
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