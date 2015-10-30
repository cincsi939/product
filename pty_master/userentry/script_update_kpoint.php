<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		จัดการผู้ใช้
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
	
set_time_limit(0);
include "epm.inc.php";
$report_title = "รายงานข้อมูลสถิติการคีย์ข้อมูล";
$key_old = "2009-10-01";
$point_avg_old = "2.6";
$date_config = "2010-07-12"; // วันที่ที่ยกเว้น

	if($_GET['action'] == "process"){
		$sql = "SELECT * FROM pointkey WHERE datekeyin <> '2010-07-12'";
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$sql1 = "UPDATE stat_user_keyin SET numkpoint='$rs[netpoint]' WHERE datekeyin='$rs[datekeyin]' AND staffid='$rs[staffid]'";	
			mysql_db_query($dbnameuse,$sql1);
			echo $sql1."<br>";
			//mysql_db_query($dbnameuse,$sql1);
		}
		
		
	}//end if($_GET['action'] == "process"){



?>
<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
</head>
<body bgcolor="#EFEFFF">
<a href="?action=process">ประมวลผลข้อมูล</a>
<BR><BR>
</BODY>
</HTML>
