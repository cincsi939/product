<?
	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20090703.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2009-07-03 09:49
	## Created By :		MR.SUWAT KHAMTUM
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20090703.002
	## Modified Detail :		จัดการผู้ใช้
	## Modified Date :		2009-07-03 09:49
	## Modified By :		MR.SUWAT KHAMTUM
	
set_time_limit(0);
include "epm.inc.php";
$report_title = "รายงานข้อมูลสถิติการคีย์ข้อมูล";
$key_old = "2009-10-01";

function NumPerKey($staffid,$datekeyin){
		global $dbnameuse,$key_old;
		$sql = "SELECT monitor_keyin.staffid, monitor_keyin.idcard, monitor_keyin.siteid FROM `monitor_keyin`
WHERE monitor_keyin.staffid =  '$staffid' AND(monitor_keyin.timestamp_key LIKE  '$datekeyin%' OR monitor_keyin.timeupdate  LIKE  '$datekeyin%' ) group by monitor_keyin.idcard ";
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$sqlc = "SELECT count(idcard) as num1  FROM `monitor_keyin` where idcard='$rs[idcard]' and timeupdate < '$key_old'  group by idcard;";
			$resultc = mysql_db_query($dbnameuse,$sqlc);
			$rsc = mysql_fetch_assoc($resultc);
			if($rsc[num1] > 0){// แสดงว่าเป็นข้อมูลเก่า
				$arr['old'] = $arr['old']+1;		
			}else{
				$arr['new'] = $arr['new']+1;
			}
		}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function NumPerKey($staffid,$datekeyin){

if($_GET['action'] == "process"){
	$sql_str = "SELECT * FROM stat_user_keyin_temp58 ";
	$result_str = mysql_db_query($dbnameuse,$sql_str);
	while($rss = mysql_fetch_assoc($result_str)){
		$arr1 = NumPerKey($rss[staffid],$rss[datekeyin]);
		$num_doc_old = $arr1['old'];
		$num_doc_new = $arr1['new'];
		$sql_update = "UPDATE stat_user_keyin_temp58 SET num_doc_old='$num_doc_old',num_doc_new='$num_doc_new'  WHERE staffid='$rss[staffid]' AND datekeyin='$rss[datekeyin]'";
		mysql_db_query($dbnameuse,$sql_update);
	}//end while($rss = mysql_fetch_assoc($result_str)){
		
$action = "";
}//end if($_GET['action'] == "process"){



?>
<html>
<head>
<title><?=$report_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<LINK href="../../common/style.css" rel=StyleSheet type="text/css">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
</head>
<body bgcolor="#EFEFFF">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="17" align="left" bgcolor="#A3B2CC"><strong><a href="?action=process">ประมวลผล</a> || รายงานค่าคะแนนสถิติการคีย์ข้อมูล</strong></td>
        </tr>
      <tr>
        <td width="3%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>วันที่</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>รหัส<br>
          พนักงาน</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ค่าคะแนน</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ค่าสุงสุด</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ค่าต่ำสุด</strong></td>
        <td width="9%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ค่าคะแนนกลาง</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>เปอร์เซนต์<br>
          เดิม</strong></td>
        <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>จำนวนชุด</strong></td>
        <td width="7%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>เปอร์เซนต์<br>
          ใหม่</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>สุ่มเปอร์<br>
          เซนต์เพิ่ม</strong></td>
        <td width="7%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ค่ากลางคูณ<br>
          เปอร์เซ็น</strong></td>
        <td width="8%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ความเร็ว<br>
          การคีย์ต่อนาที</strong></td>
        <td width="8%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>เวลา restart เครื่อง(นาที)</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ค่าประสิทธิ<br>
          ภาพเครื่อง</strong></td>
        <td width="5%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>คะแนน<br>
          ส่วนเพิ่ม</strong></td>
      </tr>
      <tr>
        <td width="4%" align="center" bgcolor="#A3B2CC"><strong>ชุดเ่ก่า</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>ชุดใหม่</strong></td>
        <td width="5%" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>
        </tr>
      <?
      	$sql = "SELECT * FROM stat_user_keyin_temp58 ORDER BY datekeyin ASC";
		$result = mysql_db_query($dbnameuse,$sql);
		$n=0;
		while($rs = mysql_fetch_assoc($result)){
			if ($n++ %  2) $bgcolor = "#F0F0F0"; else $bgcolor = "#FFFFFF";
			$difmaxmin = $rs[kmiduim]-$rs[minval];
			$maxp = number_format(($difmaxmin*100)/$rs[kmiduim],2);
			//$maxp = intval($rs[k_val_percen]);
			$sum_num = $rs[num_doc_old]+$rs[num_doc_new];
        		if($rs[num_doc_old] > 0){
						$px1 = ($rs[num_doc_old]/100)*$sum_num;
						$nump_old = $maxp*$px1; /// ค่าเปอร์เซนเพิ่มส่วนของชุดเก่า
						$nump_new = $sum_num-$nump_old; // เปอร์เซนส่วนเพิมสำหรับชุดใหม่
						
						$percen_add = ($nump_old*0.1)+($nump_new*1);
						#####
				}else{
						$percen_add =  $maxp;
				}//end if($rs[num_doc_old] > 0){

			$ranpercen = rand(1,$percen_add);
			$kval_percen = $rs[kmiduim]+(($rs[kmiduim]*$ranpercen)/100);
			$k_per_min = ($rs[kmiduim]/8)/60;
			$point_sub = $k_per_min*$rs[ksub];
			
			$sql_up = "UPDATE stat_user_keyin_temp58 SET random_percen='$ranpercen',point_subtract='$point_sub' WHERE datekeyin='$rs[datekeyin]' AND staffid='$rs[staffid]'";
			@mysql_db_query($dbnameuse,$sql_up);

	  ?>
      <tr bgcolor="<?=$bgcolor?>">
        <td align="center"><?=$rs[datekeyin]?></td>
        <td align="left"><?
        $sqlstaff = "SELECT * FROM keystaff WHERE staffid='$rs[staffid]'";
		$result_staff = mysql_db_query($dbnameuse,$sqlstaff);
		$rss = mysql_fetch_assoc($result_staff);
		echo "$rss[prename]$rss[staffname]  $rss[staffsurname]";
?>        
        </td>
        <td align="center"><?=$rs[numkpoint]?></td>
        <td align="center"><?=$rs[maxval]?></td>
        <td align="center"><?=$rs[minval]?></td>
        <td align="center"><?=$rs[kmiduim]?></td>
        <td align="center"><?=$maxp;?></td>
        <td align="center"><?=$rs[num_doc_old]?></td>
        <td align="center"><?=$rs[num_doc_new]?></td>
        <td align="center"><?=number_format($rs[num_doc_old]+$rs[num_doc_new]);?></td>
        <td align="center">
        <?
				echo number_format($percen_add,2);
		?>
        </td>
        <td align="center"><?=$ranpercen?></td>
        <td align="center"><?=number_format($kval_percen,2)?></td>
        <td align="center"><?=number_format($k_per_min,2)?></td>
        <td align="center"><?=number_format($rs[ksub])?></td>
        <td align="center"><?=number_format($point_sub,2);?></td>
        <td align="center"><?=number_format($kval_percen-$point_sub,2);?></td>
      </tr>
      <?
		}//end 
	  ?>
    </table></td>
  </tr>
</table>
<BR><BR>
</BODY>
</HTML>
