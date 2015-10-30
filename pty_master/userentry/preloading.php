<?
if ($_GET[hasloaded] != "1"){
?>
<html>
<head>
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script type="text/javascript" src="/vc_master/common/swfobject.js"></script>
<title>Loading</title>

<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body>

<table width="100%" height="100%" border=0 align=center bgcolor="e7e7e7">
  <tr valign=middle><td align=center>
		<div id="flashcontent"></div>
		<script type="text/javascript">
		// <![CDATA[
		
		var so = new SWFObject("images/indicator_preload.swf", "waiting", "70", "80", "8.0.0.0", "#e7e7e7", true);
		so.addParam("align", "middle"); 
		so.write("flashcontent");
		
		// ]]>
	</script>
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