<?
session_start();
set_time_limit(0);
include("checklist2.inc.php");
include("function_tranfer.php");
if($_SESSION['session_username'] == ""){
	echo "<h3>�Ҵ��õԴ��͡Ѻ server �ҹ�Թ仡�س� login �������к�����</h3>";
	header("Location: login.php");
	die;
}
####  �����ż���¡��
### ���ͺ
//trn_temp_general("general","localhost","cmss_5001","3501500244554","id");
### end ���ͺ
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	
}//end if($_SERVER['REQUEST_METHOD'] == "POST"){
###  end �����ż���¡��
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>�к���Ǩ�ͺ�͡��� �.�.7 �鹩�Ѻ</title>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="7" bgcolor="#CAD5FF"><strong>�����ŷ��١�Ѵ�͡����ѧ�ѡ�����š�ҧ  
          <?=show_area($xsiteid);?>
        </strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#CAD5FF"><strong>�ӴѺ</strong></td>
        <td width="18%" align="center" bgcolor="#CAD5FF"><strong>���ʺѵ�</strong></td>
        <td width="18%" align="center" bgcolor="#CAD5FF"><strong>���͹��ʡ��</strong></td>
        <td width="14%" align="center" bgcolor="#CAD5FF"><strong>���˹�</strong></td>
        <td width="16%" align="center" bgcolor="#CAD5FF"><strong>˹��§ҹ</strong></td>
        <td width="13%" align="center" bgcolor="#CAD5FF"><strong>�ʴ���������ػ</strong></td>
        <td width="17%" align="center" bgcolor="#CAD5FF"><strong>�����������<br>
���繢�������� cmss </strong></td>
      </tr>
      <?
      	$sql = "SELECT * FROM temp_general WHERE siteid='$xsiteid'";
		$result = mysql_db_query($dbnamemaster,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="left"><? echo show_school($rs[schoolid]);?></td>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
      </tr>
      <?
		}//end while(){
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
