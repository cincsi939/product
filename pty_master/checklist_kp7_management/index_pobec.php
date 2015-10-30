<?php
include("../../config/conndb_nonsession.inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>POBEC To POBEC</title>
</head>
<body style="font-size:12px;">

<table width="700" border="1" cellspacing="0" cellpadding="3" style="border-collapse:collapse;" bordercolor="#999999" >
  <tr bgcolor="#CCCCCC">
    <td width="80" align="center"><strong>ลำดับ</strong></td>
    <td width="323" align="center"><strong>เขตพื้นที่การศึกษา</strong></td>
    <td width="128" align="center"><strong>สถานะ</strong></td>
    <td width="135" align="center"><strong>Transfer</strong></td>
  </tr>
<?php
$i = 1;
$sql = " SELECT * 
         FROM  eduarea 
		 ORDER BY secid
		 WHERE secid NOT LIKE '99%'  ";
$query = mysql_db_query('edubkk_master',$sql)or die(mysql_error());
while($rows = mysql_fetch_array($query)){		 
?>  
  <tr>
    <td align="center"><?=$i?></td>
    <td><?=$rows['secname']?></td>
    <td align="center">&nbsp;</td>
    <td align="center"><a href="transfer_pobec.php?siteid=<?=$rows['secid']?>" target="_blank">[RUN]</a></td>
  </tr>
<?php
  $i++;
}
?>  
</table>


</body>
</html>
