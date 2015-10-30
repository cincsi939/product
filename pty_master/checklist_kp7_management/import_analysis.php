<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_j18.php");
include("../../common/transfer_data/function_transfer.php");
include("class/class.compare_data.php");
include("../../common/class.import_checklist2cmss.php");
include("../../common/class.getdata_master.php");
include("class.check_error.php");



$sql_del = "DELETE FROM queue_transfer WHERE siteid='$xsiteid' AND profile_id='$profile_id'";
mysql_db_query($dbname_temp,$sql_del) or die(mysql_error()."$sql<br>LINE__".__LINE__);

$obj_imp = new ImportData2Cmss();
$obj_master = new GetDataMaster();

### ตรวจสอบเลขบัตร
$obj_checkdata = new CheckDataError();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
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
  <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
</tr>
<tr><td align="center" bgcolor="#CCCCCC"><a href="report_idcardfalse.php?xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>" target="_blank">รายงานเลขประจำตัวประชาชนที่ไม่ถูกต้องตามกรมการปกครอง</a> || <a href="report_datafalse.php?xsiteid=<?=$xsiteid?>&profile_id=<?=$profile_id?>" target="_blank">รายงานข้อมูลไม่สมบูรณ์</a></td></tr>
<tr>
  <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
</tr>
  <tr>
    <td bgcolor="#000000"><? 
$gettitle = "รายงานวิเคราะห์ข้อมูลการนำเข้าข้อมูล ".$obj_master->GetAreaName($xsiteid,"secname_short")."&nbsp;|| <input type=\"button\" name=\"button\" id=\"button\" value=\"แสดงรายงานข้อมูลที่สามารถนำเข้าสู่ ฐาน  cmss ได้\" onClick=\"location.href='import_analysis_confirm.php?&xsiteid=$xsiteid&profile_id=$profile_id'\"><hr>";
$getlink = "import_analysis.php?xsiteid=$xsiteid&profile_id=$profile_id";
echo $obj_imp->AnalysisData("$xsiteid","$profile_id",$gettitle,"$getlink",$_GET['mode']);?></td>
  </tr>
</table>

</body>
</html>
