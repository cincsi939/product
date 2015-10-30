<?php
include("../../../../config/conndb_nonsession.inc.php");
include "function_vitaya.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Untitled Document</title>
</head>

<body style="font-size:11px;">
<?php
if($_GET['select'] == '1'){
  echo "<script>opener.document.getElementById('salary_id').value = '".$_GET['salary_id']."' ;opener.document.getElementById('remark').value = '".$_GET['remark']."' ; opener.document.getElementById('show_noorder').innerHTML = '".$_GET['show_noorder']."' ;opener.document.getElementById('date_command').value = '".$_GET['date_command']."' ;opener.document.getElementById('date_start').value = '".$_GET['date_start']."' ;window.close();</script>";
}

$site = $_GET['site'];
$dbname = STR_PREFIX_DB.$site;
$idcard = $_GET['idcard'];

$sql = "SELECT * FROM view_general WHERE CZ_ID = '$idcard' ";
$query = mysql_db_query($dbname,$sql);
$rows = mysql_fetch_array($query);
echo $rows['prename_th'].$rows['name_th']."  ".$rows['surname_th'];
?>
&nbsp;&nbsp;เลขที่บัตรประชาชน : <?=$idcard?>&nbsp;&nbsp;
<?php
$dir = "../../../edubkk_kp7file/".$site."/".$idcard.".pdf";
if(file_exists($dir)){
  echo "<a href='".$dir."' target='_blank'>[ดาวน์โหลด กพ.7 ต้นฉบับ]</a>";
}

?>
<br />
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#999999" style="border-collapse:collapse;">
  <tr>
    <td width="3%" align="center" bgcolor="#CCCCCC">runno</td>
    <td width="9%" align="center" bgcolor="#CCCCCC">runid</td>
    <td width="10%" align="center" bgcolor="#CCCCCC">วันที่</td>
    <td width="13%" align="center" bgcolor="#CCCCCC">ตำแหน่ง</td>
    <td width="15%" align="center" bgcolor="#CCCCCC">ระดับ</td>
    <td width="38%" align="center" bgcolor="#CCCCCC">pls</td>
    <td width="12%" align="center" bgcolor="#CCCCCC">เลขที่คำสั่ง</td>
  </tr>
<?php

$sql = "SELECT * FROM salary WHERE   id = '$idcard'  ORDER BY runno ";
$query = mysql_db_query($dbname,$sql)or die(mysql_error());
$i = 1;

while($rows = mysql_fetch_array($query)){
?>  
  <tr>
    <td align="center"><?=$rows['runno']?></td>
    <td><a href="?salary_id=<?=$rows['runid']?>&remark=<?=$rows['noorder']?>&select=1&show_noorder=<?=$rows['pls']?>&date_command=<?=$rows['dateorder']?>&date_start=<?=$rows['date']?>"><?=$rows['runid']?></a></td>
    <td>
	<?php
	  $arr_date_th = explode("-",$rows['date']);
	  echo (int)$arr_date_th[2]." ".$month_th[(int)$arr_date_th[1]]." ".$arr_date_th[0];
	?>	</td>
    <td><?=$rows['position']?></td>
    <td><?=$rows['radub']?></td>
    <td><?=$rows['pls']?></td>
    <td><?=$rows['noorder']?></td>
  </tr>
<?php
  $i++;
}
?>  
</table>
</body>
</html>
