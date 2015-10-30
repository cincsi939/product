<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");
include("class/class.compare_data.php");
include("../../common/class.import_checklist2cmss.php");
include("../../common/class.getdata_master.php");
$obj_imp = new ImportData2Cmss();
$obj_master = new GetDataMaster();


$arr_sex = array("1"=>"ชาย","2"=>"หญิง");


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript">
//	function copyit(theField) {
//		var selectedText = document.selection;
//		if (selectedText.type == 'Text') {
//			var newRange = selectedText.createRange();
//			theField.focus();
//			theField.value = newRange.text;
//		} else {
//			alert('select a text in the page and then press this button');
//		}
//	}
</script>
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
        <td colspan="9" align="left" bgcolor="#CCCCCC"><strong>รายงานข้อมูลที่ไม่สามารถนำเข้าระบบได้เนื่องจากข้อมูลไม่สมบูรณ์ 
          <?=$obj_master->GetAreaName($xsiteid,'secname_short')?></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>เลขประจำตัวประชาชน</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>ชื่อ นามสกุล</strong></td>
        <td width="17%" align="center" bgcolor="#CCCCCC"><strong>ตำแหน่ง</strong></td>
        <td width="6%" align="center" bgcolor="#CCCCCC"><strong>เพศ</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>วันเดือนปีเกิด</strong></td>
        <td width="11%" align="center" bgcolor="#CCCCCC"><strong>วันเริ่มปฏิบัติราชการ</strong></td>
        <td width="13%" align="center" bgcolor="#CCCCCC"><strong>สังกัด</strong></td>
        <td width="15%" align="center" bgcolor="#CCCCCC"><strong>หมายเหตุ</strong></td>
      </tr>
      <?
      	$sql = "SELECT
t2.idcard,
t2.siteid,
t2.prename_th,
t2.name_th,
t2.surname_th,
t2.position_now,
t2.birthday,
t2.begindate,
t2.sex,
t2.schoolid
FROM
queue_transfer_log AS t1
Inner Join tbl_checklist_kp7 AS t2 ON t1.idcard = t2.idcard AND t1.profile_id = t2.profile_id AND t1.siteid = t2.siteid
where t1.siteid='$xsiteid' and t1.profile_id='$profile_id'  and t1.flag_insert='0'  group by t1.idcard";
	$result = mysql_db_query($dbname_temp,$sql) or die(mysql_error()."".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="center"><?=$arr_sex[$rs[sex]]?></td>
        <td align="center"><?=$rs[birthday]?></td>
        <td align="center"><?=$rs[begindate]?></td>
        <td align="left"><? echo $obj_master->GetAreaName($rs[siteid])."/".$obj_master->GetSchool($rs[schoolid]); ?></td>
        <td align="left">ข้อมูลไม่สมบูรณ์</td>
      </tr>
      <?
	}
	  ?>
    </table></td>
  </tr>
</table>
</body>
</html>
