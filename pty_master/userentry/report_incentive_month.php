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
			$ccyy = date("Y")+543;
			
			$curent_date = date("Y-m-d");
			$dbnameuse = "edubkk_userentry";
			$time_start = getmicrotime();
			$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
			$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			
			
			if($yy == ""){
					$yy = date("Y")+543;
			}
			if($mm == ""){
					$sql_month = "SELECT month(datekeyin)  as month1  FROM `stat_user_keyin` group by datekeyin order by datekeyin desc limit 0,1";
					$result_month = mysql_db_query($dbnameuse,$sql_month);
					$rs_month = mysql_fetch_assoc($result_month);
					$mm = sprintf("%02d",$rs_month[month1]);
			}

//echo "$yy :: $mm";

			
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
		$sqlS = "SELECT spoint FROM stat_subtract_keyin WHERE staffid='$get_staffid' AND datekey='$get_date'";
		$resultS = mysql_db_query($dbnameuse,$sqlS);
		$rsS = mysql_fetch_assoc($resultS);
		return $rsS[spoint];
}//end function ShowSubtract(){

	


?>

<HTML><HEAD><TITLE> </TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-874">
<link href="../hr3/hr_report/images/style.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<link href="../../common/gs_sortable.css" />
<script src="../../common/gs_sortable.js"></script>
<script language="javascript">

</script>
</HEAD>
<BODY >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr align="center"     bgcolor="#10265F">
	  <td width="100%" height="42" align="left" bgcolor="#A5B2CE"><table width="100%" border="0" cellpadding="0" cellspacing="0" background="../hr_report/images/report_banner_011.gif">
        <tr>
          <td height="48" background="images/60_01.gif" style="color:#FFFFFF; font-size:16px; font-weight:bold; padding-left:15px" ><a href="index_incentive.php">กลับหน้าหลัก</a> ||รายงานการคำนวณค่า Incentive รายเดือน</td>
        </tr>
		   <tr>
          <td class="headerTB"><form name="form1" method="post" action="">
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <td width="14%" align="right"><strong>เดือนปี : </strong></td>
                <td width="86%" align="left">
                  <select name="mm" id="mm">
                  <option value="">เลือกเดือน</option>
                  <?
                  	for($m = 1 ; $m <= 12 ; $m++ ){
						$xmm = sprintf("%02d",$m);
						if($xmm == $mm){ $sel = "selected='selected'";}else{ $sel = "";}
						echo "<option value='$xmm' $sel>$monthFull[$m]</option>";
					}//end for($m = 1 ; $m <= 12 ; $m++ ){
				  ?>
                  </select>
                 <strong> ปี </strong>
                 <select name="yy" id="yy">
                 <option value="">เลือกปี</option>
                 <?
                 	for($y = 2552 ; $y <= $ccyy ; $y++){
						if($y == $yy){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
							echo "<option value='$y' $sel1>$y</option>";
					}
				 ?>
                 </select>
</td>
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
		         <td>
		           <table width="100%" border="0" cellspacing="0" cellpadding="0">
		             <tr>
		               <td align="center" bgcolor="#000000">
                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  align="left" bgcolor="#A5B2CE"><!--<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td colspan="3">&nbsp;</td>
            </tr>
          <tr>
            <td width="49%" align="left">จำนวนพนักงานทั้งหมด</td>
            <td width="25%" align="center">&nbsp;</td>
            <td width="26%" align="left">คน</td>
          </tr>
          <tr>
            <td align="left">จำนวนค่า Incentive</td>
            <td align="center">&nbsp;</td>
            <td align="left">บาท</td>
          </tr>
          <tr>
            <td align="left">จำนวนวันที่รับรองข้อมูล</td>
            <td align="center">&nbsp;</td>
            <td align="left">วัน</td>
          </tr>
          <tr>
            <td align="left">จำนวนวันที่ยังไม่ไ้ด้รับรองข้อมูล</td>
            <td align="center">&nbsp;</td>
            <td align="left">วัน</td>
          </tr>
        </table></td>
      </tr>
    </table>--></td>
  </tr>
  <tr>
    <td  align="left" bgcolor="#A5B2CE"><strong>รายงานสรุปค่าคะแนนการบันทึกข้อมูล ก.พ.7 ประจำเดือน <? echo $monthFull[intval($mm)]." ".$yy?> ค่าคะแนนมาตรฐาน = 240 คะแนน</strong></td>
  </tr>
  <tr>
    <td  align="left" bgcolor="#A5B2CE"><!--<a href="?xgtype=1&mm=<?=$mm?>&yy=<?=$yy?>"><strong>กลุ่ม A</strong></a><strong> || --><a href="?xgtype=2&mm=<?=$mm?>&yy=<?=$yy?>">กลุ่ม L </a>|| <a href="?xgtype=3&mm=<?=$mm?>&yy=<?=$yy?>">กลุ่ม N </a> || <a href="?xgtype=0&mm=<?=$mm?>&yy=<?=$yy?>"><strong>QC ที่เป็นพนักงานคีย์ข้อมูล</strong></a>|| <a href="?xgtype=OUT&mm=<?=$mm?>&yy=<?=$yy?>"><strong>พนักงานที่ออกกลางเดือน</strong></a>||<a href="?xgtype=&mm=<?=$mm?>&yy=<?=$yy?>">ทั้งหมด </a> </strong></td>
  </tr>
  <tr>
    <td  align="left" bgcolor="#A5B2CE"><strong>แสดงข้อมูล
      <? if($xgtype == "1"){ echo "กลุ่ม  A";}else if($xgtype == "2"){ echo "กลุ่ม L";}else if($xgtype == "3"){ echo "กลุ่ม N"; }else if($xgtype == "0"){ echo "QC ที่เคยเป็นพนักงานบันทึกข้อมูล";}else if($xgtype == "OUT"){ echo "พนักงานที่ออกกลางเดือน"; }else{ echo "ทั้งหมด";}?>
    </strong></td>
  </tr>
                       </table>

                       <table width="100%" border="0" cellspacing="1" cellpadding="3"  id="my_table">
                       <thead>  
		                 <tr>
		                   <th width="3%" rowspan="2" align="center" bgcolor="#A5B2CE" ><strong>ลำดับ</strong></th>
		                   <th width="7%" rowspan="2" align="center" bgcolor="#A5B2CE" >รหัส Code<br>
		                     ในระบบ Face</th>
		                   <th width="17%" rowspan="2" align="center" bgcolor="#A5B2CE" ><strong>ชื่อนามสกุล</strong></th>
		                   <th width="7%" rowspan="2" align="center" bgcolor="#A5B2CE" ><strong>รหัส<br>
		                     พนักงาน</strong></th>
		                   <th width="7%" rowspan="2" align="center" bgcolor="#A5B2CE" >วันเริ่ม<br>
		                     ทำงาน</th>
		                   <th width="10%" rowspan="2" align="center" bgcolor="#A5B2CE" ><strong>ค่าคะแนน<br>
		                     บันทึกได้</strong></th>
		                   <td colspan="5" align="center" bgcolor="#A5B2CE" ><strong>Incentive</strong></td>
	                      </tr>
		                 <tr>
		                   <th width="11%" align="center" bgcolor="#A5B2CE" ><strong>คะแนนสูงกว่าเกณฑ์</strong></th>
		                   <th width="10%" align="center" bgcolor="#A5B2CE" ><strong>คะแนนถ่วงน้ำหนัก</strong></th>
		                   <th width="9%" align="center" bgcolor="#A5B2CE" ><strong>คะแนนสุทธิ</strong></th>
		                   <th width="8%" align="center" bgcolor="#A5B2CE" ><strong>Incentive(บาท)</strong></th>
		                   <td width="11%" align="center" bgcolor="#A5B2CE" ><strong>view</strong></td>
	                      </tr>
                          	</thead>    
						<tbody>   
                          <?
						  //echo "$mm :: $yy";
						  	if($xgtype == "1"){
								$cong = "  AND status_extra='NOR' AND status_permit='YES' AND keystaff.keyin_group='1' ";	
							}else if($xgtype == "2"){
								$cong = "  AND status_extra='NOR' AND status_permit='YES'  AND keystaff.keyin_group='2'";
							}else if($xgtype == "3"){
								$cong = "  AND status_extra='NOR'  AND status_permit='YES' AND keystaff.keyin_group='3'";
							}else if($xgtype == "0"){
								$cong = " AND part_keydata='1' ";
							}else if($xgtype == "OUT"){
								$cong = " AND status_permit='NO' AND keyin_group > 0";	
								# cal_incentive='1' AND
							}else{
								$cong = "  AND (keyin_group > 0 OR part_keydata = '1' OR cal_incentive='1')";	
							}
						  	$con_date = ($yy-543)."-".$mm;
							$arrval = IncentivePerMonth($con_date);
                          	$sql_staff = "SELECT * FROM keystaff WHERE sapphireoffice='0'  $cong ORDER BY id_code ASC, staffname ASC";
							//echo $sql_staff;
							$result_staff = mysql_db_query($dbnameuse,$sql_staff);
							$i=0;
							while($rs = mysql_fetch_assoc($result_staff)){
								if ($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
								$sql_intcen = "SELECT stat_incentive.incentive  as maxincentive, datekeyin FROM stat_incentive WHERE  stat_incentive.datekeyin LIKE '$con_date%' and staffid='$rs[staffid]'  ORDER BY datekeyin DESC  LIMIT 1 "; 
								//echo $sql_intcen."<br>";
								$result_cen = mysql_db_query($dbnameuse,$sql_intcen);
								$rs_c = mysql_fetch_assoc($result_cen);
								
								$sql2 = "SELECT sum(kpoint_add) as point1, sum(subtract) as point2 FROM stat_incentive WHERE datekeyin LIKE '$con_date%' and staffid='$rs[staffid]'";
								$result2 = mysql_db_query($dbnameuse,$sql2);
								$rs2 = mysql_fetch_assoc($result2);
								$kpoint_stat = $rs2[point1]-$rs2[point2];
								
								$sql3 = "SELECT SUM(numkpoint) AS sumkp, SUM(kpoint_add) AS sumkp_add,SUM(subtract) AS sumkp_sub FROM stat_incentive WHERE stat_incentive.datekeyin LIKE '$con_date%' and staffid='$rs[staffid]' GROUP BY staffid";
								$result3 = mysql_db_query($dbnameuse,$sql3);
								$rs3 = mysql_fetch_assoc($result3);
								
								$sql4 = "SELECT net_point AS maxN_point FROM stat_incentive WHERE stat_incentive.datekeyin LIKE '$con_date%' and staffid='$rs[staffid]' ORDER BY datekeyin DESC LIMIT 1";
								//echo $sql4."<br>";
								$result4 = mysql_db_query($dbnameuse,$sql4);
								$rs4 = mysql_fetch_assoc($result4);
								
								//if($xgtype == ""){
									$xgroup1 = CheckGroupStaff($rs[staffid]);	
									if($xgroup1 == "1"){ $show_g = "[A]";}else if($xgroup1 == "2"){ $show_g = "[L]"; }else if($xgroup1 == "3"){ $show_g = "[N]";}
								//}
									
						  ?>
		                 <tr bgcolor="<?=$bg?>">
		                   <td align="center"><?=$i?></td>
		                   <td align="left"><?=$rs[id_code]?></td>
		                   <td align="left"><? echo "$rs[prename]$rs[staffname]  $rs[staffsurname]";?></td>
		                   <td align="center"><? echo "K".(substr($rs[staffid],-4));?><?=$show_g?></td>
		                   <td align="center"> <?=ShowStartDate($rs[staffid]);?>  </td>
		                   <td align="center"><? echo number_format($rs3[sumkp],2);?></td>
		                   <td align="center"><? echo number_format($rs3[sumkp_add],2);?></td>
		                   <td align="center"><? echo number_format($rs3[sumkp_sub],2);?></td>
		                   <td align="center"><? echo number_format($rs4[maxN_point],2);?></td>
		                   <td align="center"><? echo number_format($rs_c[maxincentive],2);?></td>
		                   <td align="center"><? if($rs_c[maxincentive] > 0){ echo "<a href='report_incentive_per_month.php?sent_staffid=$rs[staffid]&mm=$mm&yy=$yy&xgtype=$xgtype' target='_blank'><img src=\"images/department_money.gif\" width=\"20\" height=\"20\" border=\"0\" title=\"คลิ๊กเพื่อแสดงรายละเอียดรายเดือน\"></a>";}else{ echo "";}?>
	                       &nbsp; <a href="report_incentive_per_month_print.php?sent_staffid=<?=$rs[staffid]?>&mm=<?=$mm?>&yy=<?=$yy?>" target="_blank"><img src="../../images_sys/print.gif" width="21" height="20" border="0" title="คลี๊กเพื่อแสดงหน้ารายงานสรุป"></a></td>
	                      </tr>
                         <?
						   		$Incentive_sum += $rs_c[maxincentive];
							}//end while($rs = mysql_fetch_assoc($result_staff)){
						  ?>
                          </tbody>
                          <tfoot>
		                 <tr bgcolor="<?=$bg?>">
		                   <td colspan="9" align="right" bgcolor="#FFFFFF"><strong>รวม : </strong></td>
		                   <td align="center" bgcolor="#FFFFFF"><strong>
		                     <?=number_format($Incentive_sum,2);?>
		                   </strong></td>
		                   <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
		                   </tr>
                     </tfoot>
	                   </table></td>
                     </tr>
                   </table>
	             </td>
	           </tr>
	         </table></td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
<script type="text/javascript">
<!--
var TSort_Data = new Array ('my_table', '', 'h','g', 'g','g','g','g','g','g','g','g','g');
var TSort_Classes = new Array ('row1', 'row2');
tsRegister();
// -->
</script> 

</BODY></HTML>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>