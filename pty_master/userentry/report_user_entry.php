<?
session_start();
/*****************************************************************************
Function		: แก้ไขข้อมูลของ $epm_staff
Version			: 1.0
Last Modified	: 16/8/2548
Changes		:

*****************************************************************************/
include "epm.inc.php";
$dbcall = "edubkk_userentry";
$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}

?>


<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script>
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
	if (confirm("คุณต้องการลบข้อมูลรายการนี้ใช่หรือไม่?")) { 
		
		window.open(theURL,winName,features);
		return true; 
		
	}else{
		return false;
	}

}



function MM_openBrWindow1(theURL,winName,features) { //v2.0
		window.open(theURL,winName,features);
}

//-->
</script>



</head>

<body bgcolor="#EFEFFF"><BR>
<table border=0 align=center cellspacing=1 cellpadding=2 width="98%">
<tr><td width=35><img src="images/user_icon.gif"></td>
<td class="Label_big_black">รายงานการบันทึกข้อมูลของ   <?=$_SESSION[session_fullname]?></td>
</tr>

<tr valign=top height=1 bgcolor="#808080"><td colspan=2></td></tr>

<tr valign=top><td colspan=2>&nbsp;</td>
</tr>
</table>


<table border=0 align=center cellspacing=1 cellpadding=2 bgcolor=black width="98%" class="sortable" id="unique_id">
<tr bgcolor="#a3b2cc">
<th width=53>ลำดับ</th>
<th width="218">ชื่อ - นามสกุล</th>
<th width="171">เลขบัตรประชาชน</th>
<th width="105">รหัสพื้นที่</th>
<th width=139>สถานะการบันทึก</th>
<th width=160>สถานะการรับรอง</th>
<th width=93>&nbsp;</th>
</tr>
<?
$j = 0;
$sql1 = " select  
date(monitor_keyin.timeupdate) AS d
from  monitor_keyin  WHERE   monitor_keyin.staffid = '$_SESSION[session_staffid]' AND timeupdate  IS NOT NULL  GROUP BY date(monitor_keyin.timeupdate) ORDER BY timeupdate DESC";
$result1 = mysql_db_query($dbcall,$sql1);
while ($rs1=mysql_fetch_assoc($result1)){
	if ($n++ %  2){
		$bgcolor = "#F0F0F0";
	}else{
		$bgcolor = "#FFFFFF";
	}
?>
<tr valign=top bgcolor="<?=$bgcolor?>">
  <td colspan="7" bgcolor="#CCCCCC" >&nbsp;<?=thaidate($rs1[d])?></td>
  </tr>
<?
$n = 0;
$sql = "select  
monitor_keyin.staffid,
monitor_keyin.idcard,
monitor_keyin.keyin_name,
monitor_keyin.siteid,
monitor_keyin.status_key,
monitor_keyin.status_approve,
monitor_keyin.timeupdate,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
keystaff.priority
from  monitor_keyin  INNER JOIN  keystaff  ON  monitor_keyin.staffid = keystaff.staffid  WHERE  keystaff.staffid = '$_SESSION[session_staffid]'  AND  DATE(monitor_keyin.timeupdate) = '$rs1[d]'   ";

//echo "$sql";
$result = mysql_db_query($dbcall,$sql);
while ($rs=mysql_fetch_assoc($result)){
	if ($n++ %  2){
		$bgcolor = "#F0F0F0";
	}else{
		$bgcolor = "#FFFFFF";
	}
	
	if($rs[status_key]=="60"){$statusentry = "6 ปีย้อนหลัง";}elseif($rs[status_key]=="100"){$statusentry = "สมบูรณ์ 100%";}else{ $statusentry = "ไม่ระบุ";}
	if($rs[status_approve]=="1"){$statusapprove = "approve";}else{ $statusapprove = "<font color=#FFFF00><b>waiting</b></font>";}

?>  
<tr valign=top bgcolor="<?=$bgcolor?>">
<td align=center ><?=$n?></td>
<td >&nbsp;<?=$rs[keyin_name]?></td>
<td align="center" valign="middle" ><?=$rs[idcard]?></td>
<td align="center" valign="middle" ><?=$rs[siteid]?></td>
<td align=center><?=$statusentry?></td>
<td align=center><?=$statusapprove?></td>
<td align=center>
<img src="images/info_edit.gif" alt="แก้ไข" width="16" height="16" border="0" onClick="MM_openBrWindow1('add_user_entry.php?action=edit&idcard=<?=$rs[idcard]?>&staffid=<?=$rs[staffid]?>','','width=900,height=330,scrollbars=Yes,resizable=Yes,status=Yes')" style="cursor:hand">&nbsp;&nbsp;
<img src="images/b_drop.png" alt="ลบข้อมูล" width="16" height="16" border="0" onClick="MM_openBrWindow('add_user_entry.php?action=delete&idcard=<?=$rs[idcard]?>&staffid=<?=$rs[staffid]?>','','width=1,height=1,scrollbars=Yes,resizable=Yes,status=Yes')" style="cursor:hand"></td>
</tr>
<?
}
}
?>
</table>

<BR>
<BR>
</BODY>
</HTML>
