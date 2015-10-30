<?
session_start();
set_time_limit(0);
include("../../config/conndb_nonsession.inc.php");
include("checklist.inc.php");
include("function_tranfer.php");
if($_SESSION['session_username'] == ""){
	echo "<h3>ขาดการติดต่อกับ server นานเกินไปกรุณา login เข้าสู่ระบบใหม่</h3>";
	header("Location: login.php");
	die;
}
####  ประมวลผลรายการ
### ทดสอบ
//trn_temp_general("general","localhost","cmss_5001","3501500244554","id");
### end ทดสอบ
if($_SERVER['REQUEST_METHOD'] == "POST"){

}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
###  end ประมวลผลรายการ
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
<script language="javascript">
function CheckAll(chk)
{
for (i = 0; i < chk.length; i++)
chk[i].checked = true ;
}

function UnCheckAll(chk)
{
for (i = 0; i < chk.length; i++)
chk[i].checked = false ;
}


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
<?
if($action == ""){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td align="center"><table width="100%" border="0" cellspacing="1" cellpadding="3">
	      <tr>
	        <td colspan="5" align="left" bgcolor="#BBC9FF"><strong>รายการโฟรไฟล์</strong></td>
          </tr>
	      <tr>
	        <td width="5%" align="center" bgcolor="#BBC9FF"><strong>ลำดับ</strong></td>
	        <td width="35%" align="center" bgcolor="#BBC9FF"><strong>ชื่อโฟร์ไฟล์</strong></td>
	        <td width="26%" align="center" bgcolor="#BBC9FF"><strong>ข้อมูล ณ วันที่</strong></td>
	        <td width="26%" align="center" bgcolor="#BBC9FF"><strong>สถานะโฟรไฟล์</strong></td>
	        <td width="8%" align="center" bgcolor="#BBC9FF">&nbsp;</td>
          </tr>
          <?
          	$sql_profile = "SELECT * FROM tbl_checklist_profile  ORDER BY profile_date DESC";
			$result_profile = mysql_db_query($dbname_temp,$sql_profile);
			$i=0;
			while($rsp = mysql_fetch_assoc($result_profile)){
				 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		  ?>
	      <tr bgcolor="<?=$bg?>">
	        <td align="center">&nbsp;</td>
	        <td align="center">&nbsp;</td>
	        <td align="center">&nbsp;</td>
	        <td align="center">&nbsp;</td>
	        <td align="center">&nbsp;</td>
          </tr>
          <?
			}//end while($rsp = mysql_fetch_assoc($result_profile)){
		  ?>
        </table></td>
  </tr>
</table>
<?
}//end if($action == ""){
?>
<form name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
  </table>
</form>
<?
	}//end if($action == ""){
?>
</body>
</html>
