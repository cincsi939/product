<?
include ("../../config/conndb_nonsession.inc.php")  ;
//include('../hr3/tool_competency/diagnosticv1/function.inc_v1.php') ;
include("epm.inc.php");
$curent_yy = date("Y")+543;
//echo "<font color='red'><center>ขออภัยกำลังปรับปรุงโปรแกรม ประมาณ  30 นาที </center></font>";die;

$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$point_num = 60;	
	if($yy1 == ""){
		$yy1 = date("Y")+543;
	}
	if($mm == ""){					
		$mm = sprintf("%2d",date("m"));
	}
	
	function ShowGroup($get_group){
			if($get_group == "1"){ return "A";}
			else if($get_group == "2"){ return "L";}
			else if($get_group == "3"){ return "N";}
	}

$array_day = array("1"=>"จ.","2"=>"อ.","3"=>"พ.","4"=>"พฤ.","5"=>"ศ.","6"=>"ส.");
/*
echo "<pre>";
print_r($_POST);
*/

//$get_date = "2010-03-01";	
function ShowDayOfMonth($get_month){
	$arr_d1 = explode("-",$get_month);
	$xdd = "01";
	$xmm = "$arr_d1[1]";
	$xyy = "$arr_d1[0]";
	$get_date = "$xyy-$xmm-$xdd"; // วันเริ่มต้น
	//echo $get_date."<br>";
	$xFTime1 = getdate(date(mktime(0, 0, 0, intval($xmm+1), intval($xdd-1), intval($xyy))));
	$numcount = $xFTime1['mday']; // ฝันที่สุดท้ายของเดือน
	if($numcount > 0){
		$j=1;
			for($i = 0 ; $i < $numcount ; $i++){
				$xbasedate = strtotime("$get_date");
				 $xdate = strtotime("$i day",$xbasedate);
				 $xsdate = date("Y-m-d",$xdate);// วันถัดไป		
				 $arr_d2 = explode("-",$xsdate);
				 $xFTime = getdate(date(mktime(0, 0, 0, intval($arr_d2[1]), intval($arr_d2[2]), intval($arr_d2[0]))));	
				 if($xFTime['wday'] == 0){
					 $j++;
						 
					}
					if($xFTime['wday'] != "0"){
						$arr_date[$j][$xFTime['wday']] = $xsdate;	
					}
				 
			}
			
	}//end if($numcount > 0){
	return $arr_date;	
}//end function ShowDayOfMonth($get_month){
//$xarr = ShowDayOfMonth("2010-04-01");
//echo "<pre>";
//print_r($xarr);


function ShowKeyPerson($get_staffid,$get_date){
		global $db_name,$point_num;
		//$sql = "SELECT numkpoint  FROM stat_user_keyin  WHERE datekeyin = '$get_date' AND staffid='$get_staffid'";
		$sql = "SELECT count(idcard) as numid FROM `monitor_keyin` where staffid='$get_staffid' and timeupdate LIKE '$get_date%'";
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		return $rs[numid];
		
}

function CheckQCPerDay($get_staff,$get_date){
global $db_name;
$sql1 = "SELECT count(idcard) as num1 FROM `validate_checkdata` where staffid='$get_staff' and datecal LIKE '$get_date%'  group by idcard;";
$result1 = mysql_db_query($db_name,$sql1);
$numr1 = @mysql_num_rows($result1);
return $numr1;
//$rs1 = mysql_fetch_assoc($result1);
//return $rs1[num1];
	
}

### บันทึกข้อมูลลงในตาราง temp 
function SaveStatQc($get_staff,$get_date){
		global $db_name;
		$numkey = ShowKeyPerson($get_staff,$get_date); // จำนวนชุดที่คีย์ไ้ด้ในแต่ละวัน
		$numqc = CheckQCPerDay($get_staff,$get_date); // จำนวนชุดที่ QC
		$sql_save = "REPLACE INTO temp_check_qc(datekeyin,staffid,numkey,numqc)VALUES('$get_date','$get_staff','$numkey','$numqc')";
		//echo $sql_save."<br>";
		 mysql_db_query($db_name,$sql_save);
		
}//end function SaveStatQc($get_staff,$get_date){
	
	
function AlertQC($get_staff,$get_yymm){
		global $db_name;
		$Rpoint = ShowRpoint($get_staff);
		$sql = "SELECT * FROM temp_check_qc WHERE staffid='$get_staff' AND datekeyin LIKE '$get_yymm%' ORDER BY datekeyin ASC";
		$result = mysql_db_query($db_name,$sql);
		$numk = 0;
		$j=0;
		while($rs = mysql_fetch_assoc($result)){
				if($j==0){ // กำหนดวันเริ่ิมคีย์
					$date_start = $rs[datekeyin];
				}
				
				$numk += $rs[numkey];
				if($numk >= $Rpoint){   // กรณียอดที่คีย์เกินค่าเรโช ให้ตรวจสอบการ QC
					
					if(CheckLengthQC($get_staff,$date_start,$rs[datekeyin]) > 0){ // 5hk
						$arrDQc[$rs[datekeyin]] = "Y";
					}else{
						$arrDQc[$rs[datekeyin]] = "N";
					}//if(CheckLengthQC($get_staff,$date_start,$rs[datekeyin]) > 0){
					//$numk = 0; // กำหนดค่าเศษจากการ QC
					$numk = $numk-$Rpoint;
					$j=0;
				}else{ 
					$j++;
				} // e   // กรณียอดที่คีย์เกินค่าเรโช ให้ตรวจสอบการ QC
			
		}//end while($rs = mysql_fetch_assoc($result)){
			//echo "<pre>";
			//print_r($arrDQc);
			return $arrDQc;
}//end function AlertQC($get_staff,$get_yymm){
####  funciton นับจำนวนรายการรายการ
function  CountNumQC($flag_id,$staffid){
	global $dbnameuse;
	$sql = "SELECT count(flag_qc) as numqc FROM stat_user_keyperson WHERE flag_qc='$flag_id' AND staffid='$staffid' and flag_qc <> '0' GROUP BY staffid";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[numqc];
}

	
function AlertQcMark($get_flagid,$get_staffid){
	global $dbnameuse;
	$sql = "SELECT count(idcard) as num1 FROM `stat_user_keyperson` WHERE stat_user_keyperson.status_random_qc =  '1' AND
stat_user_keyperson.staffid =  '$get_staffid' AND stat_user_keyperson.flag_qc =  '$get_flagid' GROUP BY stat_user_keyperson.staffid";
	$result = mysql_db_query($dbnameuse,$sql);
	$rs = mysql_fetch_assoc($result);
	return $rs[num1];
	
}//end function AlertQcMark(){
	
######### 

//if($process == "cal"){
	//CalHiddenPersonPoint();// คำนวณคะแนนความซับซ้อน
//}//end 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>รายงานตรวจสอบการ QC</title>
<link href="../hr3/tool_competency/diagnosticv1/css/style.css" rel="stylesheet" type="text/css" />
    <style type="text/css">

    .mouseOut {
    background: #708090;
    color: #FFFAFA;
    }

    .mouseOver {
    background: #FFFAFA;
    color: #000000;
    }
    
	body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #000;
}
a:visited {
	color: #000;
}
a:hover {
	color: #F60;
}
a:active {
	color: #000;
}
</style>
</head>
<body>
<?
		if($xtype == ""){ $xtype = 5;} // กรณีมีได้ระบุกลุ่ม ให้ค่า defult เป็น กลุ่ม L
		if($xtype == "1"){$bg_link1 = "#FFFFFF";$bg_link2 = "#E9E9E9";$bg_link3 = "#E9E9E9";}else{ $bg_link1 = "#E9E9E9";}
		if($xtype == "2"){$bg_link2 = "#FFFFFF";$bg_link1 = "#E9E9E9";$bg_link3 = "#E9E9E9";}else{ $bg_link2 = "#E9E9E9";}
		if($xtype == "3"){$bg_link3 = "#FFFFFF";$bg_link2 = "#E9E9E9";$bg_link1 = "#E9E9E9";}else{ $bg_link3 = "#E9E9E9";}
		if($xtype == "4"){$bg_link4 = "#FFFFFF";$bg_link4 = "#E9E9E9";$bg_link4 = "#E9E9E9";}else{ $bg_link4 = "#E9E9E9";}
		if($xtype == "5"){$bg_link5 = "#FFFFFF";$bg_link5 = "#E9E9E9";$bg_link5 = "#E9E9E9";}else{ $bg_link5 = "#E9E9E9";}
		$xmonth1 = ($yy1-543)."-".sprintf("%02d",$mm);		
		$txt_yy = $yy1;
		$txt_mm = $mm;
        if($xtype == "1"){
			$cong = " WHERE  keystaff.keyin_group='1' AND status_permit='YES'";	
		}else if($xtype == "2"){
			$cong = " WHERE  keystaff.keyin_group='2' AND status_permit='YES'";	
		}else if($xtype == "3"){
			$cong = " WHERE  keystaff.keyin_group='3' AND status_permit='YES'";
		}else if($xtype == "5"){
			$cong = " WHERE  keystaff.keyin_group='5' AND status_permit='YES'";
		}
		
		
######  ทำการประมวลผลการนับQC
	if($action == "process_qc"){
		if($xtype == "1"){
			$cong = " WHERE  keystaff.keyin_group='1' AND status_permit='YES'";	
		}else if($xtype == "2"){
			$cong = " WHERE  keystaff.keyin_group='2' AND status_permit='YES'";	
		}else if($xtype == "3"){
			$cong = " WHERE  keystaff.keyin_group='3' AND status_permit='YES'";
		}else if($xtype == "5"){
			$cong = " WHERE  keystaff.keyin_group='5' AND status_permit='YES'";
		}
		
		$sql_p = "SELECT keystaff.staffid, keystaff.prename, keystaff.staffname, keystaff.staffsurname, keystaff.sapphireoffice,
keystaff.keyin_group FROM keystaff $cong";
//echo "$dbnameuse :: ".$sql_p;die;
		$result_p = mysql_db_query($dbnameuse,$sql_p);
		while($rsp = mysql_fetch_assoc($result_p)){
			//echo $rsp[staffid];die;
				SubGroupQC($rsp[staffid]); // แบ่งกลุ่ม QC
		}//end while($rsp = mysql_fetch_assoc($result_p)){
		
			echo "<script> location.href='?action=&xtype=$xtype';</script>";
		//exit;
	}///end 	if($action == "process_qc"){
		
##### end ประมวลผลการนับ QC	
?>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong>รายงานข้อมูลที่ต้อง QC</strong></td>
        </tr>
        <tr>
          <td align="left"><form id="form1" name="form1" method="post" action="">
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
                 <select name="yy1" id="yy1">
                 <option value="">เลือกปี</option>
                 <?
                 	for($y = 2552 ; $y <= $curent_yy ; $y++){
						if($y == $yy1){ $sel1 = "selected='selected'";}else{ $sel1 = "";}
							echo "<option value='$y' $sel1>$y</option>";
					}
				 ?>
                 </select>

                  <input type="submit" name="button2" id="button" value="แสดงรายงาน">
                 &nbsp;
                 <!--<a href="report_alert_qc_view.php" target="_blank" >แสดงข้อมูลQC</a>&nbsp;&nbsp;||&nbsp;&nbsp;--><!--<a href="?action=process_qc&xtype=<?=$xtype?>&mm=<?=$mm?>&yy1=<?=$yy1?>">ประมวลผลคำนวณจุดQC</a></label>--><br>
                 <i>หมายเหตุ หากการแบ่งกลุ่ม QC ไม่ถูกต้องให้คลิ๊ก &quot;แบ่งกลุ่ม QCใหม่&quot;  ของพนักงานคีย์ข้อมูลอีกครั้ง </i></td>
              </tr>
            </table>
          </form></td>
        </tr>
        <? 

	function ShowTable($xtype){
			
	global $db_name,$dbnameuse,$xmonth1;
			
	$arrF = GetFlagQC($xmonth1,$xtype);	  
	//echo "<pre>";
	//print_r($arrF);die;
	if(count($arrF) > 0){
		foreach($arrF as $key_staff => $val){
			foreach($val as $flag_arr => $val1){
					$arrval = explode("||",$val1);
					
							$arrQc1 = explode("::",CheckAlertQcOld($flag_arr,$key_staff));// หาว่ามีจำนวน Qc เก่า
							$Qc_idcard = $arrQc1[0];// รหัส idcard ที่ทำการ QC ไปแล้ว
							$QcNum = $arrQc1[1]; // นับว่ามีการ QC  ไปแล้วรึยัง 
							if($arrval[0] == $arrval[1]){
								$bg_qc = "#FF0000";
								$sLink = "<a href='report_alert_qc_detail.php?loopx=$flag_arr&datekey=$xmonth1&staffid=$key_staff&xidcard=$Qc_idcard' target='_blank'>[".$arrval[0]."]</a>";
							}else{
								$bg_qc = "#FFFF66";
								$sLink = "[".$arrval[0]."]";		
							}// end if($arrval[0] == $arrval[1]){
								
							$arr_table[$key_staff][] = "$sLink"."::".$bg_qc;
					
			}//end foreach($val as $key1 => $val1){
		}// end foreach($arrF as $key => $val){
				 	 
	}//end 	if(count($arrF) > 0){
	  
				return $arr_table;
}//end function ShowTable(){
			
	$arr_tbl = ShowTable($xtype);
	//echo "<pre>";
	//print_r($arr_tbl);die;
	//echo count($arr_tbl);
	function ShowMaxLoop($xtype){
		  global $arr_tbl;
		  if(count($arr_tbl) > 0){
			  foreach($arr_tbl as $xk => $xv){
				  $arrx[$xk] = count($xv);
			  }/// end  foreach($arr_tbl as $xk => $xv){
				  
				   $maxLoop = max($arrx);
		  }//end   if(count($arr_tbl) > 0){
			  
			  
			
			  return $maxLoop;
	}// end function ShowMaxLoop(){
				$loop_max = ShowMaxLoop($xtype);
				if($loop_max > 0){
					$width_cal = 100/$loop_max;
				}//end if($loop_max > 0){
				//echo "จำนวนสูงสุด ".ShowMaxLoop($xtype);
				//echo $loop_max;

		?>
        <tr>
          <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
           <!--   <td width="11%" align="center" bgcolor="<?=$bg_link1?>"><strong><a href="?xtype=1&mm=<?=$mm?>&yy1=<?=$yy1?>">กลุ่ม A</a></strong></td>-->
              <td width="9%" align="center" bgcolor="<?=$bg_link2?>"><strong><a href="report_alert_qc1.php?xtype=2&mm=<?=$mm?>&yy1=<?=$yy1?>">กลุ่ม L</a></strong></td>
              <td width="10%" align="center" bgcolor="<?=$bg_link3?>"><strong><a href="../hr3/tool_competency/diagnosticv1/report_qc.php" target="_blank">กลุ่ม N</a></strong></td>
              <td width="10%" align="center" bgcolor="<?=$bg_link5?>"><strong><a href="?xtype=5&mm=<?=$mm?>&yy1=<?=$yy1?>">parttime(L)</a></strong></td>
              <td width="10%" align="center" bgcolor="<?=$bg_link4?>"><strong><a href="../hr3/tool_competency/diagnosticv1/report_qc_parttime.php" target="_blank">parttime(N)</a></strong></td>
              <td width="61%" bgcolor="#E9E9E9">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6" align="left" bgcolor="#E9E9E9"><strong>แสดงข้อมูลกลุ่ม <? echo ShowGroup($xtype);?> ประจำเดือน <?=$monthFull[intval($txt_mm)]?> <?=$txt_yy?></strong></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td bgcolor="#000000"><table width="100%" border="0" cellspacing="1" cellpadding="2">
            <tr>
              <td width="4%" align="center" bgcolor="#D4D4D4"><strong>ลำดับ</strong></td>
              <td width="16%" align="center" bgcolor="#D4D4D4"><strong>ชื่อ - นามสกุล</strong></td>
              <td width="4%" align="center" bgcolor="#D4D4D4"><strong>กลุ่ม</strong></td>
              <td width="76%" align="center" bgcolor="#D4D4D4"><strong>จำนวนรอบการสุ่มตรวจสอบข้อมูล</strong></td>
              </tr>
            <?
		

			  $sql = "SELECT keystaff.staffid, keystaff.prename, keystaff.staffname, keystaff.staffsurname, keystaff.sapphireoffice,
keystaff.keyin_group FROM keystaff $cong  ";	//  AND staffid='10378'
			$result = mysql_db_query($db_name,$sql);
			$ii=0;
			while($rs = mysql_fetch_assoc($result)){
				// SubGroupQC($rs[staffid]); // แบ่งกลุ่ม QC
				if ($ii++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFFF";}
				$arr_table1 = $arr_tbl[$rs[staffid]];
				
				//$rpoint = ShowQvalue($rs[staffid]);
				
				

			  ?>
            <tr bgcolor="<?=$bg?>">
              <td align="center"><?=$ii?></td>
              <td align="left"><? echo "$rs[prename]$rs[staffname]   $rs[staffsurname]";?>&nbsp;<a href="CC_subgroupqc_GroupL_script.php?group_id=<?=$xtype?>&configdate=<?=$xmonth1?>&staffid=<?=$rs[staffid]?>" target="_blank">แบ่งกลุ่ม QCใหม่</a></td>
              <td align="center"><?=ShowGroup($rs[keyin_group]);?></td>
              <td align="center">
              <table width="100%" border="0" cellspacing="2" cellpadding="1">
                <tr>
                	<?
						for($m = 0; $m < $loop_max ; $m++){
							
							$arrx1 = explode("::",$arr_table1[$m]);
							if($arrx1[1] != ""){
								$show_val = $arrx1[0];
								$bgval = $arrx1[1];

							}else{
								$show_val = "[0]";
								$bgval = "#FFFFFF";
							}
							
					?>
                      <td align="center" width="<?=$width_cal?>%" bgcolor="<?=$bgval?>"><?=$show_val?></td>
                  <?
							$bgval = "";
						}//end  foreach($v as $k1 => $v1){
				  ?>
                </tr>
              </table>
              
              </td>
              </tr>
            <?
				}
			?>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
          </tr>
      </table>
  </td>
    </tr>
  </table>
</body>
</html>
