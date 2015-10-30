<?
include ("../../config/conndb_nonsession.inc.php")  ;
include("epm.inc.php");
$mname	= array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
$monthFull = array( "","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$point_num = 60;	
	if($yy1 == ""){
		$yy1 = date("Y")+543;
	}
	if($mm == ""){					
		$mm = sprintf("%2d",date("m"));
	}
	//echo $yy;
	function ShowGroup($get_group){
			if($get_group == "1"){ return "A";}
			else if($get_group == "2"){ return "B";}
			else if($get_group == "3"){ return "C";}
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
$col_w = 70;

function ShowKeyPerson($get_staffid,$get_date){
		global $db_name,$point_num;
		$sql = "SELECT numkpoint  FROM stat_user_keyin  WHERE datekeyin = '$get_date' AND staffid='$get_staffid'";
		//echo "$db_name :: ".$sql;
		$result = mysql_db_query($db_name,$sql);
		$rs = mysql_fetch_assoc($result);
		if($rs[numkpoint] > 0){
			return floor($rs[numkpoint]/$point_num);
		}else{
			return 0;	
		}
		
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
}

function ShowRpoint($get_staff){
		global $db_name;
		$sql1 = "SELECT
keystaff_group.rpoint
FROM
keystaff_group
Inner Join keystaff ON keystaff_group.groupkey_id = keystaff.keyin_group
WHERE
keystaff.staffid =  '$get_staff'
";
	$result1 = mysql_db_query($db_name,$sql1);
	$rs1 = mysql_fetch_assoc($result1);
	return $rs1[rpoint];
}

function CheckLengthQC($get_staff,$date_s,$date_e){
		global $db_name;
		$sql1 = "SELECT sum(numqc) AS numqc FROM  temp_check_qc  WHERE staffid='$get_staff' AND datekeyin BETWEEN '$date_s' and '$date_e' ";
		//echo $sql1."<br>";
		$result1 = mysql_db_query($db_name,$sql1);
		$rs1 = mysql_fetch_assoc($result1);
		return $rs1[numqc];
}


####  
	if($action == "view_detail"){
			$date_title = "วันที่  ".ShowDateThai($datekey);
			$get_yymm = $datekey;
	}else{
			$date_title = " ประจำเดือน ".$monthFull[intval($mm)]."  $yy1";	
			$get_yymm = ($yy1-543)."-".sprintf("%02d",$mm);
	}//end if($action == "view_detail"){
	####################
	
			##########  function ตรวจสอบ การตรวจคำผิดแล้วจาก ทีมตรวจคำผิด
		function CheckWordKey($get_idcard){
				global $db_name;
				$sql = "SELECT COUNT(idcard) as num1 FROM temp_qc WHERE idcard='$get_idcard' AND status_qc='1'";
				$result = mysql_db_query($db_name,$sql);
				$rs = mysql_fetch_assoc($result);
				return $rs[num1];
		}//end function CheckWordKey($get_idcard){
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
</style>
</head>
<body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
    <tr>
      <td valign="top" class="table_main"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><strong>โปรแกรมจะทำการสุ่มรายการให้ท่าน QC ในลำดับรายการแรกสุด</strong></td>
        </tr>
        <tr>
          <td align="center"><table width="100%" border="0" cellspacing="1" cellpadding="3">
            <tr>
              <td colspan="5" align="left" bgcolor="#D4D4D4"><strong>รายการคีย์ข้อมูลของ <? echo ShowStaffOffice($staffid); echo $date_title;?></strong></td>
              </tr>
            <tr>
              <td width="4%" align="center" bgcolor="#D4D4D4"><strong>ลำดับ</strong></td>
              <td width="13%" align="center" bgcolor="#D4D4D4"><strong>รหัสบัตร</strong></td>
              <td width="16%" align="center" bgcolor="#D4D4D4"><strong>ชื่อ - นามสกุล</strong></td>
              <td width="17%" align="center" bgcolor="#D4D4D4"><strong>วันที่คีย์ข้อมูล</strong></td>
              <td width="10%" align="center" bgcolor="#D4D4D4"><strong>QC</strong></td>
            </tr>
            <? 
			//$flag_qc = FalgQcValue($loopx,$datekey,$staffid);
				//$sql1 = "SELECT * FROM stat_user_keyperson WHERE staffid='$staffid' AND flag_qc='$flag_qc' AND datekeyin LIKE '$datekeyin' ORDER BY hidden_point DESC, age_point DESC";
			//$arr_flag = GetMaxLoop($datekey);
			//echo $arr_flag
			//$flag_qc = $arr_flag[$staffid][$loopx];
			$flag_qc = $loopx;
			
			
		$sql_check = "SELECT count(distinct idcard) as num1 FROM stat_user_keyperson WHERE staffid='$staffid' and   (hidden_point='' OR hidden_point IS NULL) and flag_qc='$flag_qc' AND flag_qc > 0 and status_approve='1'  GROUP BY flag_qc ";
		$result_check = mysql_db_query($dbnameuse,$sql_check) or die(mysql_error()."$sql_check<br>LINE__".__LINE__);
		$rsc = mysql_fetch_assoc($result_check);
		if($rsc[num1] > 0){
				CalHiddenPersonPointFlag($staffid,$flag_qc); //คำนวณหาค่าคะแนนความซับซ้อนของข้อมูลที่ใช้ในการคีย์
		}//end if($rsc[num1] > 0){

			
			
if($xidcard == ""){		
$sql1 = "SELECT
min(t1.datekeyin) as datekeyin,
t1.staffid,
t1.idcard,
t2.siteid,
t1.numkeyin,
t1.numpoint,
t1.hidden_point,
t1.age_point,
t1.status_random_qc,
t1.status_approve,
t1.flag_qc,
t1.timeupdate,
t2.keyin_name,
t3.idcard as idqc
FROM
stat_user_keyperson AS t1
Inner Join monitor_keyin AS t2 ON t1.idcard = t2.idcard AND t1.staffid = t2.staffid
Left Join validate_checkdata AS t3 ON t2.idcard = t3.idcard AND t2.staffid = t3.staffid
WHERE
t1.staffid =  '$staffid' AND
t1.status_approve =  '1' AND
t1.flag_qc =  '$flag_qc'
GROUP BY
t1.idcard
ORDER BY  t1.status_random_qc DESC, idqc desc, t1.hidden_point DESC, t1.age_point DESC ";

}else{ // stat_user_keyperson.datekeyin LIKE '$datekey%' and

$sql1 = "SELECT min(t1.datekeyin) as datekeyin, t1.staffid, if(t1.idcard=$xidcard,0,t1.idcard) as temp_idcard, t1.idcard, t2.siteid, t1.numkeyin, t1.numpoint, t1.hidden_point, t1.age_point, t1.status_random_qc,
t1.status_approve, t1.flag_qc, t1.timeupdate, t2.keyin_name
FROM
stat_user_keyperson as t1
Inner Join monitor_keyin as t2 ON t1.idcard = t2.idcard
 AND t1.staffid = t2.staffid
where  t1.staffid='$staffid' and t1.status_approve = '1' and t1.flag_qc='$flag_qc' 
GROUP BY
t1.idcard
ORDER BY t1.status_random_qc DESC, t1.status_random_flag DESC, temp_idcard ASC";
// stat_user_keyperson.datekeyin LIKE '$datekey%' and
	}//end if($xidcard == ""){		
//echo $sql1;
				//echo $sql;
				$result = mysql_db_query($db_name,$sql1);
				$i=0;
				while($rs = mysql_fetch_assoc($result)){
					if($i++ %  2){ $bg = "#F0F0F0";}else{$bg = "#FFFFF";}
					
					if($i == "1"){
						UpdateFlag_Randomqc($rs[datekeyin],$staffid,$rs[idcard],$flag_qc);
					}//end if($i == "1"){
					$pathfile = "../../../".edubkk_kp7file."/$rs[siteid]/$rs[idcard]".".pdf";
							if(is_file($pathfile)){
									$pdf_file = "<a href='$pathfile' target='_blank'><img src=\"../../images_sys/gnome-mime-application-pdf.png\" width=\"20\" height=\"21\" title=\"ตรวจสอบไฟล์ pdf ต้นฉบับ\" border='0'></a>";
							}else{
									$pdf_file = "";
							}//end if(is_file($pathfile))
							
					## ไฟล์เอกสารหลักฐาน
					$pathfile_org = "../../../".PATH_KP7_REFDOC_FILE."/$rs[siteid]/$rs[idcard]R".".pdf";
					if(is_file($pathfile_org)){
									$pdf_file_org = "<a href='$pathfile_org' target='_blank'><img src=\"../../images_sys/pdf_ref.png\" width=\"20\" height=\"20\" title=\"ตรวจสอบเอกสารหลักฐาน\" border='0'></a>";
							}else{
									$pdf_file_org = "";
							}//end if(is_file($pathfile))
							
							#$pdf_file_org = "<a href='$pathfile_org' target='_blank'><img src=\"../../images_sys/pdf_ref.png\" width=\"20\" height=\"21\" title=\"ตรวจสอบเอกสารหลักฐาน\" border='0'></a>";
							if($i == 1){ // ตรวจคนแรกที่จำทำการ QC เท่านั้น
								$arrQc1 = explode("::",CheckAlertQcOld1($flag_qc,$rs[staffid]));// หาว่ามีจำนวน Qc เก่า
								$Qc_idcard = $arrQc1[0];// รหัส idcard ที่ทำการ QC ไปแล้ว
								$QcNum = $arrQc1[1]; // นับว่ามีการ QC  ไปแล้วรึยัง 
								
								$staffname = ShowStaffOffice($rs[staffid]);
								if(CheckFlagQc($rs[staffid],$flag_qc) > 0  or $QcNum > 0){ $bg1 = "#009900"; $xtitle = " title='ทำการตรวจเรียบร้อยแล้ว'  style='cursor:hand'";}else{ $bg1 = "#FF3300"; $xtitle = " title='ยังไม่ได้ตรวจสอบข้อมูล' style='cursor:hand'";}
							
								if(CheckWordKey($rs[idcard]) > 0){
									$syb = "<strong><font color='#000000'>*</font></strong>";
								}else{
									$syb = ""	;
								}
							}//end 	if($i == 1){ // ตรวจคนแรกที่จำทำการ QC เท่านั้น
							
							if($i == 1){ $bg = $bg1; $show_title = $xtitle;}else{ $bg = $bg; $show_title = "";}			
							
							##### ตรวจสอบว่ารายการที่ทำการ QC ไปแล้ว
							
							
							if($flag_img_qc < 1){
								$num_qc1 = CheckQCPassV1($rs[idcard],$staffid);
								if($num_qc1 > 0){
									$img_qc = "<img src=\"../validate_management/images/award_star_silver_2.png\" width=\"16\" height=\"16\" border=\"0\" title=\"เอกสารได้ทำงาน QC ไปแล้ว\">";
									$flag_img_qc = 1;
								}//end 	if($num_qc1 > 0){
							}//end if($flag_img_qc < 1){

							
			?>
            <tr bgcolor="<?=$bg?>" <?=$show_title?>>
              <td align="center"><?=$i?></td>
              <td align="center"><?=$rs[idcard]?></td>
              <td align="left"><? echo "$rs[keyin_name]";?></td>
              <td align="center"><? echo DBThaiLongDate($rs[datekeyin]);?></td>
              <td align="center"><?=$syb?>&nbsp;<?=$pdf_file."&nbsp;".$pdf_file_org;?>&nbsp;<a href="../hr3/hr_report/report_check/report_check_data_new.php?idcard=<?=$rs[idcard]?>&siteid=<?=$rs[siteid]?>&xtype=validate&staffid=<?=$staffid?>" target="_blank"><img src="../validate_management/images/zoom.png" width="16" height="16" / border="0" title="หน้ารายงานเทียบ label กับ value"></a>&nbsp;
              <? if($i == 1 and $status_unfully != "1"){ // อนุญาตให้ QC ได้ก็ต่อเมื่อไม่ได้คีย์ข้อมูลเสร็จแล้วเท่านั้น?>
              <a href="../hr3/tool_competency/diagnosticv1/validate_keydata.php?idcard=<?=$rs[idcard]?>&fullname=<?=$rs[keyin_name]?>&staffname=<?=$staffname?>&staffid=<?=$rs[staffid]?>&xsiteid=<?=$rs[siteid]?>&flag_qc=<?=$loopx?>" target="_blank"><img src="../validate_management/images/cog_edit.png" width="16" height="16" border="0" title="คลิ๊กเพื่อบันทึกความผิดพลาดการบันทึกข้อมูล"></a>
              <? } echo "  $img_qc";?>
              
              </td>
            </tr>
            <? 
				$img_qc = "";
				}
			?>
          </table></td>
        </tr>
        <tr>
          <td><em>หมายเหตุ :: สัญลักษณ์เครื่องหมายดอกจันคือ ข้อมูลของบุคลากรที่ผ่านการตรวจคำผิดจากทีมตรวจคำผิดเรียบร้อยแล้ว</em></td>
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
