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
			include ("../../common/std_function.inc.php")  ;
			include ("epm.inc.php")  ;
			
			$curent_date = date("Y-m-d");
			$dbnameuse = "edubkk_userentry";
			$time_start = getmicrotime();
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			
			if($sdate == ""){
					$sdate = date("d/m/").(date("Y")+543);
			}


			
			function thaidate($temp){
				global $mname;
				$temp1 = explode(" ",$temp);
				$x = explode("-",$temp1[0]);
				$m1 = $mname[intval($x[1])];
				$d1 = (intval($x[0])+543);
				$xrs = intval($x[2])." $m1 "." $d1 ".$temp1[1];
				return $xrs;
			}


function DateSaveDB($temp){
		if($temp != ""){
				$arr1 = explode("/",$temp);
				return ($arr1[2]-543)."-".$arr1[1]."-".$arr1[0];
		}//end 	if($temp != ""){
}// end function DateSaveDB($temp){
function DateView($temp){
	if($temp != ""){
			$arr1 = explode("-",$temp);
			return $arr1[2]."/".$arr1[1]."/".($arr1[0]+543);
	}
		
}// end function DateView($temp){


function ShowSubtract($get_date,$get_staffid){
		global $dbnameuse;
		$sqlS = "SELECT spoint  FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date'";
		$resultS = mysql_db_query($dbnameuse,$sqlS);
		$rsS = mysql_fetch_assoc($resultS);
		return $rsS[spoint];
}//end function ShowSubtract(){
	
	function ShowSubtractAvg($get_date,$get_staffid){
		global $dbnameuse;
		$sqlS = "SELECT spoint  FROM stat_subtract_keyin_avg WHERE staffid='$get_staffid' AND datekey='$get_date'";
		$resultS = mysql_db_query($dbnameuse,$sqlS);
		$rsS = mysql_fetch_assoc($resultS);
		return $rsS[spoint];
}//end function ShowSubtract(){

	
function ShowSubtractBdate($get_staffid,$get_date){
	global $dbnameuse;
	$sql1 = "SELECT sum(spoint) AS subtarct FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND sdate <= '$get_date' AND edate >= '$get_date'";
	$result1 = mysql_db_query($dbnameuse,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[subtarct];
		
}//end function ShowSubtractBdate($get_staffid,$get_date){
	

##  ฟังก์ชั่นตรวจสอบค่าคะแนนลบภายในช่วงสัปดาห์
function CheckSubtractUpdate($get_staffid,$get_date){
	global $dbnameuse;
	$arrdate = ShowSdateEdate($get_date); // หาวันเริ่มต้นและสิ้นสุดของแต่ละสัปดาห์
	$sql2 = "SELECT
sum(stat_incentive.subtract) as subtract_max
FROM `stat_incentive`
WHERE
stat_incentive.staffid =  '$get_staffid' AND
stat_incentive.datekeyin BETWEEN  '".$arrdate['start_date']."' AND '".$arrdate['end_date']."'";
	$result2 = mysql_db_query($dbnameuse,$sql2);
	$rs2 = mysql_fetch_assoc($result2);
	return $rs2[subtract_max];
}	
### function update ค่าภายในช่วงสัปดาห์กรณีค่าลบใหม่มีค่ามากกว่าค่าลบเก่าให้เอาค่าลบเก่าไป update รายการข้อมูล
function ShowNumkeyPoint($get_staff,$get_date){
	global $dbnameuse;
	$arrdate = ShowSdateEdate($get_date); // หาวันเริ่มต้นและสิ้นสุดของแต่ละสัปดาห์
	$sql_k = "SELECT
stat_user_keyin.numkpoint AS kpoint,
datekeyin
FROM `stat_user_keyin`
WHERE
stat_user_keyin.datekeyin BETWEEN  '".$arrdate['start_date']."' AND '".$arrdate['end_date']."' AND
stat_user_keyin.staffid =  '$get_staff'";
	$result_k = mysql_db_query($dbnameuse,$sql_k);
	while($rs_k = mysql_fetch_assoc($result_k)){
		$arrk[$rs_k[datekeyin]] = $rs_k[kpoint];
	}//end while($rs_k = mysql_fetch_assoc($result_k)){
	return $arrk;
}//end function ShowNumkeyPoint($get_staff,$get_date){

function UpdateSubtractVal($get_staffid,$get_date,$get_val){
	global $dbnameuse,$base_point,$point_w;
	$arr_kpoint = ShowNumkeyPoint($get_staffid,$get_date);
	if(count($arr_kpoint) > 0){
		foreach($arr_kpoint as $key => $val){
			$npoint = ($val-$get_val)-$base_point;
			$kincentive = $npoint*$point_w;
			
			$sql_up = "UPDATE stat_incentive SET subtract='$get_val', net_point='$npoint', incentive='$kincentive' WHERE staffid='$get_staffid' and datekeyin='$key'";
			mysql_db_query($dbnameuse,$sql_up);	
		}//end foreach($arr_kpoint as $key => $val){	
	}//end if(count($arr_kpoint) > 0){	
}//end function UpdateSubtractVal(){ 
	  						//echo "<input type='hidden' name='arr_datekeyin[$rsv[staffid]]' value='$rsv[datekeyin]'>";
							//echo "<input type='hidden' name='arr_subtract[$rsv[staffid]]' value='$subtract_val'>";
							//echo "<input type='hidden' name='arr_net_point[$rsv[staffid]]' value='$net_kpoint'>";
							//echo "<input type='hidden' name='arr_incentive[$rsv[staffid]]' value='$Incentive_val'>";
							

	
if($_SERVER['REQUEST_METHOD'] == "POST" and $Aaction == "Save"){
	//echo "<pre>";
	//print_r($arr_incentive);
	if(count($arr_datekeyin) > 0){
			foreach($arr_datekeyin as $key => $val){
				$sql_replace = "REPLACE INTO stat_incentive(staffid,datekeyin,staff_approve,status_approve,subtract,net_point,incentive,kpoint_add,kpoint_stat,numkpoint)VALUES('$key','$val','$staff_approve','1','$arr_subtract[$key]','$arr_net_point[$key]','$arr_incentive[$key]','$arr_kpoint_add[$key]','$arr_kpoint_stat[$key]','$arr_numpoint[$key]')";
				//echo $sql_replace."<br><br>";
				mysql_db_query($dbnameuse,$sql_replace);		
			}//end foreach($arr_datekeyin as $key => $val){				
			echo "<script>alert('บันทึกรายการเรียบร้อยแล้ว'); location.href='?sdate=$sdate&group_type=$group_type';</script>";
		exit;
	}//end if(count($arr_datekeyin) > 0){	
}//end if($_SERVER['REQUEST_METHOD'] == "POST" and $Aaction == "Save"){

?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<SCRIPT SRC="sorttable.js"></SCRIPT>
<script language="javascript">

</script>
</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" ><a href="index_incentive.php">กลับหน้าหลัก</a> || รายงานการคำนวณค่า Incentive รายวัน</td>
        </tr>
		   <tr>
          <td class="headerTB"><form name="form1" method="post" action="">
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="14%" align="right"><strong>วันที่&nbsp;:</strong></td>
                <td width="86%" align="left"><INPUT name="sdate" onFocus="blur();" value="<?=$sdate?>" size="15" readOnly>
            <INPUT name="button" type="button"  onClick="popUpCalendar(this, form1.sdate, 'dd/mm/yyyy')"value="วันเดือนปี"></td>
              </tr>
              <tr>
                <td align="right">&nbsp;</td>
                <td align="left"><label>
                  <input type="submit" name="button2" id="button" value="แสดงรายงาน">
                  <input type="hidden" name="Aaction" value="Search">
                </label></td>
              </tr>
            </table>
          </form></td>
        </tr>
		   <tr>
		     <td class="headerTB"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		       <tr>
		         <td><form name="form2" method="post" action="">
		           <table width="100%" border="0" cellspacing="0" cellpadding="0">
		             <tr>
		               <td bgcolor="#FFFFFF">
                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                         <tr>
                           <td align="left" bgcolor="#A5B2CE"><strong>รายงานค่า Incentive ประจำวันที่  <? $date_show = DateSaveDB($sdate); echo thaidate($date_show);?>  ค่าคะแนนมาตรฐาน = 240 คะแนน&nbsp;&nbsp;สถานะการรับรองยอด : </strong><? if(CheckAppriveIncentive($date_show) > 0){ echo "<img src=\"../../images_sys/approve20.png\" width=\"16\" height=\"16\" border=\"0\" title=\"สถานะรับรองความถูกต้องของข้อมูลแล้ว\">";}else{ echo "<img src=\"../../images_sys/unapprove.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ยังไม่ถูกรับรองความถูกต้องของข้อมูล\">";} ?>
                            </td>
                         </tr>
                         <? 
						  if($group_type == "A"){ 
						 	 $xsub_title = "รายงานการบันทึกข้อมูลกลุ่ม A";
						  }else if($group_type == "B"){ 
						  	$xsub_title = "รายงานการบันทึกข้อมูลกลุ่ม  B";
						}else if($group_type == "C"){ 
							$xsub_title = "รายงานการบันทึกข้อมูลกลุ่ม C";
						}else{ $xsub_title = "รายงานการบันทึกข้อมูลทั้งหมด";}
						 
						 ?>
                         <tr>
                           <td align="left" bgcolor="#A5B2CE"><a href="?sdate=<?=$sdate?>&group_type=A">กลุ่ม A</a> ||<a href="?sdate=<?=$sdate?>&group_type=B">กลุ่ม B</a> || <a href="?sdate=<?=$sdate?>&group_type=C">กลุ่ม C</a> || <a href="?sdate=<?=$sdate?>&group_type=">ทั้งหมด</a></td>
                         </tr>
                         <tr>
                           <td align="left" bgcolor="#A5B2CE"><strong><? echo $xsub_title ;?></strong></td>
                         </tr>
                       </table>
						<table width="100%" border="0" cellspacing="1" cellpadding="3">
		                 <tr onMouseOver="this.style.cursor='hand'; this.style.background='#EFEFEF';" onMouseOut="this.style.cursor='point'; this.style.background='#FFFFFF';">
		                   <td width="3%" rowspan="2" align="center" bgcolor="#A5B2CE"  class="fillcolor_menu"><strong>ลำดับ</strong></td>
		                   <td width="20%" rowspan="2" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>ชื่อ - นามสกุล</strong></td>
		                   <td width="10%" rowspan="2" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>คะแนนบันทึกได้</strong></td>
		                   <td colspan="5" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>Incentive</strong></td>
		                   </tr>
		                 <tr onMouseOver="this.style.cursor='hand'; this.style.background='#EFEFEF';" onMouseOut="this.style.cursor='point'; this.style.background='#FFFFFF';">
		                   <td width="12%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>คะแนนสูงกว่าเกณฑ์</strong></td>
		                   <td width="12%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>คะแนนสะสม</strong></td>
		                   <td width="14%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>คะแนนถ่วงน้ำหนัก</strong></td>
		                   <td width="15%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>คะแนนสุทธิ</strong></td>
		                   <td width="14%" align="center" bgcolor="#A5B2CE" class="fillcolor_menu"><strong>ค่า Incentive(บาท)</strong></td>
		                   </tr>
                           <?
	if($group_type == "A"){
		$cong = " AND keyin_group='1'";	
	}else if($group_type == "B"){
		$cong = " AND keyin_group='2'";	
	}else if($group_type == "C"){
		$cong = " AND keyin_group='3'";
	}else{
		$cong = "";	
	}
              $sql_view = "SELECT
stat_user_keyin.staffid,
stat_user_keyin.datekeyin,
stat_user_keyin.numkpoint,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname
FROM
stat_user_keyin
Inner Join keystaff ON stat_user_keyin.staffid = keystaff.staffid
WHERE
stat_user_keyin.datekeyin =  '$date_show' AND keyin_group='3' ORDER BY stat_user_keyin.numkpoint DESC";
							$result_view = mysql_db_query($dbnameuse,$sql_view);
							$i=0;
							while($rsv = mysql_fetch_assoc($result_view)){
														
							$numkpoint = $rsv[numkpoint];
							
						if(CheckPointADD($rsv[staffid],$rsv[datekeyin]) < 1){ // ทำการบันทึกใน temp กรณีวันนั้นยังไม่ได้คำนวณเท่านั้น
		
						$arrxd = ShowSdateEdate($rsv[datekeyin]);
						$kpoint_add = CutPoint($numkpoint-$base_point);
							if($kpoint_add < 0){
								$kpoint_add = 0;
							}else{
								$kpoint_add = $kpoint_add;
							}
						
						$point_add1 = xSumSubtract($rsv[staffid],$rsv[datekeyin]);
						$kpoint_stat = CutPoint($kpoint_add+$point_add1);
						$ratio_point = intval(ShowQvalue($rsv[staffid])); // ค่าถ่วงน้ำหนักกาี QC ของแต่ละกลุ่ม
						$subtract  =  ShowSubtractAvg($rsv[datekeyin],$rsv[staffid])*$ratio_point; // ค่าคะแนน ลบ
						$subtract = CutPoint($subtract);
						$netval  =  $kpoint_stat-$subtract;
						$incentive = CutPoint($netval*$point_w);
						
						$sql_temp = "REPLACE INTO stat_incentive_temp SET staffid='$rsv[staffid]',datekeyin='$rsv[datekeyin]',numkpoint='$numkpoint',kpoint_add='$kpoint_add',kpoint_stat='$kpoint_stat',subtract='$subtract',net_point='$netval',incentive='$incentive'";
						//echo "$sql_temp<br>";
						mysql_db_query($dbnameuse,$sql_temp);
					}//end 	if(CheckPointADD($rsv[staffid],$rsv[datekeyin]) < 1){
						###  end ทำการบันทึกคะแนนยอยสะสม
 }//end while($rsv = mysql_fetch_assoc($result_view)){
	 ### แสดงค่ายอดสะสม#############################################		
	 $sql_show = "SELECT
stat_incentive_temp.staffid,
stat_incentive_temp.datekeyin,
stat_incentive_temp.numkpoint,
stat_incentive_temp.kpoint_add,
stat_incentive_temp.subtract,
stat_incentive_temp.net_point,
stat_incentive_temp.incentive,
stat_incentive_temp.kpoint_stat,
keystaff.prename,
keystaff.staffname,
keystaff.staffsurname
FROM
stat_incentive_temp
Inner Join keystaff ON stat_incentive_temp.staffid = keystaff.staffid
WHERE
stat_incentive_temp.datekeyin =  '$date_show' AND keyin_group='3' ORDER BY stat_incentive_temp.numkpoint DESC";
	$result_show = mysql_db_query($dbnameuse,$sql_show);
	while($rss = mysql_fetch_assoc($result_show)){
		if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
			$numpoint = CutPoint($rss[numkpoint]);
			$kpoint_add = CutPoint($rss[kpoint_add]);
			$kpoint_stat = CutPoint($rss[kpoint_stat]);
			$subtract = CutPoint($rss[subtract]);
			$net_point = CutPoint($rss[net_point]);
			$incentive = CutPoint($rss[incentive]);
								
						   ?>
		                 <tr bgcolor="<?=$bg?>">
		                   <td align="center"><?=$i?></td>
		                   <td align="left"><? echo "$rss[prename]$rss[staffname]  $rss[staffsurname]";?>&nbsp;&nbsp;<? echo "[$rss[staffid]]";?></td>
		                   <td align="center"><?=ViewCutPoint($numpoint)?></td>
		                   <td align="center"><?=ViewCutPoint($kpoint_add)?></td>
		                   <td align="center"><?=ViewCutPoint($kpoint_stat)?></td>
		                   <td align="center"><? if($subtract > 0){?><a href='report_subtract_qc.php?staffid=<?=$rss[staffid]?>&datecal=<?=$rss[datekeyin]?>&xstaffname=<? echo "$rss[prename]$rss[staffname]  $rss[staffsurname]";?>' target="_blank"><?=ViewCutPoint($subtract);?></a><? }else{ echo "0";}?></td>
		                   <td align="center"><?=ViewCutPoint($net_point);?></td>
		                   <td align="right"><?=ViewCutPoint($incentive);?></td>
		                   </tr>
                          <?
						  	echo "<input type='hidden' name='arr_datekeyin[$rss[staffid]]' value='$rss[datekeyin]'>";
							echo "<input type='hidden' name='arr_subtract[$rss[staffid]]' value='$subtract'>";
							echo "<input type='hidden' name='arr_net_point[$rss[staffid]]' value='$net_point'>";
							echo "<input type='hidden' name='arr_incentive[$rss[staffid]]' value='$incentive'>";
							echo "<input type='hidden' name='arr_kpoint_add[$rss[staffid]]' value='$kpoint_add'>";
							echo "<input type='hidden' name='arr_kpoint_stat[$rss[staffid]]' value='$kpoint_stat'>";
							echo "<input type='hidden' name='arr_numpoint[$rss[staffid]]' value='$numpoint'>";
							
							
							
								if($incentive > 0){
						   		$sum_Incentive_all += $incentive;
								}
							}//end while($rsv = mysql_fetch_assoc($result_view)){
						   ?>
	                    </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                              <tr>
                                <td width="86%" align="right"><strong>ค่า Incentive รวม : </strong></td>
                                <td width="11%" align="center"><?=number_format($sum_Incentive_all,2);?></td>
                                <td width="3%" align="left"><strong>บาท</strong></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="3">
		                     <tr>
		                       <td width="53%" align="right" bgcolor="#FFFFFF"><strong>พนักงานตรวจสอบยอด: </strong></td>
		                       <td width="47%" align="left" bgcolor="#FFFFFF"><label>
		                         <select name="staff_approve" id="staff_approve">
            					<option value="">เลือกชื่อพนักงาน</option>
                                 <?
                                 	$sql_approve = "SELECT * FROM keystaff WHERE sapphireoffice='1'";
									$result_approve = mysql_db_query($dbnameuse,$sql_approve);
									while($rs_a = mysql_fetch_assoc($result_approve)){
										$sqla1 = "SELECT COUNT(staff_approve) AS numstaff FROM stat_incentive WHERE staff_approve='$rs_a[staffid]' AND datekeyin='$date_show'";
										$result1 = mysql_db_query($dbnameuse,$sqla1);
										$rsa1 = mysql_fetch_assoc($result1);
										if($rsa1[numstaff] > 0){ $sel = "selected='selected'";}else{ $sel = "";}
										echo "  <option value='$rs_a[staffid]' $sel>$rs_a[prename]$rs_a[staffname]  $rs_a[staffsurname]</option>";
									}
								 ?>
		                           </select>
		                         </label></td>
		                       </tr>
		                     <tr>
		                       <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
		                       <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
		                       </tr>
		                     <tr>
		                       <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
		                       <td align="left" bgcolor="#FFFFFF">
                               <input type="submit" name="button3" id="button2" value="บันทึก">
                               <input type="hidden" name="Aaction" value="Save">
                               <input type="hidden" name="group_type" value="<?=$group_type?>">
                               <input type="hidden" name="sdate" value="<?=$sdate?>">
                               </td>
		                       </tr>
		                     </table></td>
                          </tr>
                        </table></td>
	                  </tr>
	                </table>
	             </form></td>
	           </tr>
	         </table></td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>