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

	if($action == "delete"){
	$sql = " DELETE  FROM  monitor_keyin   WHERE  staffid = '$staffid'  AND  idcard = '$idcard'  " ;
	mysql_db_query($dbcall,$sql);
	
		if (mysql_errno() != 0){
			$msg = "ไม่สามารถลบฐานข้อมูลได้<BR>$sql<BR><BR>" . mysql_error() ;
			echo "<script>alert('ไม่สามารถบันทึกลงฐานข้อมูลได้');window.close();</script>";
		}else{
			echo "<script>alert('ลบข้อมูลเรียบร้อยแล้ว');
					opener.document.location.reload();
					window.close();
					 </script>";
			exit;
		}
	}


if($_SERVER['REQUEST_METHOD']=="POST"){
	
	if($action == "edit"){
	$sql = " UPDATE  monitor_keyin  SET  status_key = '$status_keyin'  WHERE  staffid = '$staffid'  AND  idcard = '$idcard'  " ;
	mysql_db_query($dbcall,$sql);
		if (mysql_errno() != 0){
			$msg = "ไม่สามารถบันทึกลงฐานข้อมูลได้<BR>$sql<BR><BR>" . mysql_error() ;
			echo "<script>alert('ไม่สามารถบันทึกลงฐานข้อมูลได้');window.close();</script>";
		}else{
			echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');
					opener.document.location.reload();
					window.close();
					 </script>";
			exit;
		}
	}
	
		
}


?>


<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">

</head>

<body bgcolor="#EFEFFF">
<form name="form1" method="post" action="?">

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
<th width=57>ลำดับ</th>
<th width="251">ชื่อ - นามสกุล</th>
<th width="131">เลขบัตรประชาชน</th>
<th width="162">รหัสพื้นที่</th>
<th width=215>สถานะการบันทึก</th>
<th width=128>&nbsp;</th>
</tr>
<?
$n = 0;
$sql = "select  
monitor_keyin.staffid,
monitor_keyin.idcard,
monitor_keyin.keyin_name,
monitor_keyin.siteid,
monitor_keyin.status_key,
monitor_keyin.timeupdate,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname,
keystaff.priority
from  monitor_keyin  INNER JOIN  keystaff  ON  monitor_keyin.staffid = keystaff.staffid  WHERE  keystaff.staffid = '$_SESSION[session_staffid]'   AND  idcard = '$idcard'    ";

//echo "$sql";
$result = mysql_db_query($dbcall,$sql);
while ($rs=mysql_fetch_assoc($result)){
	if ($n++ %  2){
		$bgcolor = "#F0F0F0";
	}else{
		$bgcolor = "#FFFFFF";
	}
	
?>
<tr valign=top bgcolor="<?=$bgcolor?>">
<td align=center ><?=$n?></td>
<td >&nbsp;<?=$rs[keyin_name]?></td>
<td align="center" valign="middle" ><?=$rs[idcard]?></td>
<td align="center" valign="middle" ><?=$rs[siteid]?></td>
<td align=center><select name="status_keyin" id="status_keyin">
  <option value="60"<? if($rs[status_key] == "60"){ echo "selected='selected'";}?>>คีย์ 6 ปีย้อนหลัง( 60% )</option>
  <option value="100"  <? if($rs[status_key] == "100"){ echo "selected='selected'";}?>>คีย์ทั้งหมด ( 100% )</option>
</select>
<input name="staffid" type="hidden" id="staffid" value="<?=$rs['staffid']?>">
  <input name="idcard" type="hidden" id="idcard" value="<?=$rs['idcard']?>">
  <input name="action" type="hidden" id="action" value="edit">
</td>
<td align=center>
  <input type="submit" name="Submit" value="Submit">
</td>
</tr>
<?
}
?>
</table>
</form>
</BODY>
</HTML>
