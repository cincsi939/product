<?
$phpvar="";
$phpvar2="";
foreach($_GET as $key => $value) {
	$phpvar .=  $key."=".$value."&";
	$phpvar2 .=  $key."=". urlencode($value) ."&";
//echo $key."=".$value."<br>";
#Exec0=เขตการปกครอง|100|b|LEFT||^
#Exec1=ขนาดพื้นที่|20|b|LEFT||^0.00|11|b|CENTER||#EFEFEF^ตารางกิโลเมตร|20|b|LEFT||^|11||||^|20||||^
#Exec2=ประกอบด้วย|20|b|LEFT||^10|11|b|CENTER||#EFEFEF^อำเภอ/กิ่งอำเภอ|20|b|LEFT||^23|11||CENTER||#EFEFEF^เทศบาล|20|b|LEFT||^
#Exec3= |20||||^104|11||CENTER||#EFEFEF^ตำบล|20|b|LEFT||^104|11||CENTER||#EFEFEF^อบต.|20|b|LEFT||^
#Exec4= |20||||^961|11||CENTER||#EFEFEF^หมู่บ้าน|20|b|LEFT||^0|11||CENTER||#EFEFEF^ชุมชน|20|b|LEFT||^
}

$url = addslashes("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?" . $phpvar2);

$phpvar = str_replace("&nbsp;"," ",$phpvar);
$phpvar = str_replace(chr(160).chr(160)," ",$phpvar);
$phpvar = str_replace(chr(13)," ",$phpvar);
$phpvar = str_replace(chr(10)," ",$phpvar);
$phpvar = str_replace("%","%25",$phpvar);
$phpvar = str_replace("#","0x",$phpvar);
//echo $phpvar;

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title><?=$title?></title>
</head>
<body bgcolor="#396D9E" leftmargin="0" topmargin="0">
<!--url's used in the movie-->
<!--text used in the movie-->
<!-- saved from url=(0013)about:internet -->
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="100%" id="executive" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="executive.swf?<?=$phpvar?>" /><param name="menu" value="true" /><param name="quality" value="high" /><param name="scale" value="exactfit" /><param name="bgcolor" value="#ffffff" /><embed src="executive.swf?<?=$phpvar?>" menu="true" quality="high" scale="exactfit" bgcolor="#ffffff" width="100%" height="100%" name="executive" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>

<SCRIPT LANGUAGE="JavaScript">
<!--
//window.moveTo(0,0);
//window.resizeTo(screen.width,screen.height);

function CopyURLToClipboard(){
  if(window.clipboardData){ 
	  var r=clipboardData.setData("Text","<?=$url?>"); 
  }
}

//-->
</SCRIPT>
</body>
</html>
