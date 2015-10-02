<?
if ($_GET[hasloaded] != "1"){
?>
<html>
<head>
<title>Loading</title>
</head>
<body>

<table border=0 width="100%" height="100%" align=center><tr valign=middle><td align=center>
<BR>

<!-- <marquee style="font-size: 10pt;"></marquee> -->
<H3 style="font-family: tahoma;">ระบบกำลังประมวลผลข้อมูล กรุณารอสักครู่ . . .</H3>
<BR>
<img src="/vc_master/common/progressbar7.gif" /><br>
</td></tr></table>
<SCRIPT LANGUAGE="JavaScript">
<!--
function open_main(){
	location.href="?<?=$_SERVER['QUERY_STRING']?>&hasloaded=1";
}

setTimeout("open_main( )", 1000);
//-->
</SCRIPT>
</body>
</html>
<?
	ob_flush();
	flush();
	exit;
}	
?>