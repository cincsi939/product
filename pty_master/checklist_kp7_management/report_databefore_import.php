<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_tranfer.php");
include("function_j18.php");


if($_SESSION['session_username'] == ""){
	echo "<h3>ขาดการติดต่อกับ server นานเกินไปกรุณา login เข้าสู่ระบบใหม่</h3>";
	header("Location: login.php");
	die;
}



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>รายงานข้อมูลที่ไม่ครบถ้วนใน checklist ก่อนนำเข้าข้อมูล</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>

<style type="text/css">
<!--
.header1 {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:1em;
	font-weight:bold;
	color: #FFFFFF;
}
.main {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
	color:#FF0000;
	font-weight:bold;
}
.normal {	font-family:"MS Sans Serif", Tahoma, Arial;
	font-size:0.8em;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<style>
.txthead{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtexsum{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txtdate{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: normal;
	color: #000; 
}
.txtdata{
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	font-weight: normal;
	color: #000; 
}
.txt_link a:link {
	FONT-SIZE: 12px;
	color: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:visited {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:active {
	FONT-SIZE: 12px;
	COLOR: #000;
	FONT-FAMILY: Tahoma,  "Microsoft Sans Serif";
	TEXT-DECORATION: underline;
	FONT-WEIGHT: bold;
}
.txt_link  A:hover {
	FONT-SIZE: 12px; COLOR: #f3960b; FONT-FAMILY: Tahoma,  "Microsoft Sans Serif"; TEXT-DECORATION: underline;FONT-WEIGHT: bold;
}
.fillcolor_headgraph{	
	padding: 2pt;
	background-color:#0063C9;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#0063C9', EndColorStr='#000467');
}
.fillcolor_headgraph2{	
	padding: 2pt;
	background-color:#E6E6E6;
	filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr='#E6E6E6', EndColorStr='#8E8E8E');
	font-weight:bold;
}
</style>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="10" align="center" bgcolor="#CAD5FF"><strong>รายการบุคลากรที่ข้อมูลไม่ครบถ้วนเป็นสาเหตุให้ไม่สามารถนำเข้าระบบ cmss ได้ <?=show_area($xsiteid)?></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
        <td width="11%" align="center" bgcolor="#CAD5FF"><strong>เลขบัตรประชาชน</strong></td>
        <td width="8%" align="center" bgcolor="#CAD5FF"><strong>คำนำหน้าชื่อ</strong></td>
        <td width="8%" align="center" bgcolor="#CAD5FF"><strong>ชื่อ</strong></td>
        <td width="10%" align="center" bgcolor="#CAD5FF"><strong>นามสกุล</strong></td>
        <td width="11%" align="center" bgcolor="#CAD5FF"><strong>วันเดือนปีเกิด</strong></td>
        <td width="10%" align="center" bgcolor="#CAD5FF"><strong>วันเริ่มปฏิบัติราชการ</strong></td>
        <td width="8%" align="center" bgcolor="#CAD5FF"><strong>เพศ</strong></td>
        <td width="13%" align="center" bgcolor="#CAD5FF"><strong>ตำแหน่ง</strong></td>
        <td width="18%" align="center" bgcolor="#CAD5FF"><strong>หน่วยงานสังกัด</strong></td>
      </tr>
      <?
      	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$xsiteid' AND profile_id='$profile_id' $condition_data ORDER BY schoolid  DESC";
		$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$i=0;
		$arrschool = GetArraySchoolName($xsiteid); // แสดงรายชื่อโรงเรียน
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 $org = $arrschool[$rs[schoolid]];

	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><?=$rs[prename_th]?></td>
        <td align="left"><?=$rs[name_th]?></td>
        <td align="left"><?=$rs[surname_th]?></td>
        <td align="center"><?=$rs[birthday]?></td>
        <td align="center"><?=$rs[begindate]?></td>
        <td align="center"><?=$arr_sex[$rs[sex]]?></td>
        <td align="left"><?=$rs[position_now]?></td>
        <td align="left"><?=$orgname?></td>
      </tr>
      <?
      	}//end 
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
