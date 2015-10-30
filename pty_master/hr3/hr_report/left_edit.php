<?
session_start();
$id = $_GET[id];

include("../../../config/db.inc.php");

#$sql="select * from log_req_notapprove where general_id='$id' and status='1';";
$sql="select * from log_req_notapprove where general_id='$id' and  ( status='1' or status='2' )      ;";
#echo $sql ; 
$result = mysql_query($sql);
if (mysql_num_rows($result)){
	$menu_flag = array(
		"general"=>"",	
		"graduate"=>"",	
		"salary"=>"",	
		"seminar"=>"",	
		"sheet"=>"",	
		"getroyal"=>"",	
		"special"=>"",	
		"goodman"=>"",	
		"absent"=>"",	
		"nosalary"=>"",	
		"prohibit"=>"",	
		"specialduty"=>"",	
		"other"=>""	
	);
	while ($rs = mysql_fetch_assoc($result)){
		$menu_flag["general"] += $rs["i1_general"];
		$menu_flag["graduate"] += $rs["i2_graduate"];
		$menu_flag["salary"] += $rs["i3_salary"];
		$menu_flag["seminar"] += $rs["i4_seminar"];
		$menu_flag["sheet"] += $rs["i5_sheet"];
		$menu_flag["getroyal"] += $rs["i6_getroyal"];
		$menu_flag["special"] += $rs["i7_special"];
		$menu_flag["goodman"] += $rs["i8_goodman"];
		$menu_flag["absent"] += $rs["i9_absent"];
		$menu_flag["nosalary"] += $rs["i10_nosalary"];
		$menu_flag["prohibit"] += $rs["i11_prohibit"];
		$menu_flag["specialduty"] += $rs["i12_specialduty"];
		$menu_flag["other"] += $rs["i13_other"];
	} //while
}else{
	$menu_flag = array(
		"general"=>"1",	
		"pic_history"=>"1",
		"graduate"=>"1",	
		"salary"=>"1",	
		"seminar"=>"1",	
		"sheet"=>"1",	
		"getroyal"=>"1",	
		"special"=>"1",	
		"goodman"=>"1",	
		"absent"=>"1",	
		"nosalary"=>"1",	
		"prohibit"=>"1",	
		"specialduty"=>"1",	
		"other"=>"1"	
	);
}

$total_menu = 0;
foreach ($menu_flag as $menukey => $flag){
	$total_menu += $flag;
}

$menu_item = array(
	"general"=>array("ข้อมูลทั่วไป","../hr_report/general_all_1.php?id=$id&action=edit"),	
	"pic_history"=>array("แก้ไขรูปภาพ","../hr_report/pic_history.php?id=$id"),	
	"graduate"=>array("ประวัติการศึกษา","../hr_report/graduate_all.php?id=$id"),	
	"salary"=>array("ตำแหน่งและอัตราเงินเดือน","../hr_report/salary.php?id=$id&action=edit&viewall=5"),	
	"seminar"=>array("ฝึกอบรมและดูงาน","../hr_report/seminar_all_1.php?id=$id"),	
	"sheet"=>array("ผลงานทางวิชาการ","../hr_report/sheet_all_1.php?id=$id&action=edit&vsheet=0"),	
	"getroyal"=>array("เครื่องราชอิสริยาภรณ์ วันที่ได้รับและวันส่งคืน รวมทั้งเอกสารอ้างอิง","../hr_report/getroyal.php?id=$id&action=edit"),	
	"special"=>array("ความรู้ความสามารถพิเศษ","../hr_report/special.php?id=$id&action=edit"),	
	"goodman"=>array("รายการความดีความชอบ","../hr_report/goodman.php?id=$id&action=edit"),	
	"absent"=>array("จำนวนวันลาหยุดราชการ ขาดราชการมาสาย","../hr_report/absent_all_1.php?id=$id"),	
	"nosalary"=>array("วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็ม  หรือวันที่มิได้ประจำ ปฏิบัติหน้าที่อยู่ในเขตที่ได้มีประกาศใช้กฎอัยการศึก","../hr_report/nosalary_all_1.php?id=$id&action=edit"),	
	"prohibit"=>array("การได้รับโทษทางวินัย","../hr_report/prohibit_all_1.php?id=$id&action=edit"),	
	"specialduty"=>array("การปฏิบัติราชการพิเศษ","../hr_report/specialduty_all_1.php?id=$id&action=edit"),	
	"other"=>array("รายการอื่น ๆ ที่จำเป็น","../hr_report/other_all_1.php?id=$id&action=edit")	
);


if (intval($menu_flag["general"]) == 0){
	foreach ($menu_flag as $menukey=>$flag){
		if (intval($flag) > 0){
			$default_url = $menu_item[$menukey][1];
			break;
		}
	}
}else{
	$default_url = "general_all_1.php?id=$id&action=edit";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../libary/style.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {
	margin-left: 5px;
	margin-top: 5px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.go {
	BORDER: #09629A 1px solid; 
	PADDING-RIGHT: 0.38em; 
	PADDING-LEFT: 0.38em; 
	FONT-WEIGHT: bold; 
	FONT-SIZE: 14px; 
	BACKGROUND: url(../hr_report/images/hdr_bg.png) #5599C4 repeat-x 0px -1px; 
	FLOAT: left; 
	PADDING-BOTTOM: 0px; 
	COLOR: #fff; 
	MARGIN-RIGHT: 0.38em; 
	PADDING-TOP: 0px; 
	HEIGHT: 30px;
	cursor:hand;
}
#bf .go {
	FLOAT: none
}
.go:hover {
	BORDER: #005C96 1px solid; 
	BACKGROUND: url(../hr_report/images/hdr_bg.png) #5599C4 repeat-x 0px -263px; 
}
-->
</style></head>

<body bgcolor="#7187BD">
<table width="205" border="0" cellspacing="0" bgcolor="eeeeee" style="border:1px #5595CC solid; margin-bottom:5px">
  <tr>
    <td height="30" style="filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#F4F4F4'); padding: 2px"><font style="font-size:16px; font-weight:bold; color:#444444;">&nbsp;เมนู</font></td>
  </tr>


  <tr>
    <td class="normal_black">&nbsp;</td>
  </tr>
  <?
foreach ($menu_item as $menukey => $item){
	list($caption,$url) = $item;
?>
<tr>
    <td class="normal_black" style="padding:2px 2px 2px 10px">
	<? if ($menu_flag[$menukey] ){?>
	<a href="<?=$url?>" target="mainFrame">:: <?=$caption?></a>
	<? }else{?>
	:: <FONT COLOR="#404040"><?=$caption?></FONT>
	<? }?>	</td>
  </tr>
<?
} // foreach	


if ($total_menu == 0){ //ไม่มีเมนูเลย
	echo "<script>alert('ท่านไม่สามารถแก้ไขข้อมูลได้'); top.location.href='../hr_report/logout_edit.php';</script>";	
}else if (intval($menu_flag["general"]) == 0){ //เมนูแรกไม่ใช่ general
	echo "<script>window.open('$default_url','mainFrame');</script>";
}
?>  
<tr>
	<td>&nbsp;
	</td>
</tr>
</table>


<input name="Button" type="button" class="go" value="ออกจากระบบ"  onclick="parent.window.location='../hr_report/logout_edit.php'">
<br />

<br>
<br>
</body>
</html>
