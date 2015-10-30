<?php
session_start();
$_SESSION['secid'] = $_GET['xsiteid'];
$_SESSION['id'] = $_GET['id'];
if($_GET['debug'] == "on"){
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	exit();
}
?>
<HTML>
<HEAD>
<TITLE>ผังการการรับราชการ</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=windows-874">
</HEAD>
<FRAMESET rows="50,*" cols="*"   border="1"   >
	<FRAME src="report_top_govplan.php?id=<?=$_GET['id']?>&xsiteid=<?=$xsiteid;?>"  name="topFrame" noresize="yes" scrolling="NO"  border="0"  >
	<FRAME src="govPlan.php?id=<?=$_GET['id']?>&xsiteid=<?=$xsiteid;?>"   name="mainFramePlan"  >
</FRAMESET>
<NOFRAMES></NOFRAMES>
</HTML>