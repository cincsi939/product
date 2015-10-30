<?
session_start();
$ApplicationName	= "checklist_kp7_management";
$module_code 		= "script_retire"; 
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

include ("../../common/common_competency.inc.php")  ;
include("checklist.inc.php");
$time_start = getmicrotime();
### function ตรวจสอบเลขบัตรซ้ำกับเขตอื่น

function CheckRetire1($get_siteid){
	global $dbtemp_check;
	  	$year = date("Y")+543;
	  	$year1 = $year-61;
		$year2	= $year-60;
      	$sql = "SELECT count(idcard) as num1 FROM tbl_checklist_kp7 WHERE siteid='$get_siteid' AND (birthday like '".$year1."-10%' or birthday like '".$year1."-11%' or birthday like    '".$year1."-12%' or birthday like '".$year2."-%' ) and (birthday not like '".$year2 ."-10%' and birthday not like '".$year2."-11%' and birthday not like '".$year2."-12%' ) ";
		
		
		$result = mysql_db_query($dbtemp_check,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[num1];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>update ข้อมูลหน่วยงาน</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=stylesheet>
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
<?
	if($action == ""){
?>
<table width="100%"border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      
      <tr>
        <td colspan="3" bgcolor="#9FB3FF"><strong>เครื่องมือตรวจสอบบุคลากรที่เกษียรอายุราชการ</strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#9FB3FF"><strong>ลำดับ</strong></td>
        <td width="69%" align="center" bgcolor="#9FB3FF"><strong>เขตพื้นที่การศึกษา</strong></td>
        <td width="26%" align="center" bgcolor="#9FB3FF"><strong>ตรวจสอบ</strong></td>
        </tr>
		<?
			$sql = "SELECT *  FROM eduarea  where status_area53 ='1' order by secname asc";
			$result = mysql_db_query($dbnamemaster,$sql);
			$i=0;
			while($rs = mysql_fetch_assoc($result)){
				
			  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[secname]?></td>
        <td align="center"><? if(CheckRetire1($rs[secid]) > 0){?><a href="?action=view&sentsecid=<?=$rs[secid]?>" target="_blank"><?=CheckRetire1($rs[secid])?></a><? } else{ echo "0";}?></td>
        </tr>
	  <?
	  	}//end 	while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<?
	}//end if($action == ""){
	if($action == "view"){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="6" align="left" bgcolor="#9FB3FF"><strong>รายงานคนที่เกษียณอายุราชการแล้ว &nbsp;<?=show_area($sentsecid);?></strong></td>
        </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#9FB3FF"><strong>ลำดับ</strong></td>
        <td width="18%" align="center" bgcolor="#9FB3FF"><strong>รหัสบัตร</strong></td>
        <td width="20%" align="center" bgcolor="#9FB3FF"><strong>ชื่อ - นามสกุล</strong></td>
        <td width="21%" align="center" bgcolor="#9FB3FF"><strong>ตำแหน่ง</strong></td>
        <td width="18%" align="center" bgcolor="#9FB3FF"><strong>หน่วยงาน</strong></td>
        <td width="19%" align="center" bgcolor="#9FB3FF"><strong>วันที่เกษียณอายุราชการ</strong></td>
      </tr>
      <?
	  	$year = date("Y")+543;
	  	$year1 = $year-61;
		$year2	= $year-60;
      	$sql = "SELECT * FROM tbl_checklist_kp7 WHERE siteid='$sentsecid' AND (birthday like '".$year1."-10%' or birthday like '".$year1."-11%' or birthday like    '".$year1."-12%' or birthday like '".$year2."-%' ) and (birthday not like '".$year2 ."-10%' and birthday not like '".$year2."-11%' and birthday not like '".$year2."-12%' ) ORDER BY schoolid asc ";
		$result = mysql_db_query($dbtemp_check,$sql);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="left"><? echo "$rs[prename_th]$rs[name_th]  $rs[surname_th]";?></td>
        <td align="left"><? echo "$rs[position_now]";?></td>
        <td align="center"><? echo show_school($rs[schoolid]);?></td>
        <td align="center"><?=retireDate($rs[birthday]);?></td>
      </tr>
      <?
		}//end 
	  ?>
    </table></td>
  </tr>
</table>
<?
	}//end if($action == "view"){
?>
</body>
</html>
<?  $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>