<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<link href="../../common/tooltip_checklist/css/style.css" rel="stylesheet" type="text/css" />
<script src="../../common/tooltip_checklist/jquery_1_3_2.js"></script>
<script src="../../common/tooltip_checklist/script.js"></script>
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
.style1 {color: #006600}
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
<tr><td>&nbsp;</td></tr>
<? if($lv == "1"){?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="center" bgcolor="#CCCCCC"><strong>รายงานการเข้าดูหน้ารายงานสำหรับผู้บริหารของกลุ่มพนักงานที่เป็น senior</strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="42%" align="center" bgcolor="#CCCCCC"><strong>ชื่อนามสกุล พนักงาน</strong></td>
        <td width="30%" align="center" bgcolor="#CCCCCC"><strong>จำนวนครั้งเข้าดูหน้ารายงาน</strong></td>
        <td width="23%" align="center" bgcolor="#CCCCCC"><strong>วันที่เข้าดูหน้ารายงานล่าสุด</strong></td>
      </tr>
      <?
      	$sql = "SELECT
t1.staffid,
t1.prename,
t1.staffname,
t1.staffsurname,
count(t2.staffid) as num1,
max(t2.dateview) as maxdate
FROM
callcenter_entry.keystaff as t1
Inner Join edubkk_checklist.tbl_checklist_logviewreport_executive as t2  ON t1.staffid =t2.staffid
group by t1.staffid
";
$result = mysql_db_query($dbname_temp,$sql);
$i=0;
while($rs = mysql_fetch_assoc($result)){
	 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	 $fullname =  "$rs[prename]$rs[staffname]  $rs[staffsurname]";
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><? echo "$fullname";?></td>
        <td align="center"><? if($rs[num1] > 0){ echo "<a href='?lv=2&staffid=$rs[staffid]&fullname=$fullname'>$rs[num1]</a>";}else{ echo "0";}?></td>
        <td align="center"><?=get_dateThai($rs[maxdate])?></td>
      </tr>
      <?
}//end 
	  ?>
    </table></td>
  </tr>
  <?
}//end if($lv == "1"){
	if($lv == "2"){
  ?>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="2" align="left" bgcolor="#CCCCCC"><strong><a href="?lv=1">ย้อนกลับ</a> || สถิติการเข้าเรียกดูหน้ารายงานของ
          <?=$fullname?>
        </strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="95%" align="center" bgcolor="#CCCCCC"><strong>วันที่เรียกเข้าใช้หน้ารายงาน</strong></td>
        </tr>
       <?
       	$sql = "SELECT * FROM tbl_checklist_logviewreport_executive WHERE staffid='$staffid' ORDER BY dateview DESC";
		$result = mysql_db_query($dbname_temp,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	   ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=get_dateThai($rs[dateview])?></td>
        </tr>
       <?
		}//end while($rs = mysql_fetch_assoc($result)){
	   ?> 
    </table></td>
  </tr>
  <?
	}//end 
  ?>
</table>
</body>
</html>
