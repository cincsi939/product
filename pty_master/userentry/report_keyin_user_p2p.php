<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName= "AdminReport";
$module_code = "statuser";
$process_id = "display";
$VERSION = "9.1";
$BypassAPP= true;
#########################################################
#Developer::Pairoj
#DateCreate::29/03/2007
#LastUpdate::29/03/2007
#DatabaseTable::schooll_name, login
#END
#########################################################
//session_start();
			set_time_limit(8000);
			include ("../../common/common_competency.inc.php")  ;
			include("../../config/conndb_nonsession.inc.php");
			include ("../../common/std_function.inc.php")  ;
			include ("cal_data.inc.php")  ;
			
			
			$time_start = getmicrotime();

	
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$date1 = swapdate($date1);
		$datereq1 = $date1 ;
		$exday = explode("-",$date1);
		$datereq = ($exday[0]+543)."-$exday[1]-$exday[2]";
		
		
	}else{
		
		$dd = date("d");
		$mm = date("m");
		$dd2 = $dd-1;
		$yy=date("Y");
		$yy += 543;
		$dd = sprintf("%02d",intval($dd));
		$dd2 = sprintf("%02d",intval($dd2));
		$mm = sprintf("%02d",intval($mm));
		$datereq = "$yy-$mm-$dd";
		$datereq1 = ($yy-543)."-$mm-$dd";
		$datereq2 = "$yy-$mm-$dd2";
		$round = "am" ;
		
	}

	if($round == "am"){
		$checked1 = "checked" ;
		$checked2 = "" ;
	}else{
		$checked1 = "" ;
		$checked2 = "checked" ;
	}

$sql_d  = " SELECT
keyin_point.keyid,
keyin_point.tablename,
keyin_point.keyname,
keyin_point.keyword_detail,
keyin_point.def_point,
keyin_point.keyinpoint,
table_price.id,
table_price.price_point
FROM
keyin_point
Inner Join table_price ON table_price.tablename = keyin_point.tablename ";
//echo $sql_d;
$result_d = mysql_db_query($dbcall,$sql_d);
while ($rs_d=mysql_fetch_assoc($result_d)){
	$x_val[$rs_d[tablename]] = $rs_d[price_point] ;
	$x_val_point[$rs_d[tablename]][$rs_d[keyname]] = $rs_d[keyinpoint] ;
}
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language='javascript' src='../../common/popcalendar.js'></script>
<SCRIPT SRC="sorttable.js"></SCRIPT>
<script language="javascript">

</script>
</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" colspan="2" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px">รายงานสถิติการบันทึกข้อมูล</td>
        </tr>
		   <tr>
          <td width="63%" class="headerTB">&nbsp;</td>
          <td width="37%">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
	  <form name="form" method="post" action="">
	<table width="100%" height="19" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="13%" align="right" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="59%" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="28%" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
      
      <tr>
        <td align="right" bgcolor="#CCCCCC" class="indexbold">&nbsp;</td>
        <td bgcolor="#CCCCCC" class="indexbold">วัน เดือน ปี
          <input type="text" name="date1" value="<?=swapdate($datereq)?>" size="10">
            <input type=button NAME="d1" id="d1"  onclick='popUpCalendar(this, this.form.date1, "dd/mm/yyyy");' value='V' style='font-size:11px'>
            &nbsp;
            <input type="submit" name="Submit" value="   ค้นหา   ">		  </td>
        <td align="center" bgcolor="#CCCCCC"><a href="CC_keyin_user.inc.php" target="_blank"></a></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#CCCCCC">&nbsp;</td>
        <td bgcolor="#CCCCCC"><input name="show_detail" type="checkbox" id="show_detail" value="1"  <? if($show_detail==1){echo "checked=\"checked\"";}?>>
        แสดงรายละเอียด</td>
        <td bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
    </table>
      </form>    
<? if($action==""){?>
<table border=0 align=center cellspacing=1 cellpadding=2 bgcolor=black width="100%" class="sortable" id="unique_id">
<tr bgcolor="#a3b2cc">
<th width=65>ลำดับ</th>
<th width="372">รายการ</th>
<th width="139">เลขบัตรประชาชน</th>
<th width="119">รหัสพื้นที่</th>
<th width=126>สถานะการรับรอง</th>
<th width=143>ค่าบันทึก(บาท)</th>
</tr>
<?
$n0 = 1 ;$sum_staff_val = array();
$sql0 = "select  
COUNT(keystaff.staffid) , keystaff.prename , keystaff.staffname , keystaff.staffsurname , keystaff.staffid
from  monitor_keyin  INNER JOIN  keystaff  ON  monitor_keyin.staffid = keystaff.staffid  WHERE
  timeupdate LIKE '$datereq1%'  GROUP BY keystaff.staffid      ";

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
<tr valign=top bgcolor="<?=$bgcolor?>">
  <td colspan="5" bgcolor="#5C85EF" class="headerTB" >&nbsp;<?=$name0?></td>
  <td align=center bgcolor="#5C85EF">&nbsp;</td>
  </tr>

<?
$n = 0;
$sql = "select  
*
from  monitor_keyin  INNER JOIN  keystaff  ON  monitor_keyin.staffid = keystaff.staffid  WHERE
 keystaff.staffid = '$rs0[staffid]' AND  timeupdate LIKE '$datereq1%'     ";
//echo "$sql";
$result = mysql_db_query($dbcall,$sql);
while ($rs=mysql_fetch_assoc($result)){
$dbsite = STR_PREFIX_DB.$rs[siteid] ;
	if ($n++ %  2){
		$bgcolor = "#F0F0F0";
	}else{
		$bgcolor = "#FFFFFF";
	}
	$newdata ="";
	$namestaff[$rs[staffid]] = $name = "$rs[prename]$rs[staffname]  $rs[staffsurname]";
	
	
	if($rs[status_key]=="60"){$statusentry = "6 ปีย้อนหลัง";}elseif($rs[status_key]=="100"){$statusentry = "สมบูรณ์ 100%";}else{ $statusentry = "ไม่ระบุ";}
	if($rs[status_approve]=="1"){$statusapprove = "approve";}else{ $statusapprove = "<font color=#FFFF00><b>waiting</b></font>";}
	if( $statusentry != "ไม่ระบุ" && $rs[status_approve]!="1" ){ $newdata = "<img src=\"../../images_sys/new.gif\" width=\"38\" height=\"20\">";}else{	
		if($rs[status_approve] != 0){
	 		$newdata ="<img src=\"images/b_drop.png\" alt=\"ล้างสถานะ\" width=\"16\" height=\"16\" border=\"0\" onClick=\"MM_openBrWindow('del_user_entry.php?action=delete&idcard=$rs[idcard]&staffid=$rs[staffid]','','width=900,height=330,scrollbars=Yes,resizable=Yes,status=Yes')\" style=\"cursor:hand\">";
		} else{
			$newdata ="";
		}
	 }
?>
<tr valign=top bgcolor="<?=$bgcolor?>">
<td align=center ><?=$n?></td>
<td >&nbsp;<?=$rs[keyin_name]?></td>
<td align="center" valign="middle" ><?=$rs[idcard]?></td>
<td align="center" valign="middle" ><?=$rs[siteid]?></td>
<td align=center><?=$statusapprove?></td>
<td align=center>&nbsp;</td>
</tr>
<?

foreach($arr_tbl1 AS $tbl => $lable1){

$resultkeyin = array();
$val_sum_point = 0 ;
$sqlx1 = " SELECT  *  FROM  ".$tbl."_log_after  WHERE  id = '$rs[idcard]' AND staffid = '$rs[staffid]'  ";
$resultx1  = mysql_db_query($dbsite,$sqlx1);
while($rsx1 = mysql_fetch_assoc($resultx1)){

$sqlx2 = " SELECT  *  FROM  ".$tbl."_log_before  WHERE   auto_id='$rsx1[auto_id]' ";
$resultx2  = mysql_db_query($dbsite,$sqlx2);
$rsx2 = mysql_fetch_assoc($resultx2);

//$sqlx3 = " SHOW  COLUMNS FROM $tbl   WHERE  `Key`= 'PRI' ";
//echo $sqlx3."<br>";
//$resultx3 = mysql_db_query($dbsite,$sqlx3);
//while($rsx3 = mysql_fetch_assoc($resultx3)){
//	$key_a .= $rsx1[$rsx3[Field]];
//	echo "$key_a <br>";
//}



$resultx0 = array_diff_assoc($rsx1, $rsx2);
	if($resultx0){
		//echo $sqlx1."<br>";
		//echo $sqlx2."<br><pre>";
		//print_r($rsx1);
		//print_r($rsx2);
//		echo "<pre>";
//		print_r($resultx0);
		
		if(isset($resultkeyin[$rsx1[auto_id]])){
			$resultkeyin[$rsx1[auto_id]] =   array_merge($resultkeyin[$rsx1[auto_id]], $resultx0);
		}else{
			$resultkeyin[$rsx1[auto_id]] = $resultx0 ;
		}
//		echo "<hr>$tbl :<br><pre>";
//		print_r($resultkeyin);
//		echo "<br>";
	}

}
	$val_sum_point = 0 ;
	foreach($resultkeyin AS $k1 => $v1){
	//echo "<hr>";
		foreach($v1 AS $k2 => $v2){
			$val_point  =  $x_val_point[$tbl][$k2] * $x_val[$tbl]; 
			$val_sum_point  =  $val_sum_point  + $val_point;
			//echo " $k2  : $v2 = ".$x_val_point[$tbl][$k2]." * $x_val[$tbl] <br> " ;
		}
	}
 
 		$sum_staff_val[$rs[staffid]] +=   $val_sum_point ;
		//echo $rs[staffid]."  " .$sum_staff_val[$rs[staffid]]."   ".$val_sum_point."<hr>" ;

 if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
 if($show_detail==1){
?>
    <tr bgcolor="#<?=$bgcolor1?>">
	<td width=65>&nbsp;</td>
	<td width="372">&nbsp;&nbsp; - <?=$lable1?></td>
	<td width="139"></td>
	<td width="119"></td>
	<td width=126></td>
	<td width=143 align="right"><?=$val_sum_point?></td>
  </tr>
  <?
   } //end show detail
   } // end list Value
}
} 
?>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
  <tr>
    <td width="6%" align="center" bgcolor="#5C85EF" class="link_back">ลำดับ</td>
    <td width="35%" align="center" bgcolor="#5C85EF" class="link_back">ชื่อ</td>
    <td width="59%" align="center" bgcolor="#5C85EF" class="link_back">สรุปรายได้</td>
  </tr>
  <? 
  $n =1; 
  foreach($sum_staff_val AS $key=>$value){  
  if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}?>
  <tr bgcolor="#<?=$bgcolor1?>">
    <td align="center"><?=$n?></td>
    <td>&nbsp;<?=$namestaff[$key]?></td>
    <td align="center">&nbsp;<?=number_format($value,2)?></td>
  </tr>
  <? $sumrow += $value; $n++; } ?>
  <tr>
    <td align="right" bgcolor="#5C85EF" class="link_back">&nbsp;</td>
    <td align="center" bgcolor="#5C85EF" class="link_back">รวม</td>
    <td align="center" bgcolor="#5C85EF" class="link_back"><?=number_format($sumrow,2)?></td>
  </tr>
</table>
<? } ?>
</BODY></HTML>