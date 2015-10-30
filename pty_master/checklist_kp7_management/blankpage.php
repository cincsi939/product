<?
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<title></title>
<style type="text/css">
<!--
.style4 {font-size: 24}
.style7 {font-size: 18px}
-->
</style>
</head>

<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="center"><? if($_SESSION['session_sapphire'] == "1"){  echo "<a href='main_report.php' target='iframe_body'>รายงานการตรวจสอบเอกสาร</a>";} 
?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><span class="style7">ชื่อผู้ใช้ :<? echo $_SESSION['session_fullname'];?></span></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>



</html>
