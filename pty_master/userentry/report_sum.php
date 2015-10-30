<?
session_start();
/*****************************************************************************
Function		: แก้ไขข้อมูลของ $epm_staff
Version			: 1.0
Last Modified	: 16/8/2548
Changes		:

*****************************************************************************/
include "epm.inc.php";
$dbcall =DB_USERENTRY;

			$mname	= array("","มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");


	  		function compare_order_asc($a, $b)			
			{
				global $sortname;
				return strnatcmp($a["$sortname"], $b["$sortname"]);
			}
			
			 function compare_order_desc($a, $b)			
			{
				global $sortname;
				return strnatcmp($b["$sortname"], $a["$sortname"]);
			}
			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				if($x[0] < 2500){
				$d1 = intval($x[0]+543);
				}else{
				$d1 = intval($x[0]);
				}
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}

			function thaidate1($temp){
				global $mname;
				if($temp != ""){
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				if($x[0] < 2500){
					$d1 = intval($x[0]+543);
				}else{
					$d1 = intval($x[0]);
				}
				$xrs = intval($x[2])." $m1 "." $d1 " ;
				return $xrs;
				}else{
				$xrs = "<font color=red>Not Available</font>";
				return $xrs;
				}
			}
			
			function swapdate($temp){
				$kwd = strrpos($temp, "/");
				if($kwd != ""){
					$d = explode("/", $temp);
					$ndate = ($d[2]-543)."-".$d[1]."-".$d[0];
				} else { 		
					$d = explode("-", $temp);
					$ndate = $d[2]."/".$d[1]."/".$d[0];
				}
				return $ndate;
			}


	if($_SERVER['REQUEST_METHOD']=="POST"){
		$date1 = swapdate($date1);
		$datereq1 = $date1 ;
		$exday = explode("-",$date1);
		$datereq = ($exday[0]+543)."-$exday[1]-$exday[2]";
		
		$date2 = swapdate($date2);
		$datereq2 = $date2 ;
		$exday2 = explode("-",$date2);
		$datereq2 = ($exday2[0]+543)."-$exday2[1]-$exday2[2]";		
		
	}else{
		
		$dd = date("d");
		$mm = date("m");
		$mm = sprintf("%02d",intval($mm));
		$yy=date("Y");
		$yy1 = date("Y");
		$yy += 543;
		$yy1 += 543;
		$datereq = "$yy-$mm-$dd";
		$datereq1 = ($yy-543)."-$mm-$dd";
		$datereq01 = "$yy-$mm-$dd";
		$datereq2 = ($yy1)."-$mm-$dd";
		
		$round = "am" ;
		
	}
?>


<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language='javascript' src='../../common/popcalendar.js'></script>
<SCRIPT SRC="sorttable.js"></SCRIPT>

<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body bgcolor="#EFEFFF"><BR>
<table border=0 align=center cellspacing=1 cellpadding=2 width="98%">
<tr><td width=32><img src="images/user_icon.gif"></td>
<td width="932" class="Label_big_black">รายงานสรุปการบันทึกข้อมูลตั้งแต่วันที่ <?=thaidate($datereq1)?> ถึง  <?=thaidate($datereq2)?> </td>
</tr>

<tr valign=top height=1 bgcolor="#808080"><td colspan=2></td></tr>

<tr valign=top><td colspan=2><form name="form" method="post" action="">
  <table width="100%" height="19" border="0" cellpadding="2" cellspacing="0">
    <tr>
      <td width="10%" align="right" bgcolor="#CCCCCC">&nbsp;</td>
      <td width="39%" bgcolor="#CCCCCC">&nbsp;</td>
      <td width="51%" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" bgcolor="#CCCCCC" class="indexbold">&nbsp;</td>
      <td bgcolor="#CCCCCC" class="indexbold">วัน เดือน ปี
        <input type="text" name="date1" value="<?=swapdate($datereq)?>" size="10">
          <input type=button NAME="d1" id="d1"  onclick='popUpCalendar(this, this.form.date1, "dd/mm/yyyy");' value='V' style='font-size:11px'>
          <input type="text" name="date2" value="<?=swapdate($datereq2)?>" size="10">
          <input type=button NAME="d2" id="d2"  onclick='popUpCalendar(this, this.form.date2, "dd/mm/yyyy");' value='V' style='font-size:11px'>
&nbsp;
        <input type="submit" name="Submit" value="   ค้นหา   ">
      </td>
      <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" bgcolor="#CCCCCC">&nbsp;</td>
      <td bgcolor="#CCCCCC"></td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
  </table>
</form></td>
</tr>
</table>


<table border=0 align=center cellspacing=1 cellpadding=2 bgcolor=black width="98%">
<tr bgcolor="#a3b2cc">
<th width="879" align="center">ชื่อ - นามสกุล</th>
<th width="319" align="center">จำนวนบุคลากรที่ทำการบันทึกข้อมูล</th>
</tr>
<?
$n0 = 1 ;
$sql0 = "select  
COUNT(keystaff.staffid) , keystaff.prename , keystaff.staffname , keystaff.staffsurname , keystaff.staffid
from  monitor_keyin  INNER JOIN  keystaff  ON  monitor_keyin.staffid = keystaff.staffid  WHERE timeupdate BETWEEN '$datereq1%' AND  '$datereq2%'  GROUP BY keystaff.staffid    ";
//echo "$sql0";
$result0 = mysql_db_query($dbcall,$sql0);
while ($rs0=mysql_fetch_assoc($result0)){
	if ($n0++ %  2){
		$bgcolor = "#F0F0F0";
	}else{
		$bgcolor = "#FFFFFF";
	}
	$name0 = "$rs0[prename]$rs0[staffname]  $rs0[staffsurname]";
?>

<?
$n = 0;
$sql = "select  COUNT(idcard) AS cnum
from   monitor_keyin  INNER JOIN  keystaff  ON  monitor_keyin.staffid = keystaff.staffid  WHERE
 keystaff.staffid = '$rs0[staffid]' AND   timeupdate BETWEEN '$datereq1%' AND  '$datereq2%'  group by keystaff.staffid  ";
//echo "$sql";
$result = mysql_db_query($dbcall,$sql);
$rs=mysql_fetch_assoc($result) ;
	if ($n++ %  2){
		$bgcolor = "#F0F0F0";
	}else{
		$bgcolor = "#FFFFFF";
	}
	$newdata ="";
	$name = "$rs[prename]$rs[staffname]  $rs[staffsurname]";
	if($rs[status_key]=="60"){$statusentry = "6 ปีย้อนหลัง";}elseif($rs[status_key]=="100"){$statusentry = "สมบูรณ์ 100%";}else{ $statusentry = "ไม่ระบุ";}
$sumex += 	$rs[cnum] ;
?>
<tr valign=top bgcolor="<?=$bgcolor?>">
<td class="login_right_exsum_blue" >&nbsp;  <?=$name0?>  </td>
<td align="center" valign="middle" class="login_right_exsum_blue" ><?=$rs[cnum]?></td>
</tr>
<?
} 
?>
<tr valign=top bgcolor="<?=$bgcolor?>">
  <td align="right" bgcolor="#A3B2CC" class="link_back" >รวม</td>
  <td align="center" valign="middle" bgcolor="#A3B2CC" class="link_back" ><?=number_format($sumex)?></td>
</tr>
</table>

<BR>
<BR>
</BODY>
</HTML>
