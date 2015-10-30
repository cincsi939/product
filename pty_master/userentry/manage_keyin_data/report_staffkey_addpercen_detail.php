<?
session_start();
set_time_limit(0);
$ApplicationName	= "userentry";
$module_code 		= "manage_keyin_data"; 
$process_id			= "report_staffkey_addpercen";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110709.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-09 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110709.00
	## Modified Detail :		รายงานคะแนนเพิ่มการบันทึกข้อมูลของพนักงานคีย์ข้อมูล
	## Modified Date :		2011-07-09 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			require_once("../../../config/conndb_nonsession.inc.php");
			include ("../../../common/common_competency.inc.php")  ;
			include("../function_face2cmss.php");
			include("../function_date.php");
			include("../function_get_data.php");
			$k12 = 0.1051;
			$percenadd = 5;
			$date1 = "2011-06-27";
			$date2 = "2011-07-25";

			
			$count_yy = date("Y")+543;
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

			
			$time_start = getmicrotime();
			$arrsite = GetSiteKeyData();
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			
			
			
			
			
			
	function ShowStartdate($staffid){
	global $dbnameuse;
	$sql = "SELECT start_date FROM `keystaff` where staffid='$staffid' group by staffid";	
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	if($rs[start_date] != "" and $rs[start_date] != "0000-00-00"){
		return ShowDateThai($rs[start_date]);
	}else{
		return "";	
	}
}
			
			
		function ShowDateThai($get_date){
			global $monthFull;
			$arr = explode(" ",$get_date);
			if($arr > 1){
				$get_date = $arr[0];
			}
			if($get_date != "0000-00-00"){
				$arr1 = explode("-",$get_date);	
				return intval($arr1[2])." ".$monthFull[intval($arr1[1])]." ".($arr1[0]+543);
			}else{
				return "";	
			}
		}//end function ShowDateThai($get_date){

		
		
function GetReport(){
	global $dbnameuse,$date1,$date2;
	$sql = "SELECT
t1.staffid,
count(t1.datekeyin) as numday,
sum(t1.numkpoint) as numpoint,
sum(t1.kpoint_add5p) as numadd_k5,
sum(t1.netkpoint) as numadd_kd,
sum(t1.subtarct_val) as numsub,
sum(t1.kpoint_end) as numnet,
sum(t1.kpoint_end)/count(t1.datekeyin) as point_per_day
FROM stat_addkpoint_report as t1
WHERE t1.datekeyin BETWEEN '$date1' AND '$date2'
group by t1.staffid
order by 
point_per_day desc";	
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."".__LINE__);
		while($rs = mysql_fetch_assoc($result)){
				$arr[$rs[staffid]]['numday'] = $rs[numday];
				$arr[$rs[staffid]]['numpoint'] = $rs[numpoint];
				$arr[$rs[staffid]]['numadd_k5'] = $rs[numadd_k5];
				$arr[$rs[staffid]]['numadd_kd'] = $rs[numadd_kd];
				$arr[$rs[staffid]]['numsub'] = $rs[numsub];
				$arr[$rs[staffid]]['numnet'] = $rs[numnet];
				$arr[$rs[staffid]]['point_per_day'] = $rs[point_per_day];
		}// end while($rs = mysql_fetch_assoc($result)){
			return $arr;
}

?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="../../../common/jquery_1_3_2.js"></script>


<style type="text/css">
.txthead {	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
.txthead {	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #000;
	text-decoration: none; 
}
</style>
</HEAD>
<BODY >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="5" align="center" bgcolor="#FFFFFF"><strong>สถิติการบันทึกข้อมูลของ 
              <?=$fullname?>
            </strong></td>
            </tr>
          <tr>
            <td width="22%" align="right" bgcolor="#FFFFFF"><strong>คะแนนสุทธิรวมทั้งเดือน</strong></td>
            <td width="20%" align="left" bgcolor="#FFFFFF"><strong>
              <?=number_format($netpoint,2)?>
            </strong></td>
            <td width="10%" align="left" bgcolor="#FFFFFF"><strong>คะแนน</strong></td>
            <td colspan="2" align="left" bgcolor="#FFFFFF"><strong>อัตรางานเดือน เดือน กรกฎาคม 2554</strong></td>
            </tr>
          <tr>
            <td align="right" bgcolor="#FFFFFF"><strong>จำนวนวันทำงาน</strong></td>
            <td align="left" bgcolor="#FFFFFF"><strong>
              <?=number_format($numday)?>
            </strong></td>
            <td align="left" bgcolor="#FFFFFF"><strong>วัน</strong></td>
            <td width="34%" align="left" bgcolor="#FFFFFF"><strong> <? if($date_start != "" and $date_start != "0000-00-00"){ echo "วันที่เริ่มงาน ".ShowDateThai($date_start);}else{ echo "";}?></strong></td>
            <td width="14%" align="left" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" valign="middle" bgcolor="#FFFFFF"><strong>คะแนนเฉลี่ยต่อวัน</strong></td>
            <td align="left" valign="middle" bgcolor="#FFFFFF"><strong>
              <?=number_format($pointday,2)?>
            </strong></td>
            <td align="left" valign="middle" bgcolor="#FFFFFF"><strong>คะแนน</strong></td>
            <td colspan="2" align="center" bgcolor="#FFFFFF">
              <?
            if($pointday >= 240){
					$salary =  number_format(7000);
			}else if($pointday>= 210 and $pointday < 240){
					$salary = number_format(6500);
			}else {
					$salary = number_format(6000);
			}
				echo "<h1>$salary บาท</h1>";

			
			?>
            </td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td width="10%" rowspan="2" align="center" bgcolor="#999999"><strong>วันที่</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#999999"><strong>คะแนนดิบ</strong></td>
        <td colspan="2" align="center" bgcolor="#999999"><strong>แต้มต่อการบันทึกข้อมูลโดยใช้ไฟล์ PDF</strong></td>
        <td colspan="3" align="center" bgcolor="#999999"><strong>แต้มต่อ<span class="txthead">ค่าสัมประสิทธิการประมวลผล
Server ช้า</span></strong></td>
        <td width="9%" rowspan="2" align="center" bgcolor="#999999"><span class="txthead">ชดเชยเนื่อง<br>
จากปิดระบบ</span></td>
        <td width="8%" rowspan="2" align="center" bgcolor="#999999"><strong>คะแนนก่อน<br>
          หักจุดผิด</strong></td>
        <td width="8%" rowspan="2" align="center" bgcolor="#999999"><strong>คะแนน สปส.<br>
          (ตรวจคำผิด)</strong></td>
        <td width="9%" rowspan="2" align="center" bgcolor="#999999"><strong>คะแนน<br>
          สุทธิรายวัน</strong></td>
      </tr>
      <tr>
        <td width="10%" align="center" bgcolor="#999999"><span class="txthead">ค่า K(5%)</span></td>
        <td width="13%" align="center" bgcolor="#999999"><strong>คะแนน(+K5%)</strong></td>
        <td width="7%" align="center" bgcolor="#999999"><strong>k.daily(%)</strong></td>
        <td width="8%" align="center" bgcolor="#999999"><strong>คะแนน k.daily</strong></td>
        <td width="12%" align="center" bgcolor="#999999"><strong>คะแนน(+k.daily)</strong></td>
        </tr>
        <?
        	$sql = "SELECT
t1.staffid,
t1.datekeyin,
t1.numkpoint,
t1.k5percen,
t1.kpoint_add5p,
t1.k_date,
t1.v_k_date,
t1.vk_serverdown,
t1.point_addserver,
t1.netkpoint,
t1.subtarct_val,
t1.kpoint_end
FROM stat_addkpoint_report as t1
where t1.staffid='$staffid' and t1.datekeyin between '$date1' and '$date2'
order by 
t1.datekeyin ASC";
//echo $sql;
	$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
	$i=0;
	while($rs = mysql_fetch_assoc($result)){
		 if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
		?>
      <tr bgcolor="<?=$bg?>">
        <td align="left">&nbsp;          <?=ShowDateThai($rs[datekeyin])?></td>
        <td align="center"><?=number_format($rs[numkpoint],2)?></td>
        <td align="center"><?=number_format($rs[k5percen],2)?></td>
        <td align="center"><?=number_format($rs[kpoint_add5p],2)?></td>
        <td align="center"><?=number_format($rs[k_date],2)?></td>
        <td align="center"><?=number_format($rs[v_k_date],2)?></td>
        <td align="center"><?=number_format($rs[netkpoint],2)?></td>
        <td align="center"><?=number_format($rs[vk_serverdown],2)?></td>
        <td align="center"><?=number_format($rs[point_addserver],2)?></td>
        <td align="center"><?=number_format($rs[subtarct_val],2)?></td>
        <td align="center"><?=number_format($rs[kpoint_end],2)?></td>
      </tr>
      <?
	}//end while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end);
	$timeprocess = ($time_end - $time_start);
	echo "เวลาในการประมวลผล :: $timeprocess";
?>
