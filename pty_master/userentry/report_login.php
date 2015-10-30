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
	## Modified Detail :		รายงานการบันทึกข้อมูล
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
include "epm.inc.php";
include("function_assign.php");
$datestart = "2011-08-20";
$dateend = "2011-09-30";

function NumSchoolAll(){
	global $dbnamemaster;
	$sql = "SELECT count(id) as num1,siteid FROM allschool group by siteid";	
	$result =mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
	while($rs = mysql_fetch_assoc($result)){
			$arr[$rs[siteid]] = $rs[num1];
	}
	return $arr;
	
}


?>

<html>
<head>
<title>รายงาน</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">

<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style2 {font-weight: bold}
-->
</style>

</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="4" align="center" bgcolor="#CCCCCC"><strong>รายงานจำนวนโรงเรียนที่ login เข้าระบบนับตัว ระหว่าง วันที่ 20 สิงหาคม 2554 ถึง 30 กันยายน 2554 แยกรายเขต</strong></td>
        </tr>
      <tr>
        <td width="5%" align="center" bgcolor="#CCCCCC"><strong>ลำดับ</strong></td>
        <td width="42%" align="center" bgcolor="#CCCCCC"><strong>สำนักงานเขตพื้นที่การศึกษา</strong></td>
        <td width="28%" align="center" bgcolor="#CCCCCC"><strong>จำนวนโรงเรียนทั้งหมด(โรง)</strong></td>
        <td width="25%" align="center" bgcolor="#CCCCCC"><strong>จำนวนโรงเรียนที่ login เข้าระบบนับตัว(โรง)</strong></td>
      </tr>
      <?
	  	$arr_school = NumSchoolAll();// จำนวนโรงเรียนทั้งหมด
      	$sql = "SELECT
t1.secid as siteid,
t1.secname_short
FROM
 ".DB_MASTER.".eduarea AS t1
Inner Join ".DB_USERENTRY.".keystaff AS t2 ON t1.secid = t2.site_area
GROUP BY
t1.secid
ORDER BY
t1.secname_short ASC
";
	$result = mysql_db_query($dbnamemaster,$sql) or die(mysql_error()."".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		  $dbsite = STR_PREFIX_DB.$rs[siteid];
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[secname_short]?></td>
        <td align="right"><? echo number_format($arr_school[$rs[siteid]]);?></td>
        <td align="right">
        <?
        $sql1 = "SELECT
count(distinct t1.username) as num1
FROM
$dbsite.login AS t1
Inner Join $dbsite.log_update AS t2 ON t1.username = t2.username
Inner Join $dbnamemaster.allschool AS t3 ON t1.id = t3.id
WHERE
t3.siteid='$rs[siteid]' and t3.id <> '$rs[siteid]' and t2.updatetime between '$datestart' and '$dateend' ";
	$result1 = mysql_db_query($dbsite,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	echo number_format($rs1[num1]);

		
		?>
        
        </td>
      </tr>
      <?
	  $sum1 += $arr_school[$rs[siteid]];
	  $sum2 += $rs1[num1];
	}//end while(){
	  ?>
      <tr>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>รวม</strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong><?=number_format($sum1)?></strong></td>
        <td align="right" bgcolor="#CCCCCC"><strong><?=number_format($sum2)?></strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>
