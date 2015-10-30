<?php
	include("../../../../config/conndb_nonsession.inc.php");
	$t_encode = "UTF-8";
	mysql_query("SET character_set_results=$t_encode");
	$t_encode=str_replace('-','',$t_encode);
	mysql_query("SET NAMES ".$t_encode);
	
	$dbTempCheckData=DB_CHECKLIST;
	
	$tblMonitorKey="view_monitor_key";
	
	$url_base="https://master.cmss-otcsc.com/competency_master/";
	$partPdf="../../../../edubkk_kp7file/";
	$partPdfElec="http://202.129.35.120".APPNAME."application/hr3/hr_report/kp7_search.php?tmppass=123456&tmpuser=&";
	$partImgPdf="https://master.cmss-otcsc.com/competency_master/images_sys/gnome-mime-application-pdf.png";
	$partImgPdfElec="https://master.cmss-otcsc.com".APPNAME."application/hr3/hr_report/bimg/pdf.gif";
	
	$datecheck="2554-10-01";