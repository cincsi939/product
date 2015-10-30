<?
#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
session_start();
set_time_limit(0);
$ApplicationName	= "AdminReport";
$module_code 		= "statuser"; 
$process_id			= "display";
$VERSION 				= "9.91";
$BypassAPP 			= true;

	###################################################################
	## COMPETENCY  MANAGEMENT SUPPORTING SYSTEM
	###################################################################
	## Version :		20110701.001 (Created/Modified; Date.RunNumber)
	## Created Date :		2011-07-01 09:49
	## Created By :		Suwat
	## E-mail :			suwat@sapphire.co.th
	## Tel. :			086-1989322
	## Company :		Sappire Research and Development Co.,Ltd. (C)All Right Reserved
	###################################################################
	## Version :		20110701.00
	## Modified Detail :		รายงานข้อมูลการบันทึกข้อมูลของพนักงานคีย์ข้อมูล
	## Modified Date :		2011-07-01 09:49
	## Modified By :		MR.SUWAT KHAMTUM
###################################################################
			

			include ("../../common/common_competency.inc.php")  ;
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			include("function_face2cmss.php");
			$time_start = getmicrotime();
			$point_per_doc = 69; // ค่าคะแนต่อชุด
			$arrsite = GetSiteKeyData();
			
			ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 
			$idcard_ex = GetCard_idExcerent();// เลขบัตรประจำตัวประชาชนของกลุ่ม excerent
			
			function GetShowGroupname(){
				global $dbnameuse;
				$sql = "SELECT keystaff_group.groupname, keystaff_group.groupkey_id FROM `keystaff_group`  ";
				$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql :: ".__LINE__);	
				while($rs = mysql_fetch_assoc($result)){
						$arr[$rs[groupkey_id]] = $rs[groupname];
				}//end while($rs = mysql_fetch_assoc($result)){
					return $arr;
			}//end 	function GetShowGroupname(){
				
			function GetShowGroupnameN(){
				global $dbnameuse;
				$sql = "SELECT keystaff_group_report.groupreport_name, keystaff_group_report.r_point FROM `keystaff_group_report` where  r_point > 0";	
				$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
				while($rs = mysql_fetch_assoc($result)){
					$arr[$rs[r_point]] = $rs[groupreport_name];	
				}//end while($rs = mysql_fetch_assoc($result)){
					return $arr;
			}//end function GetShowGroupnameN(){
				
				
	function GetPointStaffOut($staffid){
			global $dbnameuse;
			$sql = "SELECT
t1.staffid,
sum(t2.numkpoint) as numpoint,
sum(t3.spoint* if(t2.rpoint > 0,t2.rpoint,t3.point_ratio)) as sub_numpoint,
count(distinct t2.datekeyin) as numday
FROM
keystaff as t1 Inner Join 
stat_user_keyin as t2  ON t1.staffid=t2.staffid
left Join stat_subtract_keyin as t3 ON t2.datekeyin = t3.datekey AND t2.staffid = t3.staffid
where t1.staffid='$staffid' ";	
		$result = mysql_db_query($dbnameuse,$sql) or die(mysql_error()."$sql<br>LINE__".__LINE__);
		$rs = mysql_fetch_assoc($result);
		$arr['numpoint'] = $rs[numpoint];
		$arr['sub_numpoint'] = $rs[sub_numpoint];
		$arr['numday'] = $rs[numday];
		return $arr;
		
	}

			
?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<script language="javascript" src="../../common/jquery_1_3_2.js"></script>

</HEAD>
<BODY >
<?		


				if($site_id != "999"){
					$in_pin = GetPinStaff($site_id);
					ConHost(HOST,USERNAME_HOST,PASSWORD_HOST); 	
					if($in_pin != ""){
						$con_idcard = " AND t1.card_id IN($in_pin)";	
					}else{
						$con_idcard = " AND t1.staffid=''";	
					}
				}//end if($site_id != "999"){

	

	if($groupreport_id == "1"){ // กลุ่ม E
	
		$con1 = " and t2.group_id='2' ";
		if($idcard_ex != ""){
				$con1_1 = " and t1.card_id IN($idcard_ex)";
		}
		
			
	}else if($groupreport_id == "2"){
		$con1 = " and t2.group_id='2' ";
		if($idcard_ex != ""){
				$con1_1 = " and t1.card_id NOT IN($idcard_ex)";
		}

	}else{
		$con1 = " and t2.group_id='3'  AND t2.ratio_id='$rpoint'";
	}



	if($r == "N"){
		$arrc = explode("||",$condate1);	
		$arrc1 = explode("||",$condate2);	
		
		if(count($arrc) > 1){
				//$conv_date = "AND t2.datekeyin between '".$arrc[0]."' AND '".$arrc[1]."'"; 
				//$conv_date1 = "AND t2.datekeyin between '".$arrc1[0]."' AND '".$arrc1[1]."'"; 
				
				//$conv_date = " AND ((t1.start_date <= '".$arrc[1]."' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ) or ( t1.status_permit='NO' AND t1.retire_date > '".$arrc[0]."' and  t1.start_date between '".$arrc[0]."' and '".$arrc[1]."'))";
				
			//	$conv_date1 = " AND ((t1.start_date <= '".$arrc1[1]."' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ))";
				
				
					$conv_date = " AND t2.date_start <= '".$arrc[0]."' AND t2.date_end >= '".$arrc[1]."' ";	
					$conv_date1 = " AND t2.date_start <= '".$arrc1[0]."' AND t2.date_end >= '".$arrc1[1]."' ";	
				
				
				$xhead = "ข้อมูลพนักงานที่ลาออกไประหว่างวันที่ ".DBThaiLongDateFull($arrc1[0])." ถึง ".DBThaiLongDateFull($arrc1[1])."".$arrsite[$site_id];
		}else{
				//$conv_date = " AND t2.datekeyin LIKE '".$arrc[0]."%'";					
				//$conv_date1 = " AND t2.datekeyin LIKE '".$arrc1[0]."%'";	
				
		
					$conv_date = " AND concat(t2.staff_yy,"."'-'".",t2.staff_mm) LIKE '".$arrc[0]."'";		
					$conv_date1 = " AND concat(t2.staff_yy,"."'-'".",t2.staff_mm) LIKE '".$arrc1[0]."'";	
			


				
				$arrd1 = explode("-",$arrc1[0]);
				$xhead = " รายงานข้อมูลพนักงานที่ลาออกไปเดือน  ".$monthname[intval($arrd1[1])]." พ.ศ. ".($arrd1[0]+543)."  ".$arrsite[$site_id];	
		}
	}else{
		
		$arrc = explode("||",$condate1);	
		$arrc1 = explode("||",$condate2);	
		
		if(count($arrc) > 1){
			//	$conv_date1 = "AND t2.datekeyin between '".$arrc[0]."' AND '".$arrc[1]."'"; 
				//$conv_date = "AND t2.datekeyin between '".$arrc1[0]."' AND '".$arrc1[1]."'"; 
				
				
				//$conv_date1 = " AND ((t1.start_date <= '".$arrc[1]."' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ) or ( t1.status_permit='NO' AND t1.retire_date > '".$arrc[0]."' and  t1.start_date between '".$arrc[0]."' and '".$arrc[1]."'))";
				
				
				//$conv_date = " AND ((t1.start_date <= '".$arrc1[1]."' AND t1.status_permit='YES' and t1.start_date IS NOT NULL ))";

					$conv_date1 = " AND t2.date_start <= '".$arrc[0]."' AND t2.date_end >= '".$arrc[1]."' ";	
					$conv_date = " AND t2.date_start <= '".$arrc1[0]."' AND t2.date_end >= '".$arrc1[1]."' ";	

				
				
				
				$xhead = "ข้อมูลพนักงานที่เพิ่มระหว่างวันที่ ".DBThaiLongDateFull($arrc1[0])." ถึง ".DBThaiLongDateFull($arrc1[1])."".$arrsite[$site_id];
		}else{
				//$conv_date1 = " AND t2.datekeyin LIKE '".$arrc[0]."%'";	
				//$conv_date = " AND t2.datekeyin LIKE '".$arrc1[0]."%'";	
				
							

					$conv_date1 = " AND concat(t2.staff_yy,"."'-'".",t2.staff_mm) LIKE '".$arrc[0]."'";		
					$conv_date = " AND concat(t2.staff_yy,"."'-'".",t2.staff_mm) LIKE '".$arrc1[0]."'";	
				
				
				
				$arrd1 = explode("-",$arrc[0]);
				$xhead = " รายงานข้อมูลพนักงานที่เพิ่มเข้ามาเดือน  ".$monthname[intval($arrd1[1])]." พ.ศ. ".($arrd1[0]+543)."  ".$arrsite[$site_id];	
		}

			
	}//end if($r == "N"){
		
	$sqlc1 = "SELECT t1.staffid FROM keystaff as t1 Inner Join keystaff_history as t2 ON t1.staffid=t2.staffid  WHERE t1.period_time='am' $con1 $con_idcard 
	$conv_date1 $con1_1	 GROUP BY t1.staffid ";
	$result1 = mysql_db_query($dbnameuse,$sqlc1) or die(mysql_error()."$sqlc1<br>LINE__".__LINE__);
	while($rs1 = mysql_fetch_assoc($result1)){
			if($in_staff > "") $in_staff .= ",";
			$in_staff .= "'$rs1[staffid]'";
	}//end while($rs1 = mysql_fetch_assoc($result1)){
		
	if($in_staff != ""){
			$con_instaff = " AND t1.staffid NOT IN($in_staff)";
	}else{
			$con_instaff = "";
	}
	
//echo " จน. :: ".	intval($numstaff);
	
	if($numstaff > 0){
		$xlimit = " LIMIT $numstaff ";	
	}else{
		$numstaff = $numstaff*-1;
		$xlimit = " LIMIT $numstaff ";	
	}
	
	//$sql_staff = "SELECT * FROM keystaff as t1 Inner Join stat_user_keyin AS t2 ON t1.staffid=t2.staffid  WHERE t1.period_time='am' and t1.status_extra='NOR' $con1 $con_idcard 
	//$conv_date $con1_1	$con_instaff  GROUP BY t1.staffid  ORDER BY t1.staffname ASC $xlimit";
	
	$sql_staff = "SELECT * FROM keystaff as t1 Inner Join  keystaff_history as t2 ON t1.staffid=t2.staffid   WHERE t1.period_time='am'  $con1 $con_idcard 
	$conv_date $con1_1	$con_instaff   GROUP BY t1.staffid ORDER BY t1.staffname ASC $xlimit";
	//echo $sql_staff;
	
	$arr_g = GetShowGroupname();
	$arr_g1 = GetShowGroupnameN();	
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td colspan="13" align="center" bgcolor="#A5B2CE"><strong><?=$xhead?></strong></td>
        </tr>
      <tr>
        <td width="3%" align="center" bgcolor="#A5B2CE"><strong>ลำดับ</strong></td>
        <td width="6%" align="center" bgcolor="#A5B2CE"><strong>รหัสพนักงาน</strong></td>
        <td width="6%" align="center" bgcolor="#A5B2CE"><strong>โคดพนักงาน</strong></td>
        <td width="11%" align="center" bgcolor="#A5B2CE"><strong>เลขบัตรประชาชนพนักงาน</strong></td>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>ชื่อนาม - นามสกุล</strong></td>
        <td width="7%" align="center" bgcolor="#A5B2CE"><strong>กลุ่มพนักงาน</strong></td>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>วันเริ่มทำงาน</strong></td>
        <td width="7%" align="center" bgcolor="#A5B2CE"><strong>วันที่ออกงาน</strong></td>
        <td width="9%" align="center" bgcolor="#A5B2CE"><strong>จำนวนวันทำงาน</strong></td>
        <td width="7%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตรวม(ชุด)</strong></td>
        <td width="8%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตเฉลี่ย<br>
          ต่อวัน(ชุด)</strong></td>
        <td width="8%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตรวม<br>
          (คะแนน)</strong></td>
        <td width="10%" align="center" bgcolor="#A5B2CE"><strong>ผลผลิตเฉลี่ยต่อวัน<br>
          (คะแนน)</strong></td>
      </tr>
      <?
      	$result = mysql_db_query($dbnameuse,$sql_staff) or die(mysql_error()."$sql_staff<br>LINE__".__LINE__);
		$i=0;
		while($rs = mysql_fetch_assoc($result)){
			if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			
		$arr_po = GetPointStaffOut($rs[staffid]);
		$point_net = $arr_po['numpoint']-$arr_po['sub_numpoint'];// คะแนนสุทธิที่ักจุดผิดแล้ว
		$point_avg_net = $point_net/$arr_po['numday']; // ผลผลิตเฉลี่ยต่อวัน(คะแนน)
		
		$pointdoc = $point_net/$point_per_doc; // ผลผลิตรวม(ชุด)
		$pointdoc_avg = $pointdoc/$arr_po['numday']; // ผลผลิตเฉลี่ยต่อวัน(ชุด)

		
			
	  ?>
      <tr bgcolor="<?=$bg?>">
        <td align="center"><?=$i?></td>
        <td align="left"><?=$rs[staffid]?></td>
        <td align="center"><?=$rs[id_code]?></td>
        <td align="center"><?=$rs[card_id]?></td>
        <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
        <td align="left"><? if($rs[ratio_id] > 0){ echo $arr_g1[$rs[ratio_id]];}else{ echo $arr_g[$rs[keyin_group]];}?></td>
        <td align="left"><?=DBThaiLongDateFull($rs[start_date]);?></td>
        <td align="left"><?=DBThaiLongDateFull($rs[retire_date]);?></td>
        <td align="center"><?=$arr_po['numday']?></td>
        <td align="center"><?=number_format($pointdoc,2);?></td>
        <td align="center"><?=number_format($pointdoc_avg,2);?></td>
        <td align="center"><?=number_format($point_net,2);?></td>
        <td align="center"><?=number_format($point_avg_net,2);?></td>
      </tr>
      <?
	  
	  	unset($arr_po);
		$point_net = 0;// คะแนนสุทธิที่ักจุดผิดแล้ว
		$point_avg_net = 0; // ผลผลิตเฉลี่ยต่อวัน(คะแนน)
		$pointdoc = 0; // ผลผลิตรวม(ชุด)
		$pointdoc_avg =0; // ผลผลิตเฉลี่ยต่อวัน(ชุด)
		}//end 	while($rs = mysql_fetch_assoc($result)){
	  ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
