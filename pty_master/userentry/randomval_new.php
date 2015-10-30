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
$point_avg_old = "2.6";
$date_config = "2010-07-12"; // วันที่ที่ยกเว้น
function CountPerkey($staffid,$datekeyin,$numold=""){
	global $dbnameuse,$key_old;
	$sql = "SELECT num_old,num_new,ksub,numkpoint_per_min FROM pointkey WHERE staffid='$staffid' AND datekeyin='$datekeyin'";
	//echo $dbnameuse." :: ".$sql;
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	$sps = ($rs[ksub]*$rs[numkpoint_per_min]);// คะแนนลบ
		//echo " sub ::$sps <br>";die;
		if($numold != ""){
			$sps_per_num = $rs[num_old]/$sps;// ค่าคะแนนลบต่อชุด
		}else{
			
			$sps_per_num = $rs[num_new]/$sps;// ค่าคะแนนลบต่อชุด
		}
	
	return $sps_per_num;
}//end function CountPerkey($staffid,$datekeyin){
	
function UpdatePerCh($staffid,$idcard,$datekeyin,$xpoint=""){
	global $dbnameuse,$point_avg_old,$date_config;
	$sqlc1 = "SELECT FLOOR(TIMESTAMPDIFF(MONTH,begindate,'2553-09-30')/12) AS age_gov FROM tbl_checklist_kp7 WHERE idcard='$idcard'";
				$resultc1 = mysql_db_query("edubkk_checklist",$sqlc1);
				$rsc1 = mysql_fetch_assoc($resultc1);
						$sqlc2 = "SELECT point_avg FROM pointkey_avg WHERE age='$rsc1[age_gov]'";
						$resultc2 = mysql_db_query($dbnameuse,$sqlc2);
						$rsc2 = mysql_fetch_assoc($resultc2);
			if($xpoint != ""){
				$sps_per_num = CountPerkey($staffid,$datekeyin,"1");
					$num_per_doc = number_format(($point_avg_old+($point_avg_old*0.05))-$sps_per_num,2); // ค่าคะแนนสุทธิต่อชุด
				$sql_update = "UPDATE stat_user_keyperson SET numpoint='$num_per_doc'  WHERE datekeyin='$datekeyin' and staffid='$staffid' AND idcard='$idcard' ";
				//echo $sql_update.";<br>";
			}else{
					
			if($rsc2[point_avg] > 0){
					$sps_per_num = CountPerkey($staffid,$datekeyin);
					$num_per_doc = number_format(($rsc2[point_avg]+($rsc2[point_avg]*0.05))-$sps_per_num,2); // ค่าคะแนนสุทธิต่อชุด
					if($num_per_doc > 0){
						$sql_update = "UPDATE stat_user_keyperson SET numpoint='$num_per_doc'  WHERE datekeyin='$datekeyin' and staffid='$staffid' AND idcard='$idcard'  ";
						//echo $sql_update.";<br>";
						//mysql_db_query($dbnameuse,$sql_update);
					}
			}
		}//end if($xpoint != ""){
}//end 

function NumPerKey($staffid,$datekeyin){
		global $dbnameuse,$key_old,$date_config;
		$sql = "SELECT  staffid,datekeyin,idcard FROM stat_user_keyperson  WHERE staffid='$staffid' AND datekeyin='$datekeyin' GROUP BY idcard ";
	/*	$sql = "SELECT monitor_keyin.staffid, monitor_keyin.idcard, monitor_keyin.siteid FROM `monitor_keyin`
WHERE monitor_keyin.staffid =  '$staffid' AND(monitor_keyin.timeupdate  LIKE  '$datekeyin%'  OR monitor_keyin.timestamp_key LIKE '$datekeyin%')   group by monitor_keyin.idcard ";*/
///AND (timestamp_key NOT LIKE '2010-07-12%' AND staffid <> '10951') 
		$result = mysql_db_query($dbnameuse,$sql);
		while($rs = mysql_fetch_assoc($result)){
			$sqlc = "SELECT count(idcard) as num1  FROM `monitor_keyin` where idcard='$rs[idcard]' and timeupdate < '$key_old'  group by idcard";
			$resultc = mysql_db_query($dbnameuse,$sqlc);
			$rsc = mysql_fetch_assoc($resultc);
			if($rsc[num1] > 0){// แสดงว่าเป็นข้อมูลเก่า
				$arr['old'] = $arr['old']+1;		
			}else{
				UpdatePerCh($staffid,$rs[idcard],$datekeyin);
				$arr['new'] = $arr['new']+1;
				$sqlc1 = "SELECT FLOOR(TIMESTAMPDIFF(MONTH,begindate,'2553-09-30')/12) AS age_gov FROM tbl_checklist_kp7 WHERE idcard='$rs[idcard]'";
				$resultc1 = mysql_db_query("edubkk_checklist",$sqlc1);
				$rsc1 = mysql_fetch_assoc($resultc1);
				if($rsc1[age_gov] > 0){
						$sqlc2 = "SELECT point_avg FROM pointkey_avg WHERE age='$rsc1[age_gov]'";
						$resultc2 = mysql_db_query($dbnameuse,$sqlc2);
						$rsc2 = mysql_fetch_assoc($resultc2);
						$arr['point'] = $arr['point']+$rsc2[point_avg];
				}
			}
		}//end while($rs = mysql_fetch_assoc($result)){
	return $arr;
}//end function NumPerKey($staffid,$datekeyin){

if($_GET['action'] == "process"){
	$sql_str = "SELECT * FROM pointkey ";
	$result_str = mysql_db_query($dbnameuse,$sql_str);
	while($rss = mysql_fetch_assoc($result_str)){
		$arr1 = NumPerKey($rss[staffid],$rss[datekeyin]);
		$num_doc_old = $arr1['old'];
		$num_doc_new = $arr1['new'];
		$numkpoint_add_new = $arr1['point'];
		if($rss[numkpoint] > $numkpoint_add_new){
			$point_new = $rss[numkpoint];
		}else{
			$point_new = $numkpoint_add_new;
		}
		#########################3   
		if($num_doc_old > 0){
				$numkpoint_add_old = $num_doc_old*$point_avg_old;
		}else{
				$numkpoint_add_old = 0;
		}//end if($num_doc_old > 0){
			
//		if($rss[datekeyin] == $date_config){
//				$point_new = $rss[numkpoint];
//		}else{
//				$point_new = $point_new;
//		}
		
		$sql_update = "UPDATE pointkey  SET num_old='$num_doc_old',num_new='$num_doc_new',numkpoint_add_new='$point_new',numkpoint_add_old='$numkpoint_add_old'  WHERE staffid='$rss[staffid]' AND datekeyin='$rss[datekeyin]'";
		mysql_db_query($dbnameuse,$sql_update);
		

	}//end while($rss = mysql_fetch_assoc($result_str)){
		
echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); location.href='?action=';</script>";
		exit;
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
        <td colspan="11" align="left" bgcolor="#A3B2CC"><strong><a href="?action=process">ประมวลผล</a> || รายงานค่าคะแนนสถิติการคีย์ข้อมูล</strong></td>
        </tr>
      <tr>
        <td width="10%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>วันที่</strong></td>
        <td width="11%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>พนักงานคีย</strong>์</td>
        <td width="8%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ค่าคะแนน</strong></td>
        <td colspan="3" align="center" bgcolor="#A3B2CC"><strong>จำนวนชุด</strong></td>
        <td width="10%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>คะแนน<br>
          ส่วนเพิ่ม(ชุดใหม่)</strong></td>
        <td width="10%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>คะแนนส่วนเพิ่ม<br>
          (ชุดเก่า)</strong></td>
        <td width="6%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>
        <td width="9%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>ค่าประสิทธิ<br>
          ภาพเครือง(S1)</strong></td>
        <td width="8%" rowspan="2" align="center" bgcolor="#A3B2CC"><strong>คะแนนสุทธิ=<br>
        (รวม*0.05)-S1</strong></td>
      </tr>
      <tr>
        <td width="10%" align="center" bgcolor="#A3B2CC"><strong>ชุดเ่ก่า</strong></td>
        <td width="10%" align="center" bgcolor="#A3B2CC"><strong>ชุดใหม่</strong></td>
        <td width="8%" align="center" bgcolor="#A3B2CC"><strong>รวม</strong></td>
        </tr>
      <?
      	$sql = "SELECT * FROM pointkey ORDER BY datekeyin ASC";
		$result = mysql_db_query($dbnameuse,$sql);
		$n=0;
		while($rs = mysql_fetch_assoc($result)){
			if ($n++ %  2) $bgcolor = "#F0F0F0"; else $bgcolor = "#FFFFFF";

	  ?>
      <tr bgcolor="<?=$bgcolor?>">
        <td align="center"><?=$rs[datekeyin]?></td>
        <td align="left"><?
        $sqlstaff = "SELECT * FROM keystaff WHERE staffid='$rs[staffid]'";
		$result_staff = mysql_db_query($dbnameuse,$sqlstaff);
		$rss = mysql_fetch_assoc($result_staff);
		echo "$rss[prename]$rss[staffname]  $rss[staffsurname]";
		$point_sub = number_format($rs[numkpoint_per_min]*$rs[ksub],2);
?>        
        </td>
        <td align="center"><?=$rs[numkpoint]?></td>
        <td align="center"><?=$rs[num_old]?></td>
        <td align="center"><?=$rs[num_new]?></td>
        <td align="center"><?=number_format($rs[num_old]+$rs[num_new]);?></td>
        <td align="center"><?=number_format($rs[numkpoint_add_new],2);?></td>
        <td align="center"><?=number_format($rs[numkpoint_add_old],2);?></td>
        <td align="center"><?=number_format($rs[numkpoint_add_new]+$rs[numkpoint_add_old],2);?></td>
        <td align="center"><?=number_format($point_sub,2);?></td>
        <td align="center"><?
        $cal_point =$rs[numkpoint_add_new]+$rs[numkpoint_add_old]; // ค่าคะแนนรวม
		$cal_point_1 = $cal_point+($cal_point*0.05);
		echo number_format($cal_point_1-$point_sub,2)?></td>
      </tr>
      <?
	  $sql_up1 = "UPDATE pointkey SET netpoint='".number_format($cal_point_1-$point_sub,2)."' WHERE datekeyin='$rs[datekeyin]' AND staffid='$rs[staffid]'";
	  mysql_db_query($dbnameuse,$sql_up1);
		}//end 
	  ?>
    </table></td>
  </tr>
</table>
<BR><BR>
</BODY>
</HTML>
