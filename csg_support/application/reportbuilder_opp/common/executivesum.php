<?php
$phpvar="";
foreach($_GET as $key => $value) {
	$phpvar .=  $key."=".$value."&";
	//echo $key."=".$value."<br>";
}
$phpvar = iconv('tis-620','utf-8',$phpvar);
$phpvar = str_replace("&nbsp;"," ",$phpvar);
$phpvar = str_replace(chr(160).chr(160)," ",$phpvar);
$phpvar = str_replace(chr(13)," ",$phpvar);
$phpvar = str_replace(chr(10)," ",$phpvar);
$phpvar = str_replace("%","%25",$phpvar);
$phpvar = str_replace("#","0x",$phpvar);
// ตัวอย่าง
/*$phpvar = "Exec0=จำนวนนักเรียน ห้องเรียนและครู จำแนกรายอำเภอ|100|b|CENTER||^";
$phpvar .= "&Exec1=สำนักงานเขตพื้นที่การศึกษาเชียงใหม่เขต 1|100|b|CENTER||^";
$phpvar .= "&Exec2=|100|b|CENTER||^";
$phpvar .= "&Exec3=|40|b|LEFT||^จำนวนนักเรียน|20|b|CENTER||^จำนวนห้องเรียน|20|b|CENTER||^จำนวนครู|20|b|CENTER||^";
$phpvar .= "&Exec4=อำเภอเมืองเชียงใหม่|40|b|LEFT||^19,914|20|b|CENTER||0x00FF00^612|20|b|CENTER||0x00FF00^995|20|b|CENTER||0x00FF00^";
$phpvar .= "&Exec5=อำเภอดอยสะเก็ด|40|b|LEFT||^5,289|20|b|CENTER||0x00FF00^295|20|b|CENTER||0x00FF00^332|20|b|CENTER||0x00FF00^";
$phpvar .= "&Exec6=อำเภอสันกำแพง|40|b|LEFT||^7,132|20|b|CENTER||0x00FF00^360|20|b|CENTER||0x00FF00^380|20|b|CENTER||0x00FF00^";
$phpvar .= "&Exec7=กิ่งอำเภอแม่ออน|40|b|LEFT||^2,225|20|b|CENTER||0x00FF00^160|20|b|CENTER||0x00FF00^155|20|b|CENTER||0x00FF00^";
$phpvar .= "&Exec8=รวม|40|b|LEFT||^34,560|20|b|CENTER||0xFF0000^1,427|20|b|CENTER||0xFF0000^1,862|20|b|CENTER||0xFF0000^";*/
// ตัวอย่าง
/*$phpvar = "Exec0= |15||CENTER||0xffffff^N/A|33.3333333333||CENTER||0xffffff^จำนวน(คน)|50||CENTER||0xe5e4e2^";
$phpvar .= "&Exec1=เครื่องราชอิสริยาภรณ์|33.3333333333||CENTER||0xe5e4e2^บุรุษ|15||CENTER||0xe5e4e2^สตรี|15||CENTER||0xe5e4e2^รวม|15||CENTER||0xe5e4e2^";
$phpvar .= "&Exec2=ชั้นสายสะพาย|33.3333333333||LEFT||0xb2ada7^N/A|15||RIGHT||0xb2ada7^N/A|15||RIGHT||0xb2ada7^N/A|15||RIGHT||0xb2ada7^";
$phpvar .= "&Exec3= |10||CENTER||0xf9f9f9^ม.ป.ช.|10||LEFT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^";
$phpvar .= "&Exec4=N/A|10||CENTER||0xffffff^ม.ว.ม.|10||LEFT||0xffffff^N/A|15||RIGHT||0xffffff^N/A|15||RIGHT||0xffffff^N/A|15||RIGHT||0xffffff^";
$phpvar .= "&Exec5=N/A|10||CENTER||0xf9f9f9^ป.ช.|10||LEFT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^";
$phpvar .= "&Exec6=N/A|10||CENTER||0xffffff^ป.ม.|10||LEFT||0xffffff^N/A|15||RIGHT||0xffffff^N/A|15||RIGHT||0xffffff^N/A|15||RIGHT||0xffffff^";
$phpvar .= "&Exec7=ชั้นต่ำกว่าสายสะพาย|33.3333333333||LEFT||0xb2ada7^N/A|15||RIGHT||0xb2ada7^N/A|15||RIGHT||0xb2ada7^N/A|15||RIGHT||0xb2ada7^";
$phpvar .= "&Exec8=N/A|10||CENTER||0xf9f9f9^ท.ช.|10||LEFT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^";
$phpvar .= "&Exec9=N/A|10||CENTER||0xffffff^ท.ม.|10||LEFT||0xffffff^N/A|15||RIGHT||0xffffff^N/A|15||RIGHT||0xffffff^N/A|15||RIGHT||0xffffff^";
$phpvar .= "&Exec10=N/A|10||CENTER||0xf9f9f9^ต.ช.|10||LEFT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^";
$phpvar .= "&Exec11=N/A|10||CENTER||0xffffff^ต.ม.|10||LEFT||0xffffff^N/A|15||RIGHT||0xffffff^N/A|15||RIGHT||0xffffff^N/A|15||RIGHT||0xffffff^";
$phpvar .= "&Exec12=N/A|10||CENTER||0xf9f9f9^จ.ช.|10||LEFT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^";
$phpvar .= "&Exec13=N/A|10||CENTER||0xffffff^จ.ม.|10||LEFT||0xffffff^N/A|15||RIGHT||0xffffff^N/A|15||RIGHT||0xffffff^N/A|15||RIGHT||0xffffff^";
$phpvar .= "&Exec14=N/A|10||CENTER||0xf9f9f9^บ.ช.|10||LEFT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^N/A|15||RIGHT||0xf9f9f9^";
$phpvar .= "&Exec15=N/A|10||CENTER||0xffffff^บ.ม.|10||LEFT||0xffffff^N/A|15||RIGHT||0xffffff^N/A|15||RIGHT||0xffffff^N/A|15||RIGHT||0xffffff^";
$phpvar .= "&Exec16=รวมทั้งหมด|33.3333333333||CENTER||0x6d6d6d^N/A|15||RIGHT||0x6a6a6a^N/A|15||RIGHT||0x6a6a6a^N/A|15||RIGHT||0x6a6a6a^&";*/
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>executive</title>
</head>
<body bgcolor="#396D9E" leftmargin="0" topmargin="0">
<!--url's used in the movie-->
<!--text used in the movie-->
<!-- saved from url=(0013)about:internet -->
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="100%" id="executive" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="../images_sys/executive.swf?<?=$phpvar?>" /><param name="menu" value="false" /><param name="quality" value="high" /><param name="scale" value="exactfit" /><param name="bgcolor" value="#ffffff" /><embed src="executive.swf?<?=$phpvar?>" menu="false" quality="high" scale="exactfit" bgcolor="#ffffff" width="100%" height="100%" name="executive" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>

<SCRIPT LANGUAGE="JavaScript">
<!--
window.moveTo(0,0);
window.resizeTo(screen.width,screen.height);
//-->
</SCRIPT>
</body>
</html>
