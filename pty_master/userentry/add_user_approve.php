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

if($datereq==""){
		$dd = date("d");
		$mm = date("m");
		$mm = sprintf("%02d",intval($mm));
		$yy=date("Y");
		$datereq1 = ($yy+543)."-$mm-$dd";
}else{
		$datereq1=$datereq;
}	
			
			$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
			
			function swapdate($temp){
				$kwd = strrpos($temp, "/");
				if($kwd != ""){
					$d = explode("/", $temp);
					$ndate = ($d[2]+543)."-".$d[1]."-".$d[0];
				} else { 		
					$d = explode("-", $temp);
					$ndate = $d[2]."/".$d[1]."/".$d[0];
				}
				return $ndate;
			}
			
			function swapdate2($temp){
				$kwd = strrpos($temp, "/");
				if($kwd != ""){
					$d = explode("/", $temp);
					$ndate = ($d[2])."-".$d[1]."-".$d[0];
				} else { 		
					$d = explode("-", $temp);
					$ndate = $d[2]."/".$d[1]."/".$d[0];
				}
				return $ndate;
			}
				function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = intval($x[0]+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}
$sql0 = "select  *  from    keystaff  WHERE  staffid = '$staffid'   ";
$result0 = mysql_db_query($dbcall,$sql0);
$rs0=mysql_fetch_assoc($result0) ;
$name0 = "$rs0[prename]$rs0[staffname]  $rs0[staffsurname]";



if($_SERVER['REQUEST_METHOD']=="POST"){

	foreach($approve AS $key=>$val){
		$textdate = '$datereq1'.$key;
		//echo "$textdate <br>";
		
		eval("\$textdate = \"$textdate\";");
		
		$textdate1 = swapdate2($textdate);
		$textdate = swapdate($textdate);
		
		$sql = " UPDATE  monitor_keyin  SET  status_approve = '$val' , audit_comment = '$comment[$key]' , timeupdate = '$textdate1'  WHERE  staffid = '$staffid'  AND  idcard = '$key'  " ;
		mysql_db_query($dbcall,$sql);
		//echo "$sql<br>";
		
		$sql1 = "SELECT  * FROM  general_check  WHERE  idcard = '$key' ";
		$result1 = mysql_db_query($dbcall,$sql1);
		$rs1=mysql_fetch_assoc($result1) ;
		
		$sql2 = "select  *  from    monitor_keyin   WHERE  staffid = '$staffid'  AND  idcard = '$key'    ";
		$result2 = mysql_db_query($dbcall,$sql2);
		$rs2=mysql_fetch_assoc($result2) ;
		
		
		

		
		if($rs1[idcard] != ""){ 
			if($rs2[status_key]==60){
				$sqlx = " UPDATE  general_check  SET 
				general_check.update6y_status = '100' ,
				general_check.update6y_note = '',
				general_check.update6y_date = '$textdate',
				general_check.update6y_timestamp = NOW(),
				general_check.update6y_staff = '$staffid'
				WHERE   idcard = '$key'  " ;
				mysql_db_query($dbcall,$sqlx);
			}else if($rs2[status_key]==100){
				$sqlx = " UPDATE  general_check  SET  
				general_check.update_status = '100' ,
				general_check.update_note = '',
				general_check.update_date = '$textdate',
				general_check.update_timestamp  = NOW(),
				general_check.update_staff = '$staffid'
				WHERE   idcard = '$key'  " ;
				mysql_db_query($dbcall,$sqlx);
			}else{
			// not query
			}
		}else{
//				$sqlx = " INSERT INTO  general_check  VALUES
//				general_check.idcard = '$key',
//				general_check.siteid = '".$siteid[$key]."', 
//				general_check.update6y_status = '100' ,
//				general_check.update6y_note = '',
//				general_check.update6y_date = '$textdate',
//				general_check.update6y_timestamp = NOW(),
//				general_check.update6y_staff = '$staffid'
//				" ;
				
				$sqlx = "INSERT INTO general_check(idcard,siteid,update6y_status,update6y_note,update6y_date,update6y_timestamp,update6y_staff)VALUES('$key','$siteid[$key]','100','','$textdate','NOW()','$staffid' )";
				//echo "$sqlx";die;
				mysql_db_query($dbcall,$sqlx);
		}	
			//echo "$sqlx<br>";die;
	
	}

//die;
	
	
		if (mysql_errno() != 0){
			$msg = "ไม่สามารถบันทึกลงฐานข้อมูลได้<BR>$sql<BR><BR>" . mysql_error() ;
			echo "<script>alert('ไม่สามารถบันทึกลงฐานข้อมูลได้');</script>";
		}else{
			echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');
					document.location.href='report_audit.php?datereq=$textdate';
					 </script>";
			exit;
		}

}


?>


<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language='javascript' src='../../common/popcalendar.js'></script>
</head>

<body bgcolor="#EFEFFF">
<form name="form" method="post" action="?">

<table border=0 align=center cellspacing=1 cellpadding=2 width="98%">
<tr><td width=32><img src="images/user_icon.gif"></td>
<td width="932" class="Label_big_black">รายงานการบันทึกข้อมูลของ   <?=$name0?>
  <input name="staffid" type="hidden" id="staffid" value="<?=$staffid?>">&nbsp;&nbsp;<?=thaidate($datereq)?></td>
</tr>

<tr valign=top height=1 bgcolor="#808080"><td colspan=2></td></tr>

<tr valign=top><td colspan=2>&nbsp;</td>
</tr>
</table>


<table border=0 align=center cellspacing=1 cellpadding=2 bgcolor=black width="98%" class="sortable" id="unique_id">
<tr bgcolor="#a3b2cc">
<th width=35>ลำดับ</th>
<th width="138">ชื่อ - นามสกุล</th>
<th width="106">เลขบัตรประชาชน</th>
<th width="83">รหัสพื้นที่</th>
<th width=104>สถานะการบันทึก</th>
<th width=110>รับรองข้อมูล</th>
<th width=161>วันที่บันทึก</th>
<th width=197>หมายเหตุ</th>
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
from  monitor_keyin  INNER JOIN  keystaff  ON  monitor_keyin.staffid = keystaff.staffid   WHERE  keystaff.staffid = '$staffid'   AND  monitor_keyin.timeupdate LIKE '$datereq%'   ";

//echo "$sql";
$result = mysql_db_query($dbcall,$sql);
while ($rs=mysql_fetch_assoc($result)){
	if ($n++ %  2){
		$bgcolor = "#F0F0F0";
	}else{
		$bgcolor = "#FFFFFF";
	}
	if($rs[status_key]=="60"){$statusentry = "6 ปีย้อนหลัง";}elseif($rs[status_key]=="100"){$statusentry = "สมบูรณ์ 100%";}else{ $statusentry = "ไม่ระบุ";}
	if($statusentry=="ไม่ระบุ" || $rs[status_approve]=="1"){$disapp = "disabled=\"disabled\"";}else{$disapp="";}
	if($rs[status_approve]=="1"){$statusapprove = "approve";}else{ $statusapprove = "<input type=\"checkbox\" name=\"approve[$rs[idcard]]\" $disapp  value=\"1\">";}
	//$statusapprove = "<input type=\"checkbox\" name=\"approve[$rs[idcard]]\" $disapp value=\"1\">";
?>
<tr valign=top bgcolor="<?=$bgcolor?>">
<td align="center" valign="top" ><?=$n?></td>
<td valign="top" >&nbsp;<?=$rs[keyin_name]?></td>
<td align="center" valign="top" ><?=$rs[idcard]?></td>
<td align="center" valign="top" ><?=$rs[siteid]?></td>
<td align=center><?=$statusentry?></td>
<td align=center><?=$statusapprove?><input name="siteid[<?=$rs[idcard]?>]" type="hidden" value="<?=$rs[siteid]?>"> </td>
<td align=center><input type="text" name="datereq1<?=$rs[idcard]?>" value="<?=swapdate($datereq1)?>" size="10">
          <input type=button NAME="d1<?=$rs[idcard]?>" id="d1<?=$rs[idcard]?>"  onclick='popUpCalendar(this, this.form.datereq1<?=$rs[idcard]?>, "dd/mm/yyyy");' value='V' style='font-size:11px'></td>
<td align=center><textarea name="comment[<?=$rs[idcard]?>]" cols="30" rows="2" id="comment[<?=$rs[idcard]?>]" <?=$disapp?>></textarea></td>
</tr>

<?
}
?>
<tr valign=top bgcolor="<?=$bgcolor?>">
  <td colspan="8" align=center ><input type="submit" name="Submit" value="  บันทึกข้อมูล  "> <input type="button" name="Submit2" value="  ยกเลิก  " onClick="location.href='report_audit.php'"></td>
  </tr>
</table>
<br>
</form>
</BODY>
</HTML>
