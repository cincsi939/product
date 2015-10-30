<?php
include("../../config/conndb_nonsession.inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>View School</title>
</head>

<body style="font-size:12px;">
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#CCCCCC" style="border-collapse:collapse">
  <tr>
    <td width="10%" align="center" bgcolor="#F0F0F0"><strong>ลำดับ</strong></td>
    <td width="27%" align="center" bgcolor="#F0F0F0"><strong>โรงเรียน</strong></td>
    <td width="31%" align="center" bgcolor="#F0F0F0"><strong>เขตพื้นที่การศึกษา</strong></td>
    <td width="32%" align="center" bgcolor="#F0F0F0"><strong>ที่ตั้ง</strong></td>
  </tr>
<?php
$sql = " SELECT * FROM log_transfer_pobec 
         JOIN allschool ON log_transfer_pobec.schoolid = allschool.id 
		 JOIN eduarea ON eduarea.secid = log_transfer_pobec.siteid 
		 WHERE log_transfer_pobec.siteid = '".$_GET['siteid']."'
		 ORDER BY allschool.moiareaid ";
$query = mysql_db_query('edubkk_master',$sql)or die(mysql_error());
$i = 1;
while($rows = mysql_fetch_array($query)){		 		 
?>  
  <tr>
    <td align="center"><?=$i?></td>
    <td><?=$rows['office']?></td>
    <td><?=$rows['secname']?></td>
    <td>
	<?php
	$province = substr($rows['moiareaid'],0,2);
	$aumphur = substr($rows['moiareaid'],0,4);
	
	$sql_p = "SELECT ccName FROM ccaa WHERE ccType = 'Changwat' AND ccDigi LIKE '$province%' ";
	$query_p = mysql_db_query('edubkk_master',$sql_p);
	$rows_p = mysql_fetch_array($query_p);
	
	$sql_a = "SELECT ccName FROM ccaa WHERE ccType = 'Aumpur' AND ccDigi LIKE '$aumphur%' ";
	$query_a = mysql_db_query('edubkk_master',$sql_a);
	$rows_a = mysql_fetch_array($query_a);
	
	echo $rows_a['ccName']."  ".$rows_p['ccName'];
	
	?>
	</td>
  </tr>
<?php
  $i++;
}
?>  
</table>

</body>
</html>
