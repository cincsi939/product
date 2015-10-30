<?
session_start();
include("checklist.inc.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>ระบบตรวจสอบเอกสาร ก.พ.7 ต้นฉบับ</title>
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
<table width="99%"border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      
      <tr>
        <td colspan="7" bgcolor="#A8B9FF"><strong>เครื่องมือตรวจสอบความถูกต้องข้อมูล ก.พ.7 ต้นฉบับ </strong></td>
        </tr>
      <tr>
        <td width="4%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>ลำดับ</strong></td>
        <td width="38%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>เขตพื้นที่การศึกษา</strong></td>
        <td width="13%" rowspan="3" align="center" bgcolor="#A8B9FF"><strong>จำนวนทั้งหมด</strong></td>
        <td colspan="3" align="center" bgcolor="#A8B9FF"><strong>สถานะการตรวจสอบ</strong></td>
        <td width="7%" rowspan="3" align="center" bgcolor="#A8B9FF">&nbsp;</td>
      </tr>
      <tr>
        <td width="14%" rowspan="2" align="center" bgcolor="#A8B9FF"><strong>ค้างตรวจสอบ</strong></td>
        <td colspan="2" align="center" bgcolor="#A8B9FF"><strong>ตรวจสอบแล้ว</strong></td>
        </tr>
      <tr>
        <td width="12%" align="center" bgcolor="#A8B9FF"><strong>สมบูรณ์</strong></td>
        <td width="12%" align="center" bgcolor="#A8B9FF"><strong>ไม่สมบูรณ์</strong></td>
        </tr>
		<?
			$sql_main = "SELECT  siteid  FROM tbl_checklist_kp7  GROUP BY siteid  order by siteid asc";
			$result_main = mysql_db_query($dbtemp_check,$sql_main);
			$i=0;
			while($rs_m = mysql_fetch_assoc($result_main)){
			$sql = "SELECT * FROM eduarea WHERE secid ='$rs_m[siteid]'";
			$result = mysql_db_query($dbnamemaster,$sql);
			$rs = mysql_fetch_assoc($result);
			  if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			 // $count_impP = count_imp_checklist($rs_m[siteid],"");// จำนวนทั้งหมด
			  $count_y = count_checklist_kp7($rs_m[siteid],"Y");// ตรวจสอบแล้วสมบูรณ์
			  $count_yn = count_checklist_kp7($rs_m[siteid],"YN");// ตรวจสอบแล้วไม่สมบูรณ์
			  $count_n = count_checklist_kp7($rs_m[siteid],"N");// รอตรวจสอบ
			  $num_imp_all = $count_y+$count_yn+$count_n; // รายการรวมทั้งหมด
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[secname]?></td>
        <td align="center"><?=number_format($num_imp_all)?></td>
        <td align="center"><?=number_format($count_n)?></td>
        <td align="center"><?=number_format($count_y)?></td>
        <td align="center"><?=number_format($count_yn)?></td>
        <td align="center"><a href="check_kp7_area.php?sentsecid=<?=$rs[secid]?>"><img src="../../images_sys/refresh.png" width="20" height="20" alt="ตรวจสอบข้อมูล" border="0"></a></td>
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
	}
?>
</body>
</html>
