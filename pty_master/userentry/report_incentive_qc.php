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
			include ("epm.inc.php")  ;
			
			$curent_date = date("Y-m-d");
			$dbnameuse = DB_USERENTRY;
			$time_start = getmicrotime();
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = (intval($x[0])+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}
		## วันที่ปัจจุบัน
		$link_b = "1";// คลิ๊กย้อนกลับ
		$link_f = "1"; // คลิ๊กถัดไป
		$edate = date("Y-m-d");// วันที่สิ้นสุด
		$edate = "2010-01-28";
		$date_length = 7;
		$basedate = strtotime("$edate");
		$date1 = strtotime("-7 day", $basedate);
		$sdate = date("Y-m-d",$date1);// วันเริ่มต้น
		
		$date_length = 7; // ช่วงระยะเวลาความห่า่งของวัน
		$percen_cal = 17; // ความกว้างของคอล์ลัม
		
		
	function CheckMonitorKey($get_date){
		global $dbnameuse;
		$sql_m = "SELECT count(staffid) as nums FROM monitor_keyin WHERE timeupdate LIKE '$get_date%'";
		$result_m = mysql_db_query($dbnameuse,$sql_m);
		$rs_m = mysql_fetch_assoc($result_m);
		return $rs_m[nums];		
	}
	
###  funciton คำนวณค่าคะแนนในแต่ละวัน
	function CalPointKeyTotal($get_dates,$get_datee){
		global $dbnameuse;
		$sql = "SELECT sum(stat_user_keyin.numkpoint) as numval, staffid FROM `stat_user_keyin` WHERE stat_user_keyin.timeupdate BETWEEN  '$get_dates' AND '$get_datee' group by staffid";
		//echo $sql;
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
				$arr1[$rs[staffid]] = $rs[numval];
		}//end while($rs = mysql_fetch_assoc($result)){
	//		echo "<pre>";
//			print_r($arr1);
		return $arr1;
	}//end function CalPointKey($get_dates,$get_datee){
	
	function CalPointKeyDate($get_date){
		global $dbnameuse;
		$sql1 = "SELECT sum(stat_user_keyin.numkpoint) as numv, staffid FROM stat_user_keyin WHERE timeupdate LIKE '$get_date%' group by staffid";
		//echo $sql1."<br>";
		$result1  = mysql_db_query($dbnameuse,$sql1);
		while($rs1 = mysql_fetch_assoc($result1)){
				$arr2[$rs1[staffid]] = $rs1[numv];
		}
		//echo "<pre>";
		//print_r($arr2);
		return $arr2;
	}//end 	function CalPointKeyDate(){
		

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
          <td height="48" colspan="2" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" >รายงานผลคะแนนการบันทึกข้อมูล</td>
        </tr>
		   <tr>
          <td width="63%" class="headerTB">&nbsp;</td>
          <td width="37%">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
  <tr>
    <td rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ลำ<br>
    ดับที่</strong></td>
    <td rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ชื่อ - สกุล</strong></td>
    <td rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ID</strong></td>
    <td rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ID card</strong></td>
    <td width="8%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong><img src="../../images_sys/arrow_left_blue.png" alt="" width="16" height="16" border="0" style="cursor:hand" onClick="location.href='?action=black&link_b=<?=$link_b?>'"><br>
    Total (Bath)</strong></td>
    <?
	$numL=0;
    for($k1=1;$k1 <= $date_length;$k1++){
				$basedate = strtotime("$sdate");
				$date1 = strtotime("$k1 day", $basedate);
				$xsdate = date("Y-m-d",$date1);// วันเริ่มต้น
				if(CheckMonitorKey($xsdate) > 0){
			$numL++;
	?>
    <td height="24" colspan="3" align="center" bgcolor="#A3B2CC"><strong>
      <?=thaidate($xsdate)?>
    </strong></td>
   <?	
				}//end if(CheckMonitorKey($xsdate) > 0){
			}// end     for($k1=1;$k1 <= $date_length;$k1++){
   ?>
    <td rowspan="2" align="center" bgcolor="#A3B2CC"><strong><img src="../../images_sys/arrow_right_blue.png" width="16" height="16" border="0"  style="cursor:hand" onClick="location.href='?action=black&link_f=<?=$link_f?>'"></strong></td>
  </tr>
  <tr>
  <?
  		for($k2 = 1;$k2 <= $date_length;$k2++){
				$basedate2 = strtotime("$sdate");
				$date2 = strtotime("$k2 day", $basedate2);
				$xsdate2 = date("Y-m-d",$date2);// วันเริ่มต้น
				if(CheckMonitorKey($xsdate2) > 0){
					$xend_date = $xsdate2;
  ?>
    <td align="center" bgcolor="#A3B2CC"><strong>คะแนน</strong></td>
    <td height="24" align="center" bgcolor="#A3B2CC"><strong>หักคะแนน QC</strong></td>
    <td align="center" bgcolor="#A3B2CC"><strong>Incentiveสุธิ (บาท)</strong></td>
    <?
				}//end if(CheckMonitorKey($xsdate2) > 0){
		}//end for($k2 = 1;$k2 <= $date_length;$k2++){
	?>
  </tr>
  <?
	$sql_staff = "SELECT * FROM keystaff WHERE status_permit='YES' AND sapphireoffice='0' AND status_extra='NOR' AND period_time='am'";
	$result_staff = mysql_db_query($dbnameuse,$sql_staff);
	$i=0;
	while($rss = mysql_fetch_assoc($result_staff)){
	if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
	$arrvd_t = CalPointKeyTotal($sdate,$xend_date);
	
?>	
  <tr bgcolor="<?=$bg?>">
    <td width="3%" height="18" align="center"><?=$i?></td>
    <td width="15%"><? echo "$rss[prename]$rss[staffname]  $rss[staffsurname]"; ?></td>
      <td width="6%" align="center"><? echo "K".(substr($rss[staffid],-4));?></td>
      <td width="15%" align="center"><? echo "$rss[card_id]";?></td>
      <td align="center"><? echo number_format($arrvd_t[$rss[staffid]],2)?></td>
      <?
	  $width_col = $percen_cal/$numL; // หาความกว้างของคอล์ลัม
      for($k3 = 1;$k3 <= $date_length;$k3++){
		  	$basedate3 = strtotime("$sdate");
			$date3 = strtotime("$k3 day", $basedate3);
			$xsdate3 = date("Y-m-d",$date3);// วันเริ่มต้น
			if(CheckMonitorKey($xsdate3) > 0){
				$arrv_d = CalPointKeyDate($xsdate3);
	  ?>
      <td width="<?=$width_col?>%" align="center"><? echo number_format($arrv_d[$rss[staffid]],2);?></td>
	  <td width="<?=$width_col?>%" align="center">&nbsp;</td>
    <td width="<?=$width_col?>%" align="center">&nbsp;</td>
    <?
			}//end if(CheckMonitorKey($xsdate3) > 0){
	  }//end 
	?>
    <td width="2%" align="center">&nbsp;</td>
  </tr>
  <?
	}//end while(){
  ?>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>