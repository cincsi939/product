<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "search_person"; 
$process_id			= "checklistkp7_byarea";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20100809.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2010-08-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20100809.00
	## Modified Detail :		ระบบตรวจสอบข้อมูลทะเบียนประวัติต้นฉบับ
	## Modified Date :		2010-08-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################


include("../../common/common_competency.inc.php");
include("checklist.inc.php");
$time_start = getmicrotime();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>

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
</head>
<body>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td align="center">&nbsp;</td>
 </tr>
 <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      
      <tr>
        <td colspan="5" align="center" bgcolor="#CAD5FF"><strong>รายงานการตรวจข้อมูลของ <?=$staffname?> ประจำวันที่ <?=$show_date?></strong></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#CAD5FF"><strong>ลำดับ</strong></td>
        <td width="20%" align="center" bgcolor="#CAD5FF"><strong>รหัสบัตร</strong></td>
        <td width="22%" align="center" bgcolor="#CAD5FF"><strong>ชื่อ - นามสกุล </strong></td>
        <td width="29%" align="center" bgcolor="#CAD5FF"><strong>ตำแหน่ง</strong></td>
        <td width="23%" align="center" bgcolor="#CAD5FF"><strong>สังกัด/หน่วยงาน</strong></td>
      </tr>
	  <?
if($sdate != "" and $edate != ""){
	$condate = " AND date(tbl_checklist_log.time_update) BETWEEN '$sdate' AND '$edate' ";
}else if($sdate != "" and $edate == ""){
	$condate = " AND date(tbl_checklist_log.time_update)='$sdate'";
}else if($edate != "" and $sdate == ""){
	$condate = " AND date(tbl_checklist_log.time_update)='$edate' ";
}
	
$sql = "SELECT 
tbl_checklist_kp7.idcard,
tbl_checklist_kp7.prename_th,
tbl_checklist_kp7.name_th,
tbl_checklist_kp7.surname_th,
tbl_checklist_kp7.position_now,
tbl_checklist_kp7.schoolid,
tbl_checklist_kp7.siteid,
tbl_checklist_log.time_update
FROM
tbl_checklist_log
Inner Join tbl_checklist_kp7 ON tbl_checklist_log.idcard = tbl_checklist_kp7.idcard
where user_update='$staffid' and type_action='1' $condate
group by tbl_checklist_log.idcard
";
//echo $sql;
	$result_search = mysql_db_query($dbtemp_check,$sql);
		while($rs = mysql_fetch_assoc($result_search)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><? echo "$rs[idcard]";?></td>
        <td align="center"><? echo "$rs[prename_th]$rs[name_th] $rs[surname_th]";?></td>
        <td align="left"><?=$rs[position_now]?></td>
        <td align="center"><?=show_area($rs[siteid]);?>/<?=show_school($rs[schoolid]);?></td>
      </tr>
	  <?
	  	}//end while(){

	  ?>
	  
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>