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

include "epm.inc.php";
$report_title = "บุคลากร";

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
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
      <tr>
        <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>โปรแกรมประมวลผลกรณีระบบไม่เก็บสถิติการคีย์ข้อมูลอาจเนื่องมาจากการทำงานของ server ผิดพลาด</strong></td>
        </tr>
      <tr>
        <td width="6%" align="center" bgcolor="#A3B2CC"><strong>ลำดับ</strong></td>
        <td width="62%" align="center" bgcolor="#A3B2CC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="32%" align="center" bgcolor="#A3B2CC"><strong>ประมวลผล</strong></td>
      </tr>
      <?
      	$sql = "SELECT
eduarea.secid,
eduarea.secname
FROM
eduarea
Inner Join eduarea_config ON eduarea.secid = eduarea_config.site
WHERE
eduarea_config.group_type =  'keydata'
ORDER BY
eduarea.secname ASC";
	$result = mysql_db_query($dbnamemaster,$sql);
	$n=0;
	while($rs = mysql_fetch_assoc($result)){
		if ($n++ %  2) $bgcolor = "#F0F0F0"; else $bgcolor = "#FFFFFF";
	  ?>
      <tr bgcolor="<?=$bgcolor?>">
        <td align="center"><?=$n?></td>
        <td align="left"><?=$rs[secname]?>&nbsp;[<?=$rs[secid]?>]</td>
        <td align="center"><a href="script_update_logv1.php?xsiteid=<?=$rs[secid]?>" target="_blank">ประมวลผล</a></td>
      </tr>
      <?
     	}//end  
	 ?>
    </table></td>
  </tr>
</table>
<BR><BR>
</BODY>
</HTML>
