<?
session_start();
include "epm.inc.php";




$sql = " SELECT
general_check.idcard,
general_check.siteid,
general_check.update6y_status,
general_check.update_status
FROM general_check
WHERE
general_check.update6y_status =  '100' AND
( general_check.update_status IS NULL  OR general_check.update_status =  '' ) ";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<link href="../../common/style.css" type="text/css" rel="stylesheet">
<SCRIPT SRC="sorttable.js"></SCRIPT>

</head>
<body bgcolor="#F2F4F7">
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr style="background-color:#E0E0E0;">
    <td background="images/login_right2_04.gif" width="1%" valign="top"><img src="images/login_right2_03.gif" width="6" height="24"></td>
    <td width="98%"><table width="100%" border="0" cellspacing="0" cellpadding="0" background="images/login_right2_04.gif">
      <tr class="headerTB">
        <td width="28%">รายการบันทึกข้อมูล</td>
        <td width="0%"><img src="images/login_right2_06.gif" width="2" height="30" align="absmiddle"></td>
        <td width="72%" align="right">&nbsp;</td>
      </tr>
    </table></td>
    <td background="images/login_right2_04.gif" width="1%" valign="top" align="right">
	<img src="images/login_right2_08.gif" width="6" height="24"></td>
  </tr>
  <tr valign="top">
    <td colspan="3" height="350">
	<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#404040"  id="table0" class="sortable">
      <tr bgcolor="#E0E0E0"  onMouseOver="this.style.cursor='hand'; this.style.background='#EFEFEF';" onMouseOut="this.style.cursor='point'; this.style.background='#FFFFFF';">
        <th width="5%" height="20" class="table_head_text">ลำดับ</th>
        <th width="19%" class="table_head_text">ชื่อ นามสกุล </th>
        <th width="10%" class="table_head_text">IDCARD</th>
        <th width="7%" class="table_head_text">siteid</th>
        <th width="9%" class="table_head_text">สถานะ 6 ปี </th>
        <th width="10%" class="table_head_text">สถานะครบ<br> 
          100%</th>
        <th width="10%" class="table_head_text">จำนวนรายการ</th>
        <th width="9%" class="table_head_text">ปีที่รับราชการ</th>
        <th width="10%" class="table_head_text">ปีเริ่มบันทึก<br>
          เงินเดือน</th>
        <th width="11%" class="table_head_text">ปีสิ้นสุดบันทึก<br>
เงินเดือน</th>
      </tr>
      <?
	  $i=1;
	  $result = mysql_query($sql);
	  while($rs=mysql_fetch_assoc($result)){
	  if($i%2){$bg="#EFEFEF";}else{$bg="#FFFFFF";}
	  
		$result3 = mysql_db_query(DB_MASTER," SELECT  siteid,name_th,surname_th , year(startdate) as startdate   FROM  view_general  WHERE  CZ_ID = '$rs[idcard]' ");
		$rs3 = mysql_fetch_assoc($result3);
		$dbsite = STR_PREFIX_DB.$rs3[siteid] ;
		$name = "$rs3[name_th] $rs3[surname_th]";
		
		$sql2 = " SELECT  count(id) AS NUM ,MIN(year(`date`)) AS  MINNUM ,MAX(year(`date`)) AS MAXNUM FROM  salary  WHERE  id = '$rs[idcard]'  ";
		$result2 = @mysql_db_query($dbsite,$sql2);
		$rs2 = @mysql_fetch_assoc($result2);


		if($rs3[startdate] == $rs2[MINNUM] ){ $bg = "#00CC66";}else{$bg = "#990033";}
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td>&nbsp;<?=$name?></td>
        <td align="center"><?=$rs[idcard]?></td>
        <td align="center"><?=$rs3[siteid]?></td>
        <td align="center"><?=$rs[update6y_status]?></td>
        <td align="center"><?=$rs[update_status]?></td>
        <td align="center"><?=$rs2[NUM]?></td>
        <td align="center"><?=$rs3[startdate]?></td>
        <td align="center"><?=$rs2[MINNUM]?></td>
        <td align="center"><? echo "$rs2[MAXNUM]";?></td>
      </tr>
		<? $i++; } ?>
    </table></td>
  </tr>
</table>
</BODY>
</HTML>